@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">@lang('titles.modules')</h3>
            </div>
            @include('messages')
            @can('create-module')
                <div class="panel-body">
                    <a href="{{route('modules.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-module')
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
                                <th style="width: 191px">@lang('headers.name')</th>
                                <th>@lang('headers.permissions')</th>
                                <th style="min-width: 354px;">@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td>{{$module->name}}</td>
                                <td>{{$module->permissions->implode('name', ', ')}}</td>
                                <td class="has-btn-group">
                                    @can('update-module')
                                        <a href="{{route('modules.edit', ['id' => $module->id])}}"
                                           class="btn btn-dct btn-sm">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            @lang('buttons.edit')
                                        </a>
                                    @endcan

                                    @can('update-module')
                                        <a href="{{route('modules.permissions', ['id' => $module->id])}}"
                                           class="btn btn-default btn-sm">
                                            <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                                            @lang('headers.permissions')
                                        </a>
                                    @endcan

                                    @can('destroy-module')
                                        <a class="btn btn-danger btn-sm delete"
                                           id="{{route('modules.destroy', ['id' => $module->id])}}" onclick="getModalDelete(this)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
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
                    {!! $modules->render() !!}
                </div>
            </div>
        </div>


    </div>
@endsection