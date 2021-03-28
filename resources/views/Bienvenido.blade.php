@extends('Layout.Plantilla')
@section('contenido')
<h1> BIENVENIDO </h1>
Version php: {{phpversion()}}


LA HORA ES {{Carbon\Carbon::now()}}
<
aqui voy a practicar el wizard

@endsection

