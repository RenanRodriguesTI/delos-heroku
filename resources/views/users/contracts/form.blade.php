<div class="modal fade" id="create-contracts" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    {{ Form::open(['route'=>['users.contracts.create','id'=>$user->id],'method' =>'post','id'=>'form-contract']) }}

    {{  Form::hidden('user_id', $user->id,['id'=>'user_id']) }}
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Contrato</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="projects col-lg-12 col-md-12 col-xs-12">
              {!! Form::label('projects', 'Projetos:') !!}
              {!! Form::select('projects', $projects, isset($projects) ? null : null, ['title' => 'Selecione um ou mais projetos', 
              'class' => 'form-control', 'data-actions-box' => "true", 
              'multiple']) !!}
              <span class="help-block">
                  <strong></strong>
              </span>
            </div>
        </div>
          <div class="row">
            <div class="start col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('start') ? 'has-error' : ''}}">
              {!! Form::label('start', 'Inicio') !!}
              {!! Form::text('start',null, ['class' => 'form-control', 'required']) !!}
              <span class="help-block"><strong>{{$errors->first('start')}}</strong></span>
            </div>
          </div>
          <div class="row">
            <div class="end col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('end') ? 'has-error' : ''}}">
                {!! Form::label('end', 'Finalização') !!}
                {!! Form::text('end', null, ['class' => 'form-control', 'required']) !!}
                <span class="help-block"><strong>{{$errors->first('end')}}</strong></span>
            </div>
          </div>
          <div class="row">
            <div class="value col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('value') ? 'has-error' : ''}}">
              {!! Form::label('value', 'Valor') !!}
              {!! Form::text('value', '', ['class' => 'form-control']) !!}
              <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
              {!! Form::label('note', 'Observação') !!}
              {!! Form::text('note', '', ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button id="save" type="button" class="btn btn-primary">Salvar</button>
          <button id='close' type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>

  @push('scripts')

  <script>
    $(document).ready(function(){
        var url = new URL(window.location.href);
        var param = url.search.replace("?","");
        if(param){
          var paramsBusca = new URLSearchParams(param);
          if(paramsBusca.get('contracts')){
            $('#usuario').removeClass("active in");
            $('#contratos').addClass("active in");

            $('#link-usuario').removeClass('active');
            $('#link-contratos').addClass('active');
          }
        }
        

    });

    $("#start").daterangepicker({
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        },
        
        "singleDatePicker": true,
        
    });

    $("#end").daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        
        "singleDatePicker": true,
    });

    $('#add-contracts').click(function(){
      $(".projects,.start,.end,.value").removeClass('has-error');
      $('.help-block > strong').html("");
      var cod = $(this).attr('data-user');
      $('#form-contract').attr('action','/users/'+cod+'/contracts/create');
      $('#start').val('');
      $('#end').val('');
      $('#value').val('');
      $('#user_id').val(cod);
      $('#note').val('');
      $('#projects').selectpicker('val','');
  });

    $('a[data-edit]').click(function( ){
      $(".projects,.start,.end,.value").removeClass('has-error');
      $('.help-block > strong').html("");
        var cod = $(this).attr('data-contract');
        var linha = $('tr[data-contract="'+cod+'"] td');
        $('#form-contract').attr('action','/users/contracts/edit/'+cod);
        $('#start').val(linha[0].innerText);
        $('#end').val((linha[1]).innerText);
        $('#value').val($(linha[2]).attr('data-value'));
        $('#user_id').val($('tr[data-contract="'+cod+'"]').attr('data-user'));
        $('#note').val(linha[3].innerText);
        //$('#projects').selectpicker('val',$('tr[data-contract="'+cod+'"]').attr('data-project'));
        let projects = $('tr[data-contract="'+cod+'"]').attr('data-project');
        projects = projects.replace('[','');
        projects = projects.replace(']','');
        let array = projects.split(',');
        $('#projects').selectpicker('val',array)
    });

    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

    $('#save').click(function(){
     // $('#create-contracts').open();
      //debugger
      $.ajax({
        type:'POST',
        url:$('#form-contract').attr('action'),
        dataType:'JSON',
        data:{
          end: $('#end').val(),
          start:$('#start').val(),
          value: $('#value').val(),
          user_id:$('#user_id').val(),
          note: $('#note').val(),
          projects: $('#projects').val()
        },
        success: function(res){
         window.location.reload();
        },
        error:function(err){
          console.log(err)
          if(err.responseJSON.errors){
            var errors = err.responseJSON.errors;
            $(".projects,.start,.end,.value").removeClass('has-error');
            $('.help-block > strong').html("");
            debugger
            Object.keys(errors).forEach(function(error){
              if(errors[error][0]){
                $("."+error+ ' > span strong').html(errors[error][0]);
                $("."+error).addClass('has-error')
              }
              
            });
          }
          
        } 
      });

      return false;
    });


   
/**
* allow popup to hide or not
* @param {type} e
* @returns {Boolean}
 */
function closeModalEvent(e) {
    e.preventDefault();
    if ($('#save').is(':active')) {
        $('#create-contracts').off('hide.bs.modal.prevent');
        $("#create-contracts").modal('hide');
        return true;
    }
    return false;
}


function select(){
  
}


  </script>
  @endpush