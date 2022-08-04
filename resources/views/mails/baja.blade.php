@extends('mails.master')
@section('tt')
    Lo siento
@endsection
@section('content')
<p>Hola, <strong> {{ $nombre }} </strong></p>
<p>
    Lo siento mucho por hacerte spam con mis noticias.
    Prometo que no te va a llegar ningun mail mas.
</p>
<p>
    Tus datos con lo cual te habias subscripto son:
    <br>
    <br>
    <strong>Correo Electrónico:</strong> <a href="mailto:{{$email}}">{{$email}}</a>, <br>
    <strong>Fecha de subcripcion:</strong> {{ $fecha_sub}}, <br>
    <strong>Fecha de baja subcripción:</strong> {{ $fecha_baja}}
</p>
{{-- <div class="center" style="display: flex; justify-content: center; align-items: center;">
    <p><a href="https://adelanto.fabriziodev.ar" target="_blank" class="miboton" style=" background-color: #FF3030; display: inline-block; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none;">Ir a mi ver un adelanto de mi portfolio</a></p>
</div> --}}
<p>Gracias por confiar en Fabrizio DEV</p>
<p style="font-size: 13px">
    Si seguis recibiendo correos por favor ponte en contacto conmigo. <a href="mailto:info@fabriziodev.ar" target="_blank" style="text-decoration: none; color:#FF3030; ">info@fabriziodev.ar</a>. Gracias
</p>
@endsection
