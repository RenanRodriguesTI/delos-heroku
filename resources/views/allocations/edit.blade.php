@extends('layouts.app')

@section('content')
<div class="container">
    {!! Form::open(['route' =>[ 'allocations.update', 'id'=>$allocation->id], 'method' => 'post', 'id' => 'form-allocation','autocomplete'=>'off']) !!}

    <div class="panel panel-dct">
        <div class="panel-heading">
            <h3 class="panel-title bold">Editar Alocação</h3>
        </div>
        <div class="panel-body">
            <div class="row">
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

            </div>


            <div class="row">

                <div class="form-group user-group col-md-6 {{$errors->has('user_id') ? ' has-error' : ''}}">
                    {!! Form::label('user_id', 'Colaborador:') !!}
                    {!! Form::select('user_id', [], $allocation->user_id ?? null , [
                    'class' => 'selectpicker form-control',
                    'title' => 'Selecione um colaborador',
                    'data-live-search' => 'true',
                    'data-box-actions' => 'true',
                    'required'
                    ]) !!}
                    <div class='circle-type-2' id='loadding-user' style='display:none'></div>
                    <span class="help-block"><strong>{{$errors->first('user_id')}}</strong></span>
                    {!! Form::hidden('user_id_old', $allocation->user_id ?? null, ['id' => 'user_id_old']) !!}
                </div>

                <!-- <div class='form-group col-md-1'>
                        Form::label('alluser','Todos:')<br>
                        <input type='checkbox' id='alluser' data-toggle='toggle' data-on='Sim' data-off='Não' />
                </div> -->



                {!! Form::hidden('group_company_id', $allocation->group_company_id ?? $group_company_id) !!}

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
                
                {{-- 
                    <div class=" form-group{{$errors->has('hourDay') ? ' has-error' : ''}} col-md-3 col-sm-12 col-xs-12">
                    {!! Form::label('hourDay', 'Quantidade de horas por dia:') !!}
                    <span title="Quantidade de horas trabalhada no dia." class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>
                    {!! Form::number('hourDay', $allocation->hourDay ?? null, [
                    'class' => 'form-control validation-hours',
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('hourDay')}}</strong></span>
                </div>

                <div class="hoursQtd form-group{{$errors->has('hours') ? ' has-error' : ''}} col-md-3 col-sm-12 col-xs-12">
                    {!! Form::label('hours', 'Quantidade total de horas:') !!}
                    <span title="@lang('tips.whats-quantity-hours')" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>
                    {!! Form::number('hours', $allocation->hours ?? null, [
                    'class' => 'form-control validation-hours',
                    'required'
                    ]) !!}
                    <div class='circle' style='display:none'></div>
                    <span class="help-block"><strong>{{$errors->first('hours')}}</strong></span>
                </div>
                    --}}


                <div class='form-group col-md-3 col-sm-12 col-xs-12"'>
                    {!! Form::label('jobWeekEnd', 'Trabalhar final de semana e feriado:') !!}
                    <span aria-hidden="true" data-toggle="tooltip" data-placement="top"></span> <span aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
                    <br>
                    <input type="checkbox" name='jobWeekEnd' id='jobWeekEnd' data-toggle="toggle" data-on="Sim" data-off="Não" {{!$userException ? 'disabled' :''}} {{$allocation->jobWeekEnd ==true?'checked':''}}>
                    @if(!$userException)
                    <input type="hidden" name="jobWeekEnd" value="{{$allocation->jobWeekEnd}}" />
                    @endif
                </div>

                <div class='col-md-2 col-sm-12 col-xs-12'>
                    <br>
                    <a class="btn btn-dct" id='add-tasks-allocation' href='javascript:void(0);'>Adicionar tarefas</a>
                </div>
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
                <a href="{{url()->previous() == url()->current() ? route('allocations.index') . '?deleted_at=whereNull' : url()->previous()}}" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    @lang('buttons.back')
                </a>
                <button type="button" class="btn btn-dct" id="send-form-allocation">
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
    $(document).ready(function() {
        $('#hoursNow').html('Atual');
        $('#hoursAdd').html('À Editar');
        buttonAddTask();
    });

    $('#hours').keyup(function() {
        checkHours("{{$allocation->id}}");
    });

    $('#send-form-allocation').click(function() {
        saveAllocation(true);
    });

    $('#add-tasks-allocation').click(function() {
        saveAllocation(true, true);
    });

    function saveAllocation(update=false,addtask=false){
    $('#send-form-allocation').attr('disabled','disabled')
        $('#preloader').show();
        $('#status').show();
        $('textarea#description').val(CKEDITOR.instances.description.getData()) ;
        $.ajax({
            url:$('#form-allocation').attr('action'),
            type:'POST',
            dataType:'JSON',
            data:new FormData($('#form-allocation')[0]),
            processData:false,
            contentType:false,
            success:function(res){
                $('.help-block strong').html('');
                if(!update){
                    $('#preloader').hide();
                    $('#status').hide();
                    questAllocation();
                }else{
                    window.location.href='/allocations?deleted_at=whereNull';
                }
               
                if(res.father && addtask){
                    window.location.href='/allocations/'+res.father+'/add-tasks'
                }
                $('#send-form-allocation').attr('disabled',null)
            },
            error:function(err){
                switch(err.status){
                    case 422:
                        setErrors(err.responseJSON);
                    break;
                    case 500:
                    break;
                }
                $('#preloader').hide();
                $('#status').hide();

                $('#send-form-allocation').attr('disabled',null)
            }
        });
    
}


function setErrors(errors){
    Object.keys(errors).forEach(function(item){
        console.log(item)
        switch(item){
            case "project_id":
                $('.project-group > .help-block strong').html(errors[item][0]).css('color','rgb(229, 28, 35)');
            break;
            case "user_id":
                $('.user-group > .help-block strong').html(errors[item][0]).css('color','rgb(229, 28, 35)');
            break;
            default:
                $("#"+item+' ~ .help-block strong').html(errors[item][0]).css('color','rgb(229, 28, 35)');
        }
    });

   swal({
        title:'Alocação',
        icon:'error',
        text:'Alguns itens não foram informados corretamente',
    });
}

function questAllocation(){
    swal({
        title:"Alocação Criada",
        text:'Deseja continuar alocando para esse projeto?',
        buttons :{
            yes:{
                text:'Sim',
                className:'swal-button--success'
            },
            no:{
                text:'Não'
            }
        }
        
    }).then(function(res){
        if(res == 'no'){
            $('#project_id').selectpicker('val','');
        }

        $('#hourDay').val('8')
        $('#start').val('');
        $('#finish').val('');
        $('#hours').val('');
        CKEDITOR.instances.description.setData('');
        $('textarea#description').val(CKEDITOR.instances.description.getData()) ;
        $('#jobWeekEnd').bootstrapToggle('off')
    });

}

</script>

@endsection