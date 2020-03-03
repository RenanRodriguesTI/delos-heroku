@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="panel-title bold">Relatório desempenho dos colaboradores</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <span title="@lang('tips.whats-users-performance')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                @include('reports.search', ['route' => 'reports.users.index'])
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Qtde de Projetos</th>
                                <th>Projetos dentro do previsto</th>
                                <th>Projetos fora do previsto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td class="text-center">{{ number_format($user['total_projects'], 0, ',', '.') }}</td>
                                    <td class="text-center">{{ number_format($user['total_right_projects'], 0, ',', '.') }}</td>
                                    <td class="text-center">{{ number_format($user['total_wrong_projects'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection