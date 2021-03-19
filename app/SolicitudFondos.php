<?php

namespace App;



use Illuminate\Database\Eloquent\Model;

class SolicitudFondos extends Model
{
    protected $table = "solicitud_fondos";
    protected $primaryKey ="codSolicitud";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    const RaizCodigoCedepas = "SOF";
    // le indicamos los campos de la tabla 
    protected $fillable = ['codProyecto','codigoCedepas','codEmpleadoSolicitante','fechaHoraEmision',
    'totalSolicitado','girarAOrdenDe','numeroCuentaBanco','codBanco','justificacion',
    'codEmpleadoEvaluador','fechaHoraRevisado','codEstadoSolicitud','observacion','codMoneda'];

    //le pasamos un modelo numeracion y calcula la nomeclatura del cod cedepas SOF21-000001
    public static function calcularCodigoCedepas($objNumeracion){
        return  SolicitudFondos::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                SolicitudFondos::rellernarCerosIzq($objNumeracion->numeroLibreActual,6);
    }
    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
        
    }


    public function getPDF(){
        $listaItems = DetalleSolicitudFondos::where('codSolicitud','=',$this->codSolicitud)->get();
        $pdf = \PDF::loadview('vigo.pdfSolicitudFondos',
            array('solicitud'=>$this,'listaItems'=>$listaItems)
                            )->setPaper('a4', 'portrait');

        return $pdf;
    }
    

    public function getDetalles(){
        return DetalleSolicitudFondos::where('codSolicitud','=',$this->codSolicitud)->get();

    }
    public function getNombreProyecto(){
        $proyecto = Proyecto::findOrFail($this->codProyecto);
        return $proyecto->nombre;
    } 
    public function getProyecto(){
        $proyecto = Proyecto::findOrFail($this->codProyecto);
        return $proyecto;
    } 

    public function getNombreEstado(){
        $estado = EstadoSolicitudFondos::findOrFail($this->codEstadoSolicitud);
        return $estado->nombre;

    }

    public function getNombreBanco(){
        $banco = Banco::findOrFail($this->codBanco);
        return $banco->nombreBanco;

    }


    /* Retorna el codigo del estado indicado por el str parametro */
    public static function getCodEstado($nombreEstado){
        $lista = EstadoSolicitudFondos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return 'Nombre no valido';
        
        return $lista[0]->codEstadoSolicitud;

    }


    public function estaRendida(){
        return $this->estaRendida==1;

    }
    /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
    public function verificarEstado($nombreEstado){

        

        $lista = EstadoSolicitudFondos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return false;
        
        $estado = $lista[0];
        if($estado->codEstadoSolicitud == $this->codEstadoSolicitud)
            return true;
        
        return false;
        

    }


    
    public function getFechaRevision(){
        if($this->fechaHoraRevisado == null )
        {
            return "---";
        }
        else{
            $stringFecha =$this->fechaHoraRevisado; 
            $stringFecha =   str_replace('-','/',$stringFecha);
            return $stringFecha;
        }

    }

    //MODIFICA EL VALOR PARA QUE SEA / en lugar de - 
    public function getFechaHoraEmision(){
        $stringFecha =$this->fechaHoraEmision; 
            $stringFecha =   str_replace('-','/',$stringFecha);
            return $stringFecha;

    }

    public function getNombreSolicitante(){
        $emp = Empleado::findOrFail($this->codEmpleadoSolicitante);
        return $emp->nombres.' '.$emp->apellidos;
    }

    public function getEmpleadoSolicitante(){
        return Empleado::findOrFail($this->codEmpleadoSolicitante);

    }

    public function getRendicion(){

        
        $rend = (RendicionGastos::where('codSolicitud','=',$this->codSolicitud)->get()) [0];
        return $rend;
    
    
    }

    public function getNombreMoneda(){
        $moneda = Moneda::findOrFail($this->codMoneda);
        return $moneda->nombre;
    }

    public function getMoneda(){
        $moneda = Moneda::findOrFail($this->codMoneda);
        return $moneda;
    }

    //retorna el objeto empleado del que lo revisó (su director / gerente)
    public function getEvaluador(){
        
        if($this->codEmpleadoEvaluador==null)
            return "";
        $e = Empleado::findOrFail($this->codEmpleadoEvaluador);
        return $e;
    }

    
    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoSolicitud){
            case $this::getCodEstado('Creada'): //CREADO
                $color = 'rgb(215,208,239)';
                break;
            case $this::getCodEstado('Aprobada'): //aprobado
                $color = 'rgb(91,79,148)';
                break;
            case $this::getCodEstado('Abonada'): //abonado
                $color = 'rgb(195,186,230)';
                break;
            case $this::getCodEstado('Contabilizada'): //rendida
                $color ='rgb(35,28,85)';
                break;
            case $this::getCodEstado('Observada'): //rechazada
                $color = 'rgb(248,18,8)';
                break;
            
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoSolicitud){
            case $this::getCodEstado('Creada'): //creada
                $color = 'black';
                break;
            case $this::getCodEstado('Aprobada')://aprobada
                $color = 'white';
                break;
            case $this::getCodEstado('Abonada'): //abonada
                $color = 'black';
                break;
            case $this::getCodEstado('Contabilizada'): //rendida
                $color = 'white';
                break;
            case $this::getCodEstado('Rechazada')://rechazada
                $color = 'white';
                break;
            
        }
        return $color;
    }
    public function getNombreEvaluador(){
        if($this->codEmpleadoEvaluador == null)
            return "";
        
        $ev = Empleado::findOrFail($this->codEmpleadoEvaluador);
        return $ev->getNombreCompleto();
    }



    /**ESCRIBIR NUMEROSSSSS */
    function escribirTotalSolicitado(){
        $n = $this->totalSolicitado;
        $arr=explode('.', $n);

        if(sizeof($arr)==1){
            $stringDecimal='00';
        }else if(strlen($arr[1])==1){
            $stringDecimal=$arr[1].'0';
        }else{
            $stringDecimal=$arr[1];
        }

        return $this->convertir($n).' Con '.$stringDecimal.'/100';
        //return $this->convertir($this->totalSolicitado);
    }

    function basico($numero) {
        $valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
        'nueve','diez', 'once','doce','trece','catorce','quince','diez y seis','diez y siete','diez y ocho','diez y nueve',
        'veinte','veintiuno','veintidos','veintitres', 'veinticuatro','veinticinco',
        'veintiséis','veintisiete','veintiocho','veintinueve');
        return $valor[$numero - 1];
    }
        
    function decenas($n) {
        $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
        70=>'setenta',80=>'ochenta',90=>'noventa');
        if( $n <= 29) return $this->basico($n);
        $x = $n % 10;
        if ( $x == 0 ) {
            return $decenas[$n];
        } else 
            return $decenas[$n - $x].' y '. $this->basico($x);
    }
        
    function centenas($n) {
        $cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
        400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
        700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
        if( $n >= 100) {
            if ( $n % 100 == 0 ) {
                return $cientos[$n];
            } else {
                $u = (int) substr($n,0,1);
                $d = (int) substr($n,1,2);
                return (($u == 1)?'ciento':$cientos[$u*100]).' '.$this->decenas($d);
            }
        } else 
            return $this->decenas($n);
    }
        
    function miles($n) {
        if($n > 999) {
            if( $n == 1000) {return 'mil';}
            else {
                $l = strlen($n);
                $c = (int)substr($n,0,$l-3);
                $x = (int)substr($n,-3);
                if($c == 1) {$cadena = 'mil '.$this->centenas($x);}
                else if($x != 0) {$cadena = $this->centenas($c).' mil '.$this->centenas($x);}
                else $cadena = $this->centenas($c). ' mil';
                return $cadena;
            }
        } else 
            return $this->centenas($n);
    }
        
    function millones($n) {
        if($n == 1000000) {return 'un millón';}
        else {
            $l = strlen($n);
            $c = (int)substr($n,0,$l-6);
            $x = (int)substr($n,-6);
            if($c == 1) {
                $cadena = ' millón ';
            } else {
                $cadena = ' millones ';
            }
            return $this->miles($c).$cadena.(($x > 0)?$this->miles($x):'');
        }
    }
    function convertir($n) {
        $sinMayusculas='';
        switch (true) {
            case ( $n >= 1 && $n <= 29) : 
                $sinMayusculas=$this->basico($n); break;
            case ( $n >= 30 && $n < 100) : 
                $sinMayusculas=$this->decenas($n); break;
            case ( $n >= 100 && $n < 1000) : 
                $sinMayusculas=$this->centenas($n); break;
            case ($n >= 1000 && $n <= 999999): 
                $sinMayusculas=$this->miles($n); break;
            case ($n >= 1000000): 
                $sinMayusculas=$this->millones($n); break;
        }
        return ucfirst($sinMayusculas);
    }

}
