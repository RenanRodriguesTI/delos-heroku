<div class="modal fade" id="office-update-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
{!! Form::open(['route'=>['office.update','id'=>0],'method' =>'post','id'=>'office-update']) !!}
    {{csrf_field()}}
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Cargo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 name">
                    {!! Form::label('name', 'Nome') !!}
                    {!! Form::text('name', '', ['class' => 'form-control','required']) !!}
                    <div class='circle' style='display:none'></div>
                    <span class="help-block">
                        <strong></strong>
                    </span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" id='btn-office-update' class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>


  @push('scripts')
      <script>
           $('#btn-office-update').click(function(){
                $(this).attr('disabled','disabled');
                $('.circle').show();
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              $.ajax({
                type:'POST',
                dataType:'JSON',
                url: $('#office-update').attr('action'),
                data:{
                  name:$('#office-update-modal #name').val()
                },
                success:function(){
                    window.location.reload();
                },
                error: function(err){
                  console.log(err)
                  if(err.status == 422){
                    var error = err.responseJSON;
                    $('#office-update-modal .name').addClass('has-error');
                    $('#office-update-modal .name .help-block strong').html(error.name);
                  }
                  $('#btn-office-update').attr('disabled',null);
                  $('.circle').hide();
                }
              })
           });
      </script>
  @endpush