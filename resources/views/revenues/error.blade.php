@extends('layouts.app')
@section('content')
    <style>
        p{
            margin-bottom: 5px;
        }
       

        .display-flex-center{
            display: flex;
            -webkit-justify-content:center;
            -webkit-align-items:center;
            justify-content: space-between;
            align-items: center;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .display-flex-start-bottom{
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items:flex-end;
            flex-wrap: wrap;
            width:100%;
            margin-bottom: 20px
        }
    </style>
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="display-flex-center">
                        <h3 class="panel-title bold">Faturamento</h3>
                        <div class="btn-group">
                            <a href="{{route('revenues.index') }}" class="btn btn-default">
                                <span class="glyphicon glyphicon-arrow-left"></span>
                                Voltar
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="display-flex-start-bottom">
                    <div class="col-xs-5">
                        <label>Filtro</label>
                        <select id='filter' class="form-control">
                            <option selected value="0">Todos</option>
                            <option value="1">Sucesso</option>
                            <option value="2">Erro</option>
                        </select>
                    </div>
                    <div class="col-xs-5">
                        <button id="search"  class="btn btn-dct">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            Pesquisar 
                        </button>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-details">
                            <thead>
                                <thead>
                                    @if(isset($log) &&!$log->isEmpty())
                                        <tr>
                                            <th>Projeto</th>
                                            <th>OS</th>
                                            <th>Status</th>
                                            <th>Descrição</th>
                                        </tr>   
                                    @endif


                                    @if(isset($fileerrors) &&!$fileerrors->isEmpty())
                                        <tr>
                                            <th>Descrição</th>
                                        </tr>   
                                    @endif

                        
                                    
                                </thead>

                            <tbody>
                              @if(isset($log) &&!$log->isEmpty())
                                @foreach ($log as $item )
                                    <tr class='{{isset($item["erros"])?"error":"sucesso" }}'>
                                        <td>{{$item['codigo_projeto'] }}</td>
                                        @if(isset($item['erros']))
                                            
                                            <td>{{ $item['numero_os'] }}</td>
                                            <td class="text-center"><i style="color:#c0392b" class="glyphicon glyphicon-remove"></i></td>
                                            <td>
                                                @foreach ($item['erros'] as $er )
                                                    <p>{{ $er }}</p>
                                                @endforeach
                                            </td>
                                        @endif

                                        @if(isset($item['success']))
                                            <td>{{ $item['numero_os'] }}</td>
                                            <td class="text-center"><i style="color:#27ae60" class="glyphicon glyphicon-ok"></i></td>

                                            
                                            <td>
                                                <p>Importado com successo.</p>
                                            </td>
                                        @endif
                                       
                                    </tr>
                                @endforeach
                              @endif


                              @if(isset($fileerrors) && !$fileerrors->isEmpty())
                                @foreach ($fileerrors as $err )
                                    <tr class="error">
                                        <td>
                                            @foreach ($err as $er )
                                                <p>{{str_replace('file deve ser um arquivo do tipo','O arquivo enviado deve ser uma planilha excel do tipo',$er ) }}</p>
                                            @endforeach
                                        </td>
                                    </tr> 
                                @endforeach
                              @endif
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