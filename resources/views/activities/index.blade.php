@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title bold">@lang('titles.activities')</h3>
                    </div>
                    <div class="col-md-4 col-xs-4 text-right">
                        <span title="@lang('tips.whats-activity')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>
            @include('messages')

            @if($errors->has('reported_external_activities'))
                <div class="panel-body">
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{$errors->first('reported_external_activities')}}
                    </div>
                </div>
            @endif

            @can('create-activity')
                <div class="panel-body">
                    <a href="{{route('activities.create')}}" class="btn btn-dct" id="btn-create-activity"><span
                                class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.post-hours')
                    </a>
                </div>
            @endcan

            @include('activities.search')

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>@lang('headers.collaborator')</th>
                            <th class="th-project">@lang('headers.project')</th>
                            <th style="min-width: 141px">@lang('headers.date')</th>
                            <th>@lang('headers.hours')</th>
                            <th>@lang('headers.task')</th>
                            <th>@lang('headers.place')</th>
                            <th>@lang('headers.note')</th>
                            <th>@lang('headers.created-at')</th>
                            <th>Status</th>
                            <th>@lang('headers.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $key => $activity)
                            <tr>
                                <td>{{$activity->user()->withTrashed()->first()->name}}</td>
                                <td class="has-btn-group"><a
                                            href="{{route('projects.index')}}?search={{$activity->project->compiled_cod}}">{{$activity->project->compiled_cod}}</a>
                                </td>
                                <td id="date-{{$key}}">
                                    <script>
                                        $(document).ready(function () {
                                            $("#date-{{$key}}").html(moment("{{$activity->date->toDateString()}}").format('dddd, DD MMMM YYYY'));
                                        });
                                    </script>
                                </td>
                                <td class="text-center">{{$activity->hours}}</td>
                                <td>{{$activity->task->name}}</td>
                                <td>{{$activity->place->name}}</td>
                                <td>{{$activity->note}}</td>
                                <td>{{$activity->created_at->format('d/m/Y')}}</td>
                                <td>{{$activity->approved ? trans('entries.status.approved') : trans('entries.status.waiting-for-approval') }}</td>
                                <td class="has-btn-group">
                                    @if(auth()->user()->can('destroy', $activity) || auth()->user()->can('approve-activity'))

                                        @if($key >= 3)
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn btn-default dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"
                                                        id="btn-options-activity-{{$key}}">
                                                    @lang('buttons.options') <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li class="divider"></li>
                                                    @can('download-report-activity')
                                                        @if($activity->approved && $activity->project->client)
                                                            @can('download-report-activity')
                                                                <li>
                                                                    <a href="{{route('activities.download', ['id' => $activity->id])}}">
                                                                        Baixar Comprovante
                                                                    </a>
                                                                </li>
                                                                <li class="divider"></li>
                                                            @endcan
                                                        @endif
                                                    @endcan

                                                    @can('destroy-activity', $activity)
                                                        <li>
                                                            <a class="delete"
                                                               id="{{route('activities.destroy', ['id' => $activity->id])}}">
                                                                @lang('buttons.remove')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                    @endcan

                                                    @can('approve-activity')
                                                        @if(!$activity->approved)
                                                            <li>
                                                                <a href="{{route('activities.approve', ['id' => $activity->id])}}">
                                                                    @lang('buttons.approve')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                        @endif
                                                    @endcan
                                                </ul>
                                            </div>
                                        @else
                                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btn-default dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"
                                                        id="btn-options-activity-{{$key}}">
                                                    @lang('buttons.options') <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li class="divider"></li>
                                                    @if($activity->approved && $activity->project->client)
                                                        @can('download-report-activity')
                                                            <li>
                                                                <a href="{{route('activities.download', ['id' => $activity->id])}}">
                                                                    Baixar Comprovante
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                        @endcan
                                                    @endif

                                                    @can('destroy-activity', $activity)
                                                        <li>
                                                            <a class="delete"
                                                               id="{{route('activities.destroy', ['id' => $activity->id])}}">
                                                                @lang('buttons.remove')

                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                    @endcan

                                                    @can('approve-activity', $activity)
                                                        @if(!$activity->approved)
                                                            <li>
                                                                <a href="{{route('activities.approve', ['id' => $activity->id])}}">
                                                                    @lang('buttons.approve')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                        @endif
                                                    @endcan
                                                </ul>
                                            </div>
                                        @endif
                                    @else

                                        <span title="@lang('tips.you-have-no-permission-to-edit-this-activity')"
                                              class="glyphicon glyphicon-question-sign black-tooltip"
                                              aria-hidden="true"
                                              data-toggle="tooltip" data-placement="top"></span>

                                    @endif
                                </td>
                                <td class="table-details-title"
                                    class="table-details-title">{{$activity->project->full_description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $activities->render() !!}
                </div>
            </div>
        </div>

    </div>
@endsection