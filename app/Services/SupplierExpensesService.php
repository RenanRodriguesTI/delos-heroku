<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\SupplierExpensesRepositoryEloquent;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\SupplierExpensesImports;
use Delos\Dgp\Events\SavedSupplierExpenseImport;
use Maatwebsite\Excel\Facades\Excel;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Carbon\Carbon;
use Exception;

class SupplierExpensesService extends AbstractService
{
    public function repositoryClass(): string
    {
        return SupplierExpensesRepositoryEloquent::class;
    }

    public function validateFile(array $data)
    {
        $rules['files'] = 'required';
        $oldRules = $this->validator->getRules();
        $this->validator->setRules($rules);
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
        } catch (ValidatorException $e) {
            throw $e;
        } finally {
            $this->validator->setRules($oldRules);
        }
    }

    public function import()
    {
        SupplierExpensesImports::query()->forceDelete();

        $data = function () {
            try {
                yield Excel::load('storage/app/fileSupplierExpensesImports.xlsx')->get()->all();
            } catch (Exception $e) {
                yield [];
            }
        };

        foreach ($data() as $rows) {
            foreach ($rows as $value) {
                $paymentType = 0;
                switch ($value->forma_pgto_fornecedor) {
                    case 'Cartão Virtual':
                        $paymentType = 2;
                        break;
                    case 'Faturado na Agência':
                        $paymentType = 1;
                        break;
                }

                $dataEmissao = $value->data_da_emissao ? $value->data_da_emissao : null;
                $check_in = $value->check_in ?? null;
                $check_out = $value->check_out ?? null;
                if ($dataEmissao && is_string($dataEmissao)) {
                    $dataEmissao = Carbon::createFromFormat('d/m/Y', explode(' ', $dataEmissao)[0]);
                }

                if ($check_in && is_string($check_in)) {
                    $check_in = Carbon::createFromFormat('d/m/Y', explode(' ', $check_in)[0]);
                }

                if ($check_out && is_string($check_out)) {
                    $check_out = Carbon::createFromFormat('d/m/Y', explode(' ', $check_out)[0]);
                }

                if ($dataEmissao == null) {
                    continue;
                }

                $obj = [
                    'issue_date' => $dataEmissao ? $dataEmissao->format('d/m/Y') : null,
                    'value' => ($value->total) ? number_format($value->total, 2, ',', '.') : 0,
                    'payment_type_provider_id' => $paymentType,
                    'note' => null,
                    'project_id' => null,
                    'debit_memo_id' => null,
                    'description_id' => $value->passageiro.' - '.($check_in ?$check_in->format('d/m/Y').' - ':'').($check_out ?$check_out->format('d/m/Y').' - ':'').$value->segmentocidade.($value->cia_operadora?' - '.$value->cia_operadora:'').' - '.$value->fornecedor,
                    'provider_id' => 4,
                    'establishment_id' => '001',
                    'voucher_type_id' => 5,
                    'exported' => 0,
                    'import' =>true,
                    'original_name' => 'DespesaImportada.jpeg',
                    's3_name' => 'https://delos-project-dgp.s3-sa-east-1.amazonaws.com/images/Despesa+Importada.jpeg',
                ];

                $projectCode = $value->projeto ? substr( $value->projeto,0,14): '00-000-0000-00';
                $project = Project::withTrashed()->where('compiled_cod', $projectCode)->first(['id']);
                $status = 'error';
                $description = '';
                if ($project != null) {
                    $obj['project_id'] = $project->id;

                    try {
                        $this->validator->with($obj)
                            ->passesOrFail(ValidatorInterface::RULE_CREATE);
                        $key_description = $value->data_da_emissao.' - '. $value->projeto . ' - '. $value->passageiro .' - '. $value->check_in. ' - '.$value->check_out;
                        $obj['key_description'] = $key_description;

                        $found = $this->repository->findWhere(['key_description'=>$key_description]);
                        if($found->isEmpty()){
                            $expense =$this->repository->create($obj);
                            event(new SavedSupplierExpenseImport($expense));
                            $status = 'success';
                            $description = 'Importado com sucesso';
                        } else{
                            $description = 'Este item já foi importado';
                        }
                       
                    } catch (ValidatorException $e) {
                        $message = '';
                        foreach ($e->getMessageBag()->messages() as $error) {
                            $message  .= '<br>' . implode('<br>', $error);
                        }
                        $description = 'Erro ao importar. ' . ltrim($message, '<br>');
                    } catch (\Exception $e) {
                        $description = 'Erro desconhecido ao importar.';
                    }
                } else {
                    $description = 'O projeto não existe';
                }

               SupplierExpensesImports::create([
                    'project_code' => $projectCode,
                    'issue_date' => $obj['issue_date'],
                    'value' => $obj['value'],
                    'provider_id' => $obj['provider_id'],
                    'status' => $status,
                    'description' => $description,
                    'date_migration' => Carbon::now()
                ]);

                
            }
        }
    }
}
