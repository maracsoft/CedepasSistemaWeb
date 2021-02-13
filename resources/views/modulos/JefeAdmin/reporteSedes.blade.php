@extends ('layout.plantilla')





@section('contenido')
<div>
  <h3> REPORTES </h3>


 

</div>

@section('script')


@endsection

@section('estilos') {{-- IMPORTAMOS LOS ESTILOS PARA EL GRÁFICO PIE --}}
  <style type="text/css">
   * {
    box-sizing: border-box;    
}
.grafico {
    height: 200px;
    margin: 1rem auto;
    position: relative;
    width: 200px;
      } 
.recorte {
    border-radius: 50%;
    clip: rect(0px, 200px, 200px, 100px);
    height: 100%;
    position: absolute;
    width: 100%;
     }
.quesito {
    border-radius: 50%;
    clip: rect(0px, 100px, 200px, 0px);
    height: 100%;
    position: absolute;
    width: 100%;
    font-family: monospace;
    font-size: 1.5rem;
     }
.sombra {
    background-color: #fff;
    border-radius: 50%;
    box-shadow: 0 4px 7px rgba(0, 0, 0, 0.3);
    border: 5px solid #000;
    height: 100%;
    position: absolute;
    width: 100%;
     }

#porcion1 {
    transform: rotate(0deg);
     }

#porcion1 .quesito {
    background-color: rgba(0,0,255,.7);
    transform: rotate(70deg);
     }
#porcion2 {
    transform: rotate(70deg);
     }
#porcion2 .quesito {
    background-color: rgba(255,255,0,.7);
    transform: rotate(120deg);
     }
#porcion3 {
    transform: rotate(-170deg);
     }
#porcion3 .quesito {
    background-color: rgba(0,128,0,.7);
    transform: rotate(25deg);
     }
#porcionFin {
    transform:rotate(-145deg);
     }
#porcionFin .quesito {
    background-color: rgba(255,0,0,.7);
    transform: rotate(145deg);
     }
#porcion1 .quesito:after {
    content: attr(data-rel);
    left: 25%;
    line-height: 5;
    position: absolute;
    top: 0;
    transform: rotate(-70deg);
}
#porcion2 .quesito:after {
    content: attr(data-rel);
    left: 15%;
    position: absolute;
    top: 30%; 
    transform: rotate(-190deg);
}
#porcion3 .quesito:after {
    content: attr(data-rel);
    left: 35%;
    position: absolute;
    top: 4%;
    transform: rotate(70deg);
}
#porcionFin .quesito:after {
   content: attr(data-rel);
   left: 10%;
   position: absolute;
   top: 30%;
}
  </style>
@endsection