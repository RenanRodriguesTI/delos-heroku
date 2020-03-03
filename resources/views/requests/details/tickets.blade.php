<table class="table table-bordered" style="width: 100%;">
    <thead>
    <tr>
        <th colspan="100%" style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Passagem</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @foreach($tickets as $key => $ticket)
            <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">
                <table class="table table-bordered" style="width: 100%;">
                    <thead>
                    <tr>
                        <th colspan="100%" style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">{{$key == 0 ? 'Ida' : 'Volta'}} <span class="label label-warning pull-right bold" style="font-size: small;font-weight: bold;">{{$ticket->preview ? ' - Prévia' : ''}}</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Chegada:</span> {{$ticket->arrival->format('d/m/Y H:i')}}</td>
                    </tr>
                    <tr>
                        <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">De:</span> {{"{$ticket->fromAirport->name} ({$ticket->fromAirport->initials}) - {$ticket->fromAirport->state->name}"}} <span class="bold" style="font-weight: bold;">Até:</span> {{"{$ticket->toAirport->name} ({$ticket->toAirport->initials}) - {$ticket->toAirport->state->name}"}}</td>
                    </tr>
                    @if($ticket->client_pay)
                        <tr>
                            <th colspan="100%">
                                <p class="bold" style="margin-bottom: 0">Pago pelo cliente</p>
                            </th>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </td>
        @endforeach
    </tr>
    </tbody>
</table>