<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Delos\Dgp\Entities\Client;
use Delos\Dgp\Entities\Group;
use Delos\Dgp\Entities\ProjectProposalValue;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\TemporaryImport;
use Carbon\Carbon;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Cast\Double;

class ImportsController extends AbstractController
{
    public function index(){
    }

    private function getContentFile($file)
    {
        return file_get_contents($file);
    }

    public function upload(Request $request){
        try{
            $this->service->validateFile($request->all());
            if ($request->has('files') && $request->file('files')->isValid()){
                Storage::put('file.xlsx', file_get_contents($request->file('files')));
                $this->service->importAllProposalValues();
               
            }

            if($this->request->wantsJson()){
                return $this->response->json([
                    'res'=> 'file is processing'
                ],200);
            }

            return redirect()->route('revenues.index');

        } catch( ValidatorException $e){
            $fileerrors = collect($e->getMessageBag()->messages());
            return view('revenues.error',compact('fileerrors'));
        }
       
    }
   
}
