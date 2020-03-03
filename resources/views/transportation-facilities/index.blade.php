@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.transportation-facilities')</h3>
        </div>
        @include('messages')
        @can('create-transportation-facility')
        <div class="panel-body">
            <a href="{{route('transportationFacilities.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                @lang('buttons.new-transportation-facility')
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
        @foreach($transportationFacilities as $transportationFacility)
        <tr>
            <td>{{$transportationFacility->name}}</td>
            <td>
            @can('update-transportation-facility')
                <a href="{{route('transportationFacilities.edit', ['id' => $transportationFacility->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan

            @can('destroy-transportation-facility')
                <a id="{{route('transportationFacilities.destroy', ['id' => $transportationFacility->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
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
          {!! $transportationFacilities->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection