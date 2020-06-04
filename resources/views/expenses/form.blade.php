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

    <div class="form-group col-lg-11 col-md-10 col-sm-10 col-xs-12 {{$errors->has('requestable_id') ? 'has-error' : ''}}">
        {!! Form::label('requestable_id', 'Número') !!}

        {!! Form::select('requestable_id', ['' => 'Selecione uma opção', 'Solicitações' => [], 'Projetos' => []], null, [
                                                        'class' => 'form-control selectpicker',
                                                        'data-live-search' => 'true',
                                                        'data-actions-box' => 'true',
                                                        'required']) !!}

        <input type="hidden" id="_old_input_requestable_id" value="{{session('_old_input')['requestable_id']}}">

        @if(isset($expense))
            {!! Form::hidden('request_selected_when_edit', $expense->request_id ? $expense->request_id : $expense->project->id . ' - project', ['id' => 'request_selected']) !!}
        @endif

        <span class="help-block"><strong>{{$errors->first('requestable_id')}}</strong></span>

    </div>

    <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12">
                {!!
                    Form::label('all', 'Todos:')
                 !!}

                 <input type="checkbox" id='all' data-toggle="toggle" data-on="Sim" data-off="Não">
        </div>

    <div class="form-group col-xs-12 user {{$errors->has('user_id') ? 'has-error' : ''}}">
        {!! Form::label('user_id', 'Colaborador:') !!}
        <span title="@lang('tips.expense-colaborator-field')" class="glyphicon glyphicon-question-sign black-tooltip"
              aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>

        <select name="user_id" id="user_id" class="form-control" required="required">
            <option value="">Selecione um colaborador</option>
            @foreach($users ?? [] as $id => $value)
                <option value="{{$id}}" {{isset($expense) && $id == $expense->user_id ? 'selected' : ''}}>{{$value}}</option>
            @endforeach
        </select>

        <span class="help-block"><strong>{{$errors->first('user_id')}}</strong></span>
        <input type="hidden" id="_old_input_user_id" value="{{session('_old_input')['user_id']}}">
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12 invoice-container  {{$errors->has('invoice') ? 'has-error' : ''}}">
                {!! Form::label('invoice', 'Nº Nota Fiscal:') !!}


                @if(isset($expense) && $expense->compiled_invoice  == 'RECIBO')
                    {!!
                        Form::text('invoice', $expense->compiled_invoice ?? null, ['class' => 'form-control receipt', 'required', 'readOnly'])
                    !!}
                @else
                    {!!
                        Form::text('invoice', $expense->compiled_invoice ?? null, ['class' => 'form-control', 'required'])
                    !!}
                @endif

                <span class="help-block"><strong>{{$errors->first('invoice')}}</strong></span>
            </div>

            <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-12 {{$errors->has('invoice') ? 'has-error' : ''}}">
                {!!
                    Form::label('isReceipt', 'Recibo:')
                 !!}
                <span title="@lang('tips.expense-receip-field')" class="glyphicon glyphicon-question-sign black-tooltip"
                      aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
                <br>
                {!!
                    Form::checkbox('isReceipt', '', isset($expense) && $expense->compiled_invoice  == 'RECIBO' ? true : false, ["class" => "toggle-tf", "data-onstyle" => "dct", "data-toggle" => "toggle", "data-on" => "Sim", "data-off" => "Não", "id" => 'isReceipt'])
                !!}
            </div>

            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12 {{$errors->has('invoice_file') ? 'has-error' : ''}}">
                {!! Form::label('invoice-file', 'Arquivo:') !!}
                <span title="@lang('tips.expense-file-field')" class="glyphicon glyphicon-question-sign black-tooltip"
                      aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
                <div class="input-group">
                    <input id="invoice-file" type="text" class="form-control name_invoice"
                           value="{{$expense->original_name ?? null}}" readonly style="margin-top: 3px;"
                           required="required">
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

            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12 {{$errors->has('payment_type_id') ? 'has-error' : ''}}">
                {!! Form::label('payment_type_id', 'Tipo de Pagamento:') !!}

                {!! Form::select('payment_type_id', $paymentTypes, $expense->paymentType->id ?? null, ['class' => 'form-control', 'placeholder' => 'Selecione um tipo de pagamento', 'required']) !!}

                <span class="help-block"><strong>{{$errors->first('payment_type_id')}}</strong></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 {{$errors->has('description') ? 'has-error' : ''}}">
                {!! Form::label('description', 'Descrição:') !!}

                {!! Form::text('description', $expense->description ?? null, [
                    'class' => 'form-control',
                    'data-provide' => "typeahead",
                    'maxlength' => '255',
                    'style' => 'min-height: 87px;',
                    'required'
                    ]) !!}
                <span class="pull-right label label-default count_message description"></span>

                <span class="help-block"><strong>{{$errors->first('description')}}</strong></span>
            </div>

            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 {{$errors->has('note') ? 'has-error' : ''}}">
                {!! Form::label('note', 'Observação:') !!}
                {!! Form::text('note', $expense->note ?? null, ['class' => 'form-control', 'maxlength' => '255', 'style' => 'min-height: 87px;']) !!}
                <span class="pull-right label label-default count_message note"></span>

                <span class="help-block"><strong>{{$errors->first('note')}}</strong></span>
            </div>
        </div>
    </div>
</div>