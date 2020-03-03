<?php

    namespace Delos\Dgp\Http\Controllers;

    use Delos\Dgp\Entities\DebitMemo;
    use Delos\Dgp\Entities\DebitMemoAlert;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Illuminate\Contracts\Filesystem\Filesystem;
    use Illuminate\Support\Facades\Storage;
    use Maatwebsite\Excel\Facades\Excel;
    use Prettus\Validator\Exceptions\ValidatorException;

    /**
     * Class DebitMemosController
     * @package Delos\Dgp\Http\Controllers
     */
    class DebitMemosController extends AbstractController
    {
        /**
         *
         */
        private const AWS_PATH = 'Downloads/Zips/InvoicesFromProjectAndND/';

        /**
         * @param string $method
         * @param array  $parameters
         *
         * @return \Illuminate\Foundation\Application|mixed
         */
        public function __call($method, $parameters)
        {
            switch ( $method ) {
                case 'filesystem':
                    return app(Filesystem::class);
                    break;
            }

            parent::__call($method, $parameters);
        }

        /**
         * @return array
         */
        public function getMappedAbilities(): array
        {
            $abilities                = parent::getMappedAbilities();
            $abilities['show-report'] = 'show';

            return $abilities;
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function close(int $id)
        {
            $this->service->close($id);

            return $this->response->redirectToRoute('debitMemos.show', ['id' => $id]);
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show(int $id)
        {
            $debitMemo = $this->repository->find($id);

            $urlToZip = null;

            if ( $this->existsZip($debitMemo) ) {
                $urlToZip = Storage::url($this->getFullPathToZip($debitMemo->requests[0]->project, $debitMemo));
            }

            return $this->response->view("{$this->getViewNamespace()}.show", [
                    $this->getEntityName() => $debitMemo,
                    'urlToZip'             => $urlToZip
                ]);
        }

        /**
         * @param $project
         * @param $debitMemo
         *
         * @return string
         */
        private function getFullPathToZip($project, $debitMemo): string
        {
            return self::AWS_PATH . $project->compiled_cod . '/' . 'ND' . $debitMemo->code . '.zip';
        }


        /**
         * @return array
         */
        protected function getVariablesForIndexView(): array
        {
            return [
                'projects' => app(ProjectRepository::class)->getPairs()
            ];
        }

        /**
         * @param $debitMemo
         *
         * @return bool
         */
        private function existsZip($debitMemo): bool
        {
            $projectCod = $debitMemo->expenses->first()->project_full_description;
            return $this->filesystem()->exists(self::AWS_PATH . $projectCod . '/ND' . str_pad($debitMemo->number, 4, 0, STR_PAD_LEFT) . '.zip');
        }

        /**
         * @param int $id
         *
         * @return AbstractController|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function update(int $id)
        {
            try {

                $updated = $this->service->update($this->request->all(), $id);
                return $updated;
            } catch ( ValidatorException $e ) {
                return Response($e->getMessageBag(), 400);
            }
        }

        /**
         * @param int $id
         */
        public function showReport(int $id)
        {
            $debitMemo = $this->repository->find($id);
            Excel::load('resources/views/debit-memos/debit-memo-details.xlsx', function ($reader) use ($debitMemo) {

                $reader->sheet('Notas Fiscais')->setCellValue('C1', $debitMemo->project->full_description);
                $reader->sheet('Notas Fiscais')->setCellValue('C2', 'ND' . $debitMemo->code);
                $reader->sheet('Notas Fiscais')->setCellValue('C4', date('d/m/Y H:i:s'));
                $reader->sheet('Notas Fiscais')->fromArray($this->getExpensesToReport($debitMemo), null, 'A7', false, false);

            })->download('xlsx');
        }

        /**
         * Create alert to observer debit memo value and notify client
         *
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function storeAlert(int $id)
        {
            DebitMemoAlert::create([
                                       'value'         => $this->request->get('value'),
                                       'debit_memo_id' => $id,
                                       'user_id'       => \Auth::id()
                                   ]);

            return $this->redirector->route('debitMemos.show', ['id' => $id]);
        }

        /**
         * Delete debit memo alert from id
         *
         * @param int $id
         * @param int $alertId
         *
         * @return \Illuminate\Http\RedirectResponse
         * @internal param int $id
         */
        public function destroyAlert(int $id, int $alertId)
        {
            DebitMemoAlert::findOrFail($alertId)->delete();

            return $this->redirector->route('debitMemos.show', ['id' => $id]);
        }

        /**
         * @param DebitMemo $debitMemo
         *
         * @return array
         */
        private function getExpensesToReport(DebitMemo $debitMemo): array
        {
            return $debitMemo->expenses->map(function ($item) {
                return [
                    'request_id'   => $item->request_id ?? $item->project->compiled_cod,
                    'issue_date'   => $item->issue_date->format('d/m/Y'),
                    'invoice'      => $item->compiled_invoice,
                    'url_invoice'  => $item->url_file,
                    'description'  => $item->description,
                    'note'         => $item->note,
                    'collaborator' => $item->user->name,
                    'payment_type' => trans('entries.' . $item->paymentType->name),
                    'value'        => (double)(str_replace(',', '.', $item->value))
                ];
            })->toArray();
        }
    }