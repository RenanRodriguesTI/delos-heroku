@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading col-xs-12" style="float: left;margin-bottom: 16px;">
                <div class="row">
                    <div class="col-sm-10 col-md-10 col-lg-10 col-xs-12">
                        <h3 class="panel-title bold">Detalhes do projeto: {{$project->full_description}}</h3>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2 col-xs-12">
                        <div class="hidden-md hidden-sm hidden-lg">
                            <br>
                        </div>

                        <a href="{{url()->previous() == url()->current() ? route('projects.index') . '?deleted_at=whereNull' : url()->previous()}}"
                           class="btn btn-default pull-right hidden-print">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td><b>Tipo de projeto</b></td>
                        <td>{{$project->projectType->name}}</td>
                    </tr>

                    <tr>
                        <td><b>Código</b></td>
                        <td>{{$project->compiled_cod}}</td>
                    </tr>

                    <tr>
                        <td><b>Empresa</b></td>
                        <td>{{$project->company->name or ''}}</td>
                    </tr>

                    <tr>
                        <td><b>Grupo</b></td>
                        <td>{{$project->clients->first()->group->name}} <span
                                    style="float: right;transform: translateX(-14px);"><strong>Código: </strong>{{$project->clients()->first()->group->cod}}</span>
                        </td>
                    </tr>
                    <tr id="projects_details_clients">
                        <td><b>Cliente(s)</b></td>
                        <td>
                            <ul class="list-group list-group-hover">
                                @foreach($project->clients as $client)
                                    <a class="list-group-item">{{$client->name}} <span style="float: right;"><strong>Código: </strong>{{$client->cod}}</span></a>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Cliente responsável</b></td>
                        <td>
                            {{$project->client->name ?? null}}
                        </td>
                    </tr>
                    <tr>
                        <td><b>Líder</b></td>
                        <td>{{ $project->owner->name ?? null}}</td>
                    </tr>
                    <tr>
                        <td><b>Co-líder</b></td>
                        <td>{{$project->coOwner->name ?? null}}</td>
                    </tr>

                    <tr>
                        <td><b>Comercial</b></td>
                        <td>{{$project->seller->name ?? ''}}</td>
                    </tr>

                    <tr>
                        <td><b>Início</b></td>
                        <td>{{$project->start->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td><b>Encerramento</b></td>
                        <td>{{$project->finish->format('d/m/Y')}}</td>
                    </tr>

                    <tr>
                        <td><b>Finalização Real</b></td>
                        <td>{{!isset($project->deleted_at)?'Não Finalizado':$project->deleted_at->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td><b>Última Atividade</b></td>
                        <td>{{$project->last_activity ? $project->last_activity->format('d/m/Y H:i') : null}}</td>
                    </tr>
                    <tr>
                        <td><b>Criado em</b></td>
                        <td>{{$project->created_at->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td><b>Membros atuais</b></td>
                        <td>{{$members}}</td>
                    </tr>
                    <tr>
                        <td><b>Número da proposta</b></td>
                        <td>{{$project->proposal_number}}</td>
                    </tr>
                    @can('see-proposal-value')
                        <tr>
                            <td><b>Valor da proposta</b></td>
                            <td>{{number_format($project->proposal_value, 2, ',', '.')}}</td>
                        </tr>
                    @endcan
                    <tr>
                        <td><b>Despesas do projeto</b></td>
                        <td>{{number_format($project->extra_expenses, 2, ',', '.')}}</td>
                    </tr>

                    <tr>
                        <td><b>Comissão</b></td>
                        <td>{{number_format($project->commission, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td><b>Observação</b></td>
                        <td>{{$project->notes ?? null}}</td>
                    </tr>

                    <tr>
                        <td><b>Tarefas</b></td>
                        <td>{{$project->tasks->implode('name', ', ')}}</td>
                    </tr>

                    <tr>
                        <td><b>Progresso do Projeto</b>
                        </td>
                        <td id="chart_budgedted_values">
                            {!! $chartPercentage->render() !!}
                        </td>
                    </tr>

                    <tr>
                        <td><b>Orçado vs Real (Horas)</b>
                        </td>
                        <td id="chart_budgeted_hours">
                            {!! $chartBudgetedVsActualHours->render() !!}
                        </td>
                    </tr>

                    @can('show-details-hours-per-task', $project)
                        <tr>
                            <td><b>Horas por tarefas</b>
                            </td>
                            <td id="chart_tasks">
                                {!! $chartHoursPerTask->render() !!}
                            </td>
                        </tr>
                    @endcan

                    @can('see-proposal-value')
                        <tr>
                            <td><b>Orçado vs Real (Valores)</b>
                            </td>
                            <td id="chart_budgedted_values">
                                {!! $chartBudgetedVsActualValues->render() !!}
                            </td>
                        </tr>
                    @endcan
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection