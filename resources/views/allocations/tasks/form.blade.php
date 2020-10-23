<div class="modal fade" id="allocations-form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  {!! Form::open(['route'=>['allocations.addTaskStore','id'=>isset($allocation) ? $allocation->id:0 ],'method' =>'post','id'=>'allocation-add-task','autocomplete'=>'off']) !!}
  @csrf
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Tarefa</h4>
      </div>
      <div class="modal-body">
      <div class="alert alert-warning"  style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p style="color: white;"></p>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p class="project-details"></p>
            <p class="period-details"></p>
            <p class="user-details"></p>
          </div>
          <input type="hidden" id="allocation_task_id" name="allocation_task_id" value="{{old('allocation_task_id')}}" />
          <div class="taskAllocation col-lg-12 col-md-12 col-xs-12 {{ $errors->has('task_id') ? 'has-error' : ''}}">
            {!! Form::label('task_id', 'Tarefa:') !!}
            {!! Form::select('task_id', $tasks, null, ['title' => 'Selecione uma tarefa',
            'class' => 'form-control', 'data-actions-box' => "true",]) !!}
            <span class="help-block">
              <strong>{{$errors->first('task_id')}}</strong>
            </span>
          </div>
        </div>

        <div class='row'>
          <div class="startAllocation col-lg-6 col-md-6 col-sm-6 col-xs-12  {{$errors->has('start') ? 'has-error' : ''}}">
            {!! Form::label('start', 'Inicio') !!}
            {!! Form::text('start', '', ['class' => 'form-control start']) !!}
            <span class="help-block"><strong>{{$errors->first('start')}}</strong></span>
          </div>

          <div class="finishAllocation col-lg-6 col-md-6 col-sm-6 col-xs-12  {{$errors->has('finish') ? 'has-error' : ''}}">
            {!! Form::label('finish', 'Finalização') !!}
            {!! Form::text('finish', '', ['class' => 'form-control finish']) !!}
            <span class="help-block"><strong>{{$errors->first('finish')}}</strong></span>
          </div>
        </div>

        <div class="row">
          <div class="hoursAllocation col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('hours') ? 'has-error' : ''}}">
            {!! Form::label('hours', 'Quantidade de Hora') !!}
            {!! Form::text('hours', '', ['class' => 'form-control']) !!}
            <span class="help-block"><strong>{{$errors->first('hours')}}</strong></span>
          </div>
        </div>

        
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input name="concludes" id="concludes" value='1' type='checkbox' />
            <label for="concludes">Concluído</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="saveTasks" type="submit" class="btn btn-primary">
              <div class="circule-btn" style="display: none;"></div>
        Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>

  {!!Form::close() !!}
</div>

@push('scripts')
<script>

  $('#start').datetimepicker({
      format: 'L',
    });

    $('#finish').datetimepicker({
      format: 'L',
    });


    // A data de inicío será a data mínima
    $("#start").on("dp.change", function(e) {
      $('#finish').data("DateTimePicker").minDate(e.date);

    });

    // A data de fim será a data máxima
    $("#finish").on("dp.change", function(e) {
      $('#start').data("DateTimePicker").maxDate(e.date);
    });
  $(document).ready(function() {
    setTimeout(() => {
      if ($('.hoursAllocation strong').html() || $('.taskAllocation strong').html() || $('.startAllocation strong').html() || $('.finishAllocation strong').html()) {
        $('#allocations-form').modal('show');
      }
    }, 1000);

    


    $('#hours').bind('input',function(){
       
       if($(this).val() !='' && $('start').val() !="" && $('finish').val() !==''){
          $('#preloader').show();
          $('#status').show();
         $('#saveTasks').attr('disabled',true)
          $.ajax({
            type:'POST',
            dataType:'JSON',
            url:"{{route('allocations.checkHoursTask',['id'=>isset($allocation) ? $allocation->id:0 ])}}",
            data: new FormData($('#allocation-add-task')[0]),
            success:function(res){
                if(res.checkHours){
                  $('#allocations-form .alert-warning p').html(res.checkHours);
                  $('#allocations-form .alert-warning').show();
                }else{
                  $('#allocations-form .alert-warning').hide();
                }
               $('#saveTasks').attr('disabled',false)
               $('#preloader').hide();
               $('#status').hide();
            },
            error:function(err){
              console.log(err);
              $('#allocations-form .alert-warning').hide();
              $('#saveTasks').attr('disabled',false);
              $('#preloader').hide();
              $('#status').hide();
            },
            contentType:false,
            processData:false
          });
       } else{
        $('#allocations-form .alert-warning').hide();
       }
    });

  });

  $('#allocations-form').on('hidden.bs.modal', function() {
    if ($('#saveTasks').is(':active')) {

    } else {
      $('allocation-add-task').attr('action', "{{route('allocations.addTaskStore',['id'=>$allocation->id ?? 0])}}")
      $('#allocation_task_id').val('');
      $('#task_id').selectpicker('val', '');
      $('#hours').val('');
      $('.start').val('');
      $('.finish').val('');
      $('.taskAllocation .help-block strong').html('');
      $('.hoursAllocation .help-block strong').html('');
      $('.taskAllocation').removeClass('has-error');
      $('.hoursAllocation').removeClass('has-error');
      $('#concludes').attr('checked',false);  
      $('#allocations-form .alert-warning').hide();
      $('#allocations-form .alert-warning p').html('');
    }
  })
</script>
@endpush