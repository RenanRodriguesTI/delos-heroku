@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-xs-12 col-sm-8">
                        <h3 class="panel-title bold">Pagamento</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <!-- <span title="@lang('tips.whats-expenses')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span> -->
                    </div>
                </div>

            </div>

            <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a data-toggle='modal' data-target='#payment' class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Adicionar
                    </a>
                </div>
            </div>

            <div class='panel-body'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    @include('payment.search')
                </div>
            </div>

            <div class="panel-body">
                <div class="table-responsive" style="min-height: 390px;">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ativo</th>
                                <th class='col-buttons'>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($payment as $key => $type)
                                    <tr data-edit="{{$type->id}}">
                                        <td>{{$type->name}}</td>
                                        <td>{{$type->ative ? 'Sim' : 'Não'}}</td>
                                        <td class="has-btn-group">

                                        @if ($key <= 3)
                                            <div class="btn-group dropdown">
                                                <button  type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                id="btn-options-users-{{$key}}">
                                                    <span class="glyphicon glyphicon-cog"></span>
                                                        @lang('buttons.options') &nbsp;<span class="caret"></span>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-edit='{{$type->id}}' data-type='{{$type->id}}' href="javascript:void(0);" data-toggle="modal" data-target='#payment'
                                                        id="btn-edit-users-{{$key}}">
                                                        <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>

                                                    <li><a href="{{route('payment.destroy', ['id' => $type->id])}}"
                                                            id="btn-edit-users-{{$key}}">
                                                            <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                                        </a>
                                                    </li>

                                                    <li class="divider"></li>
                                                </ul>
                                            </div>    
                                        </td>
                                        
                                        @else

                                        <div class="btn-group dropup">
                                            <button  type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-users-{{$key}}">
                                                        <span class="glyphicon glyphicon-cog"></span>
                                                        @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                <li><a data-edit='{{$type->id}}' data-type='{{$type->id}}' href="javascript:void(0);" data-toggle="modal" data-target='#payment'
                                                    id="btn-edit-users-{{$key}}">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>

                                                <li><a href="{{route('payment.destroy', ['id' => $type->id])}}"
                                                    id="btn-edit-users-{{$key}}">
                                                    <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
                                                    </a>
                                                </li>

                                                <li class="divider"></li>
                                            </ul>
                                        </div>    
                                    </td>
                                        @endif
                                
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                {!! $payment->render() !!}
                </div>
            </div>

        </div>
    </div>

    @include('payment.form')
@endsection