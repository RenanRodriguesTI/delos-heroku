<?php

namespace Delos\Dgp\Entities;
use Thread;

class ImportProposalThread extends Thread{
    protected $id, $vlr;

    public function __construct($id, $vlr) { 
        $this->id = $id;
        $this->vlr = $vlr;
    }

    public function run(){
        for($i=0;$i<2;$i++){

        }
    }
}