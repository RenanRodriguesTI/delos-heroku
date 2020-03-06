<div class="modal fade" id="create-contracts" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    {{ Form::open(['route'=>['users.contracts.create','id'=>$user->id],'method' =>'post','id'=>'form-contract']) }}

    {{  Form::hidden('user_id', $user->id) }}
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Contrato</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    {!! Form::label('start', 'Inicio') !!}
                    {!! Form::text('start', '', ['class' => 'form-control', 'required']) !!}
                    <span class="help-block"><strong>{{$errors->first('start')}}</strong></span>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {!! Form::label('end', 'Finalização') !!}
                {!! Form::text('end', '', ['class' => 'form-control', 'required']) !!}
                <span class="help-block"><strong>{{$errors->first('end')}}</strong></span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              {!! Form::label('value', 'Valor') !!}
              {!! Form::text('value', '', ['class' => 'form-control']) !!}
              <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>

  @push('scripts')

  <script>
    $("#start").daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
    });

    $("#end").daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        "singleDatePicker": true,
    });

    $('button[data-contract]').click(function( ){
        var cod = $(this).attr('data-contract');
        var linha = $('tr[data-contract="'+cod+'"] td');
        $('#form-contract').attr('action','/users/contracts/edit/'+cod);
        $('#start').val(linha[0].innerText);
        $('#end').val(linha[1].innerText);
        $('#value').val($(linha[2]).attr('data-value'));
        $('#user_id').val($(this).attr('data-user_id'));

        console.log(linha[2].attr('data-value'))
    });


  </script>
  @endpush