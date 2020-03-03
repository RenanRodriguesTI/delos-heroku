@extends('layouts.app')
@section('content')
<div class="container">
	<div class="panel panel-dct">
		<div class="panel-heading">
			<h3 class="panel-title bold">Criar Nova Descrição de Proposta de Valor</h3>
			
	<p class="alert alert-warning" role="alert">Valor Disponível: R$ {{number_format($avaliableValue, 2, ',', '.')}}</p>
		</div>
        {!! Form::open(['route' => ['projects.descriptionValues.store', $project->id], 'id' => 'form-project']) !!}
		<div class="panel-body">

		@include('projects.proposal-values-description.form')

		</div>
		<div class="panel-footer">
			<div class="text-right">
				<a href="{{route('projects.descriptionValues.index', ['projectId' => $project->id])}}" class="btn btn-default">
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