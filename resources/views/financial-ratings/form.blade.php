<div class="form-group col-xs-12 {{$errors->has('cod') ? 'has-error' : ''}}">
    {!! Form::label('cod', 'Código:') !!}
    {!! Form::text('cod', $financialRating->cod ?? null, ['class' => 'form-control', 'maxlength' => '2', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('cod')}}</strong></span>
</div>

<div class="form-group col-xs-12 {{$errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::text('description', $financialRating->description ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('description')}}</strong></span>
</div>

@can('change-group-of-company')
    <div class="form-group col-xs-12 {{$errors->has('groupCompany') ? ' has-error' : ''}}">
        {!! Form::label('group_company_id', 'Grupo da Empresa') !!}
        {!! Form::select('group_company_id', (['' => 'Selecione o Grupo'] + $groupCompanies->toArray()), $financialRating->group_company_id?? null, ['class' => 'form-control', 'required', 'data-actions-box' => "true",]) !!}

        <span class="help-block">{!! $errors->first('groupCompany') !!}</span>
    </div>
@endcan