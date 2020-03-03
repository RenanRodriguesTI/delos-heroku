@extends('layouts.app')
@section('content')
    <div class="container" id="checkout">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Confirmação assinatura</h3>
            </div>

            {!! Form::open(['route' => 'checkout.store', 'method' => 'POST', 'id' => 'form-checkout']) !!}

                <div class="panel-body">
                    <div class="col-lg-7 col-md-8 col-sm-12">
                        <div class="alert alert-success text-center" style="padding: 4px;">
                            <h5>Informações para cobrança</h5>
                        </div>
                        <br>
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12 col-sm-12 {{$errors->has('name') ? 'has-error' : ''}}">
                                    {!! Form::label('name', 'Nome/Razão Social') !!}
                                    {!! Form::text('name', $paymentInformation->name ?? null, ['class' => 'form-control', 'required']) !!}

                                    <span class="help-block">
                                        <strong>{{$errors->first('name')}}</strong>
                                    </span>
                                </div>

                                <div class="form-group col-md-6 col-xs-12 {{$errors->has('email') ? 'has-error' : ''}}">
                                    {!! Form::label('email', 'E-mail') !!}
                                    {!! Form::email('email', $paymentInformation->email ?? null, ['class' => 'form-control', 'required']) !!}

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
                                    {!! Form::text('telephone', $paymentInformation->telephone ?? null, ['class' => 'form-control', 'required']) !!}

                                    <span class="help-block">
                                        <strong>{{$errors->first('telephone')}}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-6 col-xs-12 {{$errors->has("document.number") ? 'has-error' : ''}}">
                                    {!! Form::label("document", 'CPF/CNPJ') !!}
                                    {!! Form::hidden('document[type]', $paymentInformation->document['type'] ?? null, ['id' => 'document-type']) !!}
                                    {!! Form::text("document[number]", $paymentInformation->document['number'] ?? null, ['class' => 'form-control', 'required', 'id' => 'document']) !!}

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
                                    {!! Form::text("address[postal_code]", $paymentInformation->address["postal_code"] ?? null, ['class' => 'form-control', 'required', 'id' => 'postal_code']) !!}

                                    <span class="help-block">
                                        <strong>{{$errors->first("address.postal_code")}}</strong>
                                    </span>
                                </div>

                                <div class="form-group col-md-6 col-xs-12 {{$errors->has("address.street") ? 'has-error' : ''}}">
                                    {!! Form::label("address", 'Endereço') !!}
                                    {!! Form::text("address[street]", $paymentInformation->address['street'] ?? null, ['class' => 'form-control', 'required', 'id' => 'address']) !!}

                                    <span class="help-block">
                                        <strong>{{$errors->first("address.street")}}</strong>
                                    </span>
                                </div>

                                <div class="form-group col-md-2 col-xs-12 {{$errors->has("address.number") ? 'has-error' : ''}}">
                                    {!! Form::label("residential_number", 'Número') !!}
                                    {!! Form::text("address[number]", $paymentInformation->address['number'] ?? null, ['class' => 'form-control', 'required', 'id' => 'residential_number']) !!}

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
                                    {!! Form::text("address[district]", $paymentInformation->address['district'] ?? null, ['class' => 'form-control', 'required', 'id' => 'district']) !!}

                                    <span class="help-block">
                                        <strong>{{$errors->first("address.district")}}</strong>
                                    </span>
                                </div>

                                <div class="form-group col-md-4 col-xs-12 {{$errors->has("address.city") ? 'has-error' : ''}}">
                                    {!! Form::label("city", 'Cidade') !!}
                                    {!! Form::text("address[city]", $paymentInformation->address['city'] ?? null, ['class' => 'form-control', 'required', 'id ' => 'city']) !!}

                                    <span class="help-block">
                                        <strong>{{$errors->first("address.city")}}</strong>
                                    </span>
                                </div>

                                <div class="form-group col-md-4 col-xs-12 {{$errors->has("address.state") ? 'has-error' : ''}}">
                                    {!! Form::label("state", 'UF') !!}
                                    {!! Form::text("address[state]", $paymentInformation->address['state'] ?? null, ['class' => 'form-control', 'required', 'id' => 'state']) !!}

                                    <span class="help-block">
                                        <strong>{{$errors->first("address.state")}}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="row">
                                <div class="form-group col-xs-12 {{$errors->has('payment_type') ? 'has-error' : ''}}">
                                    {!! Form::label('payment_type', 'Forma de pagamento') !!}
                                    {!! Form::select('payment_type', [
                                        '' => 'Selecione uma opção',
                                        /*'credit-card' => 'Cartão de Crédito',*/
                                        'bank-slip' => 'Boleto'], isset($paymentInformation) && $paymentInformation->is_bank_slip == true ? 'Boleto' : 'Cartão de Crédito', ['class' => 'form-control', 'required']) !!}
                                    <p style="color: #f00;"><small>Por enquanto estamos processando apenas pagamento via boleto.</small></p>

                                    <span class="help-block">
                                        <strong>{{$errors->first('payment_type')}}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12" id="credit-card-container">
                            <div class="alert alert-success text-center" style="padding: 4px;">
                                <h5>Informações do cartão de crédito</h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="card-wrapper"></div>
                            </div>

                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="form-group col-md-6 col-xs-12 {{$errors->has("credit_card.name") ? 'has-error' : ''}}">
                                        {!! Form::label("credit_card[name]", 'Nome impresso no cartão') !!}

                                        {!! Form::text("credit_card[name]", null, ['class' => 'form-control', 'required', 'id' => 'name_printed']) !!}
                                        <span class="help-block">
                                            <strong>{{$errors->first("credit_card.name")}}</strong>
                                        </span>
                                    </div>

                                    <div class="form-group col-md-6 col-xs-12 {{$errors->has("credit_card.number") ? 'has-error' : ''}}">
                                        {!! Form::label("credit_card[number]", 'Número do cartão ') !!}

                                        {!! Form::text("credit_card[number]", null, ['class' => 'form-control', 'required', 'id' => 'credit_card_number']) !!}
                                        <span class="help-block">
                                            <strong>{{$errors->first("credit_card.number")}}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="form-group col-md-6 col-xs-12 {{$errors->has("credit_card.valid_date") ? 'has-error' : ''}}">
                                        {!! Form::label("credit_card[valid_date]", 'Validade') !!}

                                        {!! Form::text("credit_card[valid_date]", null, ['class' => 'form-control', 'required', 'id' => 'validity']) !!}
                                        <span class="help-block">
                                            <strong>{{$errors->first("credit_card.valid_date")}}</strong>
                                        </span>
                                    </div>

                                    <div class="form-group col-md-6 col-xs-12 {{$errors->has("credit_card.cvv") ? 'has-error' : ''}}">
                                        {!! Form::label("credit_card[cvv]", 'Código de segurança') !!}

                                        {!! Form::text("credit_card[cvv]", null, ['class' => 'form-control', 'required', 'id' => 'security_code']) !!}
                                        <span class="help-block">
                                            <strong>{{$errors->first("credit_card.cvv")}}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12" id="bank-slip-container">
                                <div class="alert alert-success text-center" style="padding: 4px;">
                                    <h5>Informações do boleto</h5>
                                </div>

                                <br>

                                <ul class="list-group" style="font-size: 1.1em">
                                    <li class="list-group-item">A data de vencimento do boleto será: <span class="bold">{{$dueDateToBankSlip}}</span>.</li>
                                    <li class="list-group-item">O boleto poderá demorar até 3 dias uteís para ser compensado.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-xs-12" id="plan-selected">
                        <div>
                            <div class="alert alert-success text-center" style="padding: 4px;">
                                <h5>Plano escolhido</h5>
                            </div>
                            <br>
                            <div class="pricing ui-ribbon-container">
                                <div class="title">
                                    <h2>{{$plan->name}}</h2>
                                    <h1>R$ {{number_format($price, '2', ',', '.')}}/usuário</h1>
                                    <span>{{trans("plans.period.{$plan->periodicity}")}}</span>
                                </div>

                                <div class="x_content">
                                    <div>
                                        <div class="pricing_features">
                                            <ul class="list-unstyled text-left">
                                                @foreach($plan->modules()->orderBy('name', 'asc')->get() as $module)
                                                    <li><i class="fa fa-check text-success"></i> {{$module->name}}</li>
                                                @endforeach
                                                @foreach(app(\Delos\Dgp\Repositories\Contracts\ModuleRepository::class)->makeModel()->whereNotIn('id', $plan->modules()->pluck('id'))->orderBy('name', 'asc')->get() as $moduleUnselected)
                                                    <li><i class="fa fa-times text-danger"></i> {{$moduleUnselected->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(".pricing_features").scrollTop(1000);
                    </script>
                </div>
                <div class="panel-footer">
                    <div class="text-right">
                        <button class="btn btn-dct" type="submit">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            Confirmar assinatura
                        </button>
                        <a href="{{url()->previous() == url()->current() ? route('selectPlan') : url()->previous()}}" class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            Voltar
                        </a>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
@endsection