<div class="modal fade" id="create-app-version" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <form id="form-create-app-version" action="{{route('appVersions.store')}}" class="modal-content" method='POST'>
        {{csrf_field()}}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Adicionar Versão</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="version col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$errors->has('version') ? 'has-error':''}}">
                    <label for="version">Versão</label>
                    <input name="version" id="version" value='' class="form-control" required />
                    <span class="help-block"><strong id='version-error'>{{$errors->first('version')}}</strong></span>
                </div>

                <div class="important col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input name="important" id="important" value='1' type='checkbox' checked />
                    <label for="important"> Importante</label>
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
          if($('#version-error').html()){
                $('#create-app-version').modal('show');
          }
      });
    //   $.ajaxSetup({
    //   headers: {
    //      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   }
    //     });
    //     $('#generate').click(function(){
    //        $(".version").removeClass('has-error');
    //        $('.help-block > strong').html("");
    //        $('#loading').toggle();
    //        $.ajax({
    //          type:'POST',
    //          url:$('#form-create-app-version').attr('action'),
    //          dataType:'JSON',
    //          data:{
    //            version: $('#version').val(),
    //            important: $('#important').val(),
    //          },
    //          success: function(res){
    //             console.log('Gravou')
    //          },
    //          error:function(err){
    //            console.log(err)
    //            $('#loading').toggle();
    //            if(err.status == 500){
    //            }
    //            if(err.responseJSON.message && err.status == 422){
    //              var errors = err.responseJSON.message;
    //              console.log(errors)
    //              $(".version").removeClass('has-error');
    //              $('.help-block > strong').html("");
    //              Object.keys(errors).forEach(function(error){
    //                if(errors[error][0]){
    //                  $("."+error+ ' > span strong').html(errors[error][0]);
    //                  $("."+error).addClass('has-error')
    //                }
                   
    //              });
    //            }
               
    //          } 
    //        });
    //      });
      </script>
  @endpush