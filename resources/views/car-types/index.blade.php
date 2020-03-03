@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.car-types')</h3>
        </div>
        @include('messages')
        @can('create-car-type')
        <div class="panel-body">
            <a href="{{route('carTypes.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            @lang('buttons.new-car-type')
            </a>
        </div>
        @endcan
    <div class="panel-body">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>@lang('headers.name')</th>
                <th>@lang('headers.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($carTypes as $carType)
        <tr>
            <td>{{$carType->name}}</td>
            <td>
            @can('update-car-type')
                <a href="{{route('carTypes.edit', ['id' => $carType->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan

            @can('destroy-car-type')
                <a id="{{route('carTypes.destroy', ['id' => $carType->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
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
          {!! $carTypes->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection