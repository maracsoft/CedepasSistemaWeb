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

        //SACAR HORAS TOTALES SEMANALES DE TRABAJO
        switch ($contrato->turno->codTipoTurno) {
            case 1:
                $horasMañana = date('H', strtotime($contrato->turno->horaFin))-date('H', strtotime($contrato->turno->horaInicio));
                $horasTarde = 0;
                break;
            case 2:
                $horasMañana = 0;
                $horasTarde = date('H', strtotime($contrato->turno->horaFin2))-date('H', strtotime($contrato->turno->horaInicio2));;
                break;
            case 3:
                $horasMañana = date('H', strtotime($contrato->turno->horaFin))-date('H', strtotime($contrato->turno->horaInicio));
                $horasTarde = date('H', strtotime($contrato->turno->horaFin2))-date('H', strtotime($contrato->turno->horaInicio2));
                break;
        }
        $horasSemanales=($horasMañana+$horasTarde)*5;
    ?>
    
</head>
<body>
    <div id="principal" style="width: 600px; height: 70px;">
        <div style="width: 20%; height: 70px; float: left;">
            
        </div>
        <div style="width: 20%; height: 70px; float: right;">
            <p style="color:#817e7e; text-align: right;">T-00{{$contrato->codPeriodoEmpleado}}-2021</p>
        </div>
    </div>
    <div id="principal" style="width: 600px; height: 850px;">
        <p style="text-align: center;"><u><b>CONTRATO DE TRABAJO SUJETO A MODALIDAD</b></u></p>
        <p style="text-align: justify;">
            Conste por el presente documento el CONTRATO SUJETO A MODALIDAD ,que celebran de una parte el Centro
            Ecuménico de Promoción y Acción Social Norte – CEDEPAS Norte, con domicilio legal en Calle Los Corales N° 289
            Urb. Santa Inés de la ciudad de Trujillo, con RUC N° 20481234574, representado por su Directora General, señora
            ANA CECILIA ANGULO ALVA , identificada con DNI. N° 26682689, a quien en adelante se le denominará <b>EL
            EMPLEADOR</b>; y de la otra parte el señor <b>{{$contrato->empleado->apellidos}}, {{$contrato->empleado->nombres}}</b>, identificado con DNI N° <b>{{$contrato->empleado->dni}}</b> ,con
            domicilio legal en <b>{{$contrato->empleado->direccion}}</b>, a quien en adelante se le denominará <b>EL TRABAJADOR</b>; bajo las
            cláusulas siguientes:
        </p>
        <p><u><b>PRIMERO</b></u></p>
        <p style="text-align: justify;">
            <b>EL EMPLEADOR</b> se dedica a “Fortalecer las capacidades de varones y mujeres: líderes de sociedad civil,
            pequeños y medianos productores emprendedores, funcionarios y autoridades de gobiernos regionales y
            locales, a través de: La consolidación de la gobernabilidad local, la institucionalidad democrática y el capital
            social. La gestión sostenible de los recursos naturales y el ambiente, con énfasis en el agua. El desarrollo de
            iniciativas sostenibles y rentables de sectores económicos que dinamicen la macro región norte del Perú”.
            Acorde con su objeto social, CEDEPAS Norte ejecuta proyectos en diferentes zonas de acción.
            EL CEDEPAS Norte tiene la calificación de CITE Agropecuario, el mismo que tiene como objetivo: “Fortalecer
            capacidades de innovación tecnológica, gestión organizacional y comercial de las empresas asociativas y
            MIPYMEs del sector agroindustrial; contribuyendo a mejorar la calidad del empleo y los ingresos económicos;
            como resultado del incremento de la competitividad con enfoque inclusivo en las líneas de negocio: frutales,
            productos derivados pecuarios y hortalizas”.
        </p>
        <p><u><b>SEGUNDO</b></u></p>
        <p style="text-align: justify;">
            Para el cumplimiento de su objeto social, <b>EL EMPLEADOR</b> ha obtenido financiamiento de <b>{{$contrato->nombreFinanciador}}</b> para
            implementar el proyecto denominado: <b>“{{$contrato->proyecto()->nombre}}”</b>. En virtud del mismo, <b>EL EMPLEADOR</b> contrata a <b>EL
            TRABAJADOR</b>, para desempeñar el cargo de <b>{{$contrato->puesto->nombre}}</b> dentro del proyecto. <b>EL TRABAJADOR</b> se
            obliga a cumplir con las actividades descritas en los Términos de Referencia que dieron origen a su
            contratación, el cual forma parte del presente contrato. La descripción de las tareas y funciones es simplemente
            enunciativa y no limitativa. <b>EL EMPLEADOR</b> puede disponer que <b>EL TRABAJADOR</b> realice cualquier función
            siempre que sea análoga o similar a las descritas para la ejecución del proyecto en mención.
        </p>
        <p><u><b>TERCERO</b></u></p>
        <p style="text-align: justify;">
            El presente Contrato se celebra a plazo determinado, el mismo que se inicia el <b>{{$fechaInicio}}</b>
            @if($contrato->fechaFin!=null)
            y concluye el <b>{{$fechaFin}}</b>.
            @else
            y sin conclusion definida.
            @endif
             En todo caso, el Contrato se entenderá concluido en la fecha de su vencimiento, sin
            necesidad de comunicación alguna a <b>EL TRABAJADOR</b> por parte de <b>EL EMPLEADOR</b>. El Contrato se celebra al
            amparo de artículo 63º del Decreto Supremo 003-97–TR- Ley de Productividad y Competitividad Laboral, bajo la
            modalidad de “Contrato para Obra y Servicio” y la submodalidad de “Contrato para Servicio Específico”,
            teniendo en cuenta el carácter temporal de las labores a realizar por <b>EL TRABAJADOR</b>, para encargarse de las
            labores descritas en razón de las causas objetivas que en ella se precisan.
        </p>
        <p><u><b>CUARTO</b></u></p>
        <p style="text-align: justify;">
            <b>EL TRABAJADOR</b> percibirá como contraprestación por sus labores una remuneración mensual bruta
            equivalente a <b>S/ {{number_format($contrato->sueldoFijo,2)}}</b>, más la asignación familiar equivalente a S/ 93.00
            (Noventa y tres con 00/100 Soles), y los aumentos de Ley y aquellos otros que voluntaria y unilateralmente
            decida <b>EL EMPLEADOR</b>.
        </p>
        <p><u><b>QUINTO</b></u></p>
        <p style="text-align: justify;">
            <b>EL TRABAJADOR</b> se encuentra obligado a cumplir con una jornada de {{$horasSemanales}} horas semanales en la sede
            asignada, de lunes a viernes, de acuerdo al horario que establezca <b>EL EMPLEADOR</b>, el mismo que
            eventualmente incluye el desplazamiento a las zonas de los proyectos que ejecute <b>EL EMPLEADOR</b>.
            En razón de la naturaleza de sus obligaciones, <b>EL EMPLEADOR</b> reconoce que <b>EL TRABAJADOR</b> desempeñará
            sus labores parcialmente fuera del centro de trabajo, no encontrándose sujeto a fiscalización inmediata, ni
            obligado a registrarse en el Registro de Control de Asistencia.
        </p>
        <p><u><b>SEXTO</b></u></p>
        <p style="text-align: justify;">
            <b>EL TRABAJADOR</b> y <b>EL EMPLEADOR</b>, pactan las siguientes condiciones especiales, que regularán la ejecución del presente contrato: <br>
            <b>a)</b> <b>EL TRABAJADOR</b> se compromete a cumplir los reglamentos internos, normas y procedimientos
            establecidos por <b>EL EMPLEADOR</b>, así como el Código de Ética que forma parte del presente contrato. <br>
            <b>b)</b> <b>EL TRABAJADOR</b> se compromete a no brindar servicios similares a los contratados por <b>EL EMPLEADOR</b>
            a terceras personas, sin autorización expresa de <b>EL EMPLEADOR</b>. <br>
            <b>c)</b> <b>EL EMPLEADOR</b> tendrá la titularidad de los derechos de autor de todos los reportes, propuestas,
            compilaciones, sistematizaciones, investigaciones, materiales educativos e información que se obtenga o
            elabore en virtud de la ejecución del presente contrato. <b>EL EMPLEADOR</b> reconocerá la autoría y derechos
            morales de <b>EL TRABAJADOR</b> en todo trabajo o investigación donde haya participado <b>EL TRABAJADOR</b>. <br>
            <b>d)</b> <b>EL TRABAJADOR</b>, se compromete a guardar confidencialidad y reserva de la información a la que
            acceda en virtud del presente contrato. <br>
            <b>e)</b> <b>EL TRABAJADOR</b> no podrá ofrecer o brindar declaraciones a los medios de comunicación sobre
            asuntos institucionales, sin la autorización expresa de <b>EL EMPLEADOR</b>. <br>
            <b>f)</b> <b>EL TRABAJADOR</b> se compromete a realizar los exámenes médicos que resulten necesarios para
            verificar su buen estado de salud, de conformidad con el inciso c) del artículo 23º del Decreto Supremo
            003-97-TR, que aprueba el Texto Único Ordenado de la Ley de Productividad y Competitividad Laboral. <br>
            <b>g)</b> <b>EL TRABAJADOR</b> se compromete a no establecer relaciones personales de negocios o profesionales
            con las instituciones, organizaciones sociales y beneficiarios, relacionadas con los programas a su cargo. <br>
            <b>h)</b> <b>EL TRABAJADOR</b> se compromete a proporcionar información fidedigna y oportuna sobre las
            actividades realizadas, resultados obtenidos y recursos utilizados en el desempeño de su cargo. <br>
            <b>i)</b> <b>EL EMPLEADOR</b> reconoce la vigencia del principio de igualdad de trato y no discriminación por razón del
            género, y declara que los trabajadores de uno u otro sexo en las Organizaciones No Gubernamentales
            tienen los mismos derechos y obligaciones. <br>
            <b>j)</b> <b>EL EMPLEADOR</b> declara que la presente relación contractual se formaliza dentro de un marco contrario
            a toda practica de corrupción y se inspira en el enfoque de integridad, contenido en la Política Nacional de
            Integridad y Lucha contra la Corrupción, aprobado mediante Decreto Supremo N 092-2017-PCM. En tal
            sentido <b>EL TRABAJADOR</b> se compromete a cumplir las políticas y normas institucionales para la
            transparencia y administración de los recursos a su cargo. <br>
            <b>k)</b> <b>EL EMPLEADOR</b> declara que las prácticas de contratación empleadas se encuentran alineadas al
            enfoque de protección y salvaguarda de los niños, niñas y adolescentes, siendo contrarios a toda forma
            de trabajo y explotación infantil o posición de dominio sobre los derechos de los jóvenes.
        </p>
        <p><u><b>SEPTIMO</b></u></p>
        <p style="text-align: justify;">
            El presente contrato puede ser modificado por acuerdo de las partes y le son aplicables las normas
            fundamentales en materia de trabajo, seguridad y salud en el trabajo, y seguridad social establecidas en el Perú
            para todos los trabajadores del régimen laboral de la actividad privada.
        </p>
        <p><u><b>OCTAVO</b></u></p>
        <p style="text-align: justify;">
            En caso de alguna diferencia sobre cualquier aspecto derivado o vinculado a la ejecución del presente contrato
            las partes buscarán y propiciarán una solución conciliada y directa, en su defecto expresamente se someten a
            las autoridades de la Corte Superior de Justicia de Trujillo.
            Se firma en la ciudad de Trujillo el <b>{{$fechaActual}}</b>.
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