@extends('layouts.app')
@section('content')

<div class="container">

    <h1>MODO DE MANUTENÇÃO</h1>
    <p style="font-size: 21px; color: #5e5e5e">
        O site está passando por uma manutenção programada.<br> Volte mais tarde.
    </p>

    <hr>

<div class="row">
    <div class="col-md-4">
        <div class="media">
            <div class="media-left">
                <span class="glyphicon glyphicon-info-sign"></span>
            </div>
            <div class="media-body">
                <h4 class="media-heading">O porquê disso?</h4>
                <p>A melhoria dos nossos serviços é uma busca contínua na Delos Serviços.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="media">
            <div class="media-left">
                <span class="glyphicon glyphicon-time"></span>
            </div>
            <div class="media-body">
                <h4 class="media-heading">Volte depois!</h4>
                <p>Após a conclusão dessa manutenção, esperamos anunciar novidades, que já estão em preparo e serão de grande valia para todos.</p>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="media">
            <div class="media-left">
                <span class="glyphicon glyphicon-envelope"></span>
            </div>
            <div class="media-body">
                <h4 class="media-heading">Entrar em contato!</h4>
                <p>Nossa equipe amigável está disponível online e pronta para ajudá-lo por e-mail.</p>
            </div>
        </div>
    </div>

</div>

</div>

@endsection
