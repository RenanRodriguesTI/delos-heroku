<div class="modal fade" id="office-finish-form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  {!!Form::open(['route'=>['office.updateHistory','id'=>$office->id],'method'=>'post']) !!}
    {{csrf_field()}}
    @if(!$lastHistory->isEmpty())
      <input type='hidden' value='{{$lastHistory->first()->id}}' name='idhistory' />
    @endif
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Cargo</h4>
        </div>
        <div class="modal-body">
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 has-error  {{$errors->has("finishupdate")?"invalid":"valid"}}'>
                {!! Form::label('finishupdate', 'Data de finalização:') !!}
                    {!! Form::text('finishupdate', null, [
                    'class' => 'form-control',
                    'autocomplete'=>'off',
                    'required'
                    ]) !!}
                    <span class="help-block"><strong> {{$errors->has("finishupdate") ? $errors->first('finishupdate'):'Informe a data de finalização do periodo anterior' }}</strong></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>

    {!!Form::close()!!}
  </div>


  @push('scripts')
      <script>

        const start = '{{$lastHistory->isEmpty()? null: $lastHistory->first()->start}}';
         $('#finishupdate').datetimepicker({
                format:        'L',
                useCurrent:    false,
                minDate:     start ? moment(start) : moment().subtract(1, "days"),
                disabledDates: [
                    start ? moment(start).subtract(1, "days") : moment().subtract(1, "days"),
                ]
            });

            $(document).ready(function(){
                if($('.invalid .help-block strong').length >0){
                  $('#office-finish-form').modal().show();
                }
            });
      </script>
  @endpush