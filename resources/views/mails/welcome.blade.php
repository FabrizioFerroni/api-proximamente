@extends('mails.master')
@section('tt')
    Bienvenido a mi portfolio
@endsection
@section('content')
<p>Hola, <strong> {{ $nombre }} </strong></p>
<p>
    Gracias por subcribirte en mi portfolio web.
    Te mantendre informado de los proximos avances del desarrollo.
</p>
<p>
    Tus datos con lo cual te registraste son:
    <br>
    <br>
    <strong>Correo Electrónico:</strong> <a href="mailto:{{$email}}">{{$email}}</a>, <br>
    <strong>Fecha de subcripcion:</strong> {{ $fecha_sub}}
</p>
<div class="center" style="display: flex; justify-content: center; align-items: center;">
    <p><a href="https://adelanto.fabriziodev.ar" target="_blank" class="miboton" style=" background-color: #FF3030; display: inline-block; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none;">Ir a mi ver un adelanto de mi portfolio</a></p>
</div>
<p>Gracias por confiar en Fabrizio DEV</p>
<p style="font-size: 13px">
    Si no quiere recibir mas correos con los adelantos puede hacer <a href="http://localhost:4200/darse-de-baja/{{ $email }}" target="_blank" style="text-decoration: none; color:#FF3030; ">click aquí</a>
</p>
@endsection
