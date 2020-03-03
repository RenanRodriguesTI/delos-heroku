<div class="col-xs-12">
    <div class="row">
        <div class="form-group col-xs-6 {{$errors->has('cod') ? 'has-error' : ''}}">
            {!! Form::label('cod', 'Código:') !!}
            <span title="@lang('tips.clients-cod')" class="glyphicon glyphicon-question-sign black-tooltip"
                  aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>

            {!! Form::number('cod', $client->cod ?? null, [
                    'class' => 'form-control col-xs-12',
                    'placeholder' => 'Digite um código ou vazio para geração automática',
                    'maxlength' => 3,
                    'pattern' => '[0-9]{3}'
                ]) !!}

            <span class="help-block">
        <strong>{{$errors->first('cod')}}</strong>
    </span>
        </div>

        <div class="form-group col-md-6 col-xs-12 {{$errors->has('group_id') ? 'has-error' : ''}}">
            {!! Form::label('group_id', 'Grupo de clientes:') !!}
            {!! Form::select('group_id', $groups, $client->group->id ?? null, ['placeholder' => 'Selecione um grupo', 'class' => 'form-control', 'required', 'data-actions-box' => "true",]) !!}

            <span class="help-block">
        <strong>{{$errors->first('group_id')}}</strong>
    </span>
        </div>
    </div>
</div>

<div class="col-xs-12">
    <div class="row">
        <div class="form-group col-md-6 col-xs-12 col-sm-12 {{$errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Nome/Razão Social') !!}
            {!! Form::text('name', $client->name ?? null, ['class' => 'form-control', 'required']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first('name')}}</strong>
                                    </span>
        </div>

        <div class="form-group col-md-6 col-xs-12 {{$errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::email('email', $client->email ?? null, ['class' => 'form-control', 'required']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first('email')}}</strong>
                                    </span>
        </div>
    </div>
</div>

<div class="col-xs-12">
    <div class="row">
        <div class="form-group col-md-6 col-xs-12 {{$errors->has('telephone') ? 'has-error' : ''}}">
            {!! Form::label('telephone', 'Telefone') !!}
            {!! Form::text('telephone', $client->telephone ?? null, ['class' => 'form-control', 'required']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first('telephone')}}</strong>
                                    </span>
        </div>
        <div class="form-group col-md-6 col-xs-12 {{$errors->has("document.number") ? 'has-error' : ''}}">
            {!! Form::label("document", 'CPF/CNPJ') !!}
            {!! Form::hidden('document[type]', $client->document['type'] ?? null, ['id' => 'document-type']) !!}
            {!! Form::text("document[number]", $client->document['number'] ?? null, ['class' => 'form-control', 'required', 'id' => 'document', 'maxlength' => '18']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first("document.number")}}</strong>
                                    </span>
        </div>
    </div>
</div>

<div class="col-xs-12">
    <div class="row">
        <div class="form-group col-md-4 col-xs-12 {{$errors->has("address.postal_code") ? 'has-error' : ''}}">
            {!! Form::label("postal_code", 'CEP') !!}
            {!! Form::text("address[postal_code]", $client->address["postal_code"] ?? null, ['class' => 'form-control', 'required', 'id' => 'postal_code']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first("address.postal_code")}}</strong>
                                    </span>
        </div>

        <div class="form-group col-md-6 col-xs-12 {{$errors->has("address.street") ? 'has-error' : ''}}">
            {!! Form::label("address", 'Endereço') !!}
            {!! Form::text("address[street]", $client->address['street'] ?? null, ['class' => 'form-control', 'required', 'id' => 'address']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first("address.street")}}</strong>
                                    </span>
        </div>

        <div class="form-group col-md-2 col-xs-12 {{$errors->has("address.number") ? 'has-error' : ''}}">
            {!! Form::label("residential_number", 'Número') !!}
            {!! Form::text("address[number]", $client->address['number'] ?? null, ['class' => 'form-control', 'required', 'id' => 'residential_number']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first("address.number")}}</strong>
                                    </span>
        </div>
    </div>
</div>

<div class="col-xs-12">
    <div class="row">
        <div class="form-group col-md-4 col-xs-12 {{$errors->has("address.district") ? 'has-error' : ''}}">
            {!! Form::label("district", 'Bairro') !!}
            {!! Form::text("address[district]", $client->address['district'] ?? null, ['class' => 'form-control', 'required', 'id' => 'district']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first("address.district")}}</strong>
                                    </span>
        </div>

        <div class="form-group col-md-4 col-xs-12 {{$errors->has("address.city") ? 'has-error' : ''}}">
            {!! Form::label("city", 'Cidade') !!}
            {!! Form::text("address[city]", $client->address['city'] ?? null, ['class' => 'form-control', 'required', 'id ' => 'city']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first("address.city")}}</strong>
                                    </span>
        </div>

        <div class="form-group col-md-4 col-xs-12 {{$errors->has("address.state") ? 'has-error' : ''}}">
            {!! Form::label("state", 'UF') !!}
            {!! Form::text("address[state]", $client->address['state'] ?? null, ['class' => 'form-control', 'required', 'id' => 'state']) !!}

            <span class="help-block">
                                        <strong>{{$errors->first("address.state")}}</strong>
                                    </span>
        </div>
    </div>
</div>

@can('change-group-of-company')
    <div class="form-group col-sm-12 col-xs-12 {{$errors->has('groupCompany') ? ' has-error' : ''}}">
        {!! Form::label('group_company_id', 'Grupo da Empresa') !!}
        {!! Form::select('group_company_id', (['' => 'Selecione o Grupo'] + $groupCompanies->toArray()), $client->group_company_id?? null, ['class' => 'form-control', 'required']) !!}

        <span class="help-block">{!! $errors->first('groupCompany') !!}</span>
    </div>
@endcan