<div class='row'>
<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('cnpj') ? 'has-error' : ''}}">
    {!! Form::label('cnpj', 'CNPJ/CPF:') !!}
    {!! Form::text('cnpj', isset($provider)? $provider->cnpj: null, ['class' => 'form-control','required']) !!}
    
    <span class="help-block"><strong>{{$errors->first('cnpj')}}</strong></span>
</span>

<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('social_reason') ? 'has-error' : ''}}">
    {!! Form::label('social_reason', 'Razão Social/Nome:') !!}
    {!! Form::text('social_reason', isset($provider)?$provider->social_reason:null, ['class' => 'form-control','required']) !!}
    
    <span class="help-block"><strong>{{$errors->first('social_reason')}}</strong></span>
</span>
</div>


<div class='row'>
<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('numberaccount') ? 'has-error' : ''}}">
    {!! Form::label('accountnumber', 'N° Conta:') !!}
    {!! Form::text('accountnumber', isset($provider)? $provider->accountnumber: null, ['class' => 'form-control','required']) !!}
    
    <span class="help-block"><strong>{{$errors->first('numberaccount')}}</strong></span>
</span>


<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Nome de contato:') !!}
    {!! Form::text('name', isset($provider)?$provider->name:null, ['class' => 'form-control','required']) !!}
    
    <span class="help-block"><strong>{{$errors->first('name')}}</strong></span>
</span>
</div>


<div class='row'>
<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('telephone') ? 'has-error' : ''}}">
    {!! Form::label('telephone', 'Telefone:') !!}
    {!! Form::text('telephone',isset($provider) ? $provider->telephone: null, ['class' => 'form-control','required']) !!}
    <span class="help-block"><strong>{{$errors->first('telephone')}}</strong></span>
</span>

<span class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 {{$errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email',isset($provider) ? $provider->email: null, ['class' => 'form-control','required']) !!}
    <span class="help-block"><strong>{{$errors->first('email')}}</strong></span>
</span>
</div>


<div class='row'>
<span class="form-group col-lg-12 col-md-10 col-sm-10 col-xs-12 {{$errors->has('note') ? 'has-error' : ''}}">
    {!! Form::label('note', 'Observação:') !!}
    {!! Form::text('note',isset($provider) ? $provider->note: null, ['class' => 'form-control','required']) !!}
    <span class="help-block"><strong>{{$errors->first('note')}}</strong></span>
</span>
</div>



@push('scripts')
    <script>
        $(document).ready(function(){
            var cnpj_cpf = loadingInputCNPJ();
            var telephone = loadingInputTelephone();

            (cnpj_cpf.length > 11) ? 
            $('#cnpj').mask('00.000.000/0000-00') : 
            $('#cnpj').mask('000.000.000-00');

            (telephone.length < 11) ?
            $('#telephone').mask('(00) 0000-0000') :
            $('#telephone').mask('(00) 00000-0000');
        });

        $('#cnpj').bind('input',function(event){
            var value = event.originalEvent.data;
            $(this).val(loadingInputCNPJ());
        });

        $('#cnpj').bind('blur',function(){

            var value = loadingInputCNPJ();
            console.log(value.length)
            if(value.length < 12){
                $(this).mask('000.000.000-00');
            } else{
                $(this).mask('00.000.000/0000-00')
            }
        });

        $('#cnpj').bind('focus',function(){
            $('#cnpj').unmask();
        });


        $('#telephone').bind('input',function(event){
            var value = event.originalEvent.data;
            $(this).val(loadingInputTelephone());
        });

        $('#telephone').bind('blur',function(){

            var telephone = loadingInputTelephone();
            (telephone.length < 11) ?
                $('#telephone').mask('(00) 0000-0000') :
                $('#telephone').mask('(00) 00000-0000');
        });

        $('#telephone').bind('focus',function(){
            $('#telephone').unmask();
        });
       
        $('#accountnumber').attr('type','tel');


        function loadingInputCNPJ(){
            try{
                var cnpj_cpf = $('#cnpj').clearVal();
                return cnpj_cpf;
            } catch(err){
                var cnpj_cpf = $('#cnpj').val();

                return cnpj_cpf.replace(/[^\d]+/g,'');
            }
        }

        function loadingInputTelephone(){
            try{
                var telephone = $('#telephone').clearVal();
                return telephone;
            } catch(err){
                var telephone = $('#telephone').val();

                return telephone.replace(/[^\d]+/g,'');
            }
        }

    
    </script>
@endpush