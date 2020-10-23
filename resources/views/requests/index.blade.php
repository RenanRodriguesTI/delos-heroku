@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.requests')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-requests')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>

            @include('messages')

            @can('create-request')
                <div class="panel-body">
                    <a href="#create-request-modal" class="btn btn-dct" data-toggle="modal" id="btn-create-request">
                        <span class="glyphicon glyphicon-plus"></span>
                        Nova Solicitação
                    </a>
                </div>
            @endcan

            @include('requests.search')

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-details">
                        <thead>
                        <tr>
                            <th>Nº</th>
                            <th class="th-project">Projeto</th>
                            <th>Solicitante</th>
                            <th>De</th>
                            <th>Até</th>
                            <th>Colaboradores</th>
                            <th title="Aprovado">Aprov.</th>
                            <th title="Passagem">Passag.</th>
                            <th>Carro</th>
                            <th title="Hospedagem">Hosp.</th>
                            <th title="Adiantamento">Adian.</th>
                            <th style="min-width: 125px;">Solicitado em</th>
                            <th>Opções</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $key => $request)
                            <tr>
                                <td>{{$request->id}}</td>
                                <td style="padding: 13px 10px" class="has-btn-group"><a
                                            href="{{route('projects.index')}}?search={{$request->project->compiled_cod}}">{{$request->project->compiled_cod}}</a>
                                </td>
                                <td style="padding: 13px 10px">{{$request->requester->name}}</td>
                                <td style="padding: 13px 10px">{{$request->start->format('d/m/Y')}}</td>
                                <td style="padding: 13px 10px">{{$request->finish->format('d/m/Y')}}</td>
                                <td style="padding: 13px 10px">{{$request->users->implode('name', ', ')}}</td>
                                <td style="padding: 13px 10px">
                                    @if($request->approved === null)
                                        Aguardando aprovação
                                    @elseif($request->approved === false)
                                        Não
                                    @elseif($request->approved === true)
                                        Sim
                                    @endif
                                </td>
                                <td style="padding: 13px 10px">{{$request->children->first()->tickets()->count() ? 'Sim' : 'Não'}}</td>
                                <td style="padding: 13px 10px">{{$request->children->first()->car ? 'Sim' : 'Não'}}</td>
                                <td style="padding: 13px 10px">{{$request->children->first()->lodging ? 'Sim' : 'Não'}}</td>
                                <td style="padding: 13px 10px">{{$request->children->first()->extraExpenses()->sum('value')}}</td>
                                <td style="padding: 13px 10px">{{$request->created_at->format('d/m/Y')}}</td>
                                <td class="has-btn-group">
                                    @if($key >= 3)
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn btn-default dropdown-toggle btn-sm bold"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="glyphicon glyphicon-cog dct-color"
                                                      aria-hidden="true"></span>
                                                @lang('buttons.options') <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('requests.show', ['id' => $request->id])}}{{strstr(Request::fullUrl(),'?')}}">
                                                        <span class="glyphicon glyphicon-list-alt"></span> @lang('buttons.details')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                        </div>
                                    @else
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-default dropdown-toggle btn-sm bold"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="glyphicon glyphicon-cog dct-color"
                                                      aria-hidden="true"></span>
                                                @lang('buttons.options') <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('requests.show', ['id' => $request->id])}}{{strstr(Request::fullUrl(),'?')}}">
                                                        <span class="glyphicon glyphicon-list-alt"></span> @lang('buttons.details')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                                <td class="table-details-title">
                                    {{$request->project->full_description}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $requests->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection