<div class="form-group col-sm-6 col-xs-12 {{$errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', $user->name ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
</div>

<div class="form-group col-sm-6 col-xs-12 {{$errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', $user->email ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('email')}}</strong></span>
</div>

<div class="form-group col-sm-6 col-xs-12 {{$errors->has('admission') ? 'has-error' : ''}}">
    {!! Form::label('admission', 'Data de Admissão:') !!}
    {!! Form::text('admission', isset($user) ? $user->admission->format('d/m/Y') : Carbon\Carbon::now()->format('d/m/Y'), ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('admission')}}</strong></span>
</div>

<div class="form-group col-md-6 col-xs-12 {{$errors->has('supplier_number') ? 'has-error' : ''}}">
    {!! Form::label('supplier_number', trans('headers.supplier-number')) !!}
    {!! Form::text('supplier_number', $user->supplier_number ?? 0, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('supplier_number')}}</strong></span>
</div>

<div class="form-group col-md-6 col-xs-12 {{$errors->has('account_number') ? 'has-error' : ''}}">
    {!! Form::label('account_number', trans('headers.account-number')) !!}
    {!! Form::text('account_number', $user->account_number ?? 0, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('account_number')}}</strong></span>
</div>

{{-- TODO traduzir perfis --}}
<div class="form-group col-sm-6 col-xs-12 {{$errors->has('role_id') ? 'has-error' : ''}}">
    {!! Form::label('role_id', 'Perfil:') !!}
    <span title="@lang('tips.users-cod')" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>

    {!! Form::select('role_id', $roles, $user->role->id ?? null, ['placeholder' => 'Selecione um perfil', 'class' => 'form-control', 'required', 'data-actions-box' => "true",]) !!}
    <span class="help-block"><strong>{{$errors->first('role_id')}}</strong></span>
</div>

<div class="form-group col-sm-6 col-xs-12 {{$errors->has('company_id') ? 'has-error' : ''}}">
    {!! Form::label('company_id', trans('headers.company')) !!}
    {!! Form::select('company_id', $companies, $user->company_id ?? null, ['class' => 'form-control', 'title' => 'Selecione a empresa', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('company_id')}}</strong></span>
</div>

<div class="form-group col-sm-6 col-xs-12 {{$errors->has('is_partner_business') ? 'has-error' : ''}}">
    {!! Form::label('is_partner_business', trans('headers.is-partner-business')) !!}
    {!! Form::select('is_partner_business', [true => 'SIM', false => 'NÃO'], $user->is_partner_business ?? false ? 1 : 0, ['class' => 'form-control', 'title' => 'Selecione uma opção', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('is_partner_business')}}</strong></span>
</div>

<div class="form-group col-xs-12 {{$errors->has('notes') ? ' has-error' : ''}}">
    {!! Form::label('notes', 'Observação:') !!}
    {!! Form::textarea('notes', $user->notes ?? null, ['class' => 'form-control', 'id' => 'text', 'rows' => '2', 'maxlength' => '255']) !!}
    <span class="pull-right label label-default count_message"></span>
    <span class="help-block"><strong>{{$errors->first('notes')}}</strong></span>
</div>


@can('change-group-of-company')
    <div class="form-group col-sm-12 col-xs-12 {{$errors->has('groupCompany') ? ' has-error' : ''}}">
        {!! Form::label('group_company_id', 'Grupo da Empresa') !!}
        <span title="@lang('tips.users-company')" class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="right"></span>

        {!! Form::select('group_company_id', (['' => 'Selecione o Grupo'] + $groupCompanies->toArray()), $user->group_company_id?? null, ['class' => 'form-control', 'required']) !!}

        <span class="help-block">{!! $errors->first('groupCompany') !!}</span>
    </div>
@endcan

{{-- <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12 {{$errors->has('hours') ? 'has-error' : ''}}">
    {!! Form::label('hours', 'Cadastrar Horas:') !!}
    <span aria-hidden="true" data-toggle="tooltip" data-placement="top"></span>
    <br>
    {{Form::hidden('hours','0')}}
    {!! Form::checkbox('hours', '1', isset($user)? $user->hours : false, ["class" => "toggle-tf", "data-onstyle" => "dct", "data-toggle" => "toggle", "data-on" => "Sim", "data-off" => "Não", "id" => 'hours']) !!}
</div> --}}