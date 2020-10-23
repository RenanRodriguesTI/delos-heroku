<div class="panel-body" style="padding: 16px 24px 0 24px;">
    <form>
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="form-group">
                    {!! Form::text('search', Request::query('search'), ['class' => 'form-control', 'placeholder' => 'Pesquisar']) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    {!! Form::text('start', Request::query('start'), ['class' => 'form-control datepicker', 'placeholder' => 'De', 'id' => 'start']) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    {!! Form::text('finish', Request::query('finish'), ['class' => 'form-control datepicker', 'placeholder' => 'Até', 'id' => 'finish']) !!}
                </div>
            </div>

        <div class="col-xs-12 col-sm-12 col-lg-5 display-space-between">
            <div class="btn-group">
                <button type="submit" class="btn btn-dct">
                    Pesquisar
                </button>
            </div>

            <a href="{{route('allocations.index')}}" class="btn btn-default">
                    Voltar
                </a>
    </div>
</div>
</form>
</div>
