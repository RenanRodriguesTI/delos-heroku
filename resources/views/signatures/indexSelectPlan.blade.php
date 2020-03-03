@extends('layouts.app')
@section('content')
    @include('messages')
    <div class="container pricing-top">
        <div class="panel-heading">
            <h3 class="panel-title bold">Planos</h3>
        </div>

        <div class="row">
            <section id="pricing">
                <div class="panel-body" style="padding: 0 24px;">
                    <div class="col-md-12">
                        <div class="alert alert-success text-center">
                            <p class="bold lead">Todos os planos são cobrados por usuários.</p>
                        </div>
                    </div>

                    @foreach($plans as $plan)
                        <div class="col-md-4 col-xs-12 col-lg-4" style="padding: 10px">

                            <div class="pricing ui-ribbon-container">
                                @if($actualPlan->id == $plan->id && \Auth::user()->groupCompany->plan_status)
                                    <div class="ui-ribbon-wrapper">
                                        <div class="ui-ribbon">
                                            Plano Atual
                                        </div>
                                    </div>
                                @endif

                                <div class="title">
                                    <h2>{{$plan->name}}</h2>
                                    <h1>R$ {{number_format($plan->value, '2', ',', '.')}}/usuário</h1>
                                    <span>{{trans("plans.period.{$plan->periodicity}")}}</span>
                                </div>

                                <div class="x_content">
                                    <div class="pricing_features">
                                        <ul class="list-unstyled text-left list-group">
                                            @foreach($modules as $module)
                                                <li class="list-group-item">
                                                    @if($plan->modules()->pluck('name', 'name')->has($module->name))
                                                        <i class="fa fa-check text-success"></i>
                                                    @else
                                                        <i class="fa fa-times text-danger"></i>
                                                    @endif

                                                    {{$module->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="pricing_footer">
                                        <a href="{{$actualPlan->id == $plan->id && \Auth::user()->groupCompany->plan_status ? 'javascript:;' : route('planSelected', $plan->id)}}"
                                           class="btn btn-success btn-block col-md-12"
                                           role="button" {{$actualPlan->id == $plan->id && \Auth::user()->groupCompany->plan_status ? "disabled='disabled" : ''}}>
                                            Assinar esse plano
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="panel-heading">
            <h3 class="panel-title bold">O sistema</h3>
        </div>

        <br>

        <div class="panel-body padding-container" style="padding: 0 24px;">
            <div class="col-md-5 description-container">
                <p class="system-description">
                    Nossa ferramenta entrega soluções completas para controle de projeto. <br>
                    O <b>Delos Project</b> ajuda você e sua empresa a cumprir metas, identificar prejuízos e os pontos
                    problemáticos de um projeto e/ou serviço, reduzindo custos e melhorando a qualidade dos serviços
                    prestados.
                </p>
            </div>

            <div class="col-md-7 macbook-container">
                <img src="/images/macbook-pro.png" alt="responsive devices" class="img-responsive">
            </div>
        </div>

        <div class="panel-body padding-container" style="padding: 0 24px;">
            <div class="col-md-5 devices-container hidden-sm hidden-xs">
                <img src="/images/ipad.png" alt="responsive devices" class="img-responsive">
            </div>
            <div class="col-md-7 list-features-container">
                <h5 class="bold">Suporte total para administrar prazos e custos pré-definidos, conforme recursos humanos
                    e econômicos.</h5>
                <ul class="list-features list-unstyled">
                    <li>
                        <p>Análise: Orçado x Real</p>
                    </li>
                    <li>
                        <p>Controle de recursos</p>
                    </li>
                    <li>
                        <p>Gerenciamento de despesas</p>
                    </li>
                    <li>
                        <p>Controle de horas</p>
                    </li>
                    <li>
                        <p>Emissão de relatórios</p>
                    </li>
                    <li>
                        <p>Cadastre um projeto e atribua funções específicas para os envolvidos (ex. líder,
                            co-líder).</p>
                    </li>
                    <li>
                        <p>
                            Gerenciamentos de recursos para o projeto (tais como: passagem, hospedagem, locação etc)
                        </p>
                    </li>
                    <li>
                        <p>Controle de Notas de Débito</p>
                    </li>
                </ul>
            </div>

            <div class="col-md-5 devices-container hidden-md hidden-lg">
                <img src="/images/ipad.png" alt="responsive devices" class="img-responsive">
            </div>
        </div>
    </div>
@endsection