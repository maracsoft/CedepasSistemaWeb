@extends('layout.plantilla')
@section('contenido')


<h1> BIENVENIDO </h1>
Version php: {{phpversion()}}


LA HORA ES {{Carbon\Carbon::now()}}


@endsection