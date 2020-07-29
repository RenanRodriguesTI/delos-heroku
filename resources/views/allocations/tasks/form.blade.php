<div class="modal fade" id="allocations-form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  {!! Form::open(['route'=>['allocations.addTaskStore','id'=>$allocation->id],'method' =>'post','id'=>'allocation-add-task']) !!}
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Tarefa</h4>
        </div>
        <div class="modal-body">
          <div class="row">
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
                  $(document).ready(function(){
                      setTimeout(() => {
                        if($('.hoursAllocation strong').html() || $('.taskAllocation strong').html()){
                          $('#allocations-form').modal('show');
                        }
                      },1000);
                  });
              </script>
  @endpush