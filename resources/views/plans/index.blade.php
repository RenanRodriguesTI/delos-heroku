@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Planos</h3>
            </div>
            @include('messages')

            <div class="panel-body">
                <div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-left:10px;">
                            <a href="{{route('plans.create')}}" class="btn btn-dct"><span
                                        class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                Adicionar Plano
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="">
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel" style="height:600px;">
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="row">
                                                @foreach($plans as $plan)
                                                    <div class="col-md-4 col-sm-6 col-xs-12" style="padding: 10px">
                                                        <div class="pricing ui-ribbon-container">
                                                            <div class="title">
                                                                <h2>{{$plan->name}}</h2>
                                                                <h1>R$ {{number_format($plan->value, '2', ',', '.')}}</h1>
                                                                <span>{{trans("plans.period.{$plan->periodicity}")}}</span>
                                                            </div>
                                                            <div class="x_content">
                                                                <div class="">
                                                                    <div class="pricing_features">
                                                                        <ul class="list-unstyled text-left">
                                                                            @foreach($plan->modules()->orderBy('name', 'asc')->get() as $module)
                                                                                <li>
                                                                                    <i class="fa fa-check text-success"></i> {{$module->name}}
                                                                                </li>
                                                                            @endforeach
                                                                            @foreach(app(\Delos\Dgp\Repositories\Contracts\ModuleRepository::class)->makeModel()->whereNotIn('id', $plan->modules()->pluck('id'))->orderBy('name', 'asc')->get() as $moduleUnselected)
                                                                                <li>
                                                                                    <i class="fa fa-times text-danger"></i> {{$moduleUnselected->name}}
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="pricing_footer">
                                                                    <a href="{{route('plans.edit', $plan->id)}}"
                                                                       class="btn btn-dct col-md-6" role="button">
                                                                        <span class="glyphicon glyphicon-edit left"
                                                                              aria-hidden="true"></span> Editar
                                                                    </a>
                                                                    <a href="{{route('plans.modules', ['id' => $plan->id])}}"
                                                                       class="btn btn-default col-md-6" role="button">
                                                                        <span class="glyphicon glyphicon-list left"
                                                                              aria-hidden="true"></span> Modulos
                                                                    </a>
                                                                    <a class="btn btn-danger col-md-6 delete"
                                                                       id="{{route('plans.delete', ['id' => $plan->id])}}"
                                                                       role="button">
                                                                        <span class="glyphicon glyphicon-trash"
                                                                              aria-hidden="true"></span> Excluir
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection