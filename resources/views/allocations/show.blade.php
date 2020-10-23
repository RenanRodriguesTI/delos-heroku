@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-dct show-allocation">
            <div class="panel-heading col-xs-12" style="float: left;margin-bottom: 16px;">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                        <h3 class="panel-title bold">Detalhe da Alocação de <strong>{{$allocation->user->name}}</strong>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="printAllocations">
                <table class="table table-bordered table-striped">
                    <tbody>

                    <tr>
                        <td><b>Projeto</b></td>
                        <td>{{$allocation->project->full_description}}</td>
                    </tr>

                    <tr>
                        <td><b>Tarefa</b></td>
                        <td style="vertical-align:middle;">
                            @if(!$allocation->allocationTasks->isEmpty())
                            <span class="task-allocation">
                                {{$allocation->compiled_tasks}}
                            </span>
                            @else
                                <span class="task-allocation"> {{$allocation->task ? $allocation->task->name :"Não Especificado"}}</span>
                            @endif
                           
                            {{--<form class="form-task-allocation" style="display:none;">--}}
                            {{--<select name="status[]" class="value-task-allocation">--}}
                            {{--@foreach ($allocation->project->tasks as $task)--}}
                            {{--<option value="{{$task->id}}">{{$task->name}}</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {{--</form>--}}
                            {{--<button id="btn-change-task" class="btn btn-default btn-change-task pull-right" style="margin-top:0px;"><i class="fa fa-edit"></i> Adicionar/Alterar Tarefa</button>--}}
                        </td>
                    </tr>

                    <tr>
                        <td><b>De</b></td>
                        <td>{{$allocation->start->format('d/m/Y')}}</td>
                    </tr>

                    <tr>
                        <td><b>Até</b></td>
                        <td>{{$allocation->finish->format('d/m/Y')}}</td>
                    </tr>

                    {{--<tr>--}}
                        {{--<td><b>Status da Alocação</b></td>--}}
                        {{--<td style="vertical-align:middle;">--}}
                            {{--@if ($allocation->status == '')--}}
                                {{--<span class="status-allocation alert-not-tasks"><i class="fa fa-times"></i> Status não Informado</span>--}}
                            {{--@endif--}}
                            {{--@if ($allocation->status == 'Finalizada')--}}
                                {{--<span class="status-allocation alert-success-tasks"><i--}}
                                            {{--class="fa fa-check"></i> {{$allocation->status}}</span>--}}
                            {{--@endif--}}
                            {{--@if ($allocation->status == 'Cancelada')--}}
                                {{--<span class="status-allocation alert-danger-tasks"><i--}}
                                            {{--class="fa fa-exclamation-triangle"></i> {{$allocation->status}}</span>--}}
                            {{--@endif--}}
                            {{--@if ($allocation->status == 'Em Andamento')--}}
                                {{--<span class="status-allocation alert-warning-tasks"><i--}}
                                            {{--class="fa fa-info"></i> {{$allocation->status}}</span>--}}
                            {{--@endif--}}
                            {{--<form class="form-status-allocation" style="display:none;">--}}
                                {{--<select name="status[]" class="value-status-allocation">--}}
                                    {{--<option>Selecione um status</option>--}}
                                    {{--<option value="Finalizada">Finalizada</option>--}}
                                    {{--<option value="Cancelada">Cancelada</option>--}}
                                    {{--<option--}}
                                            {{--value="Em Andamento">Em Andamento--}}
                                    {{--</option>--}}
                                {{--</select>--}}
                            {{--</form>--}}
                            {{--<button class="btn btn-default btn-change-status pull-right" style="margin-top:0px;"><i--}}
                                        {{--class="fa fa-edit"></i> Alterar Status--}}
                            {{--</button>--}}
                        {{--</td>--}}
                    {{--</tr>--}}

                    {{--
                        <tr>
                        <td><b>Quantidade total de horas</b></td>
                        <td class="">
                            {{$allocation->hours}}
                        </td>
                    </tr>

                    <tr>
                        <td><b>Quantidade de horas por dia</b></td>
                        <td>{{$allocation->hourDay}}</td>
                    </tr>
                        --}}

                    <tr>
                        <td><b>Descrição</b></td>
                        <td>{!! $allocation->description !!}</td>
                    </tr>
                    <tr>
                            <td>Trabalhar final de semana ou feriado:</td>
                            <td>{{$allocation->jobWeekEnd ? 'Sim' : 'Não'}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                        <a href="{{ route('allocations.index') . '?deleted_at=whereNull' }}"
                           class="btn btn-default pull-right btn-align-allocations hidden-print" id="btn-back-page"
                           style="margin-right: 15px;">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            Voltar
                        </a>
                        <a class="btn btn-primary pull-right hidden-print" value="Print" onclick="printAllocation()"
                           style="margin-right: 3px;">
            <span class="glyphicon glyphicon-print"></span
            > Imprimir
                        </a>

                       

                        @can('destroy-allocation')
                            <a class="btn btn-danger pull-right btn-align-allocations destroy-allocation hidden-print"
                               id="{{ route('allocations.destroy', ['id' => $allocation->id]) }}"
                               style="margin-right: 3px;">
                                <span class="glyphicon glyphicon-trash"></span>
                                Excluir
                            </a>
                        @endcan

                        @can('add-task-store-allocation')
                        <a class='btn btn-primary pull-right'   style="margin-right: 3px;" id='btn-edit-allocation' href='{{route("allocations.addTasks",["id"=>$allocation->id])}}'>
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            Tarefas
                        </a>
                        @endcan

                        @can('update-allocation')
                        <a class='btn btn-default pull-right'   style="margin-right: 3px;" id='btn-edit-allocation' href='{{route("allocations.edit",["id"=>$allocation->id])}}'>
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            Editar
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<script>--}}
        {{--$('.btn-change-hour').click(function () {--}}
            {{--event.preventDefault();--}}
            {{--$('.change-hours').prop("disabled", false);--}}
            {{--$('.alert-update-hours').fadeIn();--}}
            {{--$('.change-hours').css({ border: "none" });--}}
            {{--$('.change-hours').focus();--}}
            {{--$('.change-hours').change(function () {--}}
                {{--var hours = $('.change-hours').val();--}}
                {{--$.ajax({--}}
                    {{--headers: {--}}
                        {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                    {{--},--}}
                    {{--data:    { 'hours': hours },--}}
                    {{--type:    'post',--}}
                    {{--url:     '/allocations/{{$allocation->id}}/update-hours',--}}
                    {{--success: function (response) {--}}
                        {{--$('.alert-update-hours').hide();--}}
                        {{--iziToast.show({--}}
                            {{--id:               'haduken',--}}
                            {{--message:          "Suas informações estão sendo atualizadas...",--}}
                            {{--position:         'bottomRight',--}}
                            {{--transitionIn:     'flipInX',--}}
                            {{--transitionOut:    'flipOutX',--}}
                            {{--progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',--}}
                            {{--layout:           2,--}}
                            {{--maxWidth:         500,--}}
                            {{--timeout:          3000--}}
                        {{--});--}}
                        {{--location.reload(4000);--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
        {{--})--}}
    {{--</script>--}}
    {{--<script>--}}
        {{--$('.btn-change-status').click(function () {--}}
            {{--event.preventDefault();--}}
            {{--$('.status-allocation').hide();--}}
            {{--$('.form-status-allocation').fadeIn();--}}
            {{--$('.value-status-allocation').change(function () {--}}
                {{--var status = $('.value-status-allocation option:selected').val();--}}
                {{--$.ajax({--}}
                    {{--headers: {--}}
                        {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                    {{--},--}}
                    {{--data:    { 'status': status },--}}
                    {{--type:    'post',--}}
                    {{--url:     '/allocations/{{$allocation->id}}/update-status',--}}
                    {{--success: function (response) {--}}
                        {{--iziToast.show({--}}
                            {{--id:               'haduken',--}}
                            {{--message:          "Suas informações estão sendo atualizadas...",--}}
                            {{--position:         'bottomRight',--}}
                            {{--transitionIn:     'flipInX',--}}
                            {{--transitionOut:    'flipOutX',--}}
                            {{--progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',--}}
                            {{--layout:           2,--}}
                            {{--maxWidth:         500,--}}
                            {{--timeout:          3000--}}
                        {{--});--}}
                        {{--location.reload(4000);--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
        {{--})--}}
    {{--</script>--}}
    {{--<script>--}}
        {{--$('.btn-change-task').click(function () {--}}
            {{--event.preventDefault();--}}
            {{--$('.task-allocation').hide();--}}
            {{--$('.form-task-allocation').fadeIn();--}}
            {{--$('.value-task-allocation').change(function () {--}}
                {{--var status = $('.value-task-allocation option:selected').val();--}}
                {{--$.ajax({--}}
                    {{--headers: {--}}
                        {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                    {{--},--}}
                    {{--data:    { 'status': status },--}}
                    {{--type:    'post',--}}
                    {{--url:     '/allocations/{{$allocation->id}}/update-tasks',--}}
                    {{--success: function (response) {--}}
                        {{--iziToast.show({--}}
                            {{--id:               'haduken',--}}
                            {{--message:          "Suas informações estão sendo atualizadas...",--}}
                            {{--position:         'bottomRight',--}}
                            {{--transitionIn:     'flipInX',--}}
                            {{--transitionOut:    'flipOutX',--}}
                            {{--progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',--}}
                            {{--layout:           2,--}}
                            {{--maxWidth:         500,--}}
                            {{--timeout:          3000--}}
                        {{--});--}}
                        {{--location.reload(4000);--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
        {{--})--}}
    {{--</script>--}}
@endsection