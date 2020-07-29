@extends('layouts.app')

@section('content')
<div class='container'>
        <div class='panel panel-dct'>
            <div class='panel-heading'>
                <h2 class='panel-title bold'>Cargos</h2>
                
            </div>

            @include('offices.search')
            <div class='panel-body'>
                <a href="{{url()->previous() == url()->current() ? route('office.index') . '?deleted_at=whereNull' : url()->previous()}}" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </a>

               
                <div class="pull-right">
                    <div class="btn-group">
                    <button type='button' data-toggle='modal' data-target='#office-form' class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Adicionar cargo
                    </button>
                    </div>
                </div>
               
            </div>
         
            <div class='panel-body'>
                <table class='table table-bordered'>
                    <thead>
                        <tr><th>Cargo</th><th>Valor</th><th>Inicio</th><th>Ação</th></tr>
                    </thead>
                    <tbody>
                        @foreach($offices as $key =>$item)
                            <tr class='office-{{$item->id}}'>
                                <td>{{$item->name}}</td>
                                <td> {{ 'R$' . ($item->value_history ? $item->value_history : $item->value)}}</td>
                                <td>{{ ($item->start_history) ? $item->start_history->format('d/m/Y') : $item->start->format('d/m/Y')}}</td>
                                <td  class="has-btn-group">
                                <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-users-{{$key}}">
                                                <span class="glyphicon glyphicon-cog"></span>
                                                @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                <li><a href="{{route('office.edit', ['id' => $item->id])}}">
                                                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp; Histórico
                                                            </a></li>
                                                
                                                <li class="divider"></li>

                                                <li>
                                                    <a class='edit-office' href='javascript:void(0);' data-id='{{$item->id}}' data-action='{{route('office.update',['id' =>$item->id])}}' data-toggle='modal' data-target='#office-update-modal'> 
                                                        <span class="glyphicon glyphicon-edit"></span>&nbsp; Editar
                                                    </a>
                                                </li>

                                                <li class='divider'></li>

                                                <li>
                                                <a id="{{route('office.destroy', ['id' => $item->id])}}"
                                                               class="delete" style="cursor: pointer"
                                                               onclick="getModalDelete(this)">
                                                                <span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')
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
    {!! Form::open(['route'=>['office.store'],'method' =>'post','id'=>'office-add']) !!}
    @include('offices.form')
    {!! Form::close()!!}

    @include('offices.update')
@endsection

@push('scripts')
    <script>
        $('.edit-office').click(function(){
            $('#office-update').attr('action',$(this).attr('data-action'));

            var colunas = $('.office-'+$(this).attr('data-id')+' td');
            console.log($(colunas[0]).html())
            $('#office-update-modal #name').val($(colunas[0]).html());
        });
    </script>
@endpush

