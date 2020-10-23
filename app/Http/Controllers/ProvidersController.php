<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Http\Request;
use Delos\Dgp\Entities\Provider;
use Delos\Dgp\Rules\CNPJRule;
use Delos\Dgp\Rules\TelephoneRule;
use Delos\Dgp\Rules\CNPJExistsRule;
use Delos\Dgp\Rules\CPFExistsRule;
use Delos\Dgp\Rules\CPFRule;
use Exception;
use Illuminate\Validation\ValidationException;

class ProvidersController extends AbstractController
{
    public function index()
    {
        switch ($this->request->input('searchfilter')) {
            case 'social_reason':
                $providers = Provider::where('social_reason', 'like', '%' . ltrim(rtrim($this->request->input('search'))) . '%')->orderBy('social_reason', 'asc')->paginate(10);
                break;
            case 'cnpj':
                $providers = Provider::where('cnpj', 'like', '%' . ltrim(rtrim($this->request->input('search'))) . '%')->orderBy('social_reason', 'asc')->paginate(10);
                break;
            case 'email':
                $providers = Provider::where('email', 'like', '%' . ltrim(rtrim($this->request->input('search'))) . '%')->orderBy('social_reason', 'asc')->paginate(10);
                break;
            default:
                $providers = Provider::orderBy('social_reason', 'asc')->paginate(10);
                break;
        }

        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store()
    {

        try {
            $this->request['cnpj'] = str_replace(['.', '/', '-'], '', $this->request->input('cnpj'));
            $this->validate($this->request, [
                'email' => ['required', 'email:rfc',],
                'social_reason' => 'required',
                'cnpj' => [
                    'required',
                    mb_strlen($this->request->input('cnpj')) < 12 ? new CPFRule : new CNPJRule,
                    mb_strlen($this->request->input('cnpj')) < 12 ? new CPFExistsRule : new CNPJExistsRule
                ],
                'telephone' => ['required', new TelephoneRule],
                'name' => ['required'],
                'accountnumber' => ['required']
            ]);

            Provider::create($this->getRequestDataForStoring());

            return redirect()->route('providers.index');
        } catch (ValidationException $e) {
            return $this->redirector->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
    public function edit(int $id)
    {
        $provider = Provider::find($id);

        return view('providers.edit', compact('provider'));
    }

    public function update(int $id)
    {
        try {
            $provider = Provider::find($id);
            $this->request['cnpj'] = str_replace(['.', '/', '-'], '', $this->request->input('cnpj'));
            $this->validate($this->request, [
                'email' => ['required', 'email:rfc',],
                'social_reason' => 'required',
                'cnpj' => [
                    'required',
                    mb_strlen($this->request->input('cnpj')) < 12 ? new CPFRule : new CNPJRule,
                    mb_strlen($this->request->input('cnpj')) < 12 ? new CPFExistsRule($id) : new CNPJExistsRule($id)
                ],
                'telephone' => ['required', new TelephoneRule],
                'name' => ['required'],
                'accountnumber' => ['required']
            ]);
            $provider->update($this->getRequestDataForStoring());
            return redirect()->route('providers.index');
        } catch (ValidationException $e) {
            return $this->redirector->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function destroy(int $id)
    {
        Provider::destroy($id);
        return redirect()->route('providers.index');
    }


    protected function getRequestDataForStoring(): array
    {
        $data = $this->request->all();

        $data['cnpj'] = str_replace(['.', '/', '-'], '', $data['cnpj']);
        $data['telephone'] = str_replace(['-', '(', ')', ' '], '', $data['telephone']);

        return $data;
    }
}
