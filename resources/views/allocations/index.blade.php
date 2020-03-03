@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <h3 class="panel-title bold">Alocações</h3>
                </div>
                <div class="col-md-4 col-sm-4 text-right">
                    <span title="@lang('tips.whats-allocation')"
                    class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                    data-toggle="tooltip" data-placement="left"></span>
                </div>
            </div>
        </div>
        
        @include('messages')
        
        @can('create-allocation')
            <div class="panel-body">
                <a href="{{route('allocations.create')}}" class="btn btn-dct" id="btn-create-allocation">
                    <span class="glyphicon glyphicon-plus"></span>
                    Nova Alocação
                </a>
            </div>
        @endcan
        
        @include('allocations.search')  
        
        <div class="panel-body">
            <div class="table-responsive table-allocation">
                <div id="calendar-allocations"></div>
            </div>
        </div>
        <div id="user-information"></div>
    </div>
</div>

<script>
    $('.fc-time').css({display:"none"});
    var datestart = '{{ app('request')->input('start') }}';
    var datefinish = '{{ app('request')->input('finish') }}';
    
    $(function() {
        
        $('.fc-time').hide();
        $('#calendar-allocations').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            validRange: {
                @if( app('request')->input('start') )
                    start: moment(datestart, 'DD/MM/YYYY'),
                @endif

                @if( app('request')->input('finish') )
                    end: moment(datefinish, 'DD/MM/YYYY').add(1, 'days')
                @endif
            },

            @if( app('request')->input('start')  == null)
                defaultDate: moment(),
            @else
                defaultDate: moment(datestart, 'DD/MM/YYYY'),
            @endif

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
        })
    });
</script>
@endsection