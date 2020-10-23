<?php

namespace Delos\Dgp\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\TemporaryImport;
use Delos\Dgp\Entities\Group;
use Delos\Dgp\Entities\ProjectProposalValue;
use Delos\Dgp\Entities\Client;
use Carbon\Carbon;
use Delos\Dgp\Events\ImportedRevenues;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportRevenues implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $tries = 1;
    public $rows;
    public $spreadsheetCount;
    public $user;

    public function __construct($rows,$spreadsheetCount=0,$user=null)
    {
        $this->rows = $rows;
        $this->spreadsheetCount = $spreadsheetCount - 1;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        foreach ($this->rows as $value) {
            $value = (object)$value;
            $update = false;
            $obj =  [
                'data_os' => ($value->data_os) ? $this->dateCorrect($value->data_os)->format('d/m/Y') : null,
                'numero_os' => ($value->numero_os) ? $value->numero_os : '',
                'nome_do_cliente' => ($value->nome_do_cliente) ? $value->nome_do_cliente : '',
                'valor_servico' => ($value->valor_servico) ? number_format($value->valor_servico, 2, ",", ".") : "",
                'codigo_do_cliente' => ($value->codigo_do_cliente) ? $value->codigo_do_cliente : '',
                'valor_nfse' => ($value->valor_nfse) ? number_format($value->valor_nfse, 2, ",", ".") : null,
                'data_emissao_nfse' => ($value->data_emissao_nfse) ? $this->dateCorrect($value->data_emissao_nfse)->format('d/m/Y') : null,
                'numero_nfs_e' => ($value->numero_nfs_e) ? "" . $value->numero_nfs_e : "",
                'codigo_projeto' => ($value->codigo_projeto) ? $value->codigo_projeto : null,
                'data_baixa_do_titulo' => ($value->data_baixa_do_titulo) ?  $this->dateCorrect($value->data_baixa_do_titulo)->format('d/m/Y') : null,
                'observacao_os' => $value->observacao_os,
                'situacao_titulo' => $value->situacao_titulo,
            ];

            $project = Project::withTrashed()->where('compiled_cod', $obj['codigo_projeto'])->first(['id']);
            if ($project != null) {
                $codcliente = explode('-', $obj['codigo_do_cliente']);
                $groupcod = $codcliente[0];
                $clientcod = $codcliente[1];
                $group = Group::where('cod', $groupcod)->first();
                $clients = $project->clients->pluck('id');
                $value = ($obj["valor_nfse"] != null) ? $obj["valor_nfse"] : $obj["valor_servico"];
                $dt = Carbon::createFromFormat('d/m/Y', $obj['data_os']);
                $valuedb = str_replace(",", ".", str_replace(".", "", $value));

                $client = Client::where('group_id', $group->id)->where('cod', $clientcod)->first();
                $proposalvalues = ProjectProposalValue::with('clients')->where('os', $obj['numero_os'])->get();
                if ($proposalvalues->isEmpty()) {
                    $proposalvalues = ProjectProposalValue::with('clients')->where('project_id', $project->id)
                        ->where('month', $dt->format('Y-m-d'))
                        ->where('value', $valuedb)->get();
                }

                $proposalvalues = $proposalvalues->filter(function ($item) use ($client) {
                    return !$item->clients->where('id', $client->id)->isEmpty();
                });

                $proposalnull = $proposalvalues->filter(function ($item) {
                    return !$item->os;
                })->first();

                $proposalvalues = $proposalvalues->filter(function ($item) use ($obj) {
                    return $item->os == $obj['numero_os'];
                })->first();



                $proposal['month'] = $obj["data_os"];
                $proposal['project_id'] = $project->id;

                switch (mb_strtoupper($obj['situacao_titulo'])) {
                    case '':
                        $proposal['has_billed'] = ($obj["data_baixa_do_titulo"] != null) ? true : false;
                        $proposal['invoice_number'] = $obj["numero_nfs_e"];
                        $proposal['date_received'] = $obj["data_baixa_do_titulo"];
                        $proposal['value'] = ($obj["valor_nfse"] != null) ? $obj["valor_nfse"] : $obj["valor_servico"];
                        $proposal['expected_date'] = $obj["data_emissao_nfse"];
                        $proposal['date_nf'] = $obj["data_emissao_nfse"];
                        $proposal['nf_nd'] = $obj["numero_nfs_e"];
                        break;
                    case 'ABERTO':
                        $proposal['has_billed'] = ($obj["data_baixa_do_titulo"] != null) ? true : false;
                        $proposal['invoice_number'] = $obj["numero_nfs_e"];
                        $proposal['date_received'] = $obj["data_baixa_do_titulo"];
                        $proposal['value'] = ($obj["valor_nfse"] != null) ? $obj["valor_nfse"] : $obj["valor_servico"];
                        $proposal['date_nf'] = $obj["data_emissao_nfse"];
                        $proposal['nf_nd'] = $obj["numero_nfs_e"];

                        $proposal['expected_date'] =  $obj["data_emissao_nfse"];
                        break;
                    case 'QUITADO':
                        $proposal['has_billed'] = ($obj["data_baixa_do_titulo"] != null) ? true : false;
                        $proposal['invoice_number'] = $obj["numero_nfs_e"];
                        $proposal['date_received'] = $obj["data_baixa_do_titulo"];
                        $proposal['value'] = ($obj["valor_nfse"] != null) ? $obj["valor_nfse"] : $obj["valor_servico"];
                        $proposal['date_nf'] = $obj["data_emissao_nfse"];
                        $proposal['nf_nd'] = $obj["numero_nfs_e"];
                        $proposal['expected_date'] =  $obj["data_emissao_nfse"];
                        break;
                    case 'CANCELADO':
                        $proposal['has_billed'] = false;
                        $proposal['invoice_number'] = '';
                        $proposal['date_received'] = '';
                        $proposal['value'] = $obj["valor_servico"];
                        $proposal['expected_date'] = null;
                        $proposal['date_nf'] = null;
                        $proposal['nf_nd'] = null;
                        break;
                }

                $proposal['description'] = ($obj['observacao_os']) ? $obj['observacao_os'] : '';
                $proposal['notes'] = '';
                $proposal['client_id'] = [$client->id];
                $proposal['import_date'] = Carbon::now()->format('d/m/Y');
                $result = [];
                $proposal['os'] = $obj["numero_os"];
                $proposal['value'] = str_replace(",", ".", str_replace(".", "", $proposal['value']));

                if (!$proposalvalues && !$proposalnull) {
                    $update = false;
                    $result = $this->createProposalValueImport($proposal);
                } else {

                    if ($proposalvalues) {
                        $update = true;
                        $proposal['date_change'] = Carbon::now()->format('d/m/Y');
                        $result = $this->updateProposalValueImport($proposal, $proposalvalues->id);
                    } else {
                        $update = true;
                        $proposal['date_change'] = Carbon::now()->format('d/m/Y');
                        $result = $this->updateProposalValueImport($proposal, $proposalnull->id);
                    }
                }

                if (!($result instanceof ProjectProposalValue)) {
                    TemporaryImport::create([
                        'project_code' => $obj['codigo_projeto'],
                        'os' => $obj['numero_os'],
                        'status' => 'error',
                        'description' => implode(' ', $result),
                        'date_migration' => Carbon::now()
                    ]);
                } else {
                    TemporaryImport::create([
                        'project_code' => $obj['codigo_projeto'],
                        'os' => $obj['numero_os'],
                        'status' => 'success',
                        'description' => ($update) ? 'Atualizado com sucesso' : 'Importado com sucesso',
                        'date_migration' => Carbon::now()
                    ]);
                }
            } else {
                TemporaryImport::create([
                    'project_code' => $obj['codigo_projeto'],
                    'os' => $obj['numero_os'],
                    'status' => 'error',
                    'description' => 'O projeto não existe',
                    'date_migration' => Carbon::now()
                ]);
            }
        }
       $imported = TemporaryImport::count();
       $remaining = $this->spreadsheetCount - $imported;

        if($remaining == 0 && $this->user){
            event(new ImportedRevenues($this->user));
        }

    
    }

    public function createProposalValueImport($data)
    {
        try {
            $maxValue = $this->getAvaliableProposalValues($data['project_id']);

            $validator = Validator::make(
                $data,
                [
                    'value' => "required|numeric|max:{number_format($maxValue)}",
                    'client_id'     => 'required|array|exists:clients,id',
                    'notes'         => 'string',
                    'invoice_number' => 'string|max:15',
                    'description'   => 'string',
                    'os' => 'unique:project_proposal_values,os'
                ]
            );

            if ($validator->fails()) {

                $errors = [];
                foreach ($validator->errors()->getMessages() as $attribute) {
                    $errors[] = implode("<br>", $attribute);
                }
                return $errors;
            }

            $descritionValue =  ProjectProposalValue::create($data);
            $descritionValue->clients()->sync($data['client_id']);
            return $descritionValue;
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    public function updateProposalValueImport($data, $id)
    {

        try {
            $maxValue = $this->getAvaliableProposalValues($data['project_id'], $id);

            $validator = Validator::make(
                $data,
                [
                    'value' => "required|numeric|max:{number_format($maxValue)}",
                    'client_id'     => 'required|array|exists:clients,id',
                    'notes'         => 'string',
                    'invoice_number' => 'string|max:15',
                    'description'   => 'string',
                    'os' => 'unique:project_proposal_values,os,' . $id
                ]
            );

            if ($validator->fails()) {

                $errors = [];
                foreach ($validator->errors()->getMessages() as $attribute) {
                    $errors[] = implode("<br>", $attribute);
                }
                return $errors;
            }

            $descritionValue =  ProjectProposalValue::find($id);
            $descritionValue->update($data);
            $descritionValue->clients()->sync($data['client_id']);
            return $descritionValue;
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    public function getAvaliableProposalValues(int $id, $proposalValuesDescriptionId = null)
    {
        $project = Project::withTrashed()->find($id);
        $sumProposalValue = $project->proposal_value - $project->proposalValueDescriptions->sum("value");

        if ($proposalValuesDescriptionId) {
            $sumProposalValue += ProjectProposalValue::find($proposalValuesDescriptionId)->value;
        }

        return $sumProposalValue;
    }


    public function dateCorrect(float $timespan){
        $date_aux = Carbon::create(1900, 01, 01, 0);
        $date_correct = $date_aux->addDays($timespan - 2);

        return $date_correct;
    }

    public function failed(Exception $exception)
    {
        var_dump($exception->getMessage());
    }
}
