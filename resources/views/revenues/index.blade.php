@extends('layouts.app')
@section('content')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

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
                <div class="col-md-8">
                    <h3 class="panel-title bold">Faturamentos</h3>
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
            </div>
            </div>

            <div>
                <br>
            </div>     

            <div class="row">   
                <form method="get" action="{{route('revenues.index') }}" class="display-flex-start-bottom">
                    <div class="col-xs-5">
                        <label>Filtro</label>
                        <select id='filter' name="status" class="form-control">
                            <option {{ ($filter =='0')?'selected':'' }} value="0">Todos</option>
                            <option {{ ($filter =='1')?'selected':'' }} value="1">Sucesso</option>
                            <option {{ ($filter =='2')?'selected':'' }} value="2">Erro</option>
                        </select>
                    </div>
                    <div class="col-xs-5">
                        <button type="submit"  class="btn btn-dct">
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
                                        <th>OS</th>
                                        <th>Status</th>
                                        <th>Descrição</th>
                                    </tr>   
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach($proposalvalues as $proposalvalue)
                                    <tr class='{{($proposalvalue->status !="success")?"error":"sucesso" }}'>
                                        <td>{{ $proposalvalue->project_code }}</td>
                                        <td>{{ $proposalvalue->os }}</td>
                                        @if($proposalvalue->status == 'success')
                                        <td class="text-center"><i style="color:#27ae60" class="glyphicon glyphicon-ok"></i></td>
                                        @endif
                                       
                                        @if($proposalvalue->status == 'error')
                                        <td class="text-center"><i style="color:#c0392b" class="glyphicon glyphicon-remove"></i></td>
                                        @endif
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