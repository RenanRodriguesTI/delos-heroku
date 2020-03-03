@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Criar Grupo de Empresas</h3>
            </div>
            {!! Form::open(['route' => ['groupCompanies.store'], 'id' => 'form-group-companies']) !!}
                @include('group-companies.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection