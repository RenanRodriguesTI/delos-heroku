<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Exceptions\CannotRemoveUserException;
use Delos\Dgp\Policies\UserPolicy;
use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Delos\Dgp\Repositories\Contracts\RoleRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use Carbon\Carbon;

class UsersController extends AbstractController
{
    protected $repository;
    protected $service;

    protected function getVariablesForPersistenceView(): array
    {
        return [
            'roles' => app(RoleRepository::class)->findWhereNotIn('slug', ['root'])->pluck('name', 'id'),
            'companies' => app(CompanyRepository::class)->pluck('name', 'id'),
            'groupCompanies' => app(GroupCompanyRepository::class)->pluck('name', 'id')
        ];
    }

    public function changePassEdit(Request $request)
    {
        $success = $request->has('changedPass');
        return $this->response->view('users.change-pass', compact('success'));
    }

    public function changePassUpdate(Request $request, AuthManager $auth)
    {
        $this->validate($request, [
            'password' => 'required|string|confirmed|min:6|max:255',
        ]);

        $auth->getUser()->update(['password' => password_hash($request->input('password'), PASSWORD_BCRYPT)]);

        return $this->response
            ->redirectToRoute('users.changePassEdit')
            ->with('message', 'Senha alterada com sucesso');
    }

    public function destroy(int $id)
    {
        try {

            return parent::destroy($id);

        } catch (CannotRemoveUserException $e) {

            return $this->response
                ->redirectToRoute($this->getRouteAliasForIndexAction())
                ->with('error', trans("exception-messages.{$e->getMessage()}"));
        }
    }

    public function login()
    {
        $this->repository->orderBy('name', 'asc');
        $users = $this->repository->all(['name', 'id'])->pluck('name', 'id');
        return $this->response->view('users.login', compact('users'));
    }

    public function attempt(Request $request, AuthManager $authManager)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id'
        ]);

        $id = $request->input('user_id');
        $authManager->loginUsingId($id);
        session(['groupCompanies' => [\Auth::user()->group_company_id]]);

        if (app(UserPolicy::class)->isSuperUser(\Auth::user())) {
            session(['groupCompanies' => app(GroupCompanyRepository::class)->pluck('id')->toArray()]);
        }

        session(['companies' => \Auth::user()->groupCompany->companies()->pluck('id')->toArray()]);
        return $this->response->redirectTo('/');
    }

    public function getMappedAbilities(): array
    {
        $abilities = parent::getMappedAbilities();
        $abilities['attempt'] = 'login';
        $abilities['change-pass-update'] = 'change-pass-edit';

        return $abilities;
    }

    public function index()
    {
        $this->repository->orderBy('name', 'asc');
        return parent::index();
    }

    public function changeAvatar()
    {
        $base64 = $this->request->input('base64');
        \Auth::user()->update(['avatar' => $base64]);
        return redirect()->back();
    }

    public function store()
    {
        try {
            $data = $this->getRequestDataForStoring();

            if (!$this->request->get('group_company_id')) {
                $data['group_company_id'] = \Auth::user()->group_company_id;
            }

            $this->service->create($data);

            return $this->response
                ->redirectTo($this->getInitialUrlIndex())
                ->with('success', $this->getMessage('created'));
        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }

    public function changeCompanies()
    {
        $this->validate($this->request, [
            'companies' => ['required', 'exists:companies,id']
        ]);

        $companies = $this->request->get('companies');

        session(['companies' => $companies]);

        return $this->response->json(['message' => 'The Companies has been updated', 200]);
    }

    public function changeGroupCompanies()
    {
        $this->validate($this->request, [
            'groupCompanies' => ['required', 'exists:group_companies,id']
        ]);

        $companies = $this->request->get('groupCompanies');

        session(['groupCompanies' => $companies]);

        return $this->response->json(['message' => 'The Group Companies has been updated', 200]);
    }

    /**
     * Update only value
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateValue(int $id)
    {
        try {
            $this->repository->makeModel()
                ->withTrashed()
                ->find($id)
                ->update([
                    'value' => doubleval(str_replace(',', '.',str_replace('.', '', $this->request->all()['value'])))
                ]);
            return $this->response
                ->json(['message' => trans("messages.edited", ['resource' => 'Valor'])], 200);

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}