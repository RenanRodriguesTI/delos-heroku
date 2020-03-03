<style>
    .panel {
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .panel-dct {
        border-color: #dddee0;
    }
    .panel-title {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 24px;
        color: inherit;
    }
    .panel-heading {
        padding: 16px 24px;
        border-bottom: 1px solid transparent;
        border-radius: 3px 3px 0 0;
        border-bottom: 2px solid #66BB6A;
    }
    .panel-body {
        padding: 16px 24px;
    }
    .panel-footer {
        padding: 16px 8px;
        background-color: #f2f3f3;
        border-color: #eaebec;
        border-radius: 0 0 3px 3px;
    }
    .bold{
        font-weight: bold;
    }
    .dct-color {
        color: #1b5e20;
    }
    .table{
        width: 100%;
    }
    .table-bordered>thead>tr>th {
        border: 1px solid #ddd;
    }
    .table-bordered>tbody>tr>td {
        border: 1px solid #ddd;
    }
    .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border-bottom-width: 2px;
        border-bottom-color: #66BB6A;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 13px;
    }
    .table>tbody>tr>td{
        padding: 8px;
        vertical-align: middle;
    }
    .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
</style>


<div class="panel panel-dct" style="margin-bottom: 20px;background-color: #fff;border: 1px solid transparent;border-radius: 4px;-webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);box-shadow: 0 1px 1px rgba(0,0,0,.05);border-color: #dddee0;">
    <div class="panel-heading" style="padding: 16px 24px;border-bottom: 2px solid #66BB6A;border-radius: 3px 3px 0 0;">
        <h3 class="panel-title dct-color" style="margin-top: 0;margin-bottom: 0;font-size: 24px;color: #1b5e20;">Redefinição de senha</h3>
    </div>
    <div class="panel-body" style="padding: 16px 24px;">

        <p>Olá, <span class="bold" style="font-weight: bold;">{{$user->name}}<span>.</p>
        <p>Recebemos uma solicitação de redefinição de senha para sua conta do Delos Project. Para redefinição da sua senha, segue o link abaixo:</p>

        <p><span class="bold" style="font-weight: bold;">Redefinir senha usando um navegador da web:</span><br>
            <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">Clique aqui para redefinir sua senha</a>
        </p>
        <br>

        <p class="bold" style="font-weight: bold;">Equipe Delos Serviços e Sistemas</p>

    </div>
    <div class="panel-footer" style="padding: 16px 8px;background-color: #f2f3f3;border-color: #eaebec;border-radius: 0 0 3px 3px;">

        <p class="bold" style="font-weight: bold;"></p>
    </div>
</div>