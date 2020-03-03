<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .padd01 {
            padding: 15px 0px 15px 0px;
        }

        table {
            width: 100%;
        }

        table thead tr td {
            border: 1px solid black;
            text-align: center;
        }

        table tbody tr td.line {
            border-bottom: 1px solid black;
        }

        .padd02 {
            padding: 0px 0px 125px 0px;
        }

        .obs01 {
            width: 100%;
            text-align: center;
        }

        .font12 {
            font-size: 12px;
        }

    </style>
</head>
<body>

<div class="padd01">Emissão: {{\Carbon\Carbon::now()->format('d/m/Y h:i') ?? null}}</div>

<table>
    <thead>
    <tr>
        <td><strong>Projeto</strong></td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="line">Código: {{$activity->project->full_description ?? null}}</td>
    </tr>
    <tr>
        <td class="line">Lider: {{$activity->project->owner->name ?? null}}</td>
    </tr>
    </tbody>
</table>
<br>
<table>
    <thead>
    <tr>
        <td><strong>Cliente(s)</strong></td>
    </tr>
    </thead>
    <tbody>
    @foreach($activity->project->clients as $client)
        <tr>
            <td class="line">Razão Social: {{$client->name ?? null}}</td>
        </tr>
        <tr>
            <td class="line">CNPJ/CPF: {{$client->document['number'] ?? null}}</td>
        </tr>
        <tr>
            <td class="line">Endereço: {{$client->address["street"] ?? null}}, {{$client->address["number"] ?? null}}</td>
        </tr>
        <tr>
            <td class="line">Telefone: {{$client->telephone ?? null}}</td>
        </tr>
        <tr>
            <td class="line">Responsável: {{$activity->project->client->name ?? null}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br>
<table>
    <thead>
    <tr>
        <td><strong>Detalhes da Atividade</strong></td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="line">Colaborador: {{$activity->user->name ?? null}}</td>
    </tr>
    <tr>
        <td class="line">Data do trabalho: {{$activity->date->format('d/m/Y') ?? null}}</td>
    </tr>
    <tr>
        <td class="line">Horas trabalhadas: {{$activity->hours ?? null}}</td>
    </tr>
    <tr>
        <td class="line">Tarefa executada: {{$activity->task->name ?? null}}</td>
    </tr>
    <tr>
        <td class="line">Local de Trabalho: {{$activity->place->name ?? null}}</td>
    </tr>

    <tr>
        <td class="line padd02">Observação Adicional:</td>
    </tr>
    </tbody>
</table>
<br>
<div class="obs01 font12">
    * Esta nota foi aporvada por <i>{{$activity->approver->name ?? null}}</i> na data: <i>{{$activity->updated_at->format('d/m/Y h:i:s') ?? null}}</i> no sistema <strong>Delos
        Project</strong>
</div>


</body>
</html>