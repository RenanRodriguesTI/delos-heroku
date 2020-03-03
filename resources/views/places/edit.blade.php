@extends('layouts.app')

@section('content')
    <div class="container">
        {!! Form::open(['route' => ['places.update', 'id' => $place->id], 'method' => 'PUT']) !!}
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Editar Local: {{$place->name}}</h3>
            </div>
            <div class="panel-body">
                {!! Form::hidden('id', $place->id)!!}
                @include('places.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('places.index') : url()->previous()}}" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Voltar
                    </a>
                    <button name="save" type="submit" class="btn btn-dct">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        Salvar
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection