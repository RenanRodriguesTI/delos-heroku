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

            <div class="col-xs-12 col-sm-12 col-lg-3">
                <div class="form-group">
                    {!! Form::select('deleted_at', ['' => 'Todos projetos','whereNotNull' => 'Somente projetos finalizados', 'whereNull' => 'Somente projetos em andamento'], Request::get('deleted_at'), [
                    'class' => 'nopadding selectpicker form-control',
                    'data-live-search' => 'true',
                    'data-actions-box' => 'true',
                    ])!!}
                </div>
            </div>

        <div class="col-xs-12 col-sm-12 col-lg-2">
            <div class="btn-group">
                <button type="submit" class="btn btn-dct">
                    Pesquisar
                </button>
                <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{route('allocations.report')}}"><span class="glyphicon glyphicon-cloud-download"></span>
                        @lang('buttons.export-excel')
                    </a>
                    <a href="javascript:void(0)" class="export-calendar" style="cursor: pointer;">
                        <i class="fa fa-google"></i> Sincronizar com Google Agenda
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
</form>
</div>
