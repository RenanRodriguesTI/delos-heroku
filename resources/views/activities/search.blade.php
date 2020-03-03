
<div class="panel-body" style="padding: 0px 24px;">
    {!! Form::open(['route' => 'activities.index', 'method' => 'get', 'id' => 'search-activities']) !!}

    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
            @if(count($users))
                {!! Form::select('users[]', $users, Request::get('users'), [
                'class' => 'nopadding selectpicker col-xs-12 col-sm-12 col-lg-2',
                'data-live-search' => 'true',
                'data-actions-box' => 'true',
                'title' => 'Selecione o(s) colaborador(es)',
                'multiple'
                ])!!}
            @endif

            <div class="hidden-lg col-xs-12 col-sm-12">
                <br>
            </div>

            {!! Form::select('projects[]', $projects, Request::get('projects') ?? [], [
                'class' => 'nopadding selectpicker col-xs-12 col-sm-12 col-lg-2',
                'data-live-search' => 'true',
                'data-actions-box' => 'true',
                'title' => 'Selecione o(s) Projeto(s)',
                'multiple'
            ]) !!}

            <div class="hidden-lg col-xs-12 col-sm-12">
                <br>
            </div>

            {!! Form::select('approved[]', ['1' => 'Aprovado', '0' => 'Aguardando aprovação'], Request::get('approved'), [
            'class' => 'nopadding selectpicker col-xs-12 col-sm-12 col-lg-2',
            'data-live-search' => 'true',
            'data-actions-box' => 'true',
            'title' => 'Selecione o(s) status',
            'multiple'
            ])!!}

            <div class="hidden-lg col-xs-12 col-sm-12">
                <br>
            </div>

            {!! Form::select('tasks[]', $tasks, Request::get('tasks'), [
            'class' => 'nopadding selectpicker col-xs-12 col-sm-12 col-lg-2',
            'data-live-search' => 'true',
            'data-actions-box' => 'true',
            'title' => 'Selecione a(s) tarefa(s)',
            'multiple'
            ])!!}

            <div class="hidden-lg col-xs-12 col-sm-12">
                <br>
            </div>

            {!! Form::select('deleted_at', ['' => 'Todos projetos','whereNotNull' => 'Somente projetos finalizados', 'whereNull' => 'Somente projetos em andamento'], Request::get('deleted_at'), [
            'class' => 'nopadding selectpicker col-xs-12 col-sm-12 col-lg-2',
            'data-live-search' => 'true',
            'data-actions-box' => 'true',
            ])!!}

            <div class="hidden-lg col-xs-12 col-sm-12">
                <br>
            </div>

            <div class="btn-group">
                {!! Form::submit('Pesquisar', ['class' => 'btn btn-dct']) !!}
                <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="report-xlsx"><span class="glyphicon glyphicon-cloud-download"></span>
                            @lang('buttons.export-excel')
                        </a>
                    </li>
                    @can('report-external-activity')
                        <li>
                            <a href="{{route('activities.externalWorksReport')}}">
                                <span class="glyphicon glyphicon-cloud-download"></span>
                                @lang('buttons.report-external-activity')
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>


    {!! Form::close() !!}
    <br>
</div>