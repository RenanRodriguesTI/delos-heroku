@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-gl-12 col-md-12 col-sm-12 col-xs-12">
                        <h3 class="panel-title bold">Versões do Aplicativo</h3>
                    </div>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a href="javascript:void(0);" data-toggle='modal' data-target='#create-app-version' class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Adicionar
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('app-versions.search')
            </div>

            <div class="panel-body">
               
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id='table-contracts' class="table table-bordered table-hover table-details">
                            <thead>
                                <th>Versão</th>
                                <th>Importante</th>
                            </thead>
                            <tbody>
                                 @foreach ($appVersions as $appVersion)
                                    <tr>
                                        <td>{{$appVersion->version}}</td>
                                        <td>{{$appVersion->important ? 'Sim':'Não'}}</td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
            <div class="panel-footer">
            <div class="text-right">
             {{ $appVersions->appends(request()->input())->links() }}
            </div>
            </div>
        </div>

        
    </div>

    @include('app-versions.create');
@endsection

