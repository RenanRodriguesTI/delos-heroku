@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-xs-12 col-sm-8">
                        <h3 class="panel-title bold">Pagamento</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <!-- <span title="@lang('tips.whats-expenses')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span> -->
                    </div>
                </div>

            </div>

            <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a data-toggle='modal' data-target='#payment-Provider' class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Adicionar
                    </a>
                </div>
            </div>

            <div class='panel-body'>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @include('payment-type-providers.search')
                </div>
                    
            </div>

            <div class="panel-body">
            
                <div class="table-responsive" style="min-height: 390px;">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ativo</th>
                                <th class='col-buttons'>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($paymentTypeProviders as $key => $type)
                                    <tr data-edit='{{$type->id}}'>
                                        <td>{{$type->name}}</td>
                                        <td>{{$type->ative ? 'Sim' : 'Não'}}</td>
                                        <td class="has-btn-group">

                                        @if ($key <= 3)
                                            <div class="btn-group dropdown">
                                                <button  type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                id="btn-options-users-{{$key}}">
                                                    <span class="glyphicon glyphicon-cog"></span>
                                                        @lang('buttons.options') &nbsp;<span class="caret"></span>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-edit='{{$type->id}}' data-type='{{$type->id}}' href="javascript:void(0);" data-toggle="modal" data-target='#payment-Provider'
                                                        id="btn-edit-users-{{$key}}">
                                                        <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>

                                                    <li><a href="{{route('paymentProvider.destroy', ['id' => $type->id])}}"
                                                            id="btn-edit-users-{{$key}}">
                                                            <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                                        </a>
                                                    </li>

                                                    <li class="divider"></li>
                                                </ul>
                                            </div>    
                                        </td>
                                        
                                        @else

                                        <div class="btn-group dropup">
                                            <button  type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-users-{{$key}}">
                                                        <span class="glyphicon glyphicon-cog"></span>
                                                        @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                <li><a data-edit='{{$type->id}}' data-type='{{$type->id}}' href="javascript:void(0);" data-toggle="modal" data-target='#payment-Provider'
                                                    id="btn-edit-users-{{$key}}">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>

                                                <li><a href="{{route('paymentProvider.destroy', ['id' => $type->id])}}"
                                                    id="btn-edit-users-{{$key}}">
                                                    <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                                    </a>
                                                </li>

                                                <li class="divider"></li>
                                            </ul>
                                        </div>    
                                    </td>
                                        @endif
                                
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $paymentTypeProviders->render() !!}
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="payment-Provider" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <form id="form-payment-provider" action="{{route('paymentProvider.store')}}" class="modal-content" method='POST'>
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
        // $.getJSON('/payment-provider/'+$(this).attr('data-edit')+'/edit').done(function(response){
        //    $('#name').val(response.paymentType.name);
        //    if(response.paymentType.ative){
        //       $('#ative').attr('checked','checked')
        //    } else{
        //       $('#ative').attr('checked',null)
        //    }

        //    $('#form-payment-provider').attr('action','payment-provider/'+response.paymentType.id);
           
        // }).always(function() {
        //   $('.circle').toggle();
        // });

        // $('.circle').toggle();
      });

      $('#close').click(function(){
        
      });

      $('#payment-Provider').on('hidden.bs.modal', function (e) {
        $('#name').val('')
        $('#ative').attr('checked','checked');
        $('#form-payment').attr('action','payment-provider');
     });
    </script>
@endpush

@endsection