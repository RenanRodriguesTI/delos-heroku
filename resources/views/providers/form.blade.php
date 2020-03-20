<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('social_reason') ? 'has-error' : ''}}">
    {!! Form::label('social_reason', 'Razão Social:') !!}
    {!! Form::text('social_reason', isset($provider)?$provider->social_reason:null, ['class' => 'form-control','required']) !!}
    
    <span class="help-block"><strong>{{$errors->first('social_reason')}}</strong></span>
</span>

<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('cnpj') ? 'has-error' : ''}}">
    {!! Form::label('cnpj', 'CNPJ:') !!}
    {!! Form::text('cnpj', isset($provider)? $provider->cnpj: null, ['class' => 'form-control','required']) !!}
    
    <span class="help-block"><strong>{{$errors->first('cnpj')}}</strong></span>
</span>


<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email',isset($provider) ? $provider->email: null, ['class' => 'form-control','required']) !!}
    <span class="help-block"><strong>{{$errors->first('email')}}</strong></span>
</span>

<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('telephone') ? 'has-error' : ''}}">
    {!! Form::label('telephone', 'Telefone:') !!}
    {!! Form::text('telephone',isset($provider) ? $provider->telephone: null, ['class' => 'form-control','required']) !!}
    <span class="help-block"><strong>{{$errors->first('telephone')}}</strong></span>
</span>


<span class="form-group col-lg-12 col-md-10 col-sm-10 col-xs-12 {{$errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Observação:') !!}
    {!! Form::text('note',isset($provider) ? $provider->note: null, ['class' => 'form-control','required']) !!}
    <span class="help-block"><strong>{{$errors->first('note')}}</strong></span>
</span>

@push('scripts')
    <script>
        $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('#telephone').mask('(00) 0000-0000');
    </script>
@endpush