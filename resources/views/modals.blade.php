<div class="modal fade" id="create-request-modal" tabindex="-1" role="dialog" aria-labelledby="modalAlertlLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title bold" id="modalAlertlLabel">Selecione o que você irá solicitar</h4>
            </div>
            <form action="{{route('requests.create')}}" method="GET">
                <div class="modal-body alertMessages bold">
                    <ul class="list-group" id="requests-services">
                        <li class="list-group-item">
                            <label for="tickets"><strong>Passagens Aéreas</strong><input type="checkbox" name="tickets"
                                                                                         value="has"
                                                                                         id="tickets"></label>
                        </li>
                        <li class="list-group-item">
                            <label for="lodgings"><strong>Hospedagem</strong><input type="checkbox" name="lodgings"
                                                                                    value="has" id="lodgings"></label>
                        </li>
                        <li class="list-group-item">
                            <label for="cars"><strong>Veículos</strong><input type="checkbox" name="cars" value="has"
                                                                              id="cars"></label>
                        </li>
                        <li class="list-group-item">
                            <label for="extras"><strong>Despesas Extras (Alimentação, Táxi, Pedágio, Combustível,
                                    Outros)</strong><input type="checkbox" name="extras" value="has"
                                                           id="extras"></label>
                        </li>
                    </ul>
                    <input type="hidden" name="has-filter" value="has">
                </div>
                <div class="modal-footer alert-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAlert" tabindex="-1" role="dialog" aria-labelledby="modalAlertlLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title bold" id="modalAlertlLabel">Título do modal</h4>
            </div>
            <div class="modal-body alertMessages bold">
                ...
            </div>
            <div class="modal-footer alert-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-table-details" tabindex="-1" role="dialog" aria-labelledby="modalAlertlLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modal-details">
                <div class="modal-header">
                    <h5 class="modal-title bold" id="modalAlertlLabel"></h5>
                </div>
                <div class="modal-body bold">

                </div>
            </div>

            <div class="modal-footer alert-footer">
                <button type="button" class="btn btn-default hidden-print" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-dct hidden-print" onclick="printContent('modal-details');">
                    Imprimir
                </button>

                <script>
                    function printContent(el) {
                        var mywindow = window.open('', 'PRINT');

                        mywindow.document.write('<html><head><title>' + document.title + '</title>');
                        mywindow.document.write("</head><body >");
                        mywindow.document.write('<h1>' + document.title + '</h1>');
                        mywindow.document.write(document.getElementById(el).innerHTML);
                        mywindow.document.write('</body></html>');

                        mywindow.document.close(); // necessary for IE >= 10
                        mywindow.focus(); // necessary for IE >= 10*/

                        mywindow.print();
                        mywindow.close();

                        return true;
                    }
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-material" id="modal-report-txt" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel-2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header nav-divider">
                <h4 class="modal-title" id="myModalLabel-2">Selecione a empresa:</h4>
            </div>

            <div class="modal-body">
                @yield('expenses.companies-select')
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dct" data-dismiss="modal"
                        onclick="$('#form-select-company-to-report').submit()"><span
                            class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Extrair
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                </button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade modal-material" id="modal-report-paymentWriteOffs" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel-2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header nav-divider">
                <h4 class="modal-title" id="myModalLabel-2">Selecione a empresa:</h4>
            </div>

            <div class="modal-body">
                @yield('expenses.companies-select.paymentWriteOffs')
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dct" data-dismiss="modal"
                        onclick="$('#form-select-company-to-report-paymentWriteOffs').submit()"><span
                            class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Extrair
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                </button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->



<div class="modal fade modal-material" id="modal-report-supplier-paymentWriteOffs" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel-2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header nav-divider">
                <h4 class="modal-title" id="myModalLabel-2">Selecione a empresa:</h4>
            </div>

            <div class="modal-body">
                @yield('expenses.companies-select.supplier.paymentWriteOffs')
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dct" data-dismiss="modal"
                        onclick="$('#form-select-company-to-report-supplier-paymentWriteOffs').submit()"><span
                            class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Extrair
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                </button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->




<div class="modal fade modal-material" id="modal-report-apportionments" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel-2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header nav-divider">
                <h4 class="modal-title" id="myModalLabel-2">Selecione a empresa:</h4>
            </div>

            <div class="modal-body">
                @yield('expenses.modal-report-apportionments')
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dct" data-dismiss="modal"
                        onclick="$('#form-select-company-to-report-apportionments').submit()"><span
                            class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Extrair
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                </button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade modal-material" id="modal-report-supplier-apportionments" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel-2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header nav-divider">
                <h4 class="modal-title" id="myModalLabel-2">Selecione a empresa:</h4>
            </div>

            <div class="modal-body">
                @yield('expenses.modal-report-supplier-apportionments')
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dct" data-dismiss="modal"
                        onclick="$('#form-select-company-to-report-supplier-apportionments').submit()"><span
                            class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Extrair
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                </button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="change_avatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header nav-divider">
                <h4 class="modal-title" id="myModalLabel-2">Alterar Avatar:</h4>
            </div>

            <div class="modal-body">
                <div class="jumbotron col-xs-12">
                    <img class="output"
                         style="transform: translate(902%,16px);width: 29px;height: 29px;border-radius: 50%;margin-right: 10px;display: none;" />
                    <img class="img-circle profile_img output" style="transform: translate(120%,-8px);display: none;" />
                </div>

                {!! Form::open(['route' => ['users.changeAvatar'], 'method' => 'POST','id' => 'form-avatar', 'files' => true]) !!}

                <label for="avatar">Selecione a imagem</label>
                <div class="input-group">
                    <input id="name_avatar" type="text" class="form-control" value="" readonly style="margin-top: 4px;">
                    <span class="input-group-btn">
                            <span class="btn btn-dct btn-file">
                                <i class="glyphicon glyphicon-cloud-upload"></i>
                                Selecionar <input type="file" name="avatar" required="required" id="avatar"
                                                  accept="image/*">
                            </span>
                        </span>
                </div>
                <input type="hidden" name="base64" id="base64">

                {!! Form::close() !!}
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="modal_image_crop" tabindex="-1" role="dialog" aria-labelledby="tasksLabel"
     data-backdrop="static"
     data-keyboard="false" style="height: 100%">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>

                <h5 class="modal-title" id="tasksLabel">
                    Recortar imagem:
                </h5>
            </div>
            <div class="modal-body">

                <div style="min-height:500px; max-height: 500px">
                    <img src=""
                         class="output" id="img-crop"
                         style="width: 100%!important; height: 100%!important; display: block!important;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dct btn-tasks-modal" id="btnCrop"><i class="fa fa-crop"></i>
                    Recortar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tasks_modal" tabindex="-1" role="dialog" aria-labelledby="tasksLabel" data-backdrop="static"
     data-keyboard="false" style="height: 100%">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>

                <h6 class="modal-title" id="tasksLabel" style="float: left;">
                    Adicionar Horas por tarefa - total: @yield('projects.tasks.total')
                </h6>

                <span title="@lang('tips.projects-hours')" class="glyphicon glyphicon-question-sign black-tooltip"
                      aria-hidden="true" data-toggle="tooltip" data-placement="bottom" style="margin-top: 11px;"></span>

                <br>

                <div class="alert alert-danger alert-tasks" style="margin-bottom: 0; display: none">
                    <h5>@lang('validation.not_more')</h5>
                </div>

            </div>
            <div class="modal-body">
                @yield('projects.tasks.content')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-tasks-hours-modal">Salvar tarefas</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@if(!Auth::guest())
    <div id="trial-period-expired-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    @can('index-select-plan-signature')
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    @endcan

                    <div class="text-center">
                        <h4 class="bold text-danger"> Parece que seu período de teste acabou.</h4>
                    </div>

                </div>
                <div class="modal-body">
                    <p class="lead">Olá {{\Auth::user()->name}},</p>
                    <p class="lead">Infelizmente temos que te dar uma notíficia ruim...seu período de teste acabou <i
                                class="fa fa-frown-o" aria-hidden="true"></i></p>
                    @if(!\Auth::user()->can('index-select-plan-signature'))
                        <p class="lead">Não se preocupe, já notificamos seus chefes</p>
                    @else
                        <p class="lead">Para ter acesso novamente ao sistema atualize suas informações de pagamento ou
                            escolha outro plano.</p>
                    @endif
                    <p class="lead">
                        Caso já tenha pago, nos mande o comprovante <a
                                href="mailto:administrador@delosservicos.com?Subject=Comprovante%2Bde%2Bpagamento"
                                target="_top">por e-mail</a>
                    </p>
                    <br>
                    <p class="lead">PS: Caso tenha alguma duvida ou feedback estamos a disposição</p>
                    <br>
                    <p class="lead">att.,</p>
                    <br>
                    <p class="lead bold">Equipe Smart Project</p>
                </div>
                <div class="modal-footer">
                    @can('index-select-plan-signature')
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    @if(session('trial_period_expired'))
        <script>
            $(document).ready(function () {
                $('#trial-period-expired-modal').modal({
                    backdrop: 'static'
                });
            });
        </script>
    @endif

    @if(session('bank_slip_upload'))
        <div id="bank_slip_upload" class="modal fade">
            {!! Form::open(['route' => ['bankSlips.upload.store', 'id' => $actualTransaction->id ?? null],'method' => 'POST', 'files' => true]) !!}
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item bold text-center">Informações do boleto</li>
                            <li class="list-group-item"><span
                                        class="bold">Empresa: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->name ?? null : ''}}
                            </li>
                            <li class="list-group-item"><span
                                        class="bold">Data de vencimento: </span> {{isset($actualTransaction) ? $actualTransaction->billing_date->format('d/m/Y') ?? null : ''}}
                            </li>
                            <li class="list-group-item"><span
                                        class="bold">CPF/CNPJ: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->document['number'] ?? null : ''}}
                            </li>
                            <li class="list-group-item"><span
                                        class="bold">Data da alteração: </span> {{isset($actualTransaction) ? $actualTransaction->billing_date->format('d/m/Y') : ''}}
                            </li>
                            <div id="payment-information" class="collapse">
                                <li class="list-group-item bold text-center">Dados Cadastrais</li>
                                <li class="list-group-item"><span
                                            class="bold">Pagador: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->name ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">E-mail: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->email ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">Telefone: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->telephone ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">CPF/CNPJ: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->document['number'] ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">CEP: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->address["postal_code"] ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">Endereço: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->address['street'] ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">Número: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->address['number'] ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">Bairro: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->address['district'] ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">Cidade: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->address['city'] ?? null : ''}}
                                </li>
                                <li class="list-group-item"><span
                                            class="bold">UF: </span> {{isset($actualTransaction) ? $actualTransaction->groupCompany->paymentInformation->address['state'] ?? null : ''}}
                                </li>
                            </div>
                        </ul>

                        <hr>

                        <a href="#payment-information" data-toggle="collapse" class="pull-right">Visualizar dados
                            cadastrais</a>
                        <h5 class="bold text-uppercase col-md-7 col-sm-7 col-xs-12" style="color: #565656">Adicionar o
                            boleto</h5>

                        <br>

                        <div class="col-md-6 form-group {{$errors->has('value_paid') ? 'has-error' : ''}}">
                            <label for="value">Valor:</label>
                            <div class="input-group">
                                <div class="input-group-addon">R$</div>
                                {!! Form::text('value_paid', null, ['class' => 'form-control', 'id' => 'value']) !!}
                            </div>
                            <span class="help-block"><strong>{{$errors->first('value_paid')}}</strong></span>
                        </div>

                        <div class="col-md-6 form-group {{$errors->has('bank_slip') ? 'has-error' : ''}}">
                            <label for="file">Arquivo:</label>
                            <div class="input-group">
                                <input id="invoice-file" type="text" class="form-control name_invoice"
                                       value="{{$expense->original_name ?? null}}" readonly style="margin-top: 3px;"
                                       required="required">
                                <span class="input-group-btn">
                                        <span class="btn btn-dct btn-file"><i
                                                    class="glyphicon glyphicon-cloud-upload"></i> Selecionar <input
                                                    type="file" accept=".pdf" id="value" name="bank_slip"
                                                    required="required"></span>
                                    </span>
                            </div>
                            <span class="help-block"><strong>{{$errors->first('bank_slip')}}</strong></span>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: 39px">
                        <hr>
                        <button type="submit" class="btn btn-dct" style="margin-top: 9px;">Enviar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>


        <script>
            $(document).ready(function () {
                $('#trial-period-expired-modal').modal('hide');


                $('#bank_slip_upload').modal('show');
                $('#bank_slip_upload').on('hidden.bs.modal', function () {
                    window.location = '{{route('bankSlips.index')}}';
                });

                Cookies.set('bank_slip_upload', true);
            });
        </script>
    @else
        <script>
            $(document).ready(function () {
                Cookies.set('bank_slip_upload', false);
            });
        </script>
    @endif
@endif

<div class="modal fade" id="debit-memo-alert" tabindex="-1" role="dialog" aria-labelledby="tasksLabel"
     data-backdrop="static"
     data-keyboard="false" style="height: 100%">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>

                <h6 class="modal-title" id="tasksLabel" style="float: left;">
                    Novo alerta para @yield('debitMemos.alert.title')
                </h6>
            </div>

            @yield('debitMemos.alert.form.open')
            <div class="modal-body">

                <div class="form-group {{$errors->has('value') ? 'has-error' : ''}}">
                    <div class="input-group">
                        <span class="input-group-addon" id="value-addon">R$</span>
                        {!! Form::label('value', 'Valor:') !!}
                        {!! Form::text('value', null, ['class' => 'form-control', 'required', 'aria-descritedby' => 'value-addon']) !!}
                        <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dct">Salvar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
            @yield('debitMemos.alert.form.close')
        </div>
    </div>
</div>
<div class="modal fade" id="destroy-allocation" tabindex="-1" role="dialog" aria-labelledby="Delete Allocation">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title bold" id="modalAlertlLabel">Deseja realmente remover essa alocação?</h4>
            </div>
            <form action="" method="POST" id="destroy-allocation-form">
                <div class="modal-body alertMessages">
                    <div class="form-group">
                        {{ csrf_field()  }}
                        {!! Form::label('reason','Motivo pelo qual deseja remover a alocação:') !!}
                        {!! Form::text('reason', '', ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="modal-footer alert-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-danger recusar-btn" type="submit">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remover
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal  fade" id="daily-allocation-details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title bold">Confirmação de horas</h4>
            </div>
            <div class="modal-body bold table-responsive" style="margin-top: -60px;">
                <div class="alert alert-danger info" role="alert">
                    O colaborador deve possuir no máximo 24 horas alocadas por dia!
                </div>

                <br>

                <table class="table table-bordered" style="margin-bottom: 0;">
                    <thead>
                    <tr>
                        <th class="text-center" rowspan="2" style="min-width: 242px;">Colaborador</th>
                        <th class="text-center" rowspan="2">Data</th>
                        <th class="text-center" rowspan="2">Projeto</th>
                        <th class="text-center" colspan="2">Horas</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 33px;" id='hoursNow'>Adicionadas</th>
                        <th class="text-center" style="width: 99px;" id='hoursAdd'>À adicionar</th>
                    </tr>
                    </thead>
                    <tbody class="modal-result">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class="glyphicon glyphicon-close"></span>
                    Fechar
                </button>
                <button type="button" class="btn btn-dct daily-submit-form">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>