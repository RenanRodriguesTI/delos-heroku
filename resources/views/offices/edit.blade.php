@extends('layouts.app')
@section('content')
<div class='container'>
        <div class='panel panel-dct'>
            <div class='panel-heading'>
    
                <h2 class='panel-title bold'>Cargo: {{$office->name}}</h2>
            </div>
            <div class='panel-body'>
                <a href="{{url()->previous() == url()->current() ? route('office.index') . '?deleted_at=whereNull' : url()->previous()}}" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </a>

               
                <div class="pull-right">
                    <div class="btn-group">

                    @if($lastHistory->isEmpty())
                    <button type='button' data-toggle='modal' data-target='#office-history-form' class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                         Adicionar
                    </button>
                    @else
                    <button type='button' data-toggle='modal' data-target='#office-finish-form' class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                         Adicionar
                    </button>
                    @endif
                   
                    </div>
                </div>
               
            </div>
            @include('offices.history.index')
            <div>
            
            </div>

</div>


{!! Form::open(['route'=>['office.update','id'=>$office->id],'method' =>'post','id'=>'office-add']) !!}
    @include('offices.form')
{!! Form::close()!!}
@endsection