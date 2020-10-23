<form class="modal fade" id="curse-form" action="{{route('curses.store')}}" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="idcurse" name="id" />
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="CurseModalLabel">Cursos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="user_id" value="{{$userId}}" />
                    <div class="nameCurse col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', 'Nome:') !!}
                        {!! Form::text('name', '', ['class' => 'form-control','id'=>'namecurse']) !!}
                        <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
                    </div>
                </div>

                <div class="row">

                </div>
                <div class='row'>
                    <div class="endDateCurse col-lg-6 col-md-6 col-sm-6 col-xs-12  {{$errors->has('end_date') ? 'has-error' : ''}}">
                        {!! Form::label('end_date', 'Data de Conclusão') !!}
                        {!! Form::text('end_date', '', ['class' => 'form-control']) !!}
                        <span class="help-block"><strong>{{$errors->first('end_date')}}</strong></span>
                    </div>
                    <div class="renewalDateCurse col-lg-6 col-md-6 col-sm-6 col-xs-12  {{$errors->has('renewal_date') ? 'has-error' : ''}}">
                        {!! Form::label('renewal_date', 'Data de Renovação') !!}
                        {!! Form::text('renewal_date', '', ['class' => 'form-control']) !!}
                        <span class="help-block"><strong>{{$errors->first('renewal_date')}}</strong></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {!! Form::label('filename', 'Arquivo') !!}
                        <div class="input-group">
                            {!! Form::text('filename', '', ['class' => 'form-control','readonly'=>true,'id'=>'filenamecurse']) !!}

                            <div class="input-group-btn">
                                <button id="btn-file-curse" class="btn btn-dct" type="button">
                                    <i class="fa fa-file"></i>
                                    Arquivo
                                </button>
                            </div>
                        </div>
                        <input type="file" id="cursefile" style="display: none;" name="file" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="saveCurse" type="button" class="btn btn-primary">
                    <div class="circule-btn" style="display: none;"></div>
                    Salvar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')

<script>
    $('#end_date').datetimepicker({
        format: 'L',
    });

    $('#renewal_date').datetimepicker({
        format: 'L',
    });

    $('#curse-form input[name="file"]').change(function() {
        $('#filenamecurse').val($(this)[0].files[0].name)
    });

    $('#btn-file-curse').click(function() {

        $('#cursefile').click();
    });

    $('#curse-form').on('hidden.bs.modal', function() {
        $('#namecurse').val('');
        $('#end_date').val('');
        $('#renewal_date').val('');
        $('#filenamecurse').val('')
        $('#idcurse').val('');
        $('.help-block strong').html('')
        $('.help-block strong').removeClass('has-error');
        $(".renewalDateCurse").removeClass('has-error');
        $(".endDateCurse").removeClass('has-error');
        $('.nameCurse').removeClass("has-error");
        $('#cursefile').val("");
    });
</script>
@endpush