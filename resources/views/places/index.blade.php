@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.places')</h3>
        </div>
        @include('messages')
        @can('create-place')
         <div class="panel-body">
            <a href="{{route('places.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                @lang('buttons.new-place')
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
        @foreach($places as $place)
        <tr>
            <td>{{$place->name}}</td>
            <td>
            @can('update-place')
                <a href="{{route('places.edit', ['id' => $place->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan
            @can('destroy-place')
                <a id="{{route('places.destroy', ['id' => $place->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
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
          {!! $places->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection