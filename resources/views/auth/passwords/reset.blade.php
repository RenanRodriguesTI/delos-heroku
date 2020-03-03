@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                <div class="panel panel-dct">
                    <div class="panel-heading bold">
                        <div class="row">
                            Redefinir senha
                        </div>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group col-xs-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">E-mail</label>

                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ $email or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-xs-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Senha</label>

                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-xs-12 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm">Confirme a Senha</label>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-dct" id="btn-reset-password">
                                    <i class="fa fa-btn fa-refresh"></i> Resetar Senha
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="panel-footer">
                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts'))
    <script>
      $('.right_col').css({
        'background': "url('{{asset('/images/bg_login.jpg')}}') no-repeat",
        'background-size': "cover"
      });

      $(document).ready(function () {
        $('footer').css({
          'position': 'relative',
          'bottom': '0',
          'width': '100%',
          'right': '0'
        });

        $('footer.pull-right').addClass('text-center');
      });
    </script>
    @endpush
@endsection
