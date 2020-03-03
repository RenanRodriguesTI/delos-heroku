<div class="panel-body">
    <div class="col-xs-12">
        <div class="form-group col-xs-12 {{$errors->has('name') ? ' has-error' : ''}}">
            {!! Form::label('name', 'Nome') !!}
            {!! Form::text('name', $company->name ?? null, ['class' => 'form-control', 'required']) !!}

            <span class="help-block">{!! $errors->first('name') !!}</span>
        </div>

        @can('change-group-of-company')
            <div class="form-group col-xs-12 {{$errors->has('groupCompany') ? ' has-error' : ''}}">
                {!! Form::label('group_company_id', 'Grupo da Empresa') !!}
                {!! Form::select('group_company_id', (['' => 'Selecione o Grupo'] + $groupCompanies->toArray()), $company->group_company_id?? null, ['class' => 'form-control', 'required', 'data-actions-box' => "true",]) !!}

                <span class="help-block">{!! $errors->first('groupCompany') !!}</span>
            </div>
        @endcan
    </div>
</div>
<div class="panel-footer">
    <div class="text-right">
        <a href="{{url()->previous() == url()->current() ? route('companies.index') : url()->previous()}}" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Voltar
        </a>
        <button name="save" type="submit" class="btn btn-dct">
            <span class="glyphicon glyphicon-floppy-disk"></span>
            Salvar
        </button>
    </div>
</div>