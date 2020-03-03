@extends('layouts.app')

@section('content')

    <div class="container">
        {!! Form::open(['route' => ['financialRatings.update', 'id' => $financialRating->id], 'method' => 'PUT']) !!}
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Editar Classificação financeira: {{$financialRating->name}}</h3>
            </div>
            <div class="panel-body">
                {!! Form::hidden('id', $financialRating->id)!!}
                @include('financial-ratings.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('financialRatings.index') : url()->previous()}}" class="btn btn-default">
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