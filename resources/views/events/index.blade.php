@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.events')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-events')" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>@lang('headers.name')</th>
                            <th>@lang('headers.description')</th>
                            <th>@lang('headers.action')</th>
                        </tr>
                        </thead>

                        @foreach($events as $key => $event)
                            <tr>
                                <td>{{trans('events.' . $event->name)}}</td>
                                <td>{{trans('events.' . $event->description)}}</td>
                                @can('emails-event')
                                    <td class="has-btn-group"><a href="{{route('events.emails', ['id' => $event->id])}}" class="btn btn-default"><i class="fa fa-envelope" aria-hidden="true"></i> Emails</a></td>
                                @endcan
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $events->render() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection