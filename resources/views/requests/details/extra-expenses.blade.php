<table class="table table-bordered" style="width: 100%;">
    <thead>
    <tr>
        <th colspan="100%" style="border: 1px solid #ddd;border-bottom-width: 2px;border-bottom-color: #66BB6A;padding: 13px;">Adiantamento</th>
    </tr>
    </thead>
    <tbody>

    @foreach($extraExpenses as $extraExpense)
        <tr>
            <td style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">{{$extraExpense->description}}:</span></td>
            <td colspan="100%" style="border: 1px solid #ddd;padding: 8px;vertical-align: middle;"><span class="bold" style="font-weight: bold;">Valor:</span> {{$extraExpense->value}}</td>
        </tr>
    @endforeach
    <tr>
        <td><span class="bold">&nbsp;</span></td>
        <td colspan="100%"><span class="bold dct-color">Total:</span>
            {{$extraExpenses->sum('value')}}
        </td>
    </tr>
    </tbody>
</table>