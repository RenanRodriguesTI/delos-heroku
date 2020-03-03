@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">Relatório desempenho dos líderes</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-owners-performance')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                {!! Form::open(['route' => 'reports.owners.index', 'method' => 'get']) !!}

                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            {!! Form::select('collaborators[]', $collaborators, Request::get('collaborators'), [
                            'class' => 'selectpicker form-control',
                            'data-live-search' => 'true',
                            'data-actions-box' => 'true',
                            'title' => 'Selecione um colaborador',
                            'multiple'
                            ])!!}
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <select name="months[]" class="selectpicker form-control" title="Selecione um mês" multiple
                                    data-size="9" data-live-search="true">
                                @foreach($months as $key => $month)
                                    @if(in_array($key, Request::get('months') ?? []))
                                        <option value="{{$key}}" selected>{{$month}}</option>
                                    @else
                                        <option value="{{$key}}">{{$month}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <select name="years[]" class="selectpicker form-control" title="Selecione um ano" multiple
                                    data-size="9" data-live-search="true">
                                @for($i = 0; $i < (date('Y')-2016+1); $i++)
                                    @if(in_array((date('Y')-$i), Request::get('years') ?? []))
                                        <option value="{{date('Y')-$i}}" selected>{{date('Y')-$i}}</option>
                                    @else
                                        <option value="{{date('Y')-$i}}">{{date('Y')-$i}}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="btn-group">
                                {!! Form::submit('Pesquisar', ['class' => 'btn btn-dct']) !!}
                                <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="report-xlsx"><span class="glyphicon glyphicon-cloud-download"></span>
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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Qtde de Projetos</th>
                            <th>Horas Orçadas</th>
                            <th>Horas Gastas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($owners as $owner)
                            <tr>
                                <td>{{ $owner['name'] }}</td>
                                <td class="text-center">{{ number_format($owner['total'], 0, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($owner['budgeted'], 0, ',', '.') }}</td>
                                <td class="text-center">
                                    {{ number_format($owner['expend'], 0, ',', '.') }}

                                    <div class="description" style="display: none;">
                                        <div class="div-description-item">
                                            <span class="name">
                                                Horas Gastas: <span
                                                        style="color: #565656;">{{ number_format($owner['expend'], 0, ',', '.') }}</span>
                                                <hr>
                                                Projetos Contabilizados
                                            </span>
                                            <span class="value">
                                                <div class="alert alert-warning alert-dismissible fade in" role="alert"
                                                     style="margin-bottom: 10px;">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <strong>Para ver a descrição do projeto posicione o cursor em cima do código</strong>
                                                </div>

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Código do Projeto</th>
                                                            <th>Horas Orçadas</th>
                                                            <th>Horas Gastas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($owner['projects'] as $project)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{route('projects.index')}}?search={{$project->compiled_cod}}"><abbr
                                                                                title="{{$project->description}}"
                                                                                class="initialism">{{$project->compiled_cod}}</abbr></a>
                                                                </td>
                                                                <td>
                                                                {{$project->budget}}
                                                                <td>
                                                                    {{$project->getSummedActivity($project)}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </span>
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
@endsection