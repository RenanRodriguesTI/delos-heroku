@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.groups')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 hidden-xs text-right">
                        <span title="@lang('tips.whats-groups')" class="glyphicon glyphicon-question-sign black-tooltip"
                        aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>
            @include('messages')
            @can('create-group')
                <div class="panel-body">
                    <a href="{{route('groups.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-group')
                    </a>
                </div>
            @endcan
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                @include('search')
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>@lang('headers.code')</th>
                            <th>@lang('headers.name')</th>
                            <th>@lang('headers.clients')</th>
                            <th style="min-width: 265px;">@lang('headers.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td class="text-center">{{$group->cod}}</td>
                                <td>{{$group->name}}</td>
                                <td>{{$group->clients->implode('name', ', ')}}</td>
                                <td class="has-btn-group">
                                    @can('update-group')
                                        <a href="{{route('groups.edit', ['id' => $group->id])}}" class="btn btn-dct btn-sm">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            @lang('buttons.edit')
                                        </a>
                                    @endcan

                                    @can('destroy-group')
                                        <a class="btn btn-danger btn-sm delete"
                                           id="{{route('groups.destroy', ['id' => $group->id])}}"
                                           onclick="getModalDelete(this)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            @lang('buttons.remove')
                                        </a>
                                    @endcan
                                </td>
                                <td class="table-details-title">{{$group->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $groups->render() !!}
                </div>
            </div>
        </div>


    </div>
@endsection