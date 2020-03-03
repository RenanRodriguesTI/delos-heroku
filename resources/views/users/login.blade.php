@extends('layouts.app')
@section('content')
    <div class="container" >
        <div class="panel panel-dct">
            <div class="panel-body">
                <br>
                <br>
                <br>
                <div class="signin">
                    <form class="form-signin2" role="form" method="POST" action="{{route('users.attempt')}}">
                        {{ csrf_field() }}
                        <h3 class="form-signin-heading dct-color">Trocar de Usuário</h3>
                        <div class="form-group nomargin{{$errors->has('user_id') ? ' has-error' : ''}}" style="padding: 0px;">
                            <label for="user_id" class="sr-only">Usuários</label>
                            {!! Form::select('user_id', $users, null,[
                                'class' => 'form-control selectpicker',
                                'placeholder' => 'Selecione um Usuário',
                                'data-live-search' => 'true',
                                'required'
                            ])!!}
                            <span class="help-block">
                                <strong>{{$errors->first('user_id')}}</strong>
                            </span>
                        </div>

                        <div class="form-group">

                        </div>
                        <button name="login" type="submit" class="btn btn-lg btn-dct btn-full btn-block" id="btn-login-users">Entrar</button>
                    </form>
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
@endsection
