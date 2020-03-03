@extends('layouts.app')
    @section('content')
        <h1 class="panel-title bold text-center">Erro ao excluir recurso do sistema</h1>
        <p class="text-center bold" style="margin-top: 40px;">O recurso que você está tentando remover está sendo usado por outros recursos</p>

        <a class="btn btn-primary text-center" style="margin-top: 40px;" href="{{$url}}">Clique aqui para voltar</a>
    @endsection
