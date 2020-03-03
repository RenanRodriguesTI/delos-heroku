<div class="form-group col-xs-12 {{$errors->has('cod') ? 'has-error' : ''}}">
    {!! Form::label('cod', 'Código:') !!}
    {!! Form::number('cod', $group->cod ?? null, [
        'class' => 'form-control',
        'placeholder' => 'Digite um código ou vazio para geração automática',
        'maxlength' => '2'
        ]) !!}
    <span class="help-block"><strong>{{$errors->first('cod')}}</strong></span>
</div>

<div class="form-group col-xs-12 {{$errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', $group->name ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
</div>

@can('change-group-of-company')
    <div class="form-group col-xs-12 {{$errors->has('groupCompany') ? ' has-error' : ''}}">
        {!! Form::label('group_company_id', 'Grupo da Empresa') !!}
        {!! Form::select('group_company_id', (['' => 'Selecione o Grupo'] + $groupCompanies->toArray()), $group->group_company_id?? null, ['class' => 'form-control', 'required', 'data-actions-box' => "true",]) !!}

        <span class="help-block">{!! $errors->first('groupCompany') !!}</span>
    </div>
@endcan