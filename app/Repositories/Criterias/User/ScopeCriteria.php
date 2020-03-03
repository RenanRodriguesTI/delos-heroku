<?php

namespace Delos\Dgp\Repositories\Criterias\User;

use Delos\Dgp\Entities\User;
use Delos\Dgp\Policies\ProjectPolicy;
use Delos\Dgp\Policies\UserPolicy;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ScopeCriteria implements CriteriaInterface
{
    private $projectId;

    public function __construct(int $projectId)
    {
        $this->projectId = $projectId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (true === $this->haveToAddScope()) {
            $project = app(ProjectRepository::class)->find($this->projectId);

            if (app(ProjectPolicy::class)->isOwnerOrCoOwner($this->getAuthenticatedUser(), $project)) {
                return $model;
            }

            $model = $model->where('id', $this->getAuthenticatedUser()->id);
        }

        return $model;
    }

    private function haveToAddScope(): bool
    {
        $user = $this->getAuthenticatedUser();

        if (is_null($user) || (new UserPolicy())->isSuperUser($user)) {
            return false;
        }

        return !$user->role
            ->permissions
            ->contains('slug', 'show-all-projects');
    }

    private function getAuthenticatedUser(): ?User
    {
        return app('auth')->getUser();
    }
}