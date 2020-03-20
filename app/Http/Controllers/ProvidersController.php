<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Http\Request;
use Delos\Dgp\Entities\Provider;
use Delos\Dgp\Rules\CNPJRule;
use Delos\Dgp\Rules\TelephoneRule;
use Delos\Dgp\Rules\CNPJExistsRule;

class ProvidersController extends AbstractController
{
    public function index(){

        switch($this->request->input('searchfilter')){
            case 'social_reason':
                $providers = Provider::where('social_reason','like','%'.$this->request->input('search').'%')->get();
            break;

            case 'cnpj':
                $providers = Provider::where('cnpj','like','%'.$this->request->input('search').'%')->get();
            break;

            case 'email':
                $providers = Provider::where('email','like','%'.$this->request->input('search').'%')->get();
            break;

            default:
                $providers = Provider::all();
            break;
        }
       
        return view('providers.index',compact('providers'));
    }

    public function create(){
        return view('providers.create');
    }

    public function store(){
        $this->request->validate([
            'email' =>['required','email:rfc',],
            'social_reason' =>'required',
            'cnpj' => ['required',new CNPJRule,new CNPJExistsRule],
            'telephone' => ['required',new TelephoneRule]
        ]);
        Provider::create($this->request->all());

        return redirect()->route('providers.index');
    }
    public function edit(int $id){
       $provider = Provider::find($id);

       return view('providers.edit',compact('provider'));
    }

    public function update(int $id){
        $provider = Provider::find($id);
        $this->request->validate([
            'email' =>['required','email:rfc',],
            'social_reason' =>'required',
            'cnpj' => ['required',new CNPJRule,new CNPJExistsRule],
            'telephone' => ['required',new TelephoneRule]
        ]);
        $provider->update($this->request->all());
        return redirect()->route('providers.index');
    }

    public function destroy(int $id){
        Provider::destroy($id);
        return redirect()->route('providers.index');
    }
}
