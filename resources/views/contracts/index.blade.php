@extends('layouts.app')
@section('content')
<style>

    form{
        display: flex;
        justify-content: space-between;
        padding: 05px 0px 0px 0px;
        align-items: center;
        -webkit-justify-content:flex-end;
        -webkit-align-items:center;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .circle{
        border:1px solid black;
    }
</style>
<div class="container">
    <div class="panel panel-dct">
        <div class="panel-heading">

            <div class="row">
                <div class="col-md-8">
                    <h3 class="panel-title bold">Contratos</h3>
                </div>
                <div class="col-md-4 text-right">
                    <span title="Importe seus faturamentos" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                </div>
            </div>
        
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form name="form-import" id="form-import" action="import/upload" method="POST" enctype='multipart/form-data'>

                        @csrf
                        <input name="files" type="file" id='file' value="" style="display:none"/>
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
            <div class="pull-right" style="display:none">
                <div class="btn-group">
                    @can('proposal-values-create-project')
                        <a href="{{route('projects.descriptionValues.create', ['id' => 0])}}" class="btn btn-dct">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            Importar 
                        </a>
                    @endcan
                    
                    @can('proposal-values-description-report-project')
                        <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('projects.descriptionValues.report', ['id' => 0])}}" class="report-xlsx"><span class="glyphicon glyphicon-cloud-download"></span>
                                    @lang('buttons.export-excel')
                                </a>
                            </li>
                        </ul>
                    @endcan
            </div>
            </div>

            <div>
                <br>
            </div>     

            <div class="row">   
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-details">
                            <thead>
                                <tr>
                                    <th>Prestador</th>
                                    <th> Data de inicio </th>
                                    <th> Data de finalização</th>
                                    <th> Valor </th>
                                </tr>   
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="panel-footer">
            <div class="text-right">
            </div>

        </div>
    </div>
</div>
@endsection