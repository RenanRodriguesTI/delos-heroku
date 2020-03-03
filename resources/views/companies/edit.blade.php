@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Editar Empresa:</h3>
            </div>
            {!! Form::open(['route' => ['companies.update', 'id' => $company->id], 'method' => 'PUT', 'id' => 'form-companies']) !!}
                @include('companies.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection