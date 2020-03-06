@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8">
                        <h3 class="panel-title bold">@lang('titles.users')</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <span title="@lang('tips.whats-users')" class="glyphicon glyphicon-question-sign black-tooltip"
                              aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            @include('messages')
            @can('create-user')
                <div class="panel-body">
                    <a href="{{route('users.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-user')
                    </a>
                </div>
            @endcan
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                @include('users.search')
            </div>

            <div class="panel-body">
                <div class="table-responsive" style="min-height: 390px;">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>@lang('headers.name')</th>
                            <th>@lang('headers.email')</th>
                            <th>@lang('headers.company')</th>
                            <th>@lang('headers.admission')</th>
                            <th>@lang('headers.role')</th>
                            <th>@lang('headers.action')</th>
                        </tr>
                        </thead>

                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->company->name ?? null}}</td>
                                <td>{{$user->admission->format('d/m/Y')}}</td>
                                <td>{{$user->role->name}}</td>
                                @if ($key <= 3)
                                    <td class="has-btn-group">
                                        <!-- Single button -->
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-users-{{$key}}">
                                                <span class="glyphicon glyphicon-cog"></span>
                                                @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                @if(!$user->deleted_at)
                                                    @can('update-user')
                                                        <li><a href="{{route('users.edit', ['id' => $user->id])}}"
                                                               id="btn-edit-users-{{$key}}">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                                            </a></li>
                                                        <li class="divider"></li>
                                                    @endcan

                                                    @can('destroy-user')
                                                        <li><a id="{{route('users.destroy', ['id' => $user->id])}}"
                                                               class="delete" style="cursor: pointer"
                                                               onclick="getModalDelete(this)">
                                                                <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                                            </a></li>
                                                        <li class="divider"></li>
                                                    @endcan
                                                        <li>
                                                            <a>
                                                                <span class="glyphicon glyphicon-file"></span>&nbsp;   Contratos
                                                            </a>
                                                        </li>


                                                @else
                                                    @can('restore-user')
                                                        <li>
                                                            <a href="{{route('users.restore', ['id' => $user->id])}}">
                                                                <span class="glyphicon glyphicon-transfer"
                                                                      aria-hidden="true"></span>
                                                                @lang('buttons.restore')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                    @endcan
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                @else
                                    <td class="has-btn-group">
                                        <!-- Single button -->
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-users-{{$key}}">
                                                <span class="glyphicon glyphicon-cog"></span>
                                                @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                @if(!$user->deleted_at)
                                                    @can('update-user')
                                                        <li><a href="{{route('users.edit', ['id' => $user->id])}}"
                                                               id="btn-edit-users-{{$key}}">
                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                                            </a></li>
                                                        <li class="divider"></li>
                                                    @endcan

                                                    @can('destroy-user')
                                                        <li><a id="{{route('users.destroy', ['id' => $user->id])}}"
                                                               class="delete" style="cursor: pointer"
                                                               onclick="getModalDelete(this)">
                                                                <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                                            </a></li>
                                                        <li class="divider"></li>
                                                    @endcan
                                                @else
                                                    @can('restore-user')
                                                        <li>
                                                            <a href="{{route('users.restore', ['id' => $user->id])}}">
                                                                <span class="glyphicon glyphicon-transfer"
                                                                      aria-hidden="true"></span>
                                                                @lang('buttons.restore')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                    @endcan
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $users->render() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection