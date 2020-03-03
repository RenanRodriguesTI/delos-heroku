<?php

    namespace Delos\Dgp\Services;

    use Delos\Dgp\Entities\Project;
    use Delos\Dgp\Events\AddedMemberEvent;
    use Delos\Dgp\Events\CreatedProjectEvent;
    use Delos\Dgp\Events\DeletedMemberEvent;
    use Delos\Dgp\Events\DeleteProjectEvent;
    use Delos\Dgp\Events\EditedProjectEvent;
    use Delos\Dgp\Repositories\Eloquent\ProjectRepositoryEloquent;
    use Delos\Dgp\Entities\ProjectProposalValue;
    use Exception;
    use Prettus\Validator\Contracts\ValidatorInterface;
    use Illuminate\Support\Facades\DB;
    use Maatwebsite\Excel\Facades\Excel;
    use Delos\Dgp\Entities\TemporaryImport; 
    use Delos\Dgp\Entities\Group;
    use Carbon\Carbon;
    use Delos\Dgp\Entities\Client;

    class ProjectService extends AbstractService
    {
        use ProjectCodeGenerator;

        public function repositoryClass(): string
        {
            return ProjectRepositoryEloquent::class;
        }

        public function delete($id)
        {
            $project = $this->repository->find($id);
            $this->event->fire(new DeleteProjectEvent($project));
            return parent::delete($id);
        }

        public function create(array $data)
        {
            DB::beginTransaction();
            if ( empty($data['client_id']) ) {
                unset($data['client_id']);
            }

            $project = parent::create($data);
            $project->clients()->attach($data['clients']);
            $project->members()->attach($data['owner_id']);

            if ( !empty($data['co_owner_id']) ) {
                $project->members()->attach($data['co_owner_id']);
            }

            if ( !empty($data['client_id']) ) {
                $project->members()->attach($data['client_id']);
            }

            $project->tasks()
                ->sync($project->projectType->tasks()->pluck('id'));

            $project = $project->fresh();

            $project->cod = empty($data['cod']) ? $this->generateCodeProject($project) : $data['cod'];
            $project->save();
            $this->event->fire(new CreatedProjectEvent($project));
            DB::commit();
            return $project;
        }

        public function update(array $data, $id)
        {

            $originalProject = clone Project::query()
                ->with(['clients', 'clients.group'])
                ->find($id);

            DB::beginTransaction();

            if ( empty($data['client_id']) ) {
                unset($data['client_id']);
            }

            $editedProject = parent::update($data, $id);
            $editedProject->clients()->sync($data['clients']);
            $owners = [];

            array_push($owners, $data['owner_id']);

            if ( !empty($data['co_owner_id']) ) {
                array_push($owners, $data['co_owner_id']);
            }

            $editedProject->members()->syncWithoutDetaching($owners);
            $editedProject->save();

            $this->event->fire(new EditedProjectEvent($originalProject, $editedProject));

            $project = Project::query()
                ->find($id)
                ->update($data);
            DB::commit();

            return $project;
        }

        private function getMembersValidationRules(int $projectId): array
        {
            $rules = [
                'members.*' => "required|integer|unique:project_user,user_id,NULL,id,project_id,{$projectId}|exists:users,id"
            ];

            return $rules;
        }

        public function addMember($projectId, array $members)
        {
            $this->validator->setRules($this->getMembersValidationRules($projectId));

            $this->validator->with(['members' => $members])->passesOrFail();

            $this->repository->attachMembers($members, $projectId);
            $project = $this->repository->find($projectId);

            foreach ( $members as $memberId ) {
                $this->event->fire(new AddedMemberEvent($memberId, $project));
            }
        }

        public function removeMember($projectId, $memberId)
        {
            $project = $this->repository->find($projectId);

            $this->validator->setRules([
                                           'member_id' => 'different:leader_id'
                                       ]);

            $this->validator->with(['member_id' => $memberId, 'leader_id' => $project->owner_id])->passesOrFail();

            $this->repository->detachMember($memberId, $projectId);

            $this->event->fire(new DeletedMemberEvent($memberId, $project));
        }

        public function addTasksWithHour(int $id, array $request)
        {
            $project = $this->repository->makeModel()->find($id);

            $this->validator->setRules([
                                           'hour_task' => "not_more:budget",
                                           'budget'    => 'required'
                                       ]);

            $this->validator->with([
                                       'hour_task' => $request['hour_task'],
                                       'budget'    => $project->budget
                                   ]);

            $tasks = $this->getSyncTasks($request);

            $project->tasks()->syncWithoutDetaching($tasks, false);

            return $project;
        }

        private function getSyncTasks($request): array
        {
            $tasks = [];
            foreach ( $request['hour_task'] as $key => $value ) {
                if ( $value !== "" ) {
                    $tasks += [
                        $key => [
                            'hour' => $value
                        ]
                    ];
                };
            }
            return $tasks;
        }

        public function deleteProposalValue(int $projectId, int $projectProposalValueId)
        {
            $project = $this->repository->withTrashed()->find($projectId);
            $projectProposalValue = $project->proposalValueDescriptions()->find($projectProposalValueId);
            return $projectProposalValue->forceDelete();
        }

        public function createProposalValue(array $data)
        {
            $this->updateRulesToProposalValue($data);
            $data = $this->convertValue($data);
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $descritionValue =  ProjectProposalValue::create($data);
            $descritionValue->clients()->sync($data['client_id']);
            return $descritionValue;
        }

        public function updateProposalValue(array $data, int $id)
        {
            $this->updateRulesToProposalValue($data, true, $id);
            $data = $this->convertValue($data);

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $descritionValue =  ProjectProposalValue::find($id);
            $descritionValue->update($data);
            $descritionValue->clients()->sync($data['client_id']);

            return $descritionValue;
        }

        private function convertValue(array $data): array
        {
            $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
            $data['value'] = $numberFormatter->parse($data['value']);
            return $data;
        }

        private function updateRulesToProposalValue(array $data, bool $isUpdate = false, $projectProposalValuesDescriptionId = null): void
        {
            $maxValue = $isUpdate ? $this->repository->withTrashed()->getAvaliableProposalValues($data['project_id'], $projectProposalValuesDescriptionId) : $this->repository->withTrashed()->getAvaliableProposalValues($data['project_id']);
            $rules['create']['value']          = "required|numeric|max:{$maxValue}";
            $rules['create']['client_id']      = 'required|array|exists:clients,id';
            $rules['create']['notes']          = 'string|max:255';
            $rules['create']['invoice_number'] = 'string|max:15';
            $rules['create']['description']    = 'required|string|max:255';
            $rules['create']['os'] ='unique:project_proposal_values,os';

            $rules['update']['value']          = "numeric|max:{$maxValue}";
            $rules['update']['client_id']      = 'array|exists:clients,id';
            $rules['update']['notes']          = 'string|max:255';
            $rules['update']['invoice_number'] = 'string|max:15';
            $rules['update']['description']    = 'string|max:255';
            $rules['update']['os'] ='unique:project_proposal_values,os';

            $this->validator->setRules($rules);
        }

        private function updateRulesToImport(array $data, bool $isUpdate = false, $projectProposalValuesDescriptionId = null): void
        {
            $maxValue = $isUpdate ? $this->repository->withTrashed()->getAvaliableProposalValues($data['project_id'], $projectProposalValuesDescriptionId) : $this->repository->withTrashed()->getAvaliableProposalValues($data['project_id']);
            $rules['create']['value']          = "required|numeric|max:{$maxValue}";
            $rules['create']['client_id']      = 'required|array|exists:clients,id';
            $rules['create']['notes']          = 'string';
            $rules['create']['invoice_number'] = 'string|max:15';
            $rules['create']['description']    = 'string';
            $rules['create']['os'] ='unique:project_proposal_values,os';
            $rules['update']['value']          = "numeric|max:{$maxValue}";
            $rules['update']['client_id']      = 'array|exists:clients,id';
            $rules['update']['notes']          = 'string';
            $rules['update']['invoice_number'] = 'string|max:15';
            $rules['update']['description']    = 'string';
            $rules['update']['os'] ='unique:project_proposal_values,os,'.$projectProposalValuesDescriptionId;

            $this->validator->setRules($rules);
        }

        public function validateFile(array $data){
            $rules['files'] ='required';
            $this->validator->setRules($rules);
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
        }

        public function  createProposalValueImport($data){
            $this->updateRulesToImport($data);
            $data = $this->convertValue($data);
            if($this->validator->with($data)->passes(ValidatorInterface::RULE_CREATE)){
                $descritionValue =  ProjectProposalValue::create($data);
                $descritionValue->clients()->sync($data['client_id']);
                return $descritionValue;
            }
            return $this->validator->errors();
        }

        public function updateProposalValueImport(array $data, int $id){
            $this->updateRulesToImport($data, true, $id);
            $data = $this->convertValue($data);

            if($this->validator->with($data)->passes(ValidatorInterface::RULE_UPDATE)){
                $descritionValue =  ProjectProposalValue::find($id);
                $descritionValue->update($data);
                $descritionValue->clients()->sync($data['client_id']);
                return $descritionValue;
            }

            return $this->validator->errors();
        }

        public function importAllProposalValues(){
            TemporaryImport::query()->forceDelete();
            $data = function(){
                try{
                    yield Excel::load('storage/app/file.xlsx')->get()->all();
                   
                } catch(Exception $erro){
                    yield [];
                }
               
            };


            foreach($data() as $rows){
                foreach($rows as $value){
                    $obj =  [
                               'data_os' =>($value->data_os)?$value->data_os->format('d/m/Y'):null,
                               'numero_os' =>($value->numero_os)?$value->numero_os:'',
                               'nome_do_cliente' => ($value->nome_do_cliente)? $value->nome_do_cliente:'',
                               'valor_servico' => ($value->valor_servico)?number_format($value->valor_servico,2,",","."):"",
                               'codigo_do_cliente'=>($value->codigo_do_cliente)?$value->codigo_do_cliente:'',
                               'valor_nfse'=>($value->valor_nfse)?number_format($value->valor_nfse,2,",","."):null,
                               'data_emissao_nfse' => ($value->data_emissao_nfse)?$value->data_emissao_nfse->format('d/m/Y'):null,
                               'numero_nfs_e' => ($value->numero_nfs_e)?"".$value->numero_nfs_e:"",
                               'codigo_projeto' => ($value->codigo_projeto)?$value->codigo_projeto:null,
                               'data_baixa_do_titulo' => ($value->data_baixa_do_titulo)?$value->data_baixa_do_titulo->format('d/m/Y'):null,
                               'observacao_os' => $value->observacao_os,
                               'situacao_titulo' =>$value->situacao_titulo,
                           ];

                           $project = Project::withTrashed()->where('compiled_cod',$obj['codigo_projeto'])->first(['id']);
                           if($project !=null){
                            $codcliente = explode('-',$obj['codigo_do_cliente']);
                            $groupcod = $codcliente[0];
                            $clientcod = $codcliente[1];       
                            $group = Group::where('cod',$groupcod)->first();
                            $clients = $project->clients->pluck('id');
                            $value = ($obj["valor_nfse"] != null)?$obj["valor_nfse"]:$obj["valor_servico"];
                            $dt = Carbon::createFromFormat('d/m/Y', $obj['data_os']);
                            $valuedb = str_replace(",",".",str_replace(".","",$value));
                            
                            $client = Client::where('group_id',$group->id)->where('cod',$clientcod)->first();
                            $proposalvalues = ProjectProposalValue::with('clients')->where('os',$obj['numero_os'])->get();
                            if($proposalvalues->isEmpty()){
                                $proposalvalues = ProjectProposalValue::with('clients')->where('project_id',$project->id)
                                ->where('month',$dt->format('Y-m-d'))
                                ->where('value',$valuedb)->get();
                            }
        
                            $proposalvalues = $proposalvalues->filter(function($item) use ($client){
                                return !$item->clients->where('id',$client->id)->isEmpty();
                            });
        
                            $proposalnull = $proposalvalues->filter(function($item){
                                return !$item->os;
                            })->first();
                            
                            $proposalvalues = $proposalvalues->filter(function($item) use ($obj){
                                return $item->os == $obj['numero_os'];
                            })->first();
        
        
        
                            $proposal['month'] = $obj["data_os"];
                            $proposal['date_nf'] = $obj["data_emissao_nfse"];
                            $proposal['nf_nd'] = $obj["numero_nfs_e"];
                          
                            $proposal['project_id'] = $project->id;
        
                            switch(mb_strtoupper($obj['situacao_titulo'])){
                                case '':
                                    $proposal['has_billed'] = ($obj["data_baixa_do_titulo"]!=null)?true:false;
                                    $proposal['invoice_number'] = $obj["numero_nfs_e"];
                                    $proposal['date_received'] = $obj["data_baixa_do_titulo"];
                                    $proposal['value'] = ($obj["valor_nfse"] != null)?$obj["valor_nfse"]:$obj["valor_servico"];
                                break;
                                case 'ABERTO':
                                    $proposal['has_billed'] = ($obj["data_baixa_do_titulo"]!=null)?true:false;
                                    $proposal['invoice_number'] = $obj["numero_nfs_e"];
                                    $proposal['date_received'] = $obj["data_baixa_do_titulo"];
                                    $proposal['value'] = ($obj["valor_nfse"] != null)?$obj["valor_nfse"]:$obj["valor_servico"];
                                break;
                                case 'QUITADO':
                                    $proposal['has_billed'] = ($obj["data_baixa_do_titulo"]!=null)?true:false;
                                    $proposal['invoice_number'] = $obj["numero_nfs_e"];
                                    $proposal['date_received'] = $obj["data_baixa_do_titulo"];
                                    $proposal['value'] = ($obj["valor_nfse"] != null)?$obj["valor_nfse"]:$obj["valor_servico"];
                                break;
                                case 'CANCELADO':
                                    $proposal['has_billed'] = false;
                                    $proposal['invoice_number'] = '';
                                    $proposal['date_received'] = '';
                                    $proposal['value'] = $obj["valor_servico"];
                                break;
                            }
                            
                            $proposal['description'] = ($obj['observacao_os'])?$obj['observacao_os']:'';
                            $proposal['notes'] = '';
                            $proposal['client_id'] = [$client->id];
                            $result =[];
                            $proposal['os'] = $obj["numero_os"];
                            if(!$proposalvalues && !$proposalnull){
                                $result = $this->createProposalValueImport($proposal);
                            } else{
                               
                                if($proposalvalues){
                                    $result = $this->updateProposalValueImport($proposal,$proposalvalues->id);
                                    
                                } else{
                                    $result = $this->updateProposalValueImport($proposal,$proposalnull->id);
                                }                        
                            }
        
                            if(!($result instanceof ProjectProposalValue) ){
                                // TemporaryImport::create([ 
                                //     'project_code' =>$obj['codigo_projeto'] ,
                                //     'os' => $obj['numero_os'],
                                //     'status'=> 'error',
                                //     'description' =>implode('<br> ',$result),
                                //     'date_migration' =>Carbon::now()]);
                            } else{
                                // TemporaryImport::create([ 
                                //     'project_code' =>$obj['codigo_projeto'] ,
                                //     'os' => $obj['numero_os'],
                                //     'status'=> 'success',
                                //     'description' =>'Importado com sucesso',
                                //     'date_migration' =>Carbon::now()]);
                            }
                        } else{
                            // TemporaryImport::create([ 
                            //     'project_code' =>$obj['codigo_projeto'] ,
                            //     'os' => $obj['numero_os'],
                            //     'status'=> 'error',
                            //     'description' =>'O projeto não existe',
                            //     'date_migration' =>Carbon::now()]);
                        }
                }    
            }
        }
    }
