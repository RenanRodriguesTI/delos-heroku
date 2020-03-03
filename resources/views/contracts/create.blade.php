@extends('layouts.app')
@section('content')
<div class="container">
	<div class="panel panel-dct">
		<div class="panel-heading">
			<h3 class="panel-title bold">Criar Nova Descrição de Proposta de Valor</h3>
			
	{{-- <p class="alert alert-warning" role="alert">Valor Disponível: R$ {{number_format($avaliableValue, 2, ',', '.')}}</p> --}}
		</div>
        {!! Form::open(['route' => ['contracts.store', $userId], 'id' => 'form-contracts']) !!}
		<div class="panel-body">

		@include('contracts.form')

		</div>
		<div class="panel-footer">
			<div class="text-right">
				<a href="{{route('contracts.index', ['userId' => $userId])}}" class="btn btn-default">
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