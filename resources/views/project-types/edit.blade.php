@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Editar Tipo de Projeto: {{$projectType->name}}</h3>
            </div>
            {!! Form::open(['route' => ['projectTypes.update', 'id' => $projectType->id], 'method' => 'PUT']) !!}
            <div class="panel-body">
                {!! Form::hidden('id', $projectType->id)!!}
                @include('project-types.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('projectTypes.index') : url()->previous()}}"
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
    </div>
@endsection