@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">Detalhes da Solicitação</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">
                            N&#8304; da Solicitação: {{$request->id}} &nbsp;&nbsp;&nbsp;
                            De: {{$request->start->format('d/m/Y')}} &nbsp;&nbsp;&nbsp;
                            Até: {{$request->finish->format('d/m/Y')}}</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">
                                <b>Projeto: </b>{{$request->project->full_description}}</span> {{-- {{$project->full_description}} --}} </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">
                                <b>Observação: </b>{{$request->notes ?? null}}</td>            
                        </tr>
                    </thead>
                </table>
                
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($request->children as $key => $childRequest)
                    <li role="presentation" class="{{$key == 0 ? 'active' : ''}}"><a href="#{{$childRequest->id}}"
                        aria-controls="{{$childRequest->id}}"
                        role="tab"
                        data-toggle="tab">{{$childRequest->users->implode('name', ', ')}}</a>
                    </li>
                    @endforeach
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach($request->children  as $key => $childRequest)
                    <div role="tabpanel" class="tab-pane{{$key == 0 ? ' active' : ''}}" id="{{$childRequest->id}}">
                        
                        
                        <ul class="nav nav-tabs" role="tablist">
                            @if($childRequest->tickets->count() > 0)
                            <li role="presentation" class="active"><a href="#Passagem_{{$childRequest->id}}"
                                aria-controls="Passagem_{{$childRequest->id}}"
                                role="tab" data-toggle="tab">Passagem</a>
                            </li>
                            @endif
                            @if($childRequest->car !== null)
                            <li role="presentation"><a href="#Carros_{{$childRequest->id}}"
                                aria-controls="Carros_{{$childRequest->id}}" role="tab"
                                data-toggle="tab">Carros</a></li>
                                @endif
                                
                                @if($childRequest->lodging !== null)
                                <li role="presentation"><a href="#Hospedagem_{{$childRequest->id}}"
                                    aria-controls="Hospedagem_{{$childRequest->id}}"
                                    role="tab" data-toggle="tab">Hospedagem</a></li>
                                    @endif
                                    
                                    @if($childRequest->extraExpenses->count() > 0)
                                    <li role="presentation"><a href="#Extras_{{$childRequest->id}}"
                                        aria-controls="Extras_{{$childRequest->id}}" role="tab"
                                        data-toggle="tab">Adiantamento</a></li>
                                        @endif
                                    </ul>
                                    
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        @if($childRequest->tickets->count() > 0)
                                        <div role="tabpanel" class="tab-pane active" id="Passagem_{{$childRequest->id}}">
                                            @include('requests.details.tickets', ['tickets' => $childRequest->tickets])
                                        </div>
                                        @endif
                                        
                                        @if($childRequest->car !== null)
                                        <div role="tabpanel" class="tab-pane" id="Carros_{{$childRequest->id}}">
                                            @include('requests.details.cars', ['car' => $childRequest->car])
                                        </div>
                                        @endif
                                        @if($childRequest->lodging !== null)
                                        <div role="tabpanel" class="tab-pane" id="Hospedagem_{{$childRequest->id}}">
                                            @include('requests.details.lodgings', ['lodging' => $childRequest->lodging])
                                        </div>
                                        @endif
                                        
                                        @if($childRequest->extraExpenses->count() > 0)
                                        <div role="tabpanel" class="tab-pane" id="Extras_{{$childRequest->id}}">
                                            @include('requests.details.extra-expenses', ['extraExpenses' => $childRequest->extraExpenses])
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                        </div>
                        
                        <div class="panel-footer">
                            <div class="text-right">
                                <a href="{{url()->previous() == url()->current() ? route('requests.index') . '?deleted_at=whereNull' : url()->previous()}}"
                                    class="btn btn-default">
                                    <span class="glyphicon glyphicon-arrow-left"></span>
                                    Voltar
                                </a>
                                
                                
                                @can('refuse-request', $request)
                                <button class="btn btn-danger reprove">
                                    <span class="glyphicon glyphicon-remove"></span>
                                    Reprovar
                                </button>
                                @endcan
                                
                                @can('approve-request', $request)
                                <a href="{{route('requests.approve', ['id' => $request->id])}}{{strstr(Request::fullUrl(),'?')}}" class="btn btn-dct">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    Aprovar
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="modalAlert2" tabindex="-1" role="dialog" aria-labelledby="modalAlertlLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title bold" id="modalAlertlLabel">Por que reprovar?</h4>
                                </div>
                                <div class="modal-body alertMessages bold">
                                    <b>Motivo pelo qual a solicitação foi rejeitada:</b>
                                    <br>
                                    <form action="{{route('requests.refuse', ['id' => $request->id])}}" method="POST"
                                        id="requestsRefuse">
                                        {{csrf_field()}}
                                        <textarea class="form-control" id="textarea" name="reason"></textarea>
                                    </form>
                                </div>
                                <div class="modal-footer alert-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    <button class="btn btn-danger recusar-btn" disabled><span class="glyphicon glyphicon-trash"
                                        aria-hidden="true"></span> Recusar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endsection