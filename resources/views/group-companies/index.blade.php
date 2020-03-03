@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">@lang('titles.group-companies')</h3>
            </div>
            @include('messages')
            @if($errors->first('groupCompanies'))
                <div class="panel-body">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {!! $errors->first('groupCompanies') !!}
                    </div>
                </div>
            @endif
            @can('create-group-company')
                <div class="panel-body">
                    <a href="{{route('groupCompanies.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-group-company')
                    </a>
                </div>
            @endcan
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>@lang('headers.name')</th>
                                <th>Plano</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($groupCompanies as $groupCompany)
                            <tr>
                                <td>{{$groupCompany->name}}</td>
                                <td>{{$groupCompany->plan->name}}</td>
                                <td>
                                    @can('update-group-company')<a
                                            href="{{route('groupCompanies.edit', ['id' => $groupCompany->id])}}"
                                            class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"
                                                                             aria-hidden="true"></span>
                                        @lang('buttons.edit')
                                    </a>@endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $groupCompanies->render() !!}
                </div>
            </div>
        </div>

    </div>
@endsection