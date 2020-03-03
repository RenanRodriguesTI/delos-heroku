<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', $city->name ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
</div>

<div class="form-group {{$errors->has('state_id') ? 'has-error' : ''}}">
    {!! Form::select('state_id', $states, $city->state_id ?? null, [
    'class' => 'selectpicker',
    'title' => 'Selecione um estado',
    'data-live-search' => 'true',
    'data-actions-box' => "true",
    'required'
    ]) !!}
    <span class="help-block"><strong>{{$errors->first('state_id')}}</strong></span>
</div>