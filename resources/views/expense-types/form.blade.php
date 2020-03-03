<div class="row">
    <div class="form-group col-md-6 {{$errors->has('cod') ? 'has-error' : ''}}">
        {!! Form::label('cod', 'Código:') !!}
        {!! Form::text('cod', $expenseType->cod ?? null, [
            'class' => 'form-control',
            'required'
            ]) !!}
        <span class="help-block"><strong>{{$errors->first('cod')}}</strong></span>
    </div>

    <div class="form-group col-md-6">
        <label for="payment_type_id">Tipo de pagamento:</label>

        <select name="payment_type_id[]" id="payment_type_id" class="form-control selectpicker" required="required" multiple title="Selecione um tipo de pagamento">
            @foreach($paymentTypes as $keyPayment => $paymentType)

                @if(isset($expenseType) && $expenseType->paymentTypes->pluck('id', 'name')->search($keyPayment))
                    @foreach($expenseType->paymentTypes->pluck('name', 'id') as $key => $currentPayment)
                        @if($key == $keyPayment)
                            <option value="{!! $keyPayment !!}" selected>@lang('entries.' . $paymentType)</option>
                        @endif
                    @endforeach

                    @continue
                @endif

                <option value="{!! $keyPayment !!}">@lang('entries.' . $paymentType)</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::textarea('description', $expenseType->description ?? null, ['class' => 'form-control', 'required', 'rows' => '3']) !!}
    <span class="help-block"><strong>{{$errors->first('description')}}</strong></span>
</div>
