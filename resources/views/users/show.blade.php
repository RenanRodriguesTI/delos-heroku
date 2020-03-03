@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Detalhes do projeto: {{$project->full_description}}</h3>
            </div>
            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td class="bold">Nome</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="bold">Email</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="bold">Data de Admissão </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="bold">Perfil </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="bold">Projetos </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="bold">Horas Pendentes </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="bold">Dias Pendentes </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{route('projects.index')}}" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection