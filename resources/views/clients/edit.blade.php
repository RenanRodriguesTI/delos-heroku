@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Editar Cliente</h3>
            </div>
            {!! Form::open(['route' => ['clients.update', 'id' => $client->id], 'method' => 'PUT', 'id' => 'form-client']) !!}
            <div class="panel-body">
                {!! Form::hidden('id', $client->id)!!}
                @include('clients.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('clients.index') : url()->previous()}}"
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