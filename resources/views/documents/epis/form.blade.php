<form class="modal fade" id="epis-form" action="{{route("epis.store")}}" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="id" name="id" />
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="EPIsModalLabel">EPIs</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="user_id" value="{{$userId}}" />
                    <div class="nameEpis col-lg-12 col-md-12 col-sm-12 col-xs-12  {{$errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', 'Nome:') !!}
                        {!! Form::text('name', '', ['class' => 'form-control']) !!}
                        <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
                    </div>
                </div>

                <div class="row">

                </div>
                <div class='row'>
                    <div class="caEpis col-lg-6 col-md-6 col-sm-6 col-xs-12  {{$errors->has('ca') ? 'has-error' : ''}}">
                        {!! Form::label('ca', 'CA:') !!}
                        {!! Form::text('ca', '', ['class' => 'form-control']) !!}
                        <span class="help-block"><strong>{{$errors->first('ca')}}</strong></span>
                    </div>
                    <div class="shelfLifeEpis col-lg-6 col-md-6 col-sm-6 col-xs-12  {{$errors->has('shelf_life') ? 'has-error' : ''}}">
                        {!! Form::label('shelf_life', 'Validade') !!}
                        {!! Form::text('shelf_life', '', ['class' => 'form-control']) !!}
                        <span class="help-block"><strong>{{$errors->first('shelf_life')}}</strong></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {!! Form::label('filename', 'Arquivo') !!}
                        <div class="input-group">
                            {!! Form::text('filename', '', ['class' => 'form-control','readonly'=>true]) !!}

                            <div class="input-group-btn">
                                <button id="btn-file" class="btn btn-dct" type="button">
                                    <i class="fa fa-file"></i>
                                    Arquivo
                                </button>
                            </div>
                        </div>
                        <input type="file" style="display: none;" id="epifile" name="file" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="saveEpis" type="button" class="btn btn-primary">
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
    $('#shelf_life').datetimepicker({
        format: 'L',
    });

    $('#epis-form input[name="file"]').change(function() {
        $('#filename').val($(this)[0].files[0].name)
    });

    $('#btn-file').click(function() {

        $('#epis-form input[name="file"]').click();
    });

</script>
@endpush

