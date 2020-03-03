<div class="row">
    <div class="form-group col-xs-12 {{$errors->has('client_id') ? 'has-error' : ''}}">
        {!! Form::label('user_id', 'Usuário:') !!}
        {!! Form::select('user_id', $users, isset($contracts) ? $contracts->user->pluck('id') : null, ['title' => 'Selecione um usuário', 
        'class' => 'form-control', 
        'required', 'data-actions-box' => "true", 
        'multiple']) !!}
        <span class="help-block">
            <strong>{{$errors->first('user_id')}}</strong>
        </span>
    </div>

    <span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('start') ? 'has-error' : ''}}">
        {!! Form::label('start', 'Data de inicio:') !!}
        {!! Form::text('start', isset($contracts) ? $contracts->start->format('d/m/Y') : null, [
        'class' => 'form-control start', 'required']) !!}
        
        <span class="help-block"><strong>{{$errors->first('start')}}</strong></span>
    </span>

    <span class="form-group col-lg-2 col-md-10 col-sm-10 col-xs-12   {{$errors->has('end') ? 'has-error' : ''}}">
        {!! Form::label('end', 'Data de fim:') !!}
        {!! Form::text('end', isset($contracts) ? $contracts->end->format('d/m/Y') : null, [
        'class' => 'form-control start', 'required']) !!}
        
        <span class="help-block"><strong>{{$errors->first('end')}}</strong></span>
    </span>

    <span class="form-group col-lg-5 col-md-10 col-sm-10 col-xs-12 {{$errors->has('value') ? 'has-error' : ''}}">
        {!! Form::label('value', 'Valor:') !!}
        <div class="input-group">
            <div class="input-group-addon">R$</div>
            {!! Form::text('value', isset($contracts) ? number_format($contracts->value, 2, ',', '.') : null, ['class' => 'form-control','required']) !!}
        </div>
        
        <span class="help-block"><strong>{{$errors->first('value')}}</strong></span>
    </span>

</div>

@push('scripts')
$("#start").daterangepicker({
    locale: {
        format: 'DD/MM/YYYY'
    },
    "singleDatePicker": true,
});

$("#end").daterangepicker({
    locale: {
        format: 'DD/MM/YYYY'
    },
    "singleDatePicker": true,
});
@endpush