@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="container">
            <div class="panel panel-dct">
                <div class="panel-heading">
                    <h3 class="panel-title bold">Editar Cidade: {{$city->name}}</h3>
                </div>
                {!! Form::open(['route' => ['cities.update', 'id' => $city->id], 'method' => 'PUT']) !!}
                <div class="panel-body">
                    {!! Form::hidden('id', $city->id)!!}
                    @include('cities.form')
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="{{url()->previous() == url()->current() ? route('cities.index') : url()->previous()}}"
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