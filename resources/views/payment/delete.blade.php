<div class="modal fade" id="payment-destroy" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <form id="form-payment" action="{{route('payment.store')}}" class="modal-content" method='POST'>
        {{csrf_field()}}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Tipo de Pagamento</h4>
        </div>
        <div class="modal-body alertMessages bold">
            Deseja mesmo excluir esse tipo de pagamento!
        </div>
        <div class="modal-footer">
            <button id="generate" type="submit" class="btn btn-danger">Excluir</button>
          <button id='close' type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </form>
    </div>
   
  </div>
