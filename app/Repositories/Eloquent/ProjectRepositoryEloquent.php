<?php

    namespace Delos\Dgp\Repositories\Eloquent;

    use Carbon\Carbon;
    use Delos\Dgp\Entities\Project;
    use Delos\Dgp\Presenters\ProjectPresenter;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Criterias\Project\ScopeCriteria;
    use Delos\Dgp\Entities\ProjectProposalValue;
    use Illuminate\Support\Facades\Auth;
    /**
     * Class ProjectRepositoryEloquent
     * @package Delos\Dgp\Repositories\Eloquent
     */
    class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
    {
        private const ROOT_ROLE_ID = 5;
        /**
         * @var array
         */
        protected $fieldSearchable = [
            'compiled_cod'     => 'like',
            'description'      => 'like',
            'owner.name'       => 'like',
        ];

        /**
         * @throws \Prettus\Repository\Exceptions\RepositoryException
         */
        public function boot()
        {
            parent::boot();
            $this->pushCriteria(ScopeCriteria::class);
        }

        /**
         * @return string
         */
        public function model()
        {
            return Project::class;
        }

        /**
         * @return string
         */
        public function presenter()
        {
            return ProjectPresenter::class;
        }

        /**
         * @param bool $applyWithTrashed
         *
         * @return array
         */
        public function getPairs($applyWithTrashed = true): array
        {
            $projects = $this;

            if ($applyWithTrashed) {
                $projects = $projects->withTrashed();
            }
            $projects = $projects->all(); 
            $projects->transform(function ($project) {
                return [
                    'id'          => $project->id,
                    'description' => $project->full_description
                ];
            });

            return $projects->pluck('description', 'id')->toArray();
        }

        public function getPairsByExtension($applyWithTrashed = true): array
        {
            $now = Carbon::now();
            $httparament = app('request')->input('showall');
            if(!$httparament || $httparament =='false'){
                $this->model = $this->model->whereHas('allocations',function($query) use($now){
                    $query->where('user_id',Auth::user()->id)->where('finish','>=',$now->toDateString());
                  
                });
            }

            $this->model = $this->model->where(function($query) use($now){
                $query->where('finish','>=',$now->toDateString())->orWhere('extension','>=',$now->toDateString());
            });
            $projects = $this;
            if ($applyWithTrashed) {
                $projects = $projects->withTrashed();
            }
            $projects = $projects->all();
            $projects->transform(function ($project) {
                return [
                    'id'          => $project->id,
                    'description' => $project->full_description
                ];
            });

            return $projects->pluck('description', 'id')->toArray();
        }


        public function getPairsForRequests($applyWithTrashed = true): array
        {
            $start = app('request')->input('start');
            $finish = app('request')->input('finish');
            $requests = app('request')->input('requests');
            $showall = app('request')->input('showall');
    
            if ($start) {
                $this->model = $this->model->whereNull('deleted_at')->where('start', '<=', $start);
            }
    
            if ($finish) {
                $this->model = $this->model->whereNull('deleted_at')->where('finish', '>=', $finish);
            }
    
            switch($showall){
                case 'false':
                    $this->model = $this->model->whereHas('allocations',function($query) use($start,$finish){
    
                        $query->where('user_id',Auth::user()->id)->where('start','<=', $start)->where('finish','>=',$finish)->whereHas('project',function($query) use($finish){
                            $query->orWhere('extension','>=',$finish);
                        });
                    });
                break;
    
                default:
                    $this->model = $this->model->orWhere('extension','>=',$finish);
                break;
            }
            $projects = $this;
            if ($applyWithTrashed) {
                $projects = $projects->withTrashed();
            }
            $projects = $projects->all();
            // $projects->transform(function ($project) {
            //     return [
            //         'id'          => $project->id,
            //         'description' => $project->full_description
            //     ];
            // });

            return $projects->toArray();
        }

        /**
         * @return array
         */
        public function getPairsDisabled(): array
        {
            $projects = $this->getAllSoftDelete(false);

            $projects->transform(function ($project) {
                return [
                    'id'          => $project->id,
                    'description' => $project->full_description
                ];
            });

            return $projects->pluck('description', 'id')->toArray();
        }

        /**
         * @param array $membersIds
         * @param int   $projectId
         */
        public function attachMembers(array $membersIds, int $projectId): void
        {
            $this->find($projectId)->members()->attach($membersIds);
        }

        /**
         * @param int $memberId
         * @param int $projectId
         */
        public function detachMember(int $memberId, int $projectId): void
        {
            $this->find($projectId)->members()->detach($memberId);
        }

        /**
         * @param int $year
         *
         * @return string
         */
        private function getStartOfYear(int $year)
        {
            $dateString = Carbon::createFromFormat('Y', $year)->startOfYear()->toDateString();

            return $dateString;
        }

        /**
         * @param int $year
         *
         * @return string
         */
        private function getEndOfYear(int $year)
        {
            $dateString = Carbon::createFromFormat('Y', $year)->endOfYear()->toDateString();

            return $dateString;
        }

        /**
         * @param int    $clientId
         * @param Carbon $year
         *
         * @return string
         */
        public function getLastClientCodeByClientIdAndYear(int $clientId, Carbon $year): string
        {
            $periodOfOneYear = [
                $this->getStartOfYear($year->format('Y')),
                $this->getEndOfYear($year->format('Y'))
            ];

            $model = $this->model->newQueryWithoutScopes();

            $model = $model->has('clients', '=', 1)->whereHas('clients', function ($query) use ($clientId) {
                    $query->where('client_id', $clientId);
                })->whereBetween('start', $periodOfOneYear);

            $cod = $model->max('cod');

            return $cod ?? '00';
        }

        /**
         * @param int    $groupId
         * @param Carbon $year
         *
         * @return string
         */
        public function getLastGroupCodeByGroupIdAndYear(int $groupId, Carbon $year): string
        {
            $periodOfOneYear = [
                $this->getStartOfYear($year->format('Y')),
                $this->getEndOfYear($year->format('Y'))
            ];

            $model = $this->model->newQueryWithoutScopes();

            $model = $model->whereBetween('start', $periodOfOneYear)->has('clients', '>', 1)->whereHas('clients.group', function ($query) use ($groupId) {
                    $query->where('id', $groupId);
                });

            $cod = $model->max('cod');
            return $cod ?? '00';
        }

        /**
         * @param Carbon $date
         *
         * @return iterable
         */
        public function getPairsByDate(Carbon $date): iterable
        {
            $this->applyCriteria();
            $this->applyScope();

            $projects = $this->model->whereRaw("'{$date->toDateString()}' BETWEEN start and finish")->get();

            $transformed = $projects->transform(function ($project) {

                return [
                    'id'          => $project->id . ' - project',
                    'description' => "Nº: $project->compiled_cod - De: {$project->start->format('d/m/Y')} - Até: {$project->finish->format('d/m/Y')} * Descrição do projeto: {$project->description}"
                ];
            });

            return $transformed->pluck('description', 'id');
        }


        public function getPairsByFullDescription($date): iterable
        {
            $this->applyCriteria();
            $this->applyScope();

            $this->model = $this->model->with('allocations');

            $httparament = app('request')->input('showall');
            $cod = app('request')->input('cod');
            switch($httparament){
                case 'true':
                    $projects = $this->model->whereRaw("'{$date->toDateString()}' <= finish or extension >= '{$date->toDateString()}'");
                break;
                default:
                    $projects = $this->model->whereHas('allocations',function($query) use($date){
                        $query->where('user_id',Auth::user()->id)->where('start','<=',$date->toDateString())->where('finish','>=',$date->toDateString());
                        $query->where('parent_id',null);
                    })->where(function($query) use($date){
                        $query->where('finish','>=',$date->toDateString())->orWhere('extension','>=',$date->toDateString());
                    });
                break;
               
            }

            if(str_contains($cod, '- project') ){
                $projects = $projects->orWhere('id',str_replace(' - project','',$cod));
            } else{
                if($cod){
                    $projects = $projects->orWhereHas('requests',function($query)use($cod){
                        $query->where('id',$cod);
                    });
                }
            }
        
            $projects = $projects->get();

            $transformed = $projects->transform(function ($project) {

                return [
                    'id'          => $project->id . ' - project',
                    'description' => "Nº: $project->compiled_cod - De: {$project->start->format('d/m/Y')} - Até: {$project->finish->format('d/m/Y')} * Descrição do projeto: {$project->description}"
                ];
            });

            return $transformed->pluck('description', 'id');
        }

        public function getAvaliableProposalValues(int $id, $proposalValuesDescriptionId = null){
            $project = $this->find($id);
            $sumProposalValue = $project->proposal_value - $project->proposalValueDescriptions->sum("value");

            if ($proposalValuesDescriptionId) {
                $sumProposalValue += ProjectProposalValue::find($proposalValuesDescriptionId)->value;
            }

            return $sumProposalValue;
        }
    }