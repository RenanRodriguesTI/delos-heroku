@extends('layouts.app')

@section('content')
        
    <div class="container">
        <ul class="nav nav-tabs">
            <li id='link-usuario' class="active"><a data-toggle="tab" href="#usuario">Usuário</a></li>
            @if(strrpos(mb_strtoupper($user->name),'PS')>-1)
            <li id='link-contratos'><a data-toggle="tab" href="#contratos">Contratos</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <div id="usuario" class="panel panel-dct  tab-pane fade in active">
                <div class="panel-heading display-flex-space-between-wh-100">
                    <h3 class="panel-title bold">Editar Usuário: {{$user->name}}</h3>    
                </div>
                {!! Form::open(['route' => ['users.update', 'id' => $user->id], 'method' => 'PUT', 'id' => 'form-users']) !!}
                <div class="panel-body">
                    {!! Form::hidden('id', $user->id)!!}
                    @include('users.form')
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="{{url()->previous() == url()->current() ? route('users.index') . '?deleted_at=whereNull' : url()->previous()}}"
                           class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            Voltar
                        </a>
                        <button type="submit" class="btn btn-dct">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            Salvar
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <div id="contratos" class="panel panel-dct tab-pane fade">
                <div class="panel-heading">
                    <h3 class="panel-title bold">Contratos: {{$user->name}}</h3>
                </div>
                @include('users.contracts.index')
            </div>
        </div>
       

      

    </div>
@endsection