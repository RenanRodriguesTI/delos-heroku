@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Editar Grupo de Empresas:</h3>
            </div>
            {!! Form::open(['route' => ['groupCompanies.update', 'id' => $groupCompany->id], 'method' => 'PUT', 'id' => 'form-group-companies']) !!}
                @include('group-companies.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection