@extends('layouts.app')
@section('content')
<div class="container" id="budgeted-vs-actual">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title bold">Orçado x Real</h3>
                </div>
                <div class="col-md-4 text-right">
                    <span title="@lang('tips.whats-budgeted-vs-actual')"
                    class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                    data-toggle="tooltip" data-placement="left"></span>
                </div>
            </div>
        </div>

        <div class="panel-body hidden-print" style="padding: 16px 24px 0 24px;">
            {!! Form::open(['route' => 'reports.budgetedVsActual.index', 'method' => 'get']) !!}

            <div class="row">

                <div class="col-md-4 col-xs-12 col-sm-12">
                    <div class="form-group">
                        {!! Form::select('projects[]', $projects ?? [], Request::get('projects') ?? [], ['class' => 'form-control', 'data-title' => 'Selecione um projeto', 'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple' => 'multiple']) !!}
                    </div>
                </div>

                <div class="col-md-2 col-xs-12 col-sm-12">
                    <div class="form-group">
                        {!! Form::select('collaborators[]', $collaboratorsToSearch ?? [], Request::get('collaborators') ?? [], ['class' => 'form-control', 'data-title' => 'Selecione um colaborador', 'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple' => 'multiple']) !!}
                    </div>
                </div>

                <div class="col-md-2 col-xs-12 col-sm-12">
                    <div class="form-group">
                        {!! Form::select('months[]', $monthsToSearch ?? [], Request::get('months') ?? [], ['class' => 'form-control', 'data-title' => 'Selecione um mês', 'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple' => 'multiple']) !!}
                    </div>
                </div>

                <div class="col-md-2 col-xs-12 col-sm-12">
                    <div class="form-group">
                        {!! Form::select('years[]', $years ?? [], Request::get('years') ?? [], ['class' => 'form-control', 'data-title' => 'Selecione um ano', 'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple' => 'multiple']) !!}
                    </div>
                </div>

                <div class="col-md-2 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div class="btn-group">
                            {!! Form::submit('Pesquisar', ['class' => 'btn btn-dct']) !!}
                            <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('reports.budgetedVsActual.index')}}?download=true"><span
                                class="glyphicon glyphicon-cloud-download"></span>
                                @lang('buttons.export-excel')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
</div>

<div class="panel-body">

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#budgetedVsActual-values"
         aria-controls="budgetedVsActual-values" role="tab" data-toggle="tab"
         class="active">Orçado x Real (Valor)</a></li>
         <li role="presentation"><a href="#budgetedVsActual-hours" aria-controls="budgetedVsActual-hours"
             role="tab" data-toggle="tab">Orçado x Real (Horas)</a></li>
             <li role="presentation"><a href="#months" aria-controls="months" role="tab"
                 data-toggle="tab">Meses</a>
             </li>
             <li role="presentation"><a href="#collaborators" aria-controls="collaborators" role="tab"
                 data-toggle="tab">Colaboradores</a></li>
             </ul>

             <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="budgetedVsActual-values">
                    <div class="table-responsive">
                        <table class="table table-striped table-details tablesorter tablesorter-default">
                            <thead>
                                <tr>
                                    <th>Projeto</th>
                                    <th>Situação</th>
                                    <th>Valor M.O. <span title="@lang('tips.whats-total-labor')"
                                       class="glyphicon glyphicon-question-sign black-tooltip"
                                       aria-hidden="true" data-toggle="tooltip"
                                       data-placement="top"></span></th>
                                       <th>Total de Despesas <span title="@lang('tips.whats-total-expenses')"
                                        class="glyphicon glyphicon-question-sign black-tooltip"
                                        aria-hidden="true" data-toggle="tooltip"
                                        data-placement="top"></span></th>
                                        <th>Real</th>
                                        <th>Orçado</th>
                                        <th>Diferença</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($values as $value)
                                    <tr class="{{$value['difference'] < 0 ? 'danger' : ''}}">
                                        <td>{{$value['compiled_cod']}}</td>
                                        <td>{{$value['status']}}</td>
                                        <td class="money">{{number_format($value['total_labor'],2,',','.')}}</td>
                                        <td class="money">
                                            {{number_format($value['total_expenses'],2,',','.')}}
                                            <div class="description" style="display: none;">
                                                <div class="div-description-item">
                                                    <span class="name">Despesas de colaboradores</span>
                                                    <span class="value">{{number_format($value['expenses'],2,',','.')}}</span>
                                                </div>
                                                <div class="div-description-item">
                                                    <span class="name">Despesas extras</span>
                                                    <span class="value">

                                                        <span class="extra-expenses-{{$value['projects.id']}}">{{number_format($value['extra_expenses'],2,',','.')}}</span>
                                                        <span title="@lang('tips.edit-extra-expenses')"
                                                        class="glyphicon glyphicon-edit black-tooltip"
                                                        onclick="showFormUpdateExtraExpenses(this)"
                                                        aria-hidden="true" data-toggle="tooltip"
                                                        data-placement="top"
                                                        style="float: right;cursor: pointer;"></span>
                                                        
                                                        <form class="form-update-extra-expenses"
                                                        data-route="{{route('projects.updateExtraExpenses', ['id' => $value['projects.id']])}}"
                                                        data-id="{{$value['projects.id']}}"
                                                        onsubmit="formExtraExpenseOptions(this)"
                                                        style="display: none;">
                                                        {{ csrf_field() }}
                                                        <input type="text" name="extra_expenses"
                                                        placeholder="Ex.: 15,50" class="value"
                                                        value="{{number_format($value['extra_expenses'],2,',','.')}}"> <button
                                                        type="submit"
                                                        class="btn btn-dct btn-sm">Enviar</button>
                                                    </form>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="money">{{number_format($value['actual'],2,',','.')}}</td>
                                    <td class="money">{{number_format($value['budget'],2,',','.')}}</td>
                                    <td class="{{$value['difference'] < 0 ? 'text-danger bold' : 'text-success'}} money">{{number_format($value['difference'],2,',','.')}}</td>
                                    <td class="table-details-title">{{$value['description']}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="budgetedVsActual-hours">
                    <div class="table-responsive">
                        <table class="table table-striped table-details tablesorter tablesorter-default">
                            <thead>
                                <tr>
                                    <th>Projeto</th>
                                    <th>Situação</th>
                                    <th>Real</th>
                                    <th>Orçado</th>
                                    <th>Diferença</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hours as $hour)
                                <tr class="{{$hour['difference'] < 0 ? 'danger' : ''}}">
                                    <td>{{$hour['compiled_cod']}}</td>
                                    <td>{{$hour['status']}}</td>
                                    <td>{{$hour['actual']}}</td>
                                    <td>{{$hour['budget']}}</td>
                                    <td class="{{$hour['difference'] < 0 ? 'text-danger bold' : 'text-success'}}">{{$hour['difference']}}</td>
                                    <td style="display: none;">{{$hour['description']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="months">
                    <div class="table-responsive">
                        <table class="table table-striped table-details tablesorter tablesorter-default">
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th>Ano</th>
                                    <th>Código do projeto</th>
                                    <th>Projeto finalizado em</th>
                                    <th>Colaborador</th>
                                    <th>Horas trabalhadas</th>
                                    <th>Valor M.O. <span title="@lang('tips.whats-total-labor')"
                                       class="glyphicon glyphicon-question-sign black-tooltip"
                                       aria-hidden="true" data-toggle="tooltip"
                                       data-placement="top"></span></th>
                                   </tr>
                               </thead>
                               <tbody>
                                @foreach($months as $month)
                                <tr>
                                    <td>{{$month['month']}}</td>
                                    <td>{{$month['year']}}</td>
                                    <td>{{$month['compiled_cod']}}</td>
                                    <td>{{$month['date_deleted'] ?? null}}</td>
                                    <td>{{$month['name']}}</td>
                                    <td>{{$month['total_hours']}}</td>
                                    <td class="money">{{number_format($month['total_labor'], 2, ',', '.')}}</td>
                                    <td class="table-details-title">{{$month['description']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="collaborators">
                    <div class="table-responsive">
                        <table class="table table-striped tablesorter tablesorter-default table-details">
                            <thead>
                                <tr>
                                    <th>Colaborador</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collaborators as $collaborator)
                                <tr>
                                    <td>{{$collaborator['name']}}</td>
                                    <td class="has-btn-group">
                                        <a href="javascript:;" class="black-tooltip btn-edit-user-value"
                                        title="@lang('tips.edit-collaborator-value')" aria-hidden="true"
                                        data-toggle="tooltip" data-placement="left"
                                        id="user-{{$collaborator['id']}}">
                                        <span style="color: #000"
                                        class="glyphicon glyphicon-edit">&nbsp;</span><span
                                        class="money"></span> <span
                                        class="price">{{number_format($collaborator['value'], 2, ',', '.')}}</span>
                                    </a>

                                    <div class="modal fade" tabindex="-1" role="dialog"
                                    id="modal-user-{{$collaborator['id']}}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" style="color: #565656;">Alterar
                                            valor do(a): {{$collaborator['name']}}</h4>
                                        </div>
                                        {!! Form::open(['url' => '#', 'class' => 'form-user-value', 'data-route' => route('users.update.value', ['id' => $collaborator['id']]), 'data-id' => $collaborator['id']]) !!}
                                        <div class="modal-body">
                                            <div class="input-group">
                                                <div class="input-group-addon">R$</div>

                                                {!! Form::text('value', number_format($collaborator['value'], 2, ',', '.'), [
                                                'class' => 'form-control value',
                                                'required'
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Fechar
                                        </button>
                                        <button type="submit" class="btn btn-dct">
                                            <span class="glyphicon glyphicon-floppy-disk"></span>
                                            Salvar
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection