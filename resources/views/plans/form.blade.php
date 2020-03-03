<div id="form-plan">

    <div class="form-group col-sm-12 col-lg-6 col-xs-12 {{$errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Título do plano:') !!}

        {!! Form::text('name', $plan->name ?? null, [
            'class' => 'form-control',
            'required'
            ]) !!}

        <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
    </div>

    <div class="form-group col-sm-12 col-lg-6 col-xs-12 {{$errors->has('billing_type') ? 'has-error' : ''}}">
        {!! Form::label('billing_type', 'Tipo de cobrança:') !!}

        {!! Form::select('billing_type', [
            '' => 'Selecione uma opção',
            'auto' => 'Automático',
            'manual' => 'Manual'
        ],
        $plan->billing_type ?? null, [
            'class' => 'form-control',
            'required'
            ]) !!}

        <span class="help-block"><strong>{{$errors->first('billing_type')}}</strong></span>
    </div>

    <div class="form-group col-sm-12 col-lg-6 col-xs-12 {{$errors->has('trial_period') ? 'has-error' : ''}}">
        {!! Form::label('trial_period', 'Dias para teste:') !!}

        {!! Form::number('trial_period', $plan->trial_period ?? null, ['class' => 'form-control', 'required']) !!}

        <span class="help-block"><strong>{{$errors->first('trial_period')}}</strong></span>
    </div>

    <div class="form-group col-sm-12 col-lg-6 col-xs-12 {{$errors->has('periodicity') ? 'has-error' : ''}}">
        {!! Form::label('periodicity', 'Período de cobrança:') !!}

        {!! Form::select('periodicity', [
            '' => 'Selecione uma opção',
            'WEEKLY' => 'Semanal',
            'MONTHLY' => 'Mensal',
            'BIMONTHLY' => 'Bimestral',
            'TRIMONTHLY' => 'Trimestral',
            'SEMIANNUAL' => 'Semestral',
            'YEARLY' => 'Anual'
        ],
        $plan->periodicity ?? null, [
            'class' => 'form-control',
            'required'
            ]) !!}

        <span class="help-block"><strong>{{$errors->first('periodicity')}}</strong></span>
    </div>

    <div class="form-group col-sm-12 col-lg-6 col-xs-12 {{$errors->has('value') ? 'has-error' : ''}}">
        {!! Form::label('value', 'Valor:') !!}

        {!! Form::text('value', number_format($plan->value ?? null, '2', ',', '.') ?? null, ['class' => 'form-control', 'required']) !!}

        <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
    </div>

    <div class="form-group col-sm-12 col-lg-6 col-xs-12 {{$errors->has('max_users') ? 'has-error' : ''}}">
        {!! Form::label('max_users', 'Quantidade máxima de usuários:') !!}

        {!! Form::number('max_users', $plan->max_users ?? '' == 0 ? '': $plan->max_users ?? '', ['class' => 'form-control']) !!}
        <p style="color: #f00;"><small>Caso não haja um número finito de usuários deixar campo vazio</small></p>
        <span class="help-block"><strong>{{$errors->first('max_users')}}</strong></span>
    </div>

    <div class="form-group col-xs-12 {{$errors->has('description') ? ' has-error' : ''}}">
        {!! Form::label('description', 'Descrição:') !!}
        {!! Form::textarea('description', $plan->description ?? null, ['class' => 'form-control', 'id' => 'text', 'rows' => '2', 'maxlength' => '255']) !!}
        <span class="pull-right label label-default count_message"></span>
        <span class="help-block"><strong>{{$errors->first('description')}}</strong></span>
    </div>
</div>