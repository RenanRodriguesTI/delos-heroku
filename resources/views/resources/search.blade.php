<div class="panel-body" style="padding: 16px 24px 0 24px;">
    <form>
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    {!! Form::text('start', Request::query('start'), ['class' => 'form-control', 'placeholder' => 'De', 'id' => 'start']) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    {!! Form::text('finish', Request::query('finish'), ['class' => 'form-control', 'placeholder' => 'Até', 'id' => 'finish']) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-lg-5 display-space-between">
                <div class="btn-group">
                    <button type="submit" class="btn btn-dct">
                        Pesquisar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
     $('#start').datetimepicker({
            format: 'L',
        });
        //Date picker fim da alocação da alocação

        if($('#finish').val()){
            $('#finish').datetimepicker({
                format:        'L',
                useCurrent:    false,
            });
        } else{
            $('#finish').datetimepicker({
                format:        'L',
                useCurrent:    false,
                minDate:       moment().subtract(1, 'days'),
                disabledDates: [
                    moment().subtract(1, 'days')
                ]
            });
        }
    // A data de inicío será a data mínima
    $("#start").on("dp.change", function(e) {
        $('#finish').data("DateTimePicker").minDate(e.date);

    });

    // A data de fim será a data máxima
    $("#finish").on("dp.change", function(e) {
        $('#start').data("DateTimePicker").maxDate(e.date);
    });
</script>

@endpush