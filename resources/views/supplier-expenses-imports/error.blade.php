@extends('layouts.app')
@section('content')
<style>
    p {
        margin-bottom: 5px;
    }

    .display-flex-center {
        display: flex;
        -webkit-justify-content: center;
        -webkit-align-items: center;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        flex-wrap: wrap;
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
                <div class="display-flex-center">
                    <h3 class="panel-title bold">Importação de Despesas</h3>
                    <div class="btn-group">
                        <a href="{{route('supplierExpensesImport.index') }}" class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <thead>
                                <tr>
                                    <th>Erro ao importar Despesas</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($fileerrors as $err)
                            <tr class="error">
                                <td>
                                    @foreach ($err as $er)
                                    <p>{{str_replace('files deve ser um arquivo do tipo','O arquivo enviado deve ser uma planilha excel do tipo',$er ) }}</p>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection