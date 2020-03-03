@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">

                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.clients')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 hidden-xs text-right">
                        <span title="@lang('tips.whats-clients')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>

            </div>
            @include('messages')
            @if($errors->first('clients'))
                <div class="panel-body">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {!! $errors->first('clients') !!}
                    </div>
                </div>
            @endif
            @can('create-client')
                <div class="panel-body">
                    <a href="{{route('clients.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-client')
                    </a>
                </div>
            @endcan
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                @include('search')
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>CPF/CNPJ</th>
                            <th>Nome</th>
                            <th>Nome do Grupo</th>
                            <th>Código do Grupo</th>
                            <th style="min-width: 265px;">@lang('headers.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td class="text-center">{{$client->cod}}</td>
                                <td style="min-width: 151px;">{{$client->document['number']}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->group->name}}</td>
                                <td class="text-center">{{$client->group->cod}}</td>
                                <td class="has-btn-group">
                                    @can('update-client')<a href="{{route('clients.edit', ['id' => $client->id])}}"
                                                            class="btn btn-dct btn-sm"><span
                                                class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        @lang('buttons.edit')
                                    </a>@endcan
                                    @can('destroy-client')<a id="{{route('clients.destroy', ['id' => $client->id])}}"
                                                             class="btn btn-danger btn-sm delete"
                                                             onclick="getModalDelete(this)"><span
                                                class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        @lang('buttons.remove')
                                    </a>@endcan
                                </td>
                                <td class="table-details-title">{{$client->group->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $clients->render() !!}
                </div>
            </div>
        </div>

    </div>
@endsection