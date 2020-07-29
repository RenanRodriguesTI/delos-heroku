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
                    <a href="{{route('supplierExpense.create')}}" class="btn btn-dct" id="btn-create-expense">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-expense')
                    </a>
                </div>
            @endcan

            @include('supplier-expenses.search')

            <div class="panel-body">
                <div class="table-responsive" style="min-height: 390px;">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>Fornecedor</th>
                                <th>@lang('headers.issue-date')</th>
                                <th class="th-project">@lang('headers.project')</th>
                                <th>Tipo de Comprovante</th>
                                <th>@lang('headers.payment-type')</th>
                                <th class='col-buttons'>Valor</th>
                                <th>@lang('headers.description')</th>
                                <th style="display: none;">@lang('headers.note')</th>
                                <th style="min-width: 111px">@lang('headers.status')</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($expenses as $key => $expense)
                            <tr>
                                <td>{{$expense->provider->social_reason}}</td>
                                <td class="text-center">{{$expense->issue_date->format('d/m/Y')}}</td>
                                <td>{{$expense->project->compiled_cod}}</td>
                                <td>{{$expense->voucherType->name}}</td>
                                <td>{{$expense->paymentTypeProvider->name}}</td>
                                <td>R$ {{$expense->value}}</td>
                                <td>{{$expense->description_id}}</td>
                                <td>{{($expense->exported ? "Exportado":"Não Exportado")}}</td>
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
                                                        <a href="{{route('supplierExpense.edit', ['id' => $expense->id])}}"
                                                           id="btn-edit-expense-{{$key}}">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                            @lang('buttons.edit')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                @can('destroy-expense', $expense)
                                                    <li {{$expense->exported ? "disabled='disabled'" : ''}}>
                                                        <a id="{{route('supplierExpense.destroy', ['id' => $expense->id])}}"
                                                           class="delete" style="cursor: pointer;" onclick="getModalDelete(this)"><span
                                                                    class="glyphicon glyphicon-trash"></span>
                                                            @lang('buttons.remove')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                <li>
                                                    <a  href="{{$expense->url_file}}" target="_blank">
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
                                                        <a href="{{route('supplierExpense.edit', ['id' => $expense->id])}}"
                                                           id="btn-edit-expense-{{$key}}">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                            @lang('buttons.edit')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                @can('destroy-expense', $expense)
                                                    <li {{$expense->exported ? "disabled='disabled'" : ''}}>
                                                        <a id="{{route('supplierExpense.destroy', ['id' => $expense->id])}}"
                                                           class="delete" style="cursor: pointer;" onclick="getModalDelete(this)"><span
                                                                    class="glyphicon glyphicon-trash"></span>
                                                            @lang('buttons.remove')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                @endcan
                                                <li>
                                                    <a href="{{$expense->url_file}}" target="_blank">
                                                        <span class="glyphicon glyphicon-eye-open"></span> @lang('buttons.show-receipt')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                     {{ $expenses->appends(request()->input())->links() }} 
                </div>
            </div>

        </div>
    </div>
@endsection

@section('expenses.companies-select.supplier.paymentWriteOffs')
    {!! Form::open(['url' => [route('supplierExpense.paymentWriteOffs')],'method' => 'GET', 'id' => 'form-select-company-to-report-supplier-paymentWriteOffs']) !!}

    <div class="form-group col-sm-12 {{$errors->has('company_id') ? 'has-error' : ''}}">
        {!! Form::select('company_id', $companiesDown, null, [
        'class' => 'form-control',
        'required',
        ]) !!}
        <span class="help-block"><strong>{{$errors->first('company_id')}}</strong></span>
    </div>

    {!! Form::close() !!}
@endsection


@section('expenses.modal-report-supplier-apportionments')
{!! Form::open(['url' => [route('supplierExpense.apportionments')],'method' => 'GET', 'id' => 'form-select-company-to-report-supplier-apportionments']) !!}

    <div class="form-group col-sm-12 {{$errors->has('company_id') ? 'has-error' : ''}}">
        {!! Form::select('company_id', $companiesDown, null, [
        'class' => 'form-control',
        'required',
        ]) !!}
        <span class="help-block"><strong>{{$errors->first('company_id')}}</strong></span>
    </div>

    {!! Form::close() !!}
@endsection