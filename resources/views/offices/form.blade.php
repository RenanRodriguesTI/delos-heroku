<div class="modal fade" id="office-form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  
    {{csrf_field()}}
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Cargo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', 'Nome') !!}
                {!! Form::text('name','', ['class' => 'form-control','required']) !!}
              <span class="help-block">
                  <strong>{{$errors->first('name')}}</strong>
              </span>
            </div>
        </div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('value') ? 'has-error' : ''}}">
              {!! Form::label('value', 'Valor/hora') !!}
              {!! Form::text('value', '', ['class' => 'form-control','required']) !!}
              <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
            </div>
          </div>

          <div class='row'>
                <div class='form-group col-lg-6 col-md-6 col-sm-12 col-xs-12'>
                    {!! Form::label('start', 'Data de início:') !!}
                    {!! Form::text('start', null, [
                    'class' => 'form-control',
                    'required',
                    'autocomplete'=>'off'
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('start')}}</strong></span>
                </div>

                <div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>
                {!! Form::label('finish', 'Data de finalização:') !!}
                    {!! Form::text('finish', null, [
                    'class' => 'form-control',
                    'autocomplete'=>'off'
                    ]) !!}
                    <span class="help-block"><strong>{{$errors->first('start')}}</strong></span>
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
        $(document).ready(function(){
            //Date picker início da alocação
        $('#start').datetimepicker({
            format: 'L',
        });

        //Date picker fim da alocação da alocação

        if($('#finish').val()){
            $('#finish').datetimepicker({
                format:        'L',
                useCurrent:    false,
            });
        } else{
            $('#finish').datetimepicker({
                format:        'L',
                useCurrent:    false,
                minDate:       moment().subtract(1, 'days'),
                disabledDates: [
                    moment().subtract(1, 'days')
                ]
            });
        }
       

        // A data de inicío será a data mínima
        $("#start").on("dp.change", function (e) {
            $('#finish').data("DateTimePicker").minDate(e.date);
           
        });

        // A data de fim será a data máxima
        $("#finish").on("dp.change", function (e) {
            $('#start').data("DateTimePicker").maxDate(e.date);
        
           
        });

        $('#value').mask("#.##0,00", {reverse: true});

        if($('#office-form .help-block strong').html()){
            $('#office-form').modal().show();
        }
        });

        
    </script>
  @endpush