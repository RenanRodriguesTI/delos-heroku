@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-dct">
	    <div class="panel-heading">
	        <h3 class="panel-title bold">Editar Perfil: {{$permission->name}}</h3>
	    </div>
	    <div class="panel-body">
        {!! Form::open(['route' => ['permissions.update', 'id' => $permission->id], 'method' => 'PUT']) !!}
        {!! Form::hidden('id', $permission->id)!!}
        @include('permissions.form')
        </div>
        <div class="panel-footer">
      <div class="text-right">
            <a href="{{url()->previous() == url()->current() ? route('permissions.index') : url()->previous()}}" class="btn btn-default">
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