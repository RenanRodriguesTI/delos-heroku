@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.companies')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-companies')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            @include('messages')
            @if($errors->first('companies'))
                <div class="panel-body">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {!! $errors->first('companies') !!}
                    </div>
                </div>
            @endif
            @can('create-company')
                <div class="panel-body">
                    <a href="{{route('companies.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-company')
                    </a>
                </div>
            @endcan
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>@lang('headers.name')</th>
                            <th>@lang('headers.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>{{$company->name}}</td>
                                <td>
                                    @can('update-company')<a href="{{route('companies.edit', ['id' => $company->id])}}"
                                                             class="btn btn-dct btn-sm"><span
                                                class="glyphicon glyphicon-edit" aria-hidden="true"></span>
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
                    {!! $companies->render() !!}
                </div>
            </div>
        </div>

    </div>
@endsection