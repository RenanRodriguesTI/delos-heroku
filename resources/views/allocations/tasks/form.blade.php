<div class="modal fade" id="allocations-form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  {!! Form::open(['route'=>['allocations.addTaskStore','id'=>$allocation->id],'method' =>'post','id'=>'allocation-add-task','autocomplete'=>'off']) !!}
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Tarefa</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" id="allocation_task_id" name="allocation_task_id" />
          <div class="taskAllocation col-lg-12 col-md-12 col-xs-12 {{ $errors->has('task_id') ? 'has-error' : ''}}">
            {!! Form::label('task_id', 'Tarefa:') !!}
            {!! Form::select('task_id', $tasks, null, ['title' => 'Selecione uma tarefa',
            'class' => 'form-control', 'data-actions-box' => "true",]) !!}
            <span class="help-block">
              <strong>{{$errors->first('task_id')}}</strong>
            </span>
          </div>
        </div>
        <div class="row">
          <div class="hoursAllocation col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('hours') ? 'has-error' : ''}}">
            {!! Form::label('hours', 'Quantidade de Hora') !!}
            {!! Form::text('hours', '', ['class' => 'form-control']) !!}
            <span class="help-block"><strong>{{$errors->first('hours')}}</strong></span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="saveTasks" type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>

  {!!Form::close() !!}
</div>

@push('scripts')
<script>
  $(document).ready(function() {
    setTimeout(() => {
      if ($('.hoursAllocation strong').html() || $('.taskAllocation strong').html() || $('.startAllocation strong').html() || $('.finishAllocation strong').html()) {
        $('#allocations-form').modal('show');
      }
    }, 1000);

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

  });

  $('#allocations-form').on('hidden.bs.modal', function () {
    if ($('#saveTasks').is(':active')){

    }else{
            $('allocation-add-task').attr('action',"{{route('allocations.addTaskStore',['id'=>$allocation->id])}}")
            $('#allocation_task_id').val('');
            $('#task_id').selectpicker('val','');
            $('#hours').val('');
    }
  })
</script>
@endpush