<form>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            <div class="form-group">
                {!! Form::text('search', Request::query('search'), ['class' => 'form-control', 'placeholder' => 'Pesquisar']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-3">
            <div class="form-group">
                {!! Form::select('deleted_at', ['' => 'Todos os usuários','whereNotNull' => 'Somente usuários desabilitados', 'whereNull' => 'Somente usuários ativos'], Request::get('deleted_at'), [
                'class' => 'nopadding selectpicker form-control',
                'data-live-search' => 'true',
                'data-actions-box' => 'true',
                ])!!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-3">
            <div class="form-group">
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
                            <a class="report-xlsx"><span class="glyphicon glyphicon-cloud-download"></span>
                                @lang('buttons.export-excel')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>