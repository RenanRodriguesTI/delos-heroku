<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="O Delos Project é a ferramenta ideal para gerenciar projetos de qualquer porte onde você precise:​ Manter controle sobre tempo e escopo​, Gerenciar equipes em diversas localidades​, Gerenciar reembolso e/ou despesas dos membros da equipe​">
    <meta name="Keywords"
          content="gestão de projetos, gerenciamento de projetos, sistema de gestão, gestao de projetos, escopo do projeto, sistema online, ferramentas de gestão, software de gestão, gestão de tempo, escopo de projeto">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>Delos Project - O software ideal para gerir seus projetos</title>

    <!-- Styles -->
    <link href="{!!elixir('css/all.css')!!}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    {!! Charts::assets() !!}
    <link href="../../vendor/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />
    <script src="../../vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="../../vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    
</head>
<body class="nav-md">
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<div class="container body">
    <div class="main_container">
        @if (!Auth::guest())
            <div class="col-md-3 left_col hidden-print">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title text-center" style="border: 0;">
                        <a href="{{ route('home.index') }}" class="site_title">
                            <img src="{{asset('images/logo.png')}}" style="max-width: 150px; margin: 15px 20px;"
                                 id="sidebar-logo">
                            <img src="{{asset('images/owl-white.png')}}" style="max-width: 32px;" id="sidebar-owl">
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            @if(Auth::user()->avatar)
                                <img src="{{Auth::user()->avatar}}" alt="Avatar profile" class="img-circle profile_img">
                            @else
                                <p class="img-circle profile_img bold"
                                   style="line-height: 48px;font-size: 45px;text-align: center;background: #73879C;color: #fff;">{{substr(Auth::user()->name,0,1)}}</p>
                            @endif
                        </div>
                        <div class="profile_info">
                            <span>Bem vindo,</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3 style="opacity: 0;">Separator</h3>
                            <ul class="nav side-menu">
                                @can('index-signature')
                                    <script>
                                        $(document).ready(function () {
                                            $('.nav.side-menu').css('transform', 'translateY(-28px');
                                        });
                                    </script>
                                    <li class="nav-divider" style="opacity: 0; cursor: default"></li>
                                    <li><a href="{{ route('signatures.index') }}" id="signatures"><i
                                                    class="fa fa-address-card"></i> @lang('menu.signatures')</a></li>
                                @endcan

                                <li style="margin-top: 10px;"><a href="{{ route('home.index') }}"><i
                                                class="fa fa-home"></i> @lang('menu.home')
                                    </a></li>

                                @can('hours-menu')
                                    <li><a><i class="fa fa-clock-o"></i> @lang('menu.hours') <span
                                                    class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            @can('index-activity')
                                                <li>
                                                    <a href="{{route('activities.index')}}?deleted_at=whereNull">@lang('menu.activities')</a>
                                                </li>
                                            @endcan

                                            @can('index-missing-activity')
                                                <li>
                                                    <a href="{{route('missingActivities.index')}}">@lang('menu.missing-activities')</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan

                                @can('expense-menu')
                                    <li>
                                        <a><i class="fa fa-money"></i> @lang('menu.expenses') <span
                                                    class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            @can('index-expense')
                                                <li>
                                                    <a> @lang('menu.invoices')</a>
                                                    <ul class="nav child_menu">
                                                        <li><a href="{{route('supplierExpense.index')}}">Fornecedores</a></li>
                                                        <li> <a href="{{route('expenses.index')}}?deleted_at=whereNull">Usuários</a></li>
                                                    </ul>
                                                </li>
                                            @endcan

                                            @can('index-debit-memo')
                                                <li>
                                                    <a href="{{route('debitMemos.index')}}?status=1">@lang('menu.debit-memos')</a>
                                                </li>
                                            @endcan
                                                

                                            @can('index-supplier-expenses-import')
                                            <li>
                                                    <a href="{{route('supplierExpensesImport.index')}}">Importar Despesas por Fornecedor</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan

                                @can('approve-menu')
                                    <li><a><i class="fa fa-gavel"></i> @lang('menu.approve') <span
                                                    class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li>
                                                <a href="{{route('activities.index')}}?approved[]=0&deleted_at=whereNull">@lang('menu.activities')</a>
                                            </li>

                                            <li>
                                                <a href="{{route('requests.index')}}?approved=whereNull">@lang('menu.requests')</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan

                                @can('manager-menu')
                                    <li><a><i class="fa fa-institution"></i> @lang('menu.management') <span
                                                    class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            @can('index-allocation')
                                                <li>
                                                    <a href="{{route('allocations.index')}}?deleted_at=whereNull">Alocações</a>
                                                </li>
                                            @endcan

                                            @can('index-project')
                                                <li>
                                                    <a href="{{route('projects.index')}}?deleted_at=whereNull">@lang('menu.projects')</a>
                                                </li>
                                            @endcan

                                            @can('index-group')
                                                <li>
                                                    <a href="{{route('groups.index')}}">@lang('menu.groups')</a>
                                                </li>
                                            @endcan

                                            @can('index-client')
                                                <li>
                                                    <a href="{{route('clients.index')}}">@lang('menu.clients')</a>
                                                </li>
                                            @endcan

                                            @can('index-user')
                                                <li>
                                                    <a href="{{route('users.index')}}?deleted_at=whereNull">@lang('menu.users')</a>
                                                </li>
                                            @endcan

                                            @can('index-request')
                                                <li>
                                                    <a href="{{route('requests.index')}}?deleted_at=whereNull">@lang('menu.requests')</a>
                                                </li>
                                            @endcan

                                            @can('index-company')
                                                <li>
                                                    <a href="{{route('companies.index')}}">@lang('menu.companies')</a>
                                                </li>
                                            @endcan

                                            @can('index-group-company')
                                                <li>
                                                    <a href="{{route('groupCompanies.index')}}">@lang('menu.group-companies')</a>
                                                </li>
                                            @endcan

                                            @can('index-plan')
                                                <li>
                                                    <a href="{{route('plans.index')}}">@lang('menu.plans')</a>
                                                </li>
                                            @endcan

                                            @can('index-module')
                                                <li>
                                                    <a href="{{route('modules.index')}}">@lang('menu.modules')</a>
                                                </li>
                                            @endcan

                                            @can('index-bank-slip')
                                                <li>
                                                    <a href="{{route('bankSlips.index')}}">@lang('menu.bankSlips')</a>
                                                </li>
                                            @endcan

                                            <li>
                                                <a href="{{route('providers.index') }}">Fornecedores</a>
                                            </li>

                                            @can('index-project')	    
                                                <li>
                                                    <a href="{{route('revenues.index')}}">Importar Faturamentos</a>	      
                                                </li>                                
                                            @endcan

                                            @can('index-app-version')
                                                <li>
                                                    <a href="{{route('appVersions.index')}}">Versões do Aplicativo</a>
                                                </li>
                                            @endcan
                                                <li>
                                                    <a href='{{route("paymentProvider.index")}}'> Tipos de Pagamento para Fornecedores</a>
                                                </li>
                                                <li>
                                                    <a href='{{route("payment.index")}}'>Tipos de Pagamento para Usuário</a>
                                                </li>
                                        </ul>
                                    </li>
                                @endcan

                                @can('report-menu')
                                    <li><a><i class="fa fa-list-alt"></i> @lang('menu.report') <span
                                                    class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            @can('owners-index-report')
                                                <li>
                                                    <a href="{{route('reports.owners.index')}}">@lang('menu.performance-owners')</a>
                                                </li>
                                            @endcan

                                            @can('users-index-report')
                                                <li>
                                                    <a href="{{route('reports.users.index')}}">@lang('menu.performance-users')</a>
                                                </li>
                                            @endcan

                                            @can('index-budgeted-vs-actual')
                                                <li>
                                                    <a href="{{route('reports.budgetedVsActual.index')}}?months[]={{\Carbon\Carbon::now()->month}}&months[]={{\Carbon\Carbon::now()->subMonth()->month}}&years[]={{\Carbon\Carbon::now()->year}}">@lang('menu.budgetedVsActual')</a>
                                                </li>
                                            @endcan

                                            @can('index-resources-gantt')
                                                <li>
                                                    <a href="{{route('reports.gantt.indexResources')}}">Gráfico Gantt
                                                        Recursos</a>
                                                </li>
                                            @endcan

                                            @can('index-projects-gantt')
                                                <li>
                                                    <a href="{{route('reports.gantt.indexProjects')}}">Gráfico Gantt
                                                        Projetos</a>
                                                </li>
                                            @endcan

                                            @can('index-budgeted-vs-actual')
                                                <li>
                                                    <a href="{{route('reports.differentEndDatesInProjects')}}">
                                                        Projetos com datas de finalização diferente
                                                    </a>
                                                </li>
                                            @endcan
                                               
                                        </ul>
                                    </li>
                                @endcan

                                @can('settings-menu')
                                    <li><a><i class="fa fa-wrench"></i> @lang('menu.settings') <span
                                                    class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            @can('index-role')
                                                <li>
                                                    <a href="{{route('roles.index')}}">@lang('menu.roles')</a>
                                                </li>
                                            @endcan

                                            @can('index-permission')
                                                <li>
                                                    <a href="{{route('permissions.index')}}">@lang('menu.permissions')</a>
                                                </li>
                                            @endcan

                                            @can('index-place')
                                                <li>
                                                    <a href="{{route('places.index')}}">@lang('menu.places')</a>
                                                </li>
                                            @endcan

                                            @can('index-phase')
                                                <li>
                                                    <a href="{{route('phases.index')}}">@lang('menu.phases')</a>
                                                </li>
                                            @endcan

                                            @can('index-task')
                                                <li>
                                                    <a href="{{route('tasks.index')}}">@lang('menu.tasks')</a>
                                                </li>
                                            @endcan

                                            @can('index-subtask')
                                                <li>
                                                    <a href="{{route('subtasks.index')}}">@lang('menu.subtasks')</a>
                                                </li>
                                            @endcan

                                            @can('index-coast-user')
                                                <li>
                                                    <a href="{{route('coastUsers.index')}}">@lang('menu.coast-user')</a>
                                                </li>
                                            @endcan

                                            @can('index-financial-rating')
                                                <li>
                                                    <a href="{{route('financialRatings.index')}}">@lang('menu.financial-ratings')</a>
                                                </li>
                                            @endcan

                                            @can('index-project-type')
                                                <li>
                                                    <a href="{{route('projectTypes.index')}}">@lang('menu.project-types')</a>
                                                </li>
                                            @endcan

                                            @can('index-car-type')
                                                <li>
                                                    <a href="{{route('carTypes.index')}}">@lang('menu.car-types')</a>
                                                </li>
                                            @endcan
                                            
                                            {{--@can('index-transportation-facility')--}}
                                                {{--<li>--}}
                                                    {{--<a href="{{route('transportationFacilities.index')}}">@lang('menu.transportation-facilities')</a>--}}
                                                {{--</li>--}}
                                            {{--@endcan--}}
                                            
                                            @can('index-city')
                                                <li>
                                                    <a href="{{route('cities.index')}}">@lang('menu.cities')</a>
                                                </li>
                                            @endcan

                                            @can('index-state')
                                                <li>
                                                    <a href="{{route('states.index')}}">@lang('menu.states')</a>
                                                </li>
                                            @endcan

                                            @can('index-airport')
                                                <li>
                                                    <a href="{{route('airports.index')}}">@lang('menu.airports')</a>
                                                </li>
                                            @endcan

                                            @can('index-expense-type')
                                                <li>
                                                    <a href="{{route('expenseTypes.index')}}">@lang('menu.expense-types')</a>
                                                </li>
                                            @endcan

                                            @can('index-holiday')
                                                <li>
                                                    <a href="{{route('holidays.index')}}">@lang('menu.holidays')</a>
                                                </li>
                                            @endcan

                                            @can('index-event')
                                                <li>
                                                    <a href="{{route('events.index')}}">@lang('menu.events')</a>
                                                </li>
                                            @endcan

                                            @can('index-audit')
                                                <li>
                                                    <a href="{{route('audits.index')}}">Log</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                    {{-- sidebar footer --}}
                    <div class="sidebar-footer hidden-small">
                        <a href="http://www.docs.delosproject.com/" target="_blank" data-toggle="tooltip"
                           data-placement="top" title="" data-original-title="Ajuda">
                            <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                        </a>
                    </div>
                    {{-- /sidebar footer --}}
                </div>
            </div>
        @endif

        <div class="top_nav" style="{{ Auth::guest() ? 'margin-left: 0' : ''}}">
            <div class="nav_menu hidden-print">
                <nav class="" role="navigation">
                    <div class="nav toggle" style="{{ Auth::guest() ? 'width: 90px' : ''}}">
                        @if(Auth::guest())
                            <li>
                                <a href="{{ route('auth.login') }}" class="bold" style="top: 1px; line-height: 2.5;">
                                    <i class="fa fa-sign-in"></i> Login
                                </a>
                            </li>
                        @endif
                    </div>

                    <div class="nav" style="margin: 0;width: 70px;float: left; position: absolute;top: 15px;">
                        @if(!Auth::guest())
                            <a id="menu_toggle" style="padding: 15px 15px 0;margin: 0;cursor: pointer;"><i
                                        class="fa fa-bars" style="font-size: 26px;"></i></a>
                        @endif
                    </div>

                    <div class="nav" style="width: 180px">
                        @if(Auth::guest())
                            <li><a href="#!" class="bold"><img src="{{asset('images/logo-dark.png')}}"
                                                               style="max-width: 150px;"></a></li>
                        @endif
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            @if (!Auth::guest())
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <div class="user-dropdown">
                                        @if(Auth::user()->avatar)
                                            <img src="{{Auth::user()->avatar}}" alt="">
                                        @else
                                            <i style="font-size: 19px;text-align: center; background: #73879C;color: #fff;padding: 0 6px;width: initial !important;height: initial !important;font-style: normal;">{{substr(Auth::user()->name,0,1)}}</i>
                                        @endif
                                        <span>{{ Auth::user()->name }}</span>
                                    </div>
                                    <span class="caret"></span>
                                    @endif
                                </a>
                                @if (!Auth::guest())

                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li>
                                            <a href="{{route('users.changePassEdit')}}">@lang('menu.change-password')</a>
                                        </li>
                                        <li><a href="#" data-toggle="modal" data-target="#change_avatar">Alterar
                                                Avatar</a>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        @can('login-user')
                                            <li>
                                                <a href="{{route('users.login')}}">@lang('menu.login-as')</a></li>
                                        @endcan
                                        <li>
                                            <a href="{{route('auth.logout')}}">@lang('menu.logout') <i
                                                        class="fa fa-sign-out pull-right"></i></a></li>
                                    </ul>
                        </li>
                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number hidden-xs" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-bell-o"></i>
                                <span class="badge bg-green" style="display: none"><i class="fa fa-asterisk"></i></span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <div class="scroll">
                                    @if(\Auth::user()->notifications()->orderby('id', 'desc')->limit(10)->pluck('data')->count() <= 0)
                                        <li>
                                            <a>
                                                <span class="bold">
                                                    <span>
                                                        Sem notificações
                                                    </span>
                                                </span>
                                                <br>
                                                <span class="message">
                                                    No momento não há notificações para voçê
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @foreach(\Auth::user()->notifications()->orderby('id', 'desc')->limit(10)->pluck('data') as $notification)
                                        <li>
                                            <a>
                                                <span class="bold">
                                                    <span>
                                                        {{$notification[0]['title']}}
                                                    </span>
                                                </span>
                                                <br>
                                                <span class="message">
                                                    {!! $notification[0]['message'] !!}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </div>
                                <li>
                                    <div class="text-center go-to-notification">
                                        <a href="{{route('notifications.index')}}" class="btn btn-block">
                                            <strong>Todas notificações</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        @can('change-companies-user')
                            <li class="hidden-xs hidden-sm">
                                <a href="#!">
                                    <div title="Clique para alterar a empresa" data-toggle="tooltip"
                                         data-placement="left">
                                        <select class="selectpicker change-company" id="change-company" multiple
                                                style="background-color: rgba(255,255,255,.6);">
                                            @foreach(app(\Delos\Dgp\Repositories\Contracts\CompanyRepository::class)->pluck('name', 'id') as $key => $company)
                                                @if(in_array($key, session('companies')))
                                                    <option value="{{$key}}" selected>{{$company}}</option>
                                                @else
                                                    <option value="{{$key}}">{{$company}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </a>

                                <meta name="csrf-token" content="{{ csrf_token() }}">

                                <script>
                                    $(function () {
                                        var count = 0;
                                        $('.change-company').on('hidden.bs.select', function () {

                                            // START - compara jsons e retorna se forem iguais
                                            selectJson  = $('#change-company').val();
                                            sessionJson = {!! collect(session('companies'))->toJson() !!};

                                            if ( jsonsAreEqual(selectJson, sessionJson) ) {
                                                return;
                                            }
                                            // FINISH - compara jsons e retorna se forem iguais


                                            if ( count == 0 ) {
                                                $.ajax({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    type:    "POST",
                                                    url:     "{{route('changeCompanies')}}",
                                                    data:    {
                                                        'companies': $('#change-company').val()
                                                    }
                                                }).done(function () {
                                                    location.reload();
                                                    count = 0;
                                                }).fail(function (result) {
                                                    alert(result.responseJSON.companies[0]);
                                                    $('.change-company').selectpicker('toggle');
                                                    count = 0;
                                                });
                                            }
                                            count++;
                                        });
                                    });
                                </script>
                            </li>
                        @endcan

                        @can('change-group-companies-user')
                            <li class="hidden-xs hidden-sm">
                                <a href="#!">
                                    <div title="Clique para alterar o grupo" data-toggle="tooltip"
                                         data-placement="left">
                                        <select class="selectpicker change-group-companies" id="change-group-companies"
                                                multiple style="background-color: rgba(255,255,255,.6);">
                                            @foreach(app(\Delos\Dgp\Repositories\Contracts\GroupCompanyRepository::class)->pluck('name', 'id') as $key => $GroupCompany)
                                                @if(in_array($key, session('groupCompanies')))
                                                    <option value="{{$key}}" selected>{{$GroupCompany}}</option>
                                                @else
                                                    <option value="{{$key}}">{{$GroupCompany}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </a>

                                <meta name="csrf-token" content="{{ csrf_token() }}">

                                <script>
                                    $(function () {
                                        var count = 0;
                                        $('.change-group-companies').on('hidden.bs.select', function () {

                                            // START - compara jsons e retorna se forem iguais
                                            selectJson  = $('#change-group-companies').val();
                                            sessionJson = {!! collect(session('groupCompanies'))->toJson() !!};

                                            if ( jsonsAreEqual(selectJson, sessionJson) ) {
                                                return;
                                            }
                                            // FINISH - compara jsons e retorna se forem iguais


                                            if ( count == 0 ) {
                                                $.ajax({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    type:    "POST",
                                                    url:     "{{route('changeGroupCompanies')}}",
                                                    data:    {
                                                        'groupCompanies': $('#change-group-companies').val()
                                                    }
                                                }).done(function () {
                                                    location.reload();
                                                    count = 0;
                                                }).fail(function (result) {
                                                    alert(result.responseJSON.companies[0]);
                                                    $('.change-group-companies').selectpicker('toggle');
                                                    count = 0;
                                                });
                                            }
                                            count++;
                                        });
                                    });
                                </script>
                            </li>
                        @endcan
                        @endif
                    </ul>
                </nav>
            </div>
        </div>

        <div class="right_col" role="main" style="{{ Auth::guest() ? 'margin-left: 0' : ''}}">

            <main style="margin-top: 70px;">
                @yield('content')
            </main>

            <div class="row">
                <!-- footer content -->
                <footer>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <span class="pull-right">
                    © {{date('Y')}} - Delos Project Versão: 2.3.0 - Delos Serviços e Sistemas LTDA.
                </span>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>
    </div>
</div>

<button class="material-scrolltop" type="button"></button>

<iframe href="" class="hidden reports"></iframe>
<!-- JavaScripts -->
<script src="{!! elixir('js/all.js')!!}"></script>
<script src="../../vendor/fullcalendar/dist/fullcalendar.min.js"></script>
<script src='../../vendor/fullcalendar/dist/locale/pt-br.js'></script>
<script>
    UPLOADCARE_PUBLIC_KEY = '1c544b865f48e0b782ad';
</script>

@stack('scripts')

@if(env('APP_ENV') == 'production')

    @if(env('NEED_HOTJAR') == 'true')
        <!-- Hotjar Tracking Code for http://delosservicos.com.br -->
        <script>
            (function (h, o, t, j, a, r) {
                h.hj          = h.hj || function () {
                    (h.hj.q = h.hj.q || []).push(arguments)
                };
                h._hjSettings = {
                    hjid: 869987,
                    hjsv: 6
                };
                a             = o.getElementsByTagName('head')[0];
                r             = o.createElement('script');
                r.async       = 1;
                r.src         = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
                a.appendChild(r);
            })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
        </script>
    @endif

    @if(env('NEED_ANALYTICS') == 'true')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83915055-4"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-83915055-4');
        </script>
    @endif
@endif

@if(env('APP_ENV') !== 'production')
    {!! Debugbar::getJavascriptRenderer()->renderHead() !!}
    {!! Debugbar::getJavascriptRenderer()->render() !!}
@endif

<script>
    $('#tasks_modal.modal .modal-body').css({ 'height': $(window).height() - (182 + 57) });
    Cookies.set('user_logged', '{{Auth::id()}}');
    Cookies.set('APP_ENV', '{{env('APP_ENV')}}');
    Cookies.set('has_bank_slip', '{{session('has_bank_slip')}}');

    // compare jsons and return true if it's equal
    function jsonsAreEqual(json1, json2) {
        // converte todos os elementos do array para int
        var selectGroupCompanyId = json1.map(function (elem) {
            return parseInt(elem);
        });

// converte todos os elementos do array para int
        var sessionGroupCompanyId = json2.map(function (elem) {
            return parseInt(elem);
        });

// verifica diferença nos dois arrays
        var diff = _.difference(selectGroupCompanyId, sessionGroupCompanyId);

// verifica diferença entre arrays: diferença e tamanho
        if ( _.isEmpty(diff) && (selectGroupCompanyId.length === sessionGroupCompanyId.length) ) {
            return true;
        }

        return false;
    }
</script>


@include('modals')

</body>
</html>