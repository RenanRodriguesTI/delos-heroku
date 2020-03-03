<div class="panel-body" id="search" style="padding: 16px 24px 0 24px;">
    <form>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-2">
                <div class="form-group">
                    {!! Form::text('search', Request::query('search'), ['class' => 'form-control nopadding', 'placeholder' => 'Digite a pesquisa']) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-lg-3">
                <div class="form-group">
                    {!! Form::select('projects[]', $projects, Request::input('projects'), [
                    'class'=> 'selectpicker form-control nopadding',
                    'multiple',
                    'title' => 'Selecione o(s) Projeto(s)',
                    'data-live-search' => 'true',
                    'data-actions-box' => 'true',
                ])!!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-lg-3">
                <div class="form-group">
                    {!! Form::select('status', ['1' => 'Em Aberto', '0' => 'Finalizado'], Request::input('status'), [
                    'class'=> 'selectpicker nopadding form-control',
                    'multiple',
                    'title' => 'Selecione o status',
                    'data-live-search' => 'true',
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
                            <a class="report-xlsx"><span
                                        class="glyphicon glyphicon-cloud-download"></span>
                                @lang('buttons.export-excel')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>