<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', $airport->name ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
</div>

<div class="form-group {{$errors->has('initials') ? 'has-error' : ''}}">
    {!! Form::label('initials', 'Sigla:') !!}
    {!! Form::text('initials', $airport->initials ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('initials')}}</strong></span>
</div>

<div class="form-group {{$errors->has('state_id') ? 'has-error' : ''}}">
    {!! Form::select('state_id', $states, $airport->state_id ?? null, [
    'class' => 'selectpicker',
    'title' => 'Selecione um estado',
    'data-live-search' => 'true',
    'required'
    ]) !!}
    <span class="help-block"><strong>{{$errors->first('state_id')}}</strong></span>
</div>