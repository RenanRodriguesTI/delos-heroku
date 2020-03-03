<?php
/**
 * Created by PhpStorm.
 * User: delos
 * Date: 10/02/2017
 * Time: 18:21
 */

namespace Delos\Dgp\Services;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\DebitMemoRepository;

class DebitMemoService extends AbstractService
{
    public function repositoryClass(): string
    {
        return DebitMemoRepository::class;
    }

    /**
     * Close Debit Memo from id
     * @param int $id
     * @return mixed
     */
    public function close(int $id)
    {
        $today = Carbon::now();

        $debitMemo = $this->repository->find($id);
        $debitMemo->update(['finish_at' => $today]);

        return $debitMemo;
    }
}