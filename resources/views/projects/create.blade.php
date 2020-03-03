@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Criar Projeto</h3>
            </div>
            {!! Form::open(['route' => ['projects.store'], 'id' => 'form-project']) !!}
            @include('projects.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection