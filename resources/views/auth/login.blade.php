@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <br>
        <br>
        <div class="signin">
            <form class="form-signin" role="form" method="POST" action="{{route('auth.attempt')}}">
                {{ csrf_field() }}
                <h4 class="form-signin-heading dct-color text-center"><i class="fa fa-lock" aria-hidden="true"></i>
                    Login</h4>
                @if(session('fail'))
                    <div class="alert alert-danger">
                        {{session('fail')}}
                    </div>
                @endif
                <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }} nomargin">
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email"
                           required="required" autofocus="autofocus" value="{{ old('email') }}">
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Senha"
                           required="required">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Lembre-me
                            </label>
                            <a href="{{ url('/password/reset') }}" style="float: right;">Esqueceu a sua senha?</a>
                        </div>
                    </div>
                </div>

                <button name="login" type="submit" class="btn btn-lg btn-dct btn-full btn-block">Entrar</button>

                <hr data-content="OU" class="hr-text">

                <div class="text-center">
                    <a href="{{ url('auth/register') }}" class="lead bold" style="color: #2E7D32">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts'))
    <script>
        $('main').css('margin-top', 0);
        $('.right_col').css({
            'background': "url('{{asset('/images/bg_login.jpg')}}') no-repeat",
            'background-size': "cover"
        });

        $(document).ready(function () {

            if ($(window).width() > 425) {
                $('footer').css({
                    'position': 'absolute',
                    'bottom': '0',
                    'width': '100%',
                    'right': '0'
                });
            } else {
                $('footer').css({
                    'position': 'relative',
                    'bottom': '0',
                    'width': '100%',
                    'right': '0'
                });
            }

            $('footer.pull-right').addClass('text-center');
        });
    </script>
    @endpush
@endsection
