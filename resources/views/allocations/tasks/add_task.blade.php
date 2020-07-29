@extends('layouts.app')
@section('content')
    <div class='container'>
        <div class='panel panel-dct'>
            <div class='panel-heading'>
                <h2 class='panel-title-sub bold'>Projeto: {{$allocation->project->full_description}}</h2>
                <h2 class='panel-title-sub bold'>Colaborador: {{$allocation->user->name}} - Periodo: {{$allocation->start->format('d/m/Y')}} - {{$allocation->finish->format('d/m/Y')}} </h2>
                <h2 class='panel-title-sub bold'>Quantidade total de horas: {{$allocation->hours}}</h2>
                <h2 class='panel-title-sub bold'>Horas utilizadas: {{$allocation->hours_used}}</h2>
                <h2 class='panel-title-sub bold'>Horas disponíveis: {{$allocation->hours_available}}</h2>
                
            </div>
            <div class='panel-body'>
                <a href="{{url()->previous() == url()->current() ? route('allocations.index') . '?deleted_at=whereNull' : url()->previous()}}" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </a>

                @if($allocation->hours != $allocation->hours_used)
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
                        <tr><th>Tarefa</th><th>Quantidade de Horas</th></tr>
                    </thead>
                    <tbody>
                        @if($allocation->task)
                            <tr><td>{{$allocation->task->name}}</td><td>{{$allocation->hours}}</td><td>Ação</td></th>
                        @endif

                        @foreach($allocation->allocationTasks as $allocationTask)
                           <tr><td>{{$allocationTask->task->name}}</td><td>{{number_format($allocationTask->hours,0,'.',',')}}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('allocations.tasks.form')
@endsection


