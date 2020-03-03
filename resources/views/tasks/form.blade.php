<div class="form-group col-xs-12 {{$errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', $task->name ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
</div>

@can('change-group-of-company')
    <div class="form-group col-xs-12 {{$errors->has('groupCompany') ? ' has-error' : ''}}">
        {!! Form::label('group_company_id', 'Grupo da Empresa') !!}
        {!! Form::select('group_company_id', (['' => 'Selecione o Grupo'] + $groupCompanies->toArray()), $task->group_company_id?? null, ['class' => 'form-control', 'required']) !!}

        <span class="help-block">{!! $errors->first('groupCompany') !!}</span>
    </div>
@endcan
