@extends('layouts.app')

@section('content')
    <div class="container">
        {!! Form::open(['route' =>[ 'allocations.update', 'id'=>$allocation->id], 'method' => 'post', 'id' => 'form-allocation','autocomplete'=>'off']) !!}

        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Editar Alocação</h3>
            </div>
            <div class="panel-body row">
                <div class="form-group project-group col-xs-12 {{$errors->has('project_id') ? ' has-error' : ''}}">
                    {!! Form::label('project_id', 'Projeto:') !!}
                    {!! Form::select('project_id', $projects, $allocation->project_id ?? null , [
                    'class' => 'selectpicker form-control',
                    'title' => 'Selecione um projeto',
                    'data-live-search' => 'true',
                    'data-box-actions' => 'true',
                    'required'
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('project_id')}}</strong></span>
                </div>

                <div class="form-group user-group col-md-6{{$errors->has('user_id') ? ' has-error' : ''}}">
                    {!! Form::label('user_id', 'Colaborador:') !!}
                    {!! Form::select('user_id', [], null , [
                    'class' => 'selectpicker form-control',
                    'title' => 'Selecione um colaborador',
                    'data-live-search' => 'true',
                    'data-box-actions' => 'true',
                    'required'
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('user_id')}}</strong></span>
                    {!! Form::hidden('user_id_old',  $allocation->user_id  ?? null, ['id' => 'user_id_old']) !!}
                </div>

                

                {!! Form::hidden('group_company_id',  $allocation->group_company_id  ?? $group_company_id) !!}

                <div class="form-group task-group col-md-6 {{$errors->has('task_id') ? ' has-error' : ''}}">
                    {!! Form::label('task_id', 'Tarefa:') !!}
                    {!! Form::select('task_id', [],  null, [
                    'class' => 'selectpicker form-control',
                    'title' => 'Selecione uma tarefa',
                    'data-live-search' => 'true',
                    'data-box-actions' => 'true',
                    !$userException ? 'required' : ''
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('task_id')}}</strong></span>
                    {!! Form::hidden('task_id_old', $allocation->task ? $allocation->task->id: null, ['id' => 'task_id_old']) !!}
                </div>

                <div class="form-group {{$errors->has('start') ? ' has-error' : ''}} col-md-3 col-sm-6 col-xs-12">
                    {!! Form::label('start', 'Data de início:') !!}
                    {!! Form::text('start', $allocation->start ? $allocation->start->format('d/m/Y') : null, [
                    'class' => 'form-control',
                    'required'
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('start')}}</strong></span>
                </div>

                <div class="form-group {{$errors->has('finish') ? ' has-error' : ''}} col-md-3 col-sm-6 col-xs-12">
                        
                    {!! Form::label('finish', 'Data de término:') !!}
                    {!! Form::text('finish', $allocation->finish ? $allocation->finish->format('d/m/Y') : null, [
                    'class' => 'form-control',
                    'required'
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('finish')}}</strong></span>
                </div>
                
                <div class=" form-group{{$errors->has('hourDay') ? ' has-error' : ''}} col-md-3 col-sm-12 col-xs-12">
                    {!! Form::label('hourDay', 'Quantidade de horas por dia:') !!}
                    <span title="Quantidade de horas trabalhada no dia."
                          class="glyphicon glyphicon-question-sign black-tooltip"
                          aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>
                    {!! Form::number('hourDay', $allocation->hourDay ?? null, [
                    'class' => 'form-control validation-hours',
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('hourDay')}}</strong></span>
                </div>

                <div class="hoursQtd form-group{{$errors->has('hours') ? ' has-error' : ''}} col-md-3 col-sm-12 col-xs-12">
                    {!! Form::label('hours', 'Quantidade total de horas:') !!}
                    <span title="@lang('tips.whats-quantity-hours')"
                          class="glyphicon glyphicon-question-sign black-tooltip"
                          aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>
                    {!! Form::number('hours', $allocation->hours ?? null, [
                    'class' => 'form-control validation-hours',
                    'required'
                    ]) !!}
                    <div class='circle' style='display:none'></div>
                    <span class="help-block"><strong>{{$errors->first('hours')}}</strong></span>
                </div>


                <div class='form-group col-md-3 col-sm-12 col-xs-12"'>
                {!! Form::label('jobWeekEnd', 'Trabalhar final de semana e feriado:') !!}
                <span aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>	    <span aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
                <br>
                <input type="checkbox" name='jobWeekEnd' id='jobWeekEnd' data-toggle="toggle" data-on="Sim" data-off="Não" {{!$userException ? 'disabled' :''}}  {{$allocation->jobWeekEnd ==true?'checked':''}}>

                </div>

                <div class="form-group col-xs-12 {{$errors->has('description') ? 'has-error' : ''}}">
                    {!! Form::label('description', 'Descrição:') !!}
                    {!! Form::textarea('description', $allocation->description ?? null, ['class' => 'form-control', 'required' => 'required', 'style' => 'min-height: 87px;']) !!}
                    <span class="help-block"><strong>{{$errors->first('description')}}</strong></span>
                </div>

            <!-- <div class="form-group col-xs-12">
                {!! Form::label('documents', 'Anexar Arquivos: ') !!}
            {!! Form::file('documents', null, ['class' => 'btn btn-default'])!!}
                    </div> -->

            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('allocations.index') . '?deleted_at=whereNull' : url()->previous()}}"
                       class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        @lang('buttons.back')
                    </a>
                    <button type="submit" class="btn btn-dct" id="send-form-allocation">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        @lang('buttons.save')
                    </button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script type="text/javascript">
        $('textarea').ckeditor();
        $('#send-form-allocation').click(function(){
        $('textarea#description').val(CKEDITOR.instances.description.getData()) ;
    
    });
           $(document).ready(function(){
            $('#hoursNow').html('Atual');
            $('#hoursAdd').html('À Editar');
           });

           $('#hours').keyup(function(){
            checkHours({{$allocation->id}});
           });
    </script>

@endsection