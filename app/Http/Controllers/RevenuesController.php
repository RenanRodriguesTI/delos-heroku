<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Http\Request;
use Delos\Dgp\Entities\TemporaryImport;

class RevenuesController extends Controller
{
    public function index(Request $request){
        $filter = ($request->input('status'))?$request->input('status'):'0';

        switch($filter){
            case '1':
                $proposalvalues = TemporaryImport::where('status','success')->orderBy('date_migration', 'asc')->paginate(15);
            break;
            case '2':
                $proposalvalues = TemporaryImport::where('status','error')->orderBy('date_migration', 'asc')->paginate(15);
            break;
            default:
                $proposalvalues = TemporaryImport::orderBy('date_migration', 'asc')->paginate(15);
            break;
        }

        
        return view('revenues.index',compact('proposalvalues','filter'));
    }
}
