<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Delos\Dgp\Entities\Client;
use Delos\Dgp\Entities\Group;
use Delos\Dgp\Entities\ProjectProposalValue;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\TemporaryImport;
use Carbon\Carbon;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Double;

class ImportsController extends AbstractController
{
    public function index(){
        return view('revenues.error');
    }

    private function getContentFile($file)
    {
        return file_get_contents($file);
    }

    public function upload(Request $request){
        try{
            $this->service->validateFile($request->all());
            if ($request->has('files') && $request->file('files')->isValid()){
                $path = Storage::disk('local')->put('file.xlsx', file_get_contents($request->file('files')));
                $data = Excel::load('storage/app/file.xlsx')->get();
            }
        
       foreach($data as $key => $value){
           if($value)
           $arr[] = [
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
       }
    //    usort($arr,function($a,$b){
        
    //     if (Carbon::createFromFormat('d/m/Y', $a['data_os'])->equalTo(Carbon::createFromFormat('d/m/Y', $b['data_os']))) {
    //         return 0;
    //         }
    //         return (Carbon::createFromFormat('d/m/Y', $a['data_os'])->lessThan(Carbon::createFromFormat('d/m/Y', $b['data_os']))) ? -1 : 1;
    //    });

       
       $empty = false; 

       if(!empty($arr)){
           TemporaryImport::query()->delete();;
           foreach($arr as $obj ){
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
                        $result = $this->service->createProposalValueImport($proposal);
                    } else{
                       
                        if($proposalvalues){
                            //$proposal['notes'] =$proposalvalues->description . "- ".$proposal['notes'];
                            $result = $this->service->updateProposalValueImport($proposal,$proposalvalues->id);
                            
                        } else{
                            //$proposal['notes'] =$proposalnull->description . "- ".$proposal['notes'];
                            $result = $this->service->updateProposalValueImport($proposal,$proposalnull->id);
                        }                        
                    }

                    if(!($result instanceof ProjectProposalValue) ){
                        TemporaryImport::create([ 
                            'project_code' =>$obj['codigo_projeto'] ,
                            'os' => $obj['numero_os'],
                            'status'=> 'error',
                            'description' =>implode('<br> ',$result),
                            'date_migration' =>Carbon::now()]);
                    } else{
                        TemporaryImport::create([ 
                            'project_code' =>$obj['codigo_projeto'] ,
                            'os' => $obj['numero_os'],
                            'status'=> 'success',
                            'description' =>'Importado com sucesso',
                            'date_migration' =>Carbon::now()]);
                    }
                } else{
                    TemporaryImport::create([ 
                        'project_code' =>$obj['codigo_projeto'] ,
                        'os' => $obj['numero_os'],
                        'status'=> 'error',
                        'description' =>'O projeto não existe',
                        'date_migration' =>Carbon::now()]);
                }
           }
       }
      
       return redirect()->route('revenues.index');

        } catch( ValidatorException $e){
            $fileerrors = collect($e->getMessageBag()->messages());
            return view('revenues.error',compact('fileerrors'));
        }
       
    }
   
}
