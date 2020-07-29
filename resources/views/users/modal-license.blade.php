<div class="modal fade" id="create-license" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <form id="form-create-license" action="{{route('users.generate.key',['id'=> 0])}}" class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Gerador de Licença</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="cpuid col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="cpuid">CPU ID</label>
                    <input name="cpuid" id="cpuid" class="form-control" maxlength="3" required />
                    <span class="help-block"><strong></strong></span>
                </div>
            </div>
            <div class="display-flex-center-wh-100">
              <div id="loading" style=" background-image: url(../../images/loading.gif);width: 200px;
              height: 200px; background-size: 200px;
              background-repeat: no-repeat;
              background-position: center; display:none">
              </div>

            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p id="license" style="margin:10px 0px" class="license"></p>                
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <button id="generate" type="button" class="btn btn-primary">Gerar</button>
          <button id='close' type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </form>
    </div>
   
  </div>

  


  @push('scripts')
      <script>
        $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });
        $('#generate').click(function(){
           $(".cpuid").removeClass('has-error');
           $('.help-block > strong').html("");
           $('#license').html('');
           $('#loading').toggle();
           $.ajax({
             type:'POST',
             url:$('#form-create-license').attr('action'),
             dataType:'JSON',
             data:{
               cpuid: $('#cpuid').val()
             },
             success: function(res){
               console.log('success',res)
               $('#loading').toggle();
               $('#license').html('Licença: '+res.license+'');
             },
             error:function(err){
               console.log(err)
               $('#loading').toggle();
               if(err.status == 500){
                  $('#license').html('Não foi possivel gerar a licença tente novamente.');
               }
               if(err.responseJSON.message && err.status == 422){
                 var errors = err.responseJSON.message;
                 console.log(errors)
                 $(".cpuid").removeClass('has-error');
                 $('.help-block > strong').html("");
                 Object.keys(errors).forEach(function(error){
                   if(errors[error][0]){
                     $("."+error+ ' > span strong').html(errors[error][0]);
                     $("."+error).addClass('has-error')
                   }
                   
                 });
               }
               
             } 
           });
         });
      </script>
  @endpush