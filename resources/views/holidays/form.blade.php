<div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::text('description', $holiday->description ?? null, ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('description')}}</strong></span>
</div>

<div class="form-group {{$errors->has('date') ? 'has-error' : ''}}">
    {!! Form::label('date', 'Data:') !!}
    {!! Form::text('date', isset($holiday) ? $holiday->date->format('d/m/Y') : Carbon\Carbon::now()->format('d/m/Y'), ['class' => 'form-control', 'required']) !!}
    <span class="help-block"><strong>{{$errors->first('date')}}</strong></span>
</div>
