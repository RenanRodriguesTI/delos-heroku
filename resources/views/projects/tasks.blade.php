@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Tarefas do Projeto: {{$project->full_description}}</h3>
            </div>

            <div class="panel-body">

                {!! Form::open(['route' => ['projectTypes.addTask', 'id' => $project->projectType->id], 'method' => 'POST']) !!}

                <a href="{{url()->previous() == url()->current() ? route('projects.index') . '?deleted_at=whereNull' : url()->previous()}}"
                   class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </a>

                <div class="hidden-lg hidden-sm hidden-md">
                    <br>
                </div>

                <input type="hidden" name="project" value="true">

                @can('manage-project', $project)
                    {!! Form::select('tasks[]', $tasks, null, [
                        'title' => 'Selecione as tarefas',
                        'class' => 'selectpicker taskProject',
                        'multiple' => true,
                        'data-live-search' => 'true',
                        'data-actions-box' => 'true',
                        'required'
                        ]) !!}

                    <div class="hidden-lg hidden-sm hidden-md">
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
                    @endforeach
                    <br>
                @else
                    <br>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>@lang('headers.name')</th>
                            <th>@lang('headers.action')</th>
                        </tr>
                        </thead>
                        <tbody class="taskslist">
                        @foreach($projectTasks as $projectTask)
                            <tr class="task_{{$projectTask->id}}">
                                <td>{{$projectTask->name}}</td>
                                <td>
                                    @can('manage-project', $project)
                                        <a href="{{route('projectTypes.removeTask', ['id' => $project->projectType->id, 'task' => $projectTask->id])}}?project=true"
                                           type="submit" class="btn btn-danger btn-sm">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            Remover Tarefa
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection