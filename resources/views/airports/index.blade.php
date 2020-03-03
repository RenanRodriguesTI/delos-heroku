@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.airports')</h3>
        </div>
        @include('messages')
        @can('create-airport')
        <div class="panel-body">
            <a href="{{route('airports.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            @lang('buttons.new-airport')
            </a>
        </div>
        @endcan
    <div class="panel-body">
        @include('search')
        <br/>
        <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>@lang('headers.name')</th>
                <th>@lang('headers.initials')</th>
                <th>@lang('headers.state')</th>
                <th>@lang('headers.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($airports as $airport)
        <tr>
            <td>{{$airport->name}}</td>
            <td>{{$airport->initials}}</td>
            <td>{{$airport->state->name}}</td>
            <td>
            @can('update-airport')
                <a href="{{route('airports.edit', ['id' => $airport->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan

            @can('destroy-airport')
                <a id="{{route('airports.destroy', ['id' => $airport->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
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
          {!! $airports->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection