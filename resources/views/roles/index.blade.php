@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
    <div class="panel-heading">
        <h3 class="panel-title bold">@lang('titles.roles')</h3>
    </div>
    @include('messages')
    <div class="panel-body">
        <a href="{{route('roles.create')}}" class="btn btn-dct">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            @lang('buttons.new-role')
        </a>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>@lang('headers.slug')</th>
                        <th>@lang('headers.name')</th>
                        <th>@lang('headers.action')</th>
                    </tr>
                </thead>
                @foreach($roles as $key => $role)
                <tr>
                    <td>{{$role->slug}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <div class="btn-group">
                        @can('permissions-role')
                          <a href="{{route('roles.permissions', ['id' => $role->id])}}" class="btn btn-default btn-sm">@lang('buttons.permissions')</a>
                        @endcan
                          <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-cog dct-color"></span>
                          </button>
                          <ul class="dropdown-menu">
                            @can('update-role')<li><a href="{{route('roles.edit', ['id' => $role->id])}}"><span class="glyphicon glyphicon-edit"></span> @lang('buttons.edit')</a></li>@endcan
                            @can('destroy-role')<li id="btn-delete-roles-{{$key}}">
                                        <a id="{{route('roles.destroy', ['id' => $role->id])}}" class="delete" style="cursor: pointer" ><span class="glyphicon glyphicon-trash"></span> @lang('buttons.remove')</a>
                                </li>@endcan
                          </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="panel-footer">
      <div class="text-right">
          {!! $roles->render() !!}
      </div>
  </div>
    </div>
    </div>
</div>
@endsection