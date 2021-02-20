<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        html {
            /* Arriba | Derecha | Abajo | Izquierda */
            margin: 30pt 70pt 30pt 70pt;
            font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        }
        #principal { 
            /*background-color: rgb(161, 51, 51);*/
            word-wrap: break-word;/* para que el texto no salga del div*/
        }
        p {

        }
        
    </style>
    <?php
        date_default_timezone_set('America/Lima');
        //PASAR LA FECHA A ESPAÑOL
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        $fechaActual = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        $fechaInicio = $diassemana[date('w', strtotime($contrato->fechaInicio))]." ".date('d', strtotime($contrato->fechaInicio))." de ".$meses[date('n', strtotime($contrato->fechaInicio))-1]. " del ".date('Y', strtotime($contrato->fechaInicio)) ;
        $fechaFin = $diassemana[date('w', strtotime($contrato->fechaFin))]." ".date('d', strtotime($contrato->fechaFin))." de ".$meses[date('n', strtotime($contrato->fechaFin))-1]. " del ".date('Y', strtotime($contrato->fechaFin)) ;

        $letras = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
    ?>
    
</head>
<body>
    <div id="principal" style="width: 600px; height: 70px;">
        <div style="width: 20%; height: 70px; float: left;">
            <img src="/GencoImg/LogoCedepas.jpg">
        </div>
        <div style="width: 20%; height: 70px; float: right;">
            <p style="color:#817e7e; text-align: right;">T-00{{$contrato->codPeriodoEmpleado}}-2021</p>
        </div>
    </div>
    <div id="principal" style="width: 600px; height: 850px;">
        <p style="text-align: center;"><u><b>CONTRATO LOCACION DE SERVICIOS</b></u></p>
        <p style="text-align: justify;">
            Conste por el presente documento el CONTRATO DE LOCACIÓN DE SERVICIOS,que celebran de una parte el
            Centro Ecuménico de Promoción y Acción Social Norte – CEDEPAS Norte, con domicilio legal en Calle Los
            Corales N° 289 Urb. Santa Inés de la ciudad de Trujillo, con RUC N° 20481234574, representado por su Directora
            General, señora ANA CECILIA ANGULO ALVA , identificada con DNI. N° 26682689, a quien en adelante se le
            denominará CEDEPAS Norte; y de la otra parte el señor<b>{{$contrato->empleado->apellidos}}, {{$contrato->empleado->nombres}}</b>, identificado con DNI N° <b>{{$contrato->empleado->dni}}</b> ,con
            domicilio legal en <b>{{$contrato->empleado->direccion}}</b>,a quien en adelante se le
            denominará <b>EL CONTRATADO</b>; bajo las cláusulas siguientes:
        </p>
        <p><u><b>PRIMERO</b></u></p>
        <p style="text-align: justify;">
            El Centro Ecuménico de Promoción y Acción Social Norte – CEDEPAS Norte, es una asociación civil de derecho
            privado. CEDEPAS Norte se dedica a “Fortalecer las capacidades de varones y mujeres: líderes de sociedad civil,
            pequeños y medianos productores emprendedores, funcionarios y autoridades de gobiernos regionales y
            locales, a través de: La consolidación de la gobernabilidad local, la institucionalidad democrática y el capital
            social. La gestión sostenible de los recursos naturales y el ambiente, con énfasis en el agua. El desarrollo de
            iniciativas sostenibles y rentables de sectores económicos que dinamicen la macro región norte del Perú”.
            Acorde con su objeto social, CEDEPAS Norte ejecuta proyectos en diferentes zonas del Perú.
            EL CEDEPAS Norte tiene la calificación de CITE Agropecuario, el mismo que tiene como objetivo: “Fortalecer
            capacidades de innovación tecnológica, gestión organizacional y comercial de las empresas asociativas y
            MIPYMEs del sector agroindustrial; contribuyendo a mejorar la calidad del empleo y los ingresos económicos;
            como resultado del incremento de la competitividad con enfoque inclusivo en las líneas de negocio: frutales,
            productos derivados pecuarios y hortalizas”.
        </p>
        <p><u><b>SEGUNDO</b></u></p>
        <p style="text-align: justify;">
            En virtud a los lineamientos de su misión y para la consecución de los objetivos institucionales, CEDEPAS Norte
            conviene en solicitar los servicios de <b>EL CONTRATADO</b>, para <b>"{{$contrato->motivo}}"</b>; según los términos 
            de referencia adjuntos, que forman parte del presente contrato.
        </p>
        <p><u><b>TERCERO</b></u></p>
        <p style="text-align: justify;">
            El tiempo asignado para el cumplimiento del contrato y entrega de los productos es del <b>{{$fechaInicio}}</b> al <b>{{$fechaFin}}</b>. 
            El tiempo de contratación ha sido determinado en función al cronograma de productos.
            El presente contrato concluirá para ambas partes el día señalado en el párrafo anterior, sin que sea necesaria
            comunicación alguna por parte de CEDEPAS NORTE.
        </p>
        <p><u><b>CUARTO</b></u></p>
        <p style="text-align: justify;">
            Como contraprestación por sus servicios, CEDEPAS NORTE abonará a <b>EL CONTRATADO</b> una retribución total de
            S/ {{number_format($contrato->sueldoFijo,2)}} ,que incluye todo concepto de pago, la misma que estará sujeta a
            descuentos y retenciones de acuerdo a la ley y se cancelará previa presentación de recibo por honorarios de
            acuerdo al siguiente detalle:
        </p>
        <p>
            @foreach($contrato->avances as $i => $itemavance)
            <b>{{$letras[$i]}})</b> S/ {{number_format($itemavance->monto,2)}} correspondiente al {{number_format($itemavance->porcentaje,2)}} %, a la presentación del Producto N°{{$i+1}}: {{$itemavance->descripcion}}<br>    
            @endforeach
        </p>
        <p><u><b>QUINTO</b></u></p>
        <p style="text-align: justify;">
            Por tratarse de LOCACIÓN DE SERVICIOS, <b>EL CONTRATADO</b>, NO tiene relación alguna de dependencia laboral
            con CEDEPAS Norte, en consecuencia, este contrato no otorga derecho de vacaciones, compensación por
            tiempo de servicios, ni otros beneficios sociales. <b>EL CONTRATADO</b> ,NO está sujeto a un horario de trabajo
            establecido.
        </p>
        <p><u><b>SEXTO</b></u></p>
        <p style="text-align: justify;">
            <b>EL CONTRATADO</b>, se obliga por el presente contrato a prestar sus servicios descritos en la cláusula segunda del
            mismo, con eficiencia, esmero y lealtad. <b>CEDEPAS Norte</b>, es propietario de toda información que se obtenga o
            elabore durante la vigencia del presente contrato. Así mismo se obliga a mantener confidencialidad y reserva
            durante y después de la vigencia del presente contrato, respecto de las informaciones que le sean
            proporcionadas para el desarrollo de la consultoría. En ese sentido <b>EL CONTRATADO</b> no deberá usar, divulgar,
            reproducir, compartir, aprovechar y/o trasladar a terceros cualquier documento, proyecto, método, conocimiento y 
            otros que durante la prestación de sus servicios haya tenido acceso, le hayan proporcionado o
            haya llegado a su poder.
        </p>
        <p><u><b>SEPTIMO</b></u></p>
        <p style="text-align: justify;">
            <b>EL CONTRATADO</b>, está obligado a contar con un seguro de salud vigente durante la vigencia del contrato,
            precisando que <b>CEDEPAS Norte</b> no cubrirá gastos de curación por accidentes ni enfermedades que pudieran
            producirse durante la prestación del servicio.
        </p>
        <p><u><b>OCTAVO</b></u></p>
        <p style="text-align: justify;">
            Son aplicables al presente contrato, en lo que corresponda, las normas que contiene el Código Civil vigente en
            los artículos 1764 al 1770 y demás normas conexas que se dicen durante la vigencia del mismo. Cualquiera de las
            partes podrá resolver el presente contrato por causas justificadas.
        </p>
        <p><u><b>NOVENO</b></u></p>
        <p style="text-align: justify;">
            Los contratantes fijan como sus domicilios los indicados en la introducción del presente contrato, en donde se
            tendrán por bien efectuadas las comunicaciones y/o notificaciones que se cursen a los efectos derivados de la
            ejecución contractual. Asimismo, declaran estar plenamente de acuerdo con los términos y condiciones
            expresadas en el presente contrato, sometiéndose a la jurisdicción y competencia de los jueces y tribunales de
            ciudad de <b>Trujillo</b>.
        </p>
        <p>
            En señal de conformidad, ambas partes firman el presente contrato en <b>Trujillo, {{$fechaActual}}</b>.
        </p>
    </div>
    <div id="principal" style="width: 600px; height: 30px;">
        <div style="width: 5%; height: 30px; float: left;">
            
        </div>
        <div style="width: 40%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 11pt;"><b>
                _______________________<br>
                ANA CECILIA ANGULO ALVA<br>
                DNI: 26682698<br>
                DIRECTORA GENERAL
            </b></p>
        </div>
        <div style="width: 10%; height: 30px; float: left;">
        </div>
        <div style="width: 40%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 11pt;"><b>
                _______________________<br>
                {{strtoupper($contrato->empleado->nombres)}} {{strtoupper($contrato->empleado->apellidos)}}<br>
                DNI: {{$contrato->empleado->dni}}<br>
                EL TRABAJADOR
            </b></p>
        </div>
        <div style="width: 5%; height: 30px; float: left;">
        </div>
    </div>
</body>

</html>