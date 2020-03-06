<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Http\Request;
use Delos\Dgp\Entities\TemporaryImport;
use Carbon\Carbon;
class RevenuesController extends Controller
{
    public function index(Request $request){
        $filter = ($request->input('status'))?$request->input('status'):'0';
        $last = TemporaryImport::orderBy('created_at','desc')->first();
        $date =null;
        if($last){
            $date = $last->created_at->format('d/m/Y H:i');
        }

        switch($filter){
            case '1':
                $proposalvalues = TemporaryImport::where('status','success')->paginate(15);
            break;
            case '2':
                $proposalvalues = TemporaryImport::where('status','error')->paginate(15);
            break;
            default:
                $proposalvalues = TemporaryImport::paginate(15);
            break;
        }

        
        return view('revenues.index',compact('proposalvalues','filter','date'));
    }
}
