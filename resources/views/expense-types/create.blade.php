@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-dct">
	    <div class="panel-heading">
	        <h3 class="panel-title bold">Criar Tipo de Despesa</h3>
	    </div>
	    <div class="panel-body">
        {!! Form::open(['route' => 'expenseTypes.index']) !!}
        @include('expense-types.form')
        </div>
        <div class="panel-footer">
      <div class="text-right">
            <a href="{{redirect()->back()->getTargetUrl() == url()->current() ? route('expenseTypes.index') : redirect()->back()->getTargetUrl()}}?deleted_at=whereNull" class="btn btn-default">
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