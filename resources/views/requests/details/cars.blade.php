<table class="table table-bordered" style="width: 100%;">
    <thead>
    <tr>
        <th colspan="100%"
            style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Carros
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Tipo de carro a ser usado:</span> {{$car->carType->name}}
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">

            <table class="table table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <th colspan="100%"
                        style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">
                        Retirada
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold"
                                                                                                  style="font-weight: bold;">Data:</span> {{$car->withdrawal_date->format('d/m/Y H:i')}}
                    </td>
                </tr>
                @if($car->carType->name === 'Locado')
                    <tr>
                        <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span
                                    class="bold" style="font-weight: bold;">Local:</span> {{$car->withdrawal_place}}
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </td>
        <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;">

            <table class="table table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <th colspan="100%"
                        style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">
                        Devolução
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold"
                                                                                                  style="font-weight: bold;">Data:</span> {{$car->return_date->format('d/m/Y H:i')}}
                    </td>
                </tr>
                @if($car->carType->name === 'Locado')
                    <tr>
                        <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span
                                    class="bold" style="font-weight: bold;">Local:</span> {{$car->return_place}}</td>
                    </tr>
                @endif
                </tbody>
            </table>

        </td>
    </tr>
    <tr>
        <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold"
                                                                                                     style="font-weight: bold;">Primeiro condutor:</span> {{$car->firstDriver->name}}
        </td>
    </tr>
    @if($car->secondDriver !== null)
        <tr>
            <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold"
                                                                                                         style="font-weight: bold;">Segundo condutor:</span> {{$car->secondDriver->name}}
            </td>
        </tr>
    @endif
    @if($car->client_pay)
        <tr>
            <th colspan="100%">
                <p class="bold" style="margin-bottom: 0">Pago pelo cliente</p>
            </th>
        </tr>
    @endif
    </tbody>
</table>