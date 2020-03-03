<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Permission;
use Delos\Dgp\Presenters\PermissionPresenter;
use Delos\Dgp\Repositories\Contracts\PermissionRepository;

class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    protected $fieldSearchable = [
        'slug' => 'like',
        'name' => 'like',
    ];

    public function model()
    {
        return Permission::class;
    }

    public function presenter()
    {
        return PermissionPresenter::class;
    }

    public function getDiffPairsByUserId(int $userId): iterable
    {
        $allPermissions = $this->all();

        $repo = $this->whereHas('users', function($query) use($userId) {
            $query = $query->where('user_id', $userId);
            return $query;
        });

        $diff = $allPermissions->diff($repo->all());

        $pairs = $diff->pluck('name', 'id');

        return $pairs->toArray();
    }

    public function getPermissionsIdsByRoleId(int $roleId): iterable
    {
        $repo = $this->whereHas('roles', function ($query) use ($roleId) {
            $query = $query->where('role_id', $roleId);
            return $query;
        });

        $repo = $this->pluck('id');
        return $repo->toArray();
    }
}
