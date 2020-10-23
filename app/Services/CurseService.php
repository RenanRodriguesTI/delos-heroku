<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\CurseRepository;
use Delos\Dgp\Events\CurseUploadedFile;

class CurseService extends AbstractService
{

    public function repositoryClass(): string
    {
        return CurseRepository::class;
    }

    public function create(array $data)
    {
        $curse = parent::create($data);

        if($this->isUpload($data)){
            $this->event->fire(new CurseUploadedFile($curse));
        }
        return $curse;
    }

    public function update(array $data, $id)
    {
        $curse = parent::update($data, $id);
        if($this->isUpload($data)){
            $this->event->fire(new CurseUploadedFile($curse));
        }
        return $curse;
    }

    public function delete($id)
    {
        $curse = $this->repository->find($id);
        parent::delete($id);
        return $curse;
    }


    private function isUpload(array $data): bool
    {
        return array_key_exists('file', $data) && !empty($data['file']);
    }
}
