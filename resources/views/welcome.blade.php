@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-dct">
                <div class="panel-body" data-without-height="true">
                    <div class="row">
                        <div class="tile_count">
                            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                            <span class="count_top"><i
                                        class="fa fa-clock-o"></i> @lang('widgets.registered-hours')</span>
                                <div class="count">{{$activityHours}}</div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                                <span class="count_top"><i
                                            class="fa fa-frown-o"></i> @lang('widgets.missing-hours')</span>
                                <div class="count">{{$user->missingActivities->sum('hours')}}</div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                                <span class="count_top"><i class="fa fa-suitcase"></i> @lang('widgets.projects')</span>
                                <div class="count">{{$projects}}</div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                                <span class="count_top"><i class="fa fa-share"></i> Solicitação(ões) pendente(s) </span>
                                <div class="count">{{$requestsToApprove}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading">
                    <h4>Próximas alocações de
                        <small style="color: #575757;">{{Auth::user()->name}}</small>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive table-allocation"
                                 style="min-height: 300px; margin-bottom: 0px;">
                                <div id="calendar-welcome"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading">
                    <h4>Últimas Atividades Pendentes</h4>
                </div>
                <div class="panel-body" data-without-height="true">
                    @if($lastMissingActivities->count() <= 0)
                        <div class="text-center">
                            <h5 style="color: #9a9a9a;">Você não possui atividades faltantes</h5>
                        </div>
                    @endif
                    <div class="row">
                        @foreach($lastMissingActivities as $key => $activity)
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div>
                                    <p>
                                        <span id="date-{{$key}}"></span>
                                        <script>
                                            $(document).ready(function () {
                                                $("#date-{{$key}}").html(moment("{{$activity->date->toDateString()}}").format('dddd, DD MMMM YYYY'));
                                            });
                                        </script>
                                    <div class="ellipsis">{{$activity->user->name}}</div>
                                    </p>
                                </div>

                                <hr>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="panel-heading">
                    <h4>Total atividades por mês</h4>
                </div>
                <div class="panel-body" data-without-height="true">
                    <div class="row">
                        <div class="dashboard_graph">
                            {!! $chartLine->render()  !!}
                        </div>
                    </div>
                </div>

                @if($hasExpenses)
                    <div class="panel-heading">
                        <h4>Total de despesas por mês</h4>
                    </div>
                    <div class="panel-body" data-without-height="true">
                        <div class="row">
                            <div class="dashboard_graph">
                                {!! $chartPie->render() !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#calendar-welcome').fullCalendar({
                    height:      400,
                    defaultView: 'listWeek',
                    views:       {
                        listDay:   { buttonText: 'Lista do Dia' },
                        listWeek:  { buttonText: 'Lista da Semana' },
                        listMonth: { buttonText: 'Lista do Mês' }
                    },
                    header:      {
                        left:   'title',
                        center: '',
                        right:  'prev,next today'
                    },
                    events: [
                            @foreach($allocations as $allocation)
                        {
                            @if($allocation->parent)
                            title  : '{{$allocation->compiled_name}}',
                            start  : '{{$allocation->start}}',
                            end    : '{{$allocation->finish}}',
                            allDay : 'false',
                            color  : '#009E35',
                            url    : '/allocations/' + '{{$allocation->parent->id}}' + '/show'
                            @endif
                        },
                        @endforeach
                    ]
                });
            });
        </script>
    @endpush
@endsection
        