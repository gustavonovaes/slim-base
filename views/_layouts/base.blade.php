<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="author" content="Gustavo Novaes">

    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/vendor/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" />

    <link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

    <link href="/assets/vendor/jgrowl/jquery.jgrowl.min.css" rel="stylesheet" />

    <link href="/assets/css/style.min.css" rel="stylesheet" />

    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />

    <style>

        html, body {
            min-height: 100% !important;
        }

        .page {
            width: 100%;
            height: 100%;

            padding-bottom: 30px;

            display: table;

            text-align: center;
        }

        footer {
            background-color: #222;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 10px;
            line-height: 30px;

            border-top: solid 1px #CCC;

            transition: height .5s, transform .5s;
        }

        footer:hover {
            height: 30px;
        }

        .browsehappy {
            position: fixed;
            top: 0; left: 0;

            width: 100%;
            height: 100%;

            z-index:9999;

            background-color: #000;
        }

        .browsehappy > div {

            position:absolute;
            top:50%; left:50%;

            width:768px;
            height:200px;

            margin:-100px 0 0 -384px;

            font-size: 1.7em;
            letter-spacing: 0.2em;

            color: #fafafa;

            text-align: center;
        }

    </style>

    @yield("style")

    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/vendor/jgrowl/jquery.jgrowl.min.js"></script>

    <title>
    @section('title')
        Slim-Base -
    @show
    </title>
</head>
<body class="no-select">

<!--[if lt IE 9]>
    <div class="browsehappy">
        <div>
           You are using a browser <strong>outdated</strong>. Please, <a href="http://browsehappy.com/">upgrade your browser</a>.
        </div>
    </div>
<![endif]-->

<div class="page">
    @yield("page")

    <footer class="text-center">
        &copy; Slim-Base by <a href="http://www.gnovaes.com.br">Gustavo Novaes</a>
    </footer>
</div>

<script src="/assets/js/main.min.js"></script>
@yield('script')

</body>
</html>