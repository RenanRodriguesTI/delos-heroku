@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.states')</h3>
        </div>
        @include('messages')
        @can('create-state')
        <div class="panel-body">
            <a href="{{route('states.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            @lang('buttons.new-state')
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
                <th>@lang('headers.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($states as $state)
        <tr>
            <td>{{$state->name}}</td>
            <td>
                <div class="btn-group">
                    @can('index-city')
                    <a href="{{route('cities.index', ['search' => $state->name, 'searchFields' => 'state.name:='])}}" class="btn btn-default btn-sm">
                        @lang('buttons.cities')
                    </a>
                    @endcan
                    <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-cog dct-color"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @can('update-state')<li><a href="{{route('states.edit', ['id' => $state->id])}}"><span class="glyphicon glyphicon-edit"></span>
                            @lang('buttons.edit')
                            </a></li>@endcan
                        @can('destroy-state')<li><a id="{{route('states.destroy', ['id' => $state->id])}}" class="delete" style="cursor: pointer"><span class="glyphicon glyphicon-trash"></span>
                                @lang('buttons.remove')
                            </a></li>@endcan
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <div class="panel-footer">
      <div class="text-right">
          {!! $states->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection