@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.tasks')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-tasks')" class="glyphicon glyphicon-question-sign black-tooltip"
                              aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            @include('messages')

            @can('create-task')
                <div class="panel-body">
                    <a href="{{route('tasks.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-task')
                    </a>
                </div>
            @endcan
            <div class="panel-body">
                @include('search')
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>@lang('headers.name')</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->name}}</td>
                                <td class="has-btn-group">
                                    @can('update-task')
                                        <a href="{{route('tasks.edit', ['id' => $task->id])}}"
                                           class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                                            @lang('buttons.edit')
                                        </a>
                                    @endcan

                                    @can('destroy-task')
                                        <a id="{{route('tasks.destroy', ['id' => $task->id])}}"
                                           class="btn btn-danger btn-sm delete" onclick="getModalDelete(this)"><span
                                                    class="glyphicon glyphicon-trash"></span>
                                            @lang('buttons.remove')
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $tasks->render() !!}
                </div>
            </div>

        </div>
    </div>
@endsection