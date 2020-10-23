<div class="panel-body">
    <form id="requests_index">
        <div class="row">
            @if(Request::input('approved'))
                <input name="approved" type="hidden" value="{{Request::input('approved')}}" />
            @endif
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <div class="form-group">
                    {!! Form::text('period', Request::get('period'), [
                        'class' => 'form-control',
                        'placeholder' => 'Selecione o período'
                    ]) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    {!! Form::select('projects[]', $projects, Request::get('projects') ?? [], [
                        'id' => 'projects[]',
                        'class' => 'selectpicker form-control',
                        'multiple',
                        'title' => 'Selecione o(s) Projeto(s)',
                        'data-live-search' => 'true',
                        'data-actions-box' => "true",
                    ]) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    {!! Form::select('collaborators[]', $users, Request::get('collaborators') ?? [], [
                        'id' => 'users[]',
                        'class' => 'selectpicker form-control',
                        'multiple',
                        'title' => 'Selecione os colaboradores',
                        'data-live-search' => 'true',
                        'data-actions-box' => "true",
                    ]) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <div class="form-group">
                    {!! Form::select('deleted_at', ['' => 'Todos projetos','whereNotNull' => 'Somente projetos finalizados', 'whereNull' => 'Somente projetos em andamento'], Request::get('deleted_at'), [
                        'class' => 'selectpicker form-control',
                        'data-live-search' => 'true',
                        'data-actions-box' => 'true',
                    ])!!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <div class="form-group">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-dct">Pesquisar</button>
                        <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="report-xlsx"><span class="glyphicon glyphicon-cloud-download"></span>
                                    @lang('buttons.export-excel')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>