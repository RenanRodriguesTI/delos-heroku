<table class="table table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th colspan="100%" style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Hospedagem</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Check-in:</span> {{$lodging->check_in->format('d/m/Y')}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Checkout:</span> {{$lodging->checkout->format('d/m/Y')}}</td>
        </tr>
        @if($lodging->client_pay)
        <tr>
            <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Estado:</span> {{$lodging->state->name ?? null}}</td>
        </tr>
        @endif
        @if($lodging->city)
        <tr>
            <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Município: </span> {{"{$lodging->city->name} - {$lodging->city->state->name}"}}</td>
        </tr>
        @endif
        <tr>
            <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Tipo de quarto: </span> {{$lodging->hotelRoom->name ?? null}}</td>
        </tr>
        <tr>
            <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Observação: </span> {{$lodging->suggestion}}</td>
        </tr>
        @if($lodging->secondCity !== null)
        <tr>
            <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Segunda opção: </span> {{"{$lodging->secondCity->name} - {$lodging->secondCity->state->name}"}}</td>
        </tr>
        @endif
        @if($lodging->client_pay)
        <tr>
            <th colspan="100%">
                <p class="bold" style="margin-bottom: 0">Pago pelo cliente</p>
            </th>
        </tr>
        @endif
    </tbody>
</table>