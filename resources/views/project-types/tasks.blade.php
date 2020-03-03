@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Tarefas do Tipo de Projeto: {{$projectType->name}}</h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['route' => ['projectTypes.addTask', 'id' => $projectType->id], 'class' => 'form-inline']) !!}

                <a href="{{url()->previous() == url()->current() ? route('tasks.index') : url()->previous()}}"
                   class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </a>

                <div class="hidden-sm hidden-md hidden-lg">
                    <br>
                </div>

                @can('add-task-project-type')
                    {!! Form::select('tasks[]', $tasks, null, [
                        'title' => 'Selecione as tarefas',
                        'class' => 'selectpicker',
                        'multiple' => true,
                        'data-live-search' => 'true',
                        'data-actions-box' => 'true',
                        'required'
                    ]) !!}

                    <div class="hidden-sm hidden-md hidden-lg">
                        <br>
                    </div>

                    <button type="submit" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus"></span>
                        Adicionar Tarefa
                    </button>
                @endcan

                {!! Form::close() !!}

                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                        <br>
                    @endforeach
                @else
                    <br>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Ação</th>
                        </tr>
                        </thead>

                        @foreach($projectTypeTasks as $projectTypeTask)
                            <tr>
                                <td>{{$projectTypeTask->name}}</td>
                                <td class="has-btn-group">
                                    @can('remove-task-project-type')
                                        <a href="{{route('projectTypes.removeTask', ['id' => $projectType->id, 'task' => $projectTypeTask->id])}}"
                                           class="btn btn-danger btn-sm">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            Remover Tarefa
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection