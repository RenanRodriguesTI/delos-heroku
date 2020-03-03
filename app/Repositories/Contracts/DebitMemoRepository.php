<?php
/**
 * Created by PhpStorm.
 * User: delos
 * Date: 10/02/2017
 * Time: 18:19
 */

namespace Delos\Dgp\Repositories\Contracts;

interface DebitMemoRepository extends RepositoryInterface
{
    public function getAllOpened();

    public function getAllFinished();

    public function verifyExistsProjectAttached(int $id);

    public function getAllOpenedAndEmptyRelationships() : iterable;

    public function getLastNumberByCompanyType(string $path, int $id) : int;
}