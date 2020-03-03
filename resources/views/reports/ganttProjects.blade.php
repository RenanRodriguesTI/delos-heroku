@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">Relatório Gantt de Projetos</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-owners-performance')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                <form class="row">
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <div class="form-group">
                            {!! Form::select('projects[]', $projectsToSearch ?? [], Request::get('projects') ?? [], ['class' => 'form-control', 'data-title' => 'Selecione um projeto', 'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple' => 'multiple']) !!}
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-12">
                        <button type="submit" class="btn btn-dct">
                            Pesquisar
                        </button>
                    </div>
                </form>
            </div>

            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                <div style="position:relative" class="gantt" id="GanttChartProjeto"></div>

                @push('scripts')
                    <script>

                        var p = new JSGantt.GanttChart(document.getElementById('GanttChartProjeto'), 'day');

                        p.setShowRes(0);

                        @foreach($projects as $project)
                            p.AddTaskItem(new JSGantt.TaskItem({{$project->id}}, '{{$project->compiled_cod}}', '', '', 'gtaskgreen', '', 0, '', 100, 1, 0, 0, '', '', '{{$project->description}}', p));

                            @foreach($project->activities as $activity)
                                p.AddTaskItem(
                                    new JSGantt.TaskItem(
                                        {{$activity->id}},
                                        '{{$activity->task->name}}', '{{$activity->date->format('Y-m-d')}}',
                                        '{{$activity->date->format('Y-m-d')}}',
                                        'gtaskgreen',
                                        '', 0, '{{$activity->user->name}}', 100, 0, {{$project->id}}, 1, '', '', 'Qtde de horas: {{$activity->hours}}', p
                                    )
                                );
                            @endforeach
                        @endforeach

                        p.setShowEndWeekDate(0);
                        p.setDayMajorDateDisplayFormat('mon yyyy');
                        p.setCaptionType('Complete');
                        p.setFormatArr('Day', 'Month');
                        p.addLang('pt-br', {
                            'format': 'Formato',
                            'day': 'Dia',
                            'dy': 'Dia',
                            'dys': 'Dias',
                            'duration': 'Duração',
                            'startdate': 'Data Inicial',
                            'enddate': 'Data Final',
                            'comp': '% Concl.',
                            'completion': 'Conclusão',
                            'resource': 'Recurso',
                            'notes': 'Observações',
                            'jan': 'Jan',
                            'feb': 'Fev',
                            'mar': 'Mar',
                            'apr': 'Abr',
                            'may': 'Mai',
                            'jun': 'Jun',
                            'jul': 'Jul',
                            'aug': 'Ago',
                            'sep': 'Set',
                            'oct': 'Out',
                            'nov': 'Nov',
                            'dec': 'Dez',
                            'month': 'Mês',
                            'january': 'Janeiro',
                            'february': 'Fevereiro',
                            'march': 'Março',
                            'april': 'Abril',
                            'maylong': 'Maio',
                            'june': 'Junho',
                            'july': 'Julho',
                            'august': 'Agosto',
                            'september': 'Setembro',
                            'october': 'Outubro',
                            'november': 'Novembro',
                            'december': 'Dezembro'
                        });
                        p.setLang('pt-br');
                        p.Draw();
                    </script>
                @endpush
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! in_array('render', get_class_methods($projects)) ? $projects->render() : null !!}
                </div>
            </div>
        </div>
    </div>
@endsection