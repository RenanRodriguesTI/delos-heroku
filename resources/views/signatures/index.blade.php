@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-xs-12">
                <div class="panel-heading">
                    <h3 class="panel-title bold">Assinatura e cobrança</h3>
                </div>

                @include('messages')

                <div class="panel-body" data-without-height="true" style="padding: 0 24px;">
                    <br>
                    <h6 class="bold" style="color: #b1b1b1">Status do plano: {{\Auth::user()->groupCompany->plan_status ? 'Ativo' : 'Cancelado'}}</h6>
                    <div class="jumbotron col-md-4 col-sm-12">
                        <div class="container">
                            <h6 class="bold" style="display: inline-block;">Plano: {{$actualPlan->name ?? null}}</h6>
                            <a href="{{route('selectPlan')}}" style="margin-left: 13.5px; font-size: 16px; float: right;">Alterar Plano</a>
                            <h4 class="bold" style="margin-bottom: 0">R$ {{number_format($actualPlan->value ?? 0, 2, ',', '.')}}</h4>
                            <span class="line"></span>
                            <p style="font-size: 13.5px;">Data estimada para próxima cobrança:</p>
                            <p><i class="fa fa-calendar" aria-hidden="true"></i> <span id="date" style="margin-left: 7px"></span></p>
                            @if(isset($date))
                                <script>
                                    $(document).ready(function () {
                                        $('#date').html(moment("{!! $date->toDateString() !!}").format('dddd, DD MMMM YYYY'));
                                    });
                                </script>
                            @endif
                        </div>
                    </div>

                    @if(isset($transactionPending))
                        <div class="jumbotron col-md-4 col-md-push-4 col-xs-12" style="background-color: #24A830 !important;color: #fff !important;">
                            <div class="container">
                                <h6 class="bold" style="display: inline-block;opacity: 0;"></h6>
                                <h4 class="bold text-center" style="margin-bottom: 0;color: #fff;">Seu boleto foi gerado</h4>
                                <span class="line"></span>
                                <p style="font-size: 13.5px;opacity:0;">...</p>
                                <p class="text-center"><a href="{{$transactionPending->url}}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-external-link" aria-hidden="true"></i> <span style="margin-left: 7px">Clique aqui para baixa-lo</span></a></p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <br>

            <div class="col-xs-12">
                <div class="panel-heading" style="padding-top: 0">
                    <h3 class="panel-title bold">Forma de pagamento</h3>
                </div>
                <div class="panel-body col-md-6" data-without-height="true">
                    <p style="font-size: 15px;"><i class="fa fa-barcode" aria-hidden="true"></i> <span class="bold" style="margin-left: 8px;">BOLETO</span></p>
                    {{--<a href="#" style="margin-left: 13.5px; font-size: 16px;">Alterar informações de pagamento</a>--}}
                </div>
            </div>

            <div class="col-xs-12">
                <div class="panel-heading col-md-12" style="padding-top: 0;margin-top: 15px;">
                    <h3 class="panel-title bold">Transações realizadas</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Data</th>
                                <th>Pagamento</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->id}}</td>
                                    <td>{{$transaction->billing_date->format('d/m/Y')}}</td>
                                    <td>{{!is_null($transaction->payday) ? $transaction->payday->format('d/m/Y') : 'NÃO REALIZADO'}}</td>
                                    <td>{{$transaction->status}}</td>
                                    <td>R$ {{number_format($transaction->value_paid, 2, ',', '.')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="panel-heading" style="padding-top: 0">
                    <h3 class="panel-title bold">Cancelamento de assinatura</h3>
                </div>
                <div class="panel-body">
                        <a href="{{\Auth::user()->groupCompany->plan_status ? route('signatures.cancellation') : 'javascript:;'}}" class="btn btn-dct" {{\Auth::user()->groupCompany->plan_status ? '' : "disabled='disabled'"}}>Cancelar Assinatura</a>
                </div>
            </div>
        </div>
    </div>
@endsection