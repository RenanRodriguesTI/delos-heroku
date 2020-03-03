@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Subtarefas da Tarefa: {{$task->name}}</h3>
            </div>

            @include('messages')

            <div class="panel-body">

                {!! Form::open(['route' => ['tasks.addSubtasks', 'id' => $task->id], 'method' => 'POST']) !!}

                <a href="{{url()->previous() == url()->current() ? route('tasks.index') : url()->previous()}}"
                   class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    @lang('buttons.back')
                </a>

                <div class="hidden-lg hidden-sm hidden-md">
                    <br>
                </div>

                @can('add-tasks-phase')
                        {!! Form::select('tasks[]', $subtasks, null, [
                            'title' => 'Selecione as subtarefas',
                            'class' => 'selectpicker subtasksTask',
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
                        Adicionar Subarefa
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
                        @foreach($task->subtasks as $subtask)
                            <tr class="task_{{$subtask->id}}">
                                <td>{{$subtask->name}}</td>
                                <td>
                                    @can('remove-subtask-task')
                                        <a href="{{route('tasks.removeTask', ['id' => $subtask->id, 'task' => $subtask->id])}}"
                                           class="btn btn-danger btn-sm">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            Remover Subtarefa
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