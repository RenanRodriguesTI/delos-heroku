<div class="panel-body">
    <div class="col-xs-12">
        <div class="form-group {{$errors->has('name') ? ' has-error' : ''}}">
            {!! Form::label('name', 'Nome') !!}
            {!! Form::input('Nome', 'name', $groupCompany->name ?? null, ['class' => 'form-control', 'required']) !!}

            <span class="help-block">{!! $errors->first('name') !!}</span>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group {{$errors->has('plan_id') ? ' has-error' : ''}}">
            {!! Form::label('plan_id', 'Planos') !!}
            {!! Form::select('plan_id', (['' => 'Selecione uma opção'] + $plans), $groupCompany->plan_id ?? null, ['class' => 'form-control', 'required']) !!}

            <span class="help-block">{!! $errors->first('plan_id') !!}</span>
        </div>
    </div>
</div>
<div class="panel-footer">
    <div class="text-right">
        <a href="{{url()->previous() == url()->current() ? route('groupCompanies.index') : url()->previous()}}" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Voltar
        </a>
        <button name="save" type="submit" class="btn btn-dct">
            <span class="glyphicon glyphicon-floppy-disk"></span>
            Salvar
        </button>
    </div>
</div>