@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.holidays')</h3>
        </div>
        @include('messages')
        @can('create-holiday')
        <div class="panel-body">
            <a href="{{route('holidays.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            @lang('buttons.new-holiday')
            </a>
        </div>
        @endcan
    <div class="panel-body">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>@lang('headers.description')</th>
                <th>@lang('headers.date')</th>
                <th>@lang('headers.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($holidays as $holiday)
        <tr>
            <td>{{$holiday->description}}</td>
            <td>{{$holiday->date->format('d/m/Y')}}</td>
            <td>
            @can('update-holiday')
                <a href="{{route('holidays.edit', ['id' => $holiday->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan

            @can('destroy-holiday')
                <a id="{{route('holidays.destroy', ['id' => $holiday->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
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
          {!! $holidays->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection