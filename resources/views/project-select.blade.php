<div class="panel-body" style="padding: 16px 24px 0 24px;">
    <form class="form-inline">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-8">
                    {!! Form::select('projects[]', $projectsForSelect, Request::get('projects'), [
                        'id' => 'projects',
                        'class' => 'selectpicker',
                        'data-actions-box' => 'true',
                        'data-live-search' => 'true',
                        'title' => 'Selecione o(s) Projeto(s)',
                        'multiple'
                    ]) !!}
                </div>
                <div class="col-xs-4">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search dct-color"></span>
                        </button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
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
</div>