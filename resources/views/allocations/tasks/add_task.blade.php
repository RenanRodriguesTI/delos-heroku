@extends('layouts.app')
@section('content')
<div class='container'>
    <div class='panel panel-dct'>
        <div class='panel-heading'>
            <h2 class='panel-title-sub bold'>Projeto: {{$allocation->project->full_description}}</h2>
            <h2 class='panel-title-sub bold'>Colaborador: {{$allocation->user->name}} - Periodo: {{$allocation->start->format('d/m/Y')}} - {{$allocation->finish->format('d/m/Y')}} </h2>
            <h2 class='panel-title-sub bold'>Quantidade total de horas: {{$allocation->project->hours}}</h2>
            <h2 class='panel-title-sub bold'>Horas utilizadas: {{$allocation->project->used_buget}}</h2>
            <h2 class='panel-title-sub bold'>Horas disponíveis: {{$allocation->project->remaining_budget}}</h2>
        </div>
        <div class='panel-body'>
            <a href="{{url()->previous() == url()->current() ? route('allocations.index') . '?deleted_at=whereNull' : url()->previous()}}" class="btn btn-default">
                <span class="glyphicon glyphicon-arrow-left"></span>
                Voltar
            </a>

            @if($allocation->project->hours != $allocation->hours_used)
            <div class="pull-right">
                <div class="btn-group">
                    <button type='button' data-toggle='modal' data-target='#allocations-form' class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Adicionar tarefa
                    </button>
                </div>
            </div>
            @endif
        </div>

        <div class='panel-body'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Tarefa</th>
                        <th>Quantidade de Horas</th>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @if($allocation->task)
                    <tr>
                        <td>{{$allocation->task->name}}</td>
                        <td colspan="2">{{$allocation->hours}}</td>
                        </th>
                        @endif

                        @foreach($allocationTasks as $key => $allocationTask)
                    <tr class="allocation-task-{{$allocationTask->id}}">
                        <td class='task-{{$allocationTask->task_id}}'>{{$allocationTask->task->name}}</td>
                        <td>{{number_format($allocationTask->hours,0,'','')}}</td>
                        <td>{{$allocationTask->start}}</td>
                        <td>{{$allocationTask->finish}}</td>
                        <td>
                        <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-users-{{$key}}">
                                                <span class="glyphicon glyphicon-cog"></span>
                                                @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                @can('update-task-allocation')
                                                <li class="divider"></li>

                                                <li>
                                                    <a href='javascript:void(0);' class='edit' data-id="allocation-task-{{$allocationTask->id}}" data-action='' data-toggle='modal' data-target='#allocations-form'> 
                                                        <span class="glyphicon glyphicon-edit"></span>&nbsp; Editar
                                                    </a>
                                                </li>
                                                @endcan
                                                <li class='divider'></li>
                                                @can('destroy-task-allocation')
                                                <li>
                                                <a id='{{route("allocations.destroyTask",["id"=>$allocationTask->allocation_id,"allocationTaskId"=>$allocationTask->id ])}}'
                                                               class="delete" style="cursor: pointer"
                                                               onclick="getModalDelete(this)">
                                                                <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                                            </a>
                                                </li>
                                                <li class="divider"></li>
                                                @endcan
                                            </ul>

                                </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

       @if(!$allocationTasks->isEmpty())
       <div class="panel-footer">
                <div class="text-right">
                    {!!  $allocationTasks->appends(request()->input())->links() !!}
                </div>
        </div>
       @endif
    </div>
</div>

@include('allocations.tasks.form')
@endsection

@push('scripts')
    <script>

        $(document).ready(function(){
            console.log($('#allocation_task_id').val())
            if($('#allocation_task_id').val()){
                $('#allocation-add-task').attr('action',"/allocations/{{$allocation->id}}/"+task_id.replace('allocation-task-','')+"/update-task");
            } else{
                $('#allocation-add-task').attr('action',"{{route('allocations.addTaskStore',['id'=>$allocation->id])}}");
            }
        });

        $('.edit').click(function(){
            
            var task_id = $(this).attr('data-id');
            $('#allocation_task_id').val(task_id.replace('allocation-task-',''));
            $('#allocation-add-task').attr('action',"/allocations/{{$allocation->id}}/"+task_id.replace('allocation-task-','')+"/update-task")
            $('#task_id').selectpicker('val',$($('.'+task_id+' td')[0]).attr('class').replace('task-',''));
            $('#hours').val($($('.'+task_id+' td')[1]).html());
            if($($('.'+task_id+' td')[2]).html() =='Sim'){
                $('#concludes').attr('checked','checked')
            } else{
                $('#concludes').attr('checked',false);
            }
        });
    </script>
@endpush