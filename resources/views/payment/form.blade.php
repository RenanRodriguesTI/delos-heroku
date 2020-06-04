<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <form id="form-payment" action="{{route('payment.store')}}" class="modal-content" method='POST'>
        {{csrf_field()}}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Tipo de Pagamento</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="version col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$errors->has('name') ? 'has-error':''}}">
                    <label for="name">Nome</label>
                    <input name="name" id="name" value='' class="form-control" required />
                    <div class='circle' style='display:none'></div>
                    <span class="help-block"><strong id='payment-error'>{{$errors->first('name')}}</strong></span>
                </div>
                <div class="important col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <input name="ative" id="ative" value='1' type='checkbox' checked />
                  <label for="ative"> Ativo</label>
                </div>
            </div>
            <div class="display-flex-center-wh-100">
              <div id="loading" style=" background-image: url(../../images/loading.gif);width: 200px;
              height: 200px; background-size: 200px;
              background-repeat: no-repeat;
              background-position: center; display:none">
              </div>

            </div>
        </div>
        <div class="modal-footer">
            <button id="generate" type="submit" class="btn btn-primary">Salvar</button>
          <button id='close' type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </form>
    </div>
   
  </div>

@push('scripts')
    <script>
        $(document).ready(function(){
          if($('#payment-error').html()){
                $('#create-payment').modal('show');
          }
      });

      $('a[data-edit]').click(function(){
        var id =  $(this).attr('data-edit');
        var typePayment = $('tr[data-edit="'+id+'"] > td');

        $('#name').val($(typePayment[0]).html());
        $('#form-payment-provider').attr('action','payment-provider/'+id);
        console.log($(typePayment[1]).html() =='Sim')
        if($(typePayment[1]).html() =='Sim'){
            $('#ative').prop('checked','checked')
        } else{
            $('#ative').prop('checked',null)
        }
        // $('.circle').toggle();
        // $.getJSON('/payment-user/'+$(this).attr('data-edit')+'/edit').done(function(response){
        //    $('#name').val(response.paymentType.name);
        //    if(response.paymentType.ative){
        //       $('#ative').attr('checked','checked')
        //    } else{
        //       $('#ative').attr('checked',null)
        //    }

        //    $('#form-payment').attr('action','payment-user/'+response.paymentType.id);
           
        // }).always(function() {
        //   $('.circle').toggle();
        // });
      });

      $('#close').click(function(){
        $('#name').val()
      });
    </script>
@endpush