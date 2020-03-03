@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-xs-12 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.expenses')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-expenses')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            @include('messages')
            @can('create-expense')
                <div class="panel-body">
                    <a href="{{route('expenses.create')}}" class="btn btn-dct" id="btn-create-expense">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-expense')
                    </a>
                </div>
            @endcan

            @include('expenses.search')

            <div class="panel-body">
                <div class="table-responsive" style="min-height: 390px;">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>@lang('headers.collaborator')</th>
                                <th>@lang('headers.issue-date')</th>
                                <th class="th-project">@lang('headers.project')</th>
                                <th>@lang('headers.request-number')</th>
                                <th>@lang('headers.invoice')</th>
                                <th class="th-project">@lang('headers.value')</th>
                                <th>@lang('headers.payment-type')</th>
                                <th>@lang('headers.description')</th>
                                <th style="display: none;">@lang('headers.note')</th>
                                <th style="min-width: 111px">@lang('headers.status')</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $key => $expense)
                            <tr>
                                <td>{{$expense->user->name}}</td>
                                <td class="text-center">{{$expense->issue_date->format('d/m/Y')}}</td>
                                <td style="min-width: 125px;" class="has-btn-group"><a href="{{route('projects.index')}}?search={{$expense->project->compiled_cod}}">{{$expense->project->compiled_cod}}</a></td>
                                <td class="text-center">{{$expense->request_id ?? $expense->project->compiled_cod}}</td>
                                <td>{{$expense->compiled_invoice }}</td>
                                <td style="min-width: 82px;">R$ {{$expense->value}}</td>
                                <td>{{ $expense->paymentType->name }}</td>
                                <td>{{$expense->description}}</td>
                                <td style="display: none;">{{$expense->note}}</td>
                                <td>@lang("entries.status.{$expense->status}")</td>
                                <td class="has-btn-group">
                                    @if($key >= 3)
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn btn-default dropdown-toggle btn-sm bold"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-expense-{{$key}}">
                                                <span class="glyphicon glyphicon-cog dct-color" aria-hidden="true"></span>
                                                @lang('buttons.options') <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                @can('update-expense', $expense)
                                                    <li {{$expense->exported ? "disabled='disabled'" : ''}}>
                                                        <a href="{{route('expenses.edit', ['id' => $expense->id])}}"
                                                           id="btn-edit-expense-{{$key}}">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                            @lang('buttons.edit')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                @can('destroy-expense', $expense)
                                                    <li {{$expense->exported ? "disabled='disabled'" : ''}}>
                                                        <a id="{{route('expenses.destroy', ['id' => $expense->id])}}"
                                                           class="delete" style="cursor: pointer;" onclick="getModalDelete(this)"><span
                                                                    class="glyphicon glyphicon-trash"></span>
                                                            @lang('buttons.remove')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                <li>
                                                    <a class='toview' data-href="{{$expense->url_file}}" target="_blank">
                                                        <span class="glyphicon glyphicon-eye-open"></span> @lang('buttons.show-receipt')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                        </div>
                                    @else
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-default dropdown-toggle btn-sm bold"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-expense-{{$key}}">
                                                <span class="glyphicon glyphicon-cog dct-color" aria-hidden="true"></span>
                                                @lang('buttons.options') <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                @can('update-expense', $expense)
                                                    <li {{$expense->exported ? "disabled='disabled'" : ''}}>
                                                        <a href="{{route('expenses.edit', ['id' => $expense->id])}}"
                                                           id="btn-edit-expense-{{$key}}">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                            @lang('buttons.edit')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                @can('destroy-expense', $expense)
                                                    <li {{$expense->exported ? "disabled='disabled'" : ''}}>
                                                        <a id="{{route('expenses.destroy', ['id' => $expense->id])}}"
                                                           class="delete" style="cursor: pointer;" onclick="getModalDelete(this)"><span
                                                                    class="glyphicon glyphicon-trash"></span>
                                                            @lang('buttons.remove')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                <li>
                                                    <a class='toview' data-href="{{$expense->url_file}}" target="_blank">
                                                        <span class="glyphicon glyphicon-eye-open"></span> @lang('buttons.show-receipt')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                                <td class="table-details-title">{{$expense->project->full_description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $expenses->render() !!}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('expenses.companies-select')
    {!! Form::open(['url' => [route('expenses.report.txt')],'method' => 'GET', 'id' => 'form-select-company-to-report']) !!}

    <div class="form-group col-sm-12 {{$errors->has('company_id') ? 'has-error' : ''}}">
        {!! Form::select('company_id', $companies, null, [
        'class' => 'form-control',
        'required',
        ]) !!}
        <span class="help-block"><strong>{{$errors->first('company_id')}}</strong></span>
    </div>

    {!! Form::close() !!}
@endsection