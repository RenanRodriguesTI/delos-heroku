@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">

            <div class="panel-heading pull-left" style="margin-bottom: 15px;width: 100%;">
                <div class="hidden-md hidden-lg hidden-sm col-xs-12 nopadding" style="margin-bottom: 25px">
                    <div class="col-xs-6" style="margin-top: 7px">
                        <h5 class="panel-title text-left bold {{$debitMemo->status}}">@lang('debitMemos.index.status.' . $debitMemo->status)</h5>
                    </div>

                    <div class="col-xs-6" style="transform: translateX(7px);">
                        <a href="{{url()->previous() == url()->current() ? route("debitMemos.index") . '?status=1': url()->previous()}}" class="btn btn-default hidden-print pull-right">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            @lang('buttons.back')
                        </a>
                    </div>
                </div>

                <h3 class="panel-title text-center bold" style="font-size: 2.8em;cursor:pointer;">@lang('debitMemos.show.title')<span id="nd-code" class="nd-container">{{$debitMemo->code}}</span>
                    {!! Form::text('number', $debitMemo->code, ['class' => 'panel-title text-left bold hidden-xs', 'id' => 'nd-input', 'style' => 'font-size: 1.0em; text-align: center; width: 110px; display: none;margin-left: -11px;']) !!}
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <span title="@lang('tips.edit-debit-memo-number')" style="font-size: 12px; top: -5px;" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>
                    <a href="{{url()->previous() == url()->current() ? route("debitMemos.index") . '?status=1': url()->previous()}}" class="btn btn-default hidden-print pull-right hidden-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        @lang('buttons.back')
                    </a>
                </h3>

                <h5 class="panel-title text-left bold hidden-xs {{$debitMemo->status}}"
                    style="transform: translate(0,-27px); width: 40%">@lang('debitMemos.index.status.' . $debitMemo->status)</h5>

                <br>
                <div class="col-md-10 col-lg-10 col-sm-12 col-xs-12">
                    <h4 class="bold"
                        style="display: inline-block;">{{$debitMemo->expenses->first()->project->full_description}}</h4>

                    @if($debitMemo->alerts->pluck('user_id')->contains(\Auth::id()))
                        <br><br>

                        <blockquote>
                            <p>Alertas:

                            @foreach($debitMemo->alerts as $alert)
                                    @if($alert->user_id == \Auth::id())
                                        <span class="label label-danger debit-memo-alert">
                                            R$ {{$alert->value}} <span style="margin-left: 6px">|</span><a class="delete debit-memo-alert-exclude" id="{{route('debitMemos.destroy.alert', ['id' => $debitMemo->id, 'alertId' => $alert->id])}}" data-toggle="tooltip" data-placement="top" title="Clique para excluir o alerta">X</a>
                                        </span>
                                    @endif
                                @endforeach
                            </p>
                        </blockquote>

                        <div class="hidden-lg hidden-md">
                            <br>
                        </div>
                    @endif
                </div>

                <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    <div class="btn-group hidden-print" style="float: right">
                        @can('options-debit-memo')
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" id="btn-options-debit-memos">
                                <span class="glyphicon glyphicon-cog"></span> @lang('buttons.options') <span
                                        class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="divider"></li>
                                <li>
                                    <a href="{{route('debitMemos.showReport', ['id' => $debitMemo->id])}}"><span class="glyphicon glyphicon-cloud-download"></span>
                                        @lang('buttons.export-excel')
                                    </a>
                                </li>
                                <li class="divider" {{$urlToZip ? "" : "style=display:none;"}}></li>
                                <li {{$urlToZip ? "" : "style=display:none;"}}>
                                    <a href="{{$urlToZip}}"><span class="glyphicon glyphicon-picture"></span> Baixar Comprovantes</a>
                                </li>
                                @if(!$debitMemo->finish_at)
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#debit-memo-alert" data-toggle="modal">
                                            <span class="glyphicon glyphicon-time"></span> Adicionar alerta
                                            <span title="Crie alertas para valores da Nota de Débito" style="margin-left: 5px" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="bottom"></span>
                                        </a>
                                    </li>
                                    @can('close-debit-memo')
                                        <li class="divider"></li>
                                        <li><a href="#" class="delete"
                                               id="{{route('debitMemos.close', ['id' => $debitMemo->id])}}"><span
                                                        class="glyphicon glyphicon-folder-close"></span> @lang('buttons.finish')
                                            </a></li>
                                        <li class="divider"></li>
                                    @endcan
                                @endif
                            </ul>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="table-responsive col-xs-12">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>@lang('debitMemos.show.issue-date')</th>
                                <th>@lang('debitMemos.show.invoice')</th>
                                <th>@lang('debitMemos.show.description')</th>
                                <th>@lang('debitMemos.show.note')</th>
                                <th>@lang('headers.collaborator')</th>
                                <th>@lang('debitMemos.show.payment-type')</th>
                                <th style="min-width: 90px;">@lang('debitMemos.show.value')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($debitMemo->expenses as $expense)
                                <tr>
                                    <td>{{$expense->compiled_invoice}}</td>
                                    <td>{{$expense->issue_date->format('d/m/Y')}}</td>
                                    <td class="has-btn-group"><a href="{{$expense->url_file}}" target="_blank">Link para o comprovante</a></td>
                                    <td>{{$expense->description}}</td>
                                    <td>{{$expense->note}}</td>
                                    <td>{{$expense->user->name}}</td>
                                    <td>@lang('entries.'.$expense->paymentType->name)</td>
                                    <td>R$ {{$expense->value}}</td>
                                    <td class="table-details-title">
                                        Detalhes da nota: {{$expense->compiled_invoice}}
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="border-top: 2px solid rgba(0,0,0,.2)">
                                <td colspan="8"class="text-right">
                                    <span class="bold">@lang('debitMemos.value-total'):</span>
                                    <span> R$ {{$debitMemo->value_total}}</span>
                                </td>
                            </tr>
                        </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('debitMemos.alert.title')
    <span class="nd-container">@lang('debitMemos.show.title'){{$debitMemo->code}}</span>
@endsection

@section('debitMemos.alert.form.open')
    {!! Form::open(['route' => ['debitMemos.store.alert', 'id' => $debitMemo->id], 'method' => 'POST']) !!}
@endsection

@section('debitMemos.alert.form.close')
    {!! Form::close() !!}
@endsection
