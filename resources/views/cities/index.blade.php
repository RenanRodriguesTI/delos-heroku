@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.cities')</h3>
        </div>
        @include('messages')
        @can('create-city')
        <div class="panel-body">
            <a href="{{route('cities.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            @lang('buttons.new-city')
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
                <th>@lang('headers.state')</th>
                <th>@lang('headers.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cities as $city)
        <tr>
            <td>{{$city->name}}</td>
            <td>{{$city->state->name}}</td>
            <td>
            @can('update-city')
                <a href="{{route('cities.edit', ['id' => $city->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan

            @can('destroy-city')
                <a id="{{route('cities.destroy', ['id' => $city->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
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
          {!! $cities->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection