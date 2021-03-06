@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="container">
            <div class="panel panel-dct">
                <div class="panel-heading">
                    <h3 class="panel-title bold">Editar Tipo de carro: {{$carType->name}}</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => ['carTypes.update', 'id' => $carType->id], 'method' => 'PUT']) !!}
                    {!! Form::hidden('id', $carType->id)!!}
                    @include('car-types.form')
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <a href="{{url()->previous() == url()->current() ? route('carTypes') : url()->previous()}}"
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