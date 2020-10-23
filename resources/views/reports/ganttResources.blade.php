@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">Relatório Gantt de Recursos</h3>
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
                            {!! Form::select('collaborators[]', $collaborators ?? [], Request::get('collaborators') ?? [], ['class' => 'form-control', 'data-title' => 'Selecione um colaborador', 'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple' => 'multiple']) !!}
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
                <div style="position:relative" class="gantt" id="GanttChartRecurso"></div>

                @push('scripts')
                    <script>

                        var r = new JSGantt.GanttChart(document.getElementById('GanttChartRecurso'), 'day');

                        r.setShowRes(0);

                        @foreach($users as $user)
                            r.AddTaskItem(new JSGantt.TaskItem({{$user->id}}, '{{$user->name}}', '', '', 'gtaskgreen', '', 0, '', 100, 1, 0, 0, '', '', '', r));

                            @foreach($user->allocations as $allocation)
                                    @if ($allocation->parent)
                                        r.AddTaskItem(new JSGantt.TaskItem(Math.floor((Math.random() * (99999 * 9999)) + (99 * 9)), '{{$allocation->project->compiled_cod}}', '{{$allocation->start->format('Y-m-d')}}', '{{$allocation->finish->format('Y-m-d')}}', 'gtaskgreen', '', 0, '{{$allocation->project->description}}', 100, 0, {{$user->id}}, 1, '', '', '{{$allocation->task ? $allocation->task->name : "Mutiplas Tarefas"}}', r));
                                    @endif
                            @endforeach
                        @endforeach

                        r.setShowEndWeekDate(0);
                        r.setDayMajorDateDisplayFormat('mon yyyy');
                        r.setCaptionType('Complete');
                        r.setFormatArr('Day', 'Month');
                        r.addLang('pt-br', {
                            'format': 'Formato',
                            'day': 'Dia',
                            'dy': 'Dia',
                            'dys': 'Dias',
                            'duration': 'Duração',
                            'startdate': 'Data Inicial',
                            'enddate': 'Data Final',
                            'comp': '% Concl.',
                            'completion': 'Conclusão',
                            'resource': 'Projeto',
                            'notes': 'Tarefa',
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
                            'december': 'Dezembro',
                        });
                        r.setLang('pt-br');
                        r.Draw();
                    </script>
                @endpush
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! in_array('render', get_class_methods($users)) ? $users->render() : null !!}

                </div>
            </div>
        </div>
    </div>
@endsection