<?php

    namespace Delos\Dgp\Repositories\Eloquent;

    use Delos\Dgp\Entities\User;
    use Delos\Dgp\Presenters\UserPresenter;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Delos\Dgp\Repositories\Criterias\LoggedUserMembersCriteria;
    use Delos\Dgp\Repositories\Criterias\User\FilterCriteria;
    use Delos\Dgp\Repositories\Criterias\User\ScopeCriteria;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Collection;

    /**
     * Class UserRepositoryEloquent
     * @package Delos\Dgp\Repositories\Eloquent
     */
    class UserRepositoryEloquent extends BaseRepository implements UserRepository
    {
        /**
         * @var array
         */
        protected $fieldSearchable = [
            'name'  => 'like',
            'email' => 'like',
            'role.name',
        ];

        /**
         * @return string
         */
        public function model()
        {
            return User::class;
        }

        /**
         * @return string
         */
        public function presenter()
        {
            return UserPresenter::class;
        }

        /**
         * @throws \Prettus\Repository\Exceptions\RepositoryException
         */
        public function boot()
        {
            parent::boot();
            $this->pushCriteria(new LoggedUserMembersCriteria('id'));
            $this->pushCriteria(new FilterCriteria());
        }

        /**
         * @param bool     $paginate
         * @param int|null $limit
         * @param array    $columns
         *
         * @return mixed
         */
        public function getCollaborators(bool $paginate = false, int $limit = null, array $columns = ['*'])
        {
            $repository = $this->whereHas('role', function (Builder $builder) {
                $builder->where('slug', 'collaborator');
            });

            if ( true === $paginate ) {
                return $repository->paginate($limit, $columns);
            }

            return $repository->all();
        }


        /**
         * @return array
         */
        public function getPairs(): array
        {
            $users = $this->orderBy('name', 'asc')
                          ->all();
            $users->transform(function ($users) {
                return [
                    'id'   => $users->id,
                    'name' => $users->name
                ];
            });

            return $users->pluck('name', 'id')
                         ->toArray();
        }


        /**
         * @param int         $projectId
         * @param string      $column
         * @param string|null $key
         *
         * @return array|\Illuminate\Support\Collection
         * @throws \Prettus\Repository\Exceptions\RepositoryException
         */
        public function getPairsOfMembersProject(int $projectId, string $column, string $key = null)
        {
            $this->pushCriteria(new ScopeCriteria($projectId));
            $repo = $this->whereHas('projects', function ($query) use ($projectId) {
                return $query->where('project_id', $projectId);
            });

            return $repo->pluck($column, $key);
        }

        /**
         * @param int $requestId
         *
         * @return iterable
         */
        public function getPairsByRequestId(int $requestId): iterable
        {
            $repository = $this->orderBy('name', 'asc')
                               ->scopeQuery(function ($builder) use ($requestId) {
                                   $builder = $builder->whereHas('requests', function ($builder) use ($requestId) {
                                       $builder->where('id', $requestId);
                                   });

                                   return $builder;
                               });

            $result = $repository->pluck('name', 'id')
                                 ->toArray();

            return $result;
        }

        /**
         * @param int $projectId
         *
         * @return iterable
         */
        public function getCollaboratorsAndCoLeaderByProjectId(int $projectId): iterable
        {
            $repo = $this->whereHas('projects', function ($query) use ($projectId) {
                return $query->where('project_id', $projectId);
            });

            $members = $repo->all();

            $members = $members->filter(function ($member) use ($projectId) {
                return $this->isCollaboratorOrCoLeader($member, $projectId);
            });

            return $members;
        }

        /**
         * @param $member
         * @param $projectId
         *
         * @return bool
         */
        private function isCollaboratorOrCoLeader($member, $projectId)
        {
            $project = $member->projects()
                              ->where('project_id', $projectId)
                              ->first();

            if ( is_null($project) ) {
                return false;
            }

            return $member->id != $project->owner->id;
        }

        /**
         * @return iterable
         */
        public function getUsersHasMissingActivities(): iterable
        {
            $this->applyCriteria();
            $repo = $this->has('missingActivities');
            $repo->all()
                 ->count();
            return $repo->all();
        }

        /**
         * @param int $roleId
         *
         * @return iterable
         */
        public function getByRoleId(int $roleId): iterable
        {
            $users = $this->findWhere(['role_id' => $roleId]);
            return $users;
        }

        /**
         * @param array $columns
         *
         * @return iterable
         */
        public function getAllUsersWhoCanBeMembers(array $columns = ['*']): iterable
        {
            $this->resetCriteria();
            $this->resetScope();

            $repository = $this->whereHas('role', function ($query) {
                return $query->whereIn('slug', ['manager', 'collaborator', 'administrative', 'administrator']);
            });

            $users = $repository->all($columns);
            return $users;
        }

        /**
         * @param int $leader
         *
         * @return iterable
         */
        public function getMembersByLeaderId(int $leader): iterable
        {
            $this->resetCriteria();
            $this->resetScope();

            $repository = $this->whereHas('projects', function ($query) use ($leader) {
                return $query->where('owner_id', $leader)
                             ->orWhere('co_owner_id', $leader);
            });

            $members = $repository->all();

            return $members;
        }

        /**
         * @param int $leader
         *
         * @return iterable
         */
        public function getMembersIdsByLeaderId(int $leader): iterable
        {
            $members = $this->getMembersByLeaderId($leader);
            $ids     = $members->modelKeys();
            return array_unique($ids);
        }

        /**
         * @return iterable
         */
        public function getManagers(): iterable
        {
            $this->applyCriteria();

            $model = $this->model->whereHas('role', function (Builder $query) {
                $query->where('slug', 'manager');
            });

            return $model->get(['name', 'email'])
                         ->toArray();
        }


        /**
         * @return $this
         */
        public function removeScopeIfSourceIsRegister()
        {
            // must remove criteria when source page is register form
            if ( strpos(\URL::previous(), 'auth/register') ) {
                $this->popCriteria(\Delos\Dgp\Repositories\Criteria\MultiTenant\ScopeCriteria::class);
            }

            return $this;
        }

        /**
         * Get users where role is Client
         * @return Collection
         */
        public function getFromClientRole(): Collection
        {
            $users = $this->whereHas('role', function (Builder $query) {
                $query->where('name', 'Client');
            });

            return $users->get();
        }
    }