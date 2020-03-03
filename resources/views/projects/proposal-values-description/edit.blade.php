@extends('layouts.app')

@section('content')

  	<div class="container">
        <div class="panel panel-dct">
	    <div class="panel-heading">
	        <h3 class="panel-title bold">Editar Descrição de Valor do Projeto: {{$project->full_description}}</h3>
            <p class="alert alert-warning" role="alert">Valor da disponível: R$ {{number_format($avaliableValue, 2, ',', '.')}}</p>  
        </div>

		{!! Form::open(['route' => ['projects.descriptionValues.update', 'id' => $proposalValueDescription->id], 'method' => 'PUT']) !!}
		<div class="panel-body">
        {!! Form::hidden('id', $project->id)!!}
        @include('projects.proposal-values-description.form')
        </div>
		<div class="panel-footer">
			<div class="text-right">
				<a href="{{url()->previous() == url()->current() ? route('projects.descriptionValues.index', $project->id) : url()->previous()}}" class="btn btn-default">
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