@extends('layouts.app')

@section('content')

    <div class="container">
        {!! Form::open(['route' => 'permissions.index']) !!}
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Criar Permissão</h3>
            </div>
            <div class="panel-body">
                @include('permissions.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('permissions.index') : url()->previous()}}" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Voltar
                    </a>
                    <button name="save" type="submit" class="btn btn-dct">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        Salvar
                    </button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection