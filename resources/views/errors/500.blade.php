<!DOCTYPE html>
<html>
<head>
    <title>Error 500</title>

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #FFF;
            display: table;
            background-color: #c0392b;
        }
        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            width: 80%;
            margin: auto;
            text-align: center;
            display: inline-block;
        }
        .alg-left {
            text-align: left;;
            display: inline-block;
        }
        hr {
            background-image: -webkit-linear-gradient(left, transparent, #dbdbdb, transparent);
            background-image: linear-gradient(to right, transparent, #dbdbdb, transparent);
            border: 0;
            height: 1px;
            margin: 22px 0;
        }
    </style>
</head>
<body>

<div class='container'>
    <div class="content">
        <div style="width:100%" class="alg-left">
            <h1 style="font-size:52px">(x_x) <span style="font-size:20px">Cód. 500</span></h1>
            <h1>Desculpe, ocorreu um problema em nossos servidores, estamos trabalhando duro para corrigir o mesmo.</h1>
            <h3>
                Tente novamente mais tarde, se mantiver o erro, entre em contato conosco imediatamente.
            </h3>
            <h3>
                Vá para a pagina inicial do site e tente acessar uma página a partir do menu de navegação.
            </h3>
            <p><button onclick="window.open('{{route('home.index')}}', '_self');">Ir para pagina inicial</button></p>
        </div>
    </div>
</div>
</body>
</html>
