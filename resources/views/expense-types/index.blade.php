@extends('layouts.app')
@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">@lang('titles.expense-types')</h3>
        </div>
        @include('messages')
        @can('create-expense-type')
        <div class="panel-body">
            <a href="{{route('expenseTypes.create')}}" class="btn btn-dct">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            @lang('buttons.new-expense-type')
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
                <th>@lang('headers.code')</th>
                <th>@lang('headers.description')</th>
                <th>@lang('headers.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($expenseTypes as $expenseType)
        <tr>
            <td>{{$expenseType->cod}}</td>
            <td>{{$expenseType->description}}</td>
            <td>
            @can('update-expense-type')
                <a href="{{route('expenseTypes.edit', ['id' => $expenseType->id])}}" class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                    @lang('buttons.edit')
                </a>
            @endcan

            @can('destroy-expense-type')
                <a id="{{route('expenseTypes.destroy', ['id' => $expenseType->id])}}" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span>
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
          {!! $expenseTypes->render() !!}
      </div>
  </div>
    
    </div>
</div>
@endsection