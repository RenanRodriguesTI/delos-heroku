@extends('layouts.app')
@section('content')

    <a href="{{route('reports.differentEndDatesInProjects', ['format' => 'xlsx'])}}" class="btn btn-dct">
        Extrair em Excel
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Líder</th>
                <th>Início</th>
                <th>Finalização Prevista</th>
                <th>Finalização real</th>
                <th>Diff (dias)</th>
            </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{$project['cod']}}</td>
                <td>{{$project['description']}}</td>
                <td>{{$project['owner']}}</td>
                <td>{{$project['start']}}</td>
                <td>{{$project['finish']}}</td>
                <td>{{$project['deleted_at']}}</td>
                <td>{{$project['diff']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection