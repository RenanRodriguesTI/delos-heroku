<?php

namespace Delos\Dgp\Http\Controllers;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Delos\Dgp\Repositories\Contracts\EpiRepository;
use Delos\Dgp\Repositories\Contracts\CurseRepository;

class DocumentsController extends AbstractController
{

    public function index(){
        $users = app(UserRepository::class)->paginate(10);
        
        return view('documents.index',compact('users'));
    }

    public function list(int $userId){
        $epis = app(EpiRepository::class);
        
        $curses  = app(CurseRepository::class)->scopeQuery(function($query) use($userId){
            return $query->where('user_id',$userId);
        });

        if($this->request->wantsJson()){
            $epis = $epis->skipPresenter(false)->all();
            $curses = $curses->skipPresenter(false)->all();
            $found = count($epis["data"]) >0 || count($curses["data"]) >0;
            return $this->response->json([
                'epis' => $epis["data"],
                'curses' => $curses["data"]
            ],$found ? 200:404);
        }

        $epis = $epis->paginate(10);
        $curses = $curses->paginate(10);

        for($i=0; $i<count($epis);$i++){
            $epis[$i]->epi_user =  $epis[$i]->epiUser->where('user_id',$userId)->first();
            if($epis[$i]->epi_user){
                $epis[$i]->epi_user->expired = $epis[$i]->epi_user->expired;
            }
        }
        
        return view('documents.list',compact("userId","epis","curses"));
    }
}
