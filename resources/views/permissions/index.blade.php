@extends('layouts.app')
@section('content')
<div class="container">

    <div class="panel panel-dct">
    <div class="panel-heading">
        <h3 class="panel-title bold">@lang('titles.permissions')</h3>
    </div>
    @include('messages')
    @can('create-permission')
    <div class="panel-body">
        <a href="{{route('permissions.create')}}" class="btn btn-dct">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        @lang('buttons.new-permission')
        </a>
    </div>
    @endcan

    <div class="panel-body" style="padding: 16px 24px 0 24px;">
    @include('search')
    </div>

    <div class="panel-body">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>@lang('headers.slug')</th>
                <th>@lang('headers.name')</th>
                <th>@lang('headers.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($permissions as $permission)
        <tr>
            <td>{{$permission->slug}}</td>
            <td>{{$permission->name}}</td>
            <td>
            @can('update-permission')
                <a href="{{route('permissions.edit', ['id' => $permission->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan
            @can('destroy-permission')
                <a id="{{route('permissions.destroy', ['id' => $permission->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
                    @lang('buttons.remove')
                </a>
            @endcan
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <div class="panel-footer">
      <div class="text-right">
          {!! $permissions->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection