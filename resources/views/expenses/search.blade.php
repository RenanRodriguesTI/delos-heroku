<div class="panel-body" style="padding: 0 24px;">
    <form>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-12 col-sm-12 col-lg-2 nopadding">
                    <div class="form-group">
                        {!!
                            Form::text('search',
                                Request::query('search'),
                                [
                                    'class' => 'form-control',
                                    'id' => 'form-search-expenses',
                                    'placeholder' => 'Nota Fiscal',
                                ])
                        !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-lg-2 nopadding">
                    <div class="form-group">
                        {!!
                       Form::select('users[]', $users, Request::input('users'), [
                            'id' => 'form-control',
                            'class' => 'form-control selectpicker nopadding',
                            'title' => 'Selecione o(s) colaborador(es)',
                            'data-actions-box' => 'true',
                            'data-live-search' => 'true',
                            'multiple'
                         ])
                    !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-lg-2 nopadding">
                    <div class="form-group">

                        {!! Form::text('period', Request::get('period'), [
                            'class' => 'form-control',
                            'id' => 'period',
                            'placeholder' => 'Selecione o período'
                            ]) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-lg-2 nopadding">
                    <div class="form-group">
                        {!!
                       Form::select('projects[]', $projects, Request::input('projects'), [
                            'id' => 'form-control',
                            'class' => 'form-control selectpicker nopadding',
                            'title' => 'Selecione o(s) Projeto(s)',
                            'data-actions-box' => 'true',
                            'data-live-search' => 'true',
                            'multiple'
                         ])
                    !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-lg-2 nopadding">
                    <div class="form-group">

                        {!! Form::select('deleted_at', ['' => 'Todos projetos','whereNotNull' => 'Somente projetos finalizados', 'whereNull' => 'Somente projetos em andamento'], Request::get('deleted_at'), [
                            'class' => 'nopadding selectpicker form-control',
                            'data-live-search' => 'true',
                            'data-actions-box' => 'true',
                        ])!!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-lg-2 nopadding">
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
                            @can('report-txt-expense')
                                <li>
                                    <a class="report-txt" data-toggle="modal" data-target="#modal-report-txt"
                                       href="#!"><span class="glyphicon glyphicon-cloud-download"></span>
                                        @lang('buttons.export-txt')
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#period').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                autoApply: true,
                autoUpdateInput: false
            });

            $('#period').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
        });
    </script>
@endpush