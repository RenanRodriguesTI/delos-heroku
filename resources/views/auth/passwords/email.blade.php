@extends('layouts.app')

<!-- Main Content -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                <div class="panel panel-dct">
                    <div class="panel-heading">
                        <h3 class="panel-title bold">Redefinir senha</h3>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>

                            @else
                                <div class="alert alert-success">
                                    Enviaremos um email com um link para redefinir sua senha.
                                </div>
                            @endif
                        </div>

                        <br>


                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-xs-12 bold">Informe seu email de
                                    acesso:</label>

                                <div class="col-xs-12">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <br>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-dct btn-block">
                                        <i class="fa fa-btn fa-envelope"></i> Enviar link de de redefinição de senha
                                    </button>
                                </div>
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
