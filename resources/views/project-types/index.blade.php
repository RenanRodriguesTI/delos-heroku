@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.project-types')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-project-types')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            @include('messages')
            @can('create-project-type')
                <div class="panel-body">
                    <a href="{{route('projectTypes.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-project-type')
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
                                <th>@lang('headers.description')</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($projectTypes as $projectType)
                            <tr>
                                <td>{{$projectType->name}}</td>
                                <td class="has-btn-group">
                                    @can('update-project-type')
                                        <a href="{{route('projectTypes.edit', ['id' => $projectType->id])}}"
                                           class="btn btn-sm btn-dct"><span class="glyphicon glyphicon-edit"></span>
                                            @lang('buttons.edit')
                                        </a>
                                    @endcan
                                    @can('tasks-project-type')
                                        <a href="{{route('projectTypes.tasks', ['id' => $projectType->id])}}"
                                        class="btn btn-default btn-sm"><span class="glyphicon glyphicon-tasks"></span>
                                            @lang('buttons.tasks')
                                        </a>
                                    @endcan
                                    @can('destroy-project-type')
                                        <a id="{{route('projectTypes.destroy', ['id' => $projectType->id])}}"
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
                    {!! $projectTypes->render() !!}
                </div>
            </div>

        </div>
    </div>
@endsection