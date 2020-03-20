@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-gl-12 col-md-12 col-sm-12 col-xs-12">
                        <h3 class="panel-title bold">Fornecedores</h3>
                    </div>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a href="{{ route('providers.create') }}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Adicionar
                    </a>
                </div>
            </div>

            <div class="panel-body">
                @include('providers.search')
            </div>

            <div class="panel-body">
               
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table id='table-contracts' class="table table-bordered table-hover table-details">
                            <thead>
                                <th>Fornecedor</th>
                                <th>CNPJ</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Observação</th>
                                <th>Ação</th>
                            </thead>
                            <tbody>
                                @foreach ($providers as $provider)
                                    <tr>
                                        <td>{{ $provider->social_reason }}</td>
                                        <td>{{ $provider->cnpj }}</td>
                                        <td>{{ $provider->telephone }}</td>
                                        <td>{{ $provider->email }}</td>
                                        <td>{{ $provider->note}}</td>
                                        <td class="has-btn-group">
                                            <div class="btn-group dropdown">
                                                <button  type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="glyphicon glyphicon-cog"></span>
                                                @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>
            
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('providers.edit',['id' =>$provider->id])}}">
                                                     <span class="glyphicon glyphicon-edit"></span>&nbsp; @lang('buttons.edit')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('providers.destroy', ['id' => $provider->id])}}">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                        &nbsp; @lang('buttons.remove')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                            </div>    
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
            <div class="panel-footer">
    
            </div>
        </div>

        
    </div>
@endsection

