@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-dct">
		  	<div class="panel-heading">
		    <h3 class="panel-title bold">Editando projeto: {{$project->compiled_cod}}</h3>
		  	</div>
        
            {!! Form::open(['route' => ['projects.update', 'id' => $project->id], 'method' => 'PUT', 'id' => 'form-project']) !!}
                {!! Form::hidden('id', $project->id)!!}
                @include('projects.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection