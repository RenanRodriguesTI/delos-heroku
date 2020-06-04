<div class="row">
    <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12 {{$errors->has('issue_date') ? 'has-error' : ''}}">
        {!! Form::label('issue_date_calendar', 'Data de emissão:') !!}

        {!! Form::text('issue_date_calendar', '', [
            'class' => 'form-control issue_date_calendar',
            'required',
            'readonly'
            ]) !!}

        {!! Form::hidden('issue_date', isset($expense) ? $expense->issue_date->format('d/m/Y') : date('d/m/Y'), ['id' => 'issue_date']) !!}

        <span class="help-block"><strong>{{$errors->first('issue_date')}}</strong></span>
    </div>

    <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12 {{$errors->has('requestable_id') ? 'has-error' : ''}}">
        {!! Form::label('requestable_id', 'Número') !!}

        {!! Form::select('requestable_id', ['' => 'Selecione uma opção','Projetos' => []], $expense->project_id ?? null, [
                                                        'class' => 'form-control selectpicker',
                                                        'data-live-search' => 'true',
                                                        'data-actions-box' => 'true',
                                                        'required'
                                                    ]) !!}

        <input type="hidden" id="_old_input_requestable_id" value="{{session('_old_input')['requestable_id']}}">

        @if(isset($expense))
            {!! Form::hidden('request_selected_when_edit', $expense->project->id . ' - project', ['id' => 'request_selected']) !!}
        @endif

        <span class="help-block"><strong>{{$errors->first('requestable_id')}}</strong></span>

    </div>

    <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                {!!
                    Form::label('all', 'Todos:')
                 !!}

                 <input type="checkbox" id='all' data-toggle="toggle" data-on="Sim" data-off="Não">
        </div>

    <div class="form-group col-xs-6 provider {{$errors->has('provider_id') ? 'has-error' : ''}}">
        {!! Form::label('provider_id', 'Fornecedor:') !!}
     

        {{--  <select name="provider_id" id="provider_id" class="form-control" required>
            <option value="">Selecione um fornecedor</option>
            @foreach($providers ?? [] as $id => $value)
                <option value="{{$id}}" {{isset($expense) && $id ==  ? 'selected' : ''}}>{{$value}}</option>
            @endforeach
        </select>  --}}

        {!! Form::select('provider_id', $providers,$expense->provider_id ?? null, ['class' => 'form-control', 'placeholder' => 'Selecione um fornecedor','required']) !!}

        <span class="help-block"><strong>{{$errors->first('provider_id')}}</strong></span>
    </div>

    <div class="form-group col-xs-6 {{$errors->has('voucher_type_id') ? 'has-error' : ''}}">
        {!! Form::label('voucher_type_id', 'Tipo de Comprovante:') !!}

        {!! Form::select('voucher_type_id', $vouchers,$expense->voucherType->id ?? null, ['class' => 'form-control', 'placeholder' => 'Selecione um tipo de comprovante','required']) !!}

        <span class="help-block"><strong>{{$errors->first('voucher_type_id')}}</strong></span>

    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12 {{$errors->has('invoice_file') ? 'has-error' : ''}}">
                {!! Form::label('invoice-file', 'Arquivo:') !!}
                <span title="@lang('tips.expense-file-field')" class="glyphicon glyphicon-question-sign black-tooltip"
                      aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
                <div class="input-group">
                    <input id="invoice-file" type="text" class="form-control name_invoice"
                           value="{{$expense->original_name ?? null}}" readonly style="margin-top: 3px;"
                          >
                    <span class="input-group-btn">
                        <span class="btn btn-dct btn-file"><i
                                    class="glyphicon glyphicon-cloud-upload"></i> Selecionar <input type="file"
                                                                                                    name='invoice_file' {{ isset($expense) && $expense ? "" : "required='required'" }}></span>
                    </span>
                </div>

                @if(isset($expense))
                    <a href="{{$expense->url_file}}" target="_blank">Visualizar comprovante</a>
                @endif

                <span class="help-block text-danger"><strong>{{$errors->first('invoice_file')}}</strong></span>
            </div>

            <div class="form-group col-lg-3 col-md-12 col-lg-12 col-md-122 col-xs-12 {{$errors->has('value') ? 'has-error' : ''}}">
                {!! Form::label('value', 'Valor:') !!}
                <div class="input-group">
                    <div class="input-group-addon">R$</div>

                    {!! Form::text('value', $expense->value ?? null, [
                        'class' => 'form-control',
                        'required'
                        ]) !!}
                </div>
                <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
            </div>

            <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12 {{$errors->has('payment_type_provider_id') ? 'has-error' : ''}}">
                {!! Form::label('payment_type_provider_id', 'Tipo de Pagamento:') !!}

                {!! Form::select('payment_type_provider_id', $paymentTypes, $expense->paymentTypeProvider->id ?? null, ['class' => 'form-control', 'placeholder' => 'Selecione um tipo de pagamento','required']) !!}

                <span class="help-block"><strong>{{$errors->first('payment_type_provider_id')}}</strong></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">

        @if(!isset($expense) || !$expense->import)
        <div class="form-group col-xs-6 {{$errors->has('description_id') ? 'has-error' : ''}}">
                {!! Form::label('description_id', 'Descrição:') !!}
        
                {!! Form::select('description_id', $descriptions,$expense->description_id ?? null, ['class' => 'form-control', 'placeholder' => 'Selecione uma descrição','required']) !!}
        
                <span class="help-block"><strong>{{$errors->first('description_id')}}</strong></span>
        
            </div>
        @endif

          

            

            <div class="form-group col-xs-6 {{$errors->has('establishment_id') ? 'has-error' : ''}}">
                {!! Form::label('establishment_id', 'Estabelecimento:') !!}
        
                {!! Form::select('establishment_id', $establishment,$expense->establishment_id ?? null, ['class' => 'form-control', 'placeholder' => 'Selecione um estabelecimento','required']) !!}
        
                <span class="help-block"><strong>{{$errors->first('establishment_id')}}</strong></span>
        
            </div>

            
        </div>

        @if ( isset($expense) && $expense->import == true)
           <div class='col-xs-12'>
           <div class="form-group col-xs-12 {{$errors->has('description_id') ? 'has-error' : ''}}">
                {!! Form::label('description_id', 'Descrição:') !!}
        
                {!! Form::text('description_id', $expense->description_id ?? null, ['class' => 'form-control', 'maxlength' => '255', 'style' => 'min-height: 87px;']) !!}        
                <span class="help-block"><strong>{{$errors->first('description_id')}}</strong></span>
        
            </div>
           </div>
            @endif


        

        <div class="col-xs-12">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$errors->has('note') ? 'has-error' : ''}}">
                {!! Form::label('note', 'Observação:') !!}
                {!! Form::text('note', $expense->note ?? null, ['class' => 'form-control', 'maxlength' => '255', 'style' => 'min-height: 87px;']) !!}
                <span class="pull-right label label-default count_message note"></span>

                <span class="help-block"><strong>{{$errors->first('note')}}</strong></span>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $("#requestable_id").change(function() {
            var requestId = $(this).val();
    
            $.ajax({
                url: "/supplier-expenses/providers/" + requestId,
                success: function(result) {
    
                    var select = $("#user_id");
                    select.find('option').remove();
                    select.append('<option value="">Selecione um colaborador</option>');
    
                    $.each(result.providers, function(key, value) {
                        if (countObject(result) == 1) {
                            select.append('<option value=' + key + ' selected>' + value + '</option>');
                        } else {
                            select.append('<option value=' + key + '>' + value + '</option>');
                        }
    
                    });
                    select.selectpicker('destroy');
                    select.selectpicker();
                }
            });
        });

    </script>

@endpush