@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Boletos</h3>
            </div>

            @include('messages')

            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#toGenerate" aria-controls="A gerar" role="tab"
                                                              data-toggle="tab">A gerar</a></li>
                    <li role="presentation"><a href="#generated" aria-controls="Gerados" role="tab" data-toggle="tab">Gerados</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="toGenerate">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-details">
                                <thead>
                                    <tr>
                                        <th>Empresa</th>
                                        <th>Data de emissão</th>
                                        <th>Data de vencimento</th>
                                        <th>Valor</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($transactionsToDo as $transaction)
                                    <tr>
                                        <td>{{$transaction->groupCompany->name}}</td>
                                        <td>{{ $transaction->billing_date->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->due_date }}</td>
                                        <td>R$ {{number_format($transaction->value_paid, 2, ',', '.')}}</td>
                                        <td class="has-btn-group">
                                            @can('update-bank-slip')
                                                <a href="{{route('bankSlips.upload', ['id' => $transaction->id])}}"
                                                   class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"
                                                                                        aria-hidden="true"></span>
                                                    Adicionar boleto
                                                </a>
                                            @endcan

                                            @can('destroy-bank-slip')
                                                <a id="{{route('bankSlips.destroy', ['id' => $transaction->id])}}"
                                                   class="btn btn-danger btn-sm delete"><span
                                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                    Cancelar Transação
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="generated">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Data de emissão</th>
                                    <th>Data de vencimento</th>
                                    <th>Valor</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactionsPendingAproval as $transaction)
                                    <tr>
                                        <td>{{$transaction->groupCompany->name}}</td>
                                        <td>{{ $transaction->billing_date->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->due_date }}</td>
                                        <td>R$ {{number_format($transaction->value_paid, 2, ',', '.')}}</td>
                                        <td>
                                            @can('approve-bank-slip')
                                                <a href="{{route('bankSlips.approve', ['id' => $transaction->id])}}"
                                                   class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"
                                                                                        aria-hidden="true"></span>
                                                    Aprovar Transação
                                                </a>
                                            @endcan

                                            @can('destroy-bank-slip')
                                                <a id="{{route('bankSlips.destroy', ['id' => $transaction->id])}}"
                                                   class="btn btn-danger btn-sm delete"><span
                                                            class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                    Cancelar Transação
                                                </a>
                                            @endcan
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