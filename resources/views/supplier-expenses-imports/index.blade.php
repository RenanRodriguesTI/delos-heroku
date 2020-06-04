@extends('layouts.app')
@section('content')
<style>
    form {
        display: flex;
        justify-content: space-between;
        padding: 05px 0px 0px 0px;
        align-items: center;
        -webkit-justify-content: flex-end;
        -webkit-align-items: center;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .circle {
        border: 1px solid black;
    }

    .display-flex-start-bottom {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: flex-end;
        flex-wrap: wrap;
        width: 100%;
        margin-bottom: 20px
    }
</style>

<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title bold">Importação de Despesas</h3>
                    <p style="font-size: 16px;">Ultima importação feita em: {{( $date)? $date: 'não há importação' }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form name="form-import" id="form-import" action="{{ route('supplierExpensesImport.store') }}" method="POST" enctype='multipart/form-data'>
                        @csrf
                        <input name="files" type="file" id='file' value="" style="display:none" />
                        <button class="btn btn-dct" type="button" id="btn-import">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            Importar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @include('messages')
        <div class="panel-body">
            <div class="row">
                <form method="get" action="{{route('supplierExpensesImport.index') }}" class="display-flex-start-bottom">
                    <div class="col-xs-5">
                        <label>Filtro</label>
                        <select id='filter' name="status" class="form-control">
                            <option {{ ($filter =='0')?'selected':'' }} value="0">Todos</option>
                            <option {{ ($filter =='1')?'selected':'' }} value="1">Sucesso</option>
                            <option {{ ($filter =='2')?'selected':'' }} value="2">Erro</option>
                        </select>
                    </div>
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-dct">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            Pesquisar
                        </button>
                    </div>
                </form>
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-details">
                            <thead>
                                <tr>
                                <tr>
                                    <th>Projeto</th>
                                    <th>Data de emissão</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Descrição</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proposalvalues as $proposalvalue)
                                <tr class='{{($proposalvalue->status !="success")?"error":"sucesso" }}'>
                                    <td>{{ $proposalvalue->project_code }}</td>
                                    <td>{{ $proposalvalue->issue_date ? $proposalvalue->issue_date->format('d/m/Y') : '' }}</td>
                                    <td>R$ {{ $proposalvalue->value }}</td>
                                    <td class="text-center">
                                        @if($proposalvalue->status == 'success')
                                        <i style="color:#27ae60" class="glyphicon glyphicon-ok"></i>
                                        @endif
                                        @if($proposalvalue->status == 'error')
                                        <i style="color:#c0392b" class="glyphicon glyphicon-remove"></i>
                                        @endif
                                    </td>
                                    <td>{{ $proposalvalue->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <div class="text-right">
                {{ $proposalvalues->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection