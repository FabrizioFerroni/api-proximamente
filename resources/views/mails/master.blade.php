<!DOCTYPE html>
<html lang="es">
<head>
    {{-- Meta de la web --}}
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{-- Titulo de la web --}}
	<title>@yield('tt') | Fabrizio DEV</title>
	{{-- Favicon --}}
	<link rel="shortcut icon" href="{{ url('static/img/favicon.ico') }}" type="image/x-icon">
	{{-- Estilos CSS --}}
	{{-- <link rel="stylesheet" href="{{ url('static/css/bootstrap.min.css') }}"> --}}
	<link rel="stylesheet" href="{{ url('static/css/app.css?v='.time()) }}">
	{{-- Iconos --}}
	<script src="https://kit.fontawesome.com/7391b45a61.js" crossorigin="anonymous"></script>
	{{-- jQuery --}}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body style="margin: 0px; padding: 0px; background-color: #f3f3f3;">
    <div class="main" style="width: 60%; max-width: 728px; margin: 0 auto; display: block;">
        <img src="https://i.imgur.com/4T3YrZw.png" class="img-banner" style="width: 100%; display: block;">
        {{-- <img src="{{ url('static/img/mailencabezado.png') }}" class="img-banner" style="width: 100%; display: block;"> --}}
        <div class="content" style="background-color: #fff; padding: 24px;">
            {{-- Content --}}
            @yield('content')

        </div>
    </div>
</body>
</html>
