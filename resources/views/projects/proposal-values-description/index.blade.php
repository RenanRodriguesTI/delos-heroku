@extends('layouts.app')
@section('content')

<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">Descrição da Proposta do Valor do Projeto: {{$project->full_description}}</h3>
            <div class="pull-center">
                
                @can('see-proposal-value')
                <h4 class="panel-tittle bold">Valor da Proposta: R$ {{number_format($project->proposal_value, 2, ',', '.')}}</h4>
                @endcan
                
            </div>
        </div>
        @include('messages')
        <div class="panel-body">
            
            {!! Form::open(['route' => ['projectTypes.addTask', 'id' => $project->projectType->id], 'method' => 'POST']) !!}
            
            <a href="{{route('projects.index')}}?deleted_at=whereNull"
            class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Voltar
        </a>
        
        <div class="pull-right">
            <div class="btn-group">
                @can('proposal-values-create-project')
                    <a href="{{route('projects.descriptionValues.create', ['id' => $project->id])}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-descriptionValue')
                    </a>
                @endcan
                
                @can('proposal-values-description-report-project')
                    <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{route('projects.descriptionValues.report', ['id' => $project->id])}}" class="report-xlsx"><span class="glyphicon glyphicon-cloud-download"></span>
                                @lang('buttons.export-excel')
                            </a>
                        </li>
                    </ul>
                @endcan
        </div>
    </div>
    
    <div>
        <br>
    </div>                
    
    <div class="row">
        
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-details">
                    <thead>
                        <tr>
                            <th>Data Prevista</th>
                            <th>Data de Criação</th>
                            <th>@lang('OS')</th>
                            <th>@lang('headers.client')</th>
                            @can('see-proposal-value')
                            <th style="min-width: 110px;">@lang('headers.value')</th>
                            @endcan
                            <th>@lang('headers.description')</th>
                            <th>@lang('Data do Documento')</th>
                            <th>@lang('Título de Documento')</th>
                            <th>@lang('Data Recebimento')</th>
                            <th>@lang('headers.notes')</th>
                            @can('proposal-values-edit-project')
                            <th style="min-width: 125px;">@lang('headers.action')</th>
                            @endcan
                        </tr>   
                    </thead>
                    <tbody class="proposallist">
                        @foreach($project->proposalValueDescriptions->sortBy("month") as $proposalValueDescription)
                        <tr class="descriptionValues{{$proposalValueDescription->month}}">
                            <td>{{($proposalValueDescription->expected_date )?$proposalValueDescription->expected_date->format('d/m/Y'):''}}</td>
                            <td>{{$proposalValueDescription->month->format('d/m/Y')}}</td>
                            <td>{{$proposalValueDescription->os}}</td>
                            <td>{{$proposalValueDescription->clients->implode("name")}}</td>
                            @can('see-proposal-value')
                            <td>R$ {{number_format($proposalValueDescription->value, 2, '.', ',')}}</td>
                            @endcan
                            <td>{{$proposalValueDescription->description}}</td>
                            <td>{{($proposalValueDescription->date_nf && $proposalValueDescription->date_nf->format('Y') != '-0001')?$proposalValueDescription->date_nf->format('d/m/Y'):'Não especificado'}}</td>
                            <td>{{$proposalValueDescription->invoice_number}}</td>
                            <td>{{($proposalValueDescription->date_received && $proposalValueDescription->date_received->format('Y') != '-0001')?$proposalValueDescription->date_received->format('d/m/Y'):'Não especificado'}}</td>
                            <td>{{$proposalValueDescription->notes}}</td>
                            
                            @can('proposal-values-edit-project')
                            <td class="has-btn-group">
                                <a style="margin-bottom: 5%;" href="{{route('projects.descriptionValues.edit', ['proposalValuesDescriptionId' => $proposalValueDescription->id])}}"
                                    class="btn btn-dct btn-sm"><span
                                    class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    @lang('buttons.edit')
                                </a>
                                @endcan
                                @can('proposal-values-destroy-project')                                
                                <a class="btn btn-danger btn-sm delete"
                                id="{{route('projects.descriptionValues.destroy', ['projectId' => $project->id, 'projectProposalValueId' => $proposalValueDescription->id])}}"
                                onclick="getModalDelete(this)">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                @lang('buttons.remove')
                            </a>
                        </td>
                        @endcan
                        <td class="table-details-title">{{$proposalValueDescription->description}}</td>
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