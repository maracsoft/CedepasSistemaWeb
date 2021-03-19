<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class RendicionGastos extends Model
{
    protected $table = "rendicion_gastos";
    protected $primaryKey ="codRendicionGastos";

    const raizArchivo = "RendGast-CDP-";
    const RaizCodigoCedepas = "REN";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codSolicitud','codigoCedepas','totalImporteRecibido',
    'totalImporteRendido','saldoAFavorDeEmpleado',
    'resumenDeActividad','codEstadoRendicion','fechaRendicion',
    'cantArchivos','terminacionesArchivos','codEmpleadoEvaluador'];


    public static function calcularCodigoCedepas($objNumeracion){
        return  RendicionGastos::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                RendicionGastos::rellernarCerosIzq($objNumeracion->numeroLibreActual,6);
    }
  

    public function borrarArchivosCDP(){ //borra todos los archivos que sean de esa rendicion
        
        $vectorTerminaciones = explode('/',$this->terminacionesArchivos);
        
        for ($i=1; $i <=  $this->cantArchivos; $i++) { 
            $nombre = $this::raizArchivo.
                        $this->rellernarCerosIzq($this->codRendicionGastos,6).
                        '-'.
                        $this->rellernarCerosIzq($i,2).
                        '.'.
                        $vectorTerminaciones[$i-1];
            Storage::disk('rendiciones')->delete($nombre);
            Debug::mensajeSimple('Se acaba de borrar el archivo:'.$nombre);
            
        }
    }


    //               RendGast-CDP-   000002                           -   5   .  jpg
    public static function getFormatoNombreCDP($codRendicionGastos,$i,$terminacion){
        return  RendicionGastos::raizArchivo.
                RendicionGastos::rellernarCerosIzq($codRendicionGastos,6).
                '-'.
                RendicionGastos::rellernarCerosIzq($i,2).
                '.'.
                $terminacion;
    }

    //retorna vector de strings 
    public function getVectorTerminaciones(){
        return explode('/',$this->terminacionesArchivos);
    }

    //la primera es la 1 OJO
    public function getTerminacionNro($index){
        $vector = explode('/',$this->terminacionesArchivos);
        return $vector[$index-1];

    }

    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
 
     }
    

    public function getPDF(){
        $listaItems = DetalleRendicionGastos::where('codRendicionGastos','=',$this->codRendicionGastos)->get();
        
        
        $pdf = \PDF::loadview('ProvisionFondos.pdfRendicionGastos',
            array('rendicion'=>$this,'listaItems'=>$listaItems)
                            )->setPaper('a4', 'portrait');
        return $pdf;
    }

    public function getNombreEvaluador(){
        if($this->codEmpleadoEvaluador == null)
            return "";
        
        $ev = Empleado::findOrFail($this->codEmpleadoEvaluador);
        return $ev->getNombreCompleto();
    }


    /* Retorna el codigo del estado indicado por el str parametro */
    public static function getCodEstado($nombreEstado){
        $lista = EstadoRendicionGastos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return 'Nombre no valido';
        
        return $lista[0]->codEstadoRendicion;

    }

    /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
    public function verificarEstado($nombreEstado){
        $lista = EstadoRendicionGastos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return false;
        
        
        $estado = $lista[0];
        
        if($estado->codEstadoRendicion == $this->codEstadoRendicion)
            return true;
        
        return false;
        
    }


    //calcula el siguiente numero libre para ser usado como nroEnRendicion
    //este siempre va en aumento, si hubiera el caso en el que están siendo usados el 1 4 6, el mayorLibre sería el 7
    /* public function calcularMayorLibre(){
        $listaDetalles = DetalleRendicionGastos::where(
            'codRendicionGastos','=',$this->codRendicionGastos)->get();
        $mayor=0;
        for ($i=0; $i <count($listaDetalles) ; $i++) { 
           
            if( $mayor < $listaDetalles[$i]->nroEnRendicion)
                $mayor = $listaDetalles[$i]->nroEnRendicion;
        }

        return $mayor+1;
    } */

    
    public function getNombreSolicitante(){
        return $this->getSolicitud()->getNombreSolicitante();
    }
    public function getEmpleadoSolicitante(){
        return $this->getSolicitud()->getEmpleadoSolicitante();
    }

    public function getNombreProyecto(){
        return $this->getSOlicitud()->getNombreProyecto();
    }

    public function getFechaRendicion(){
        return $this->fechaRendicion;

    }

    //VER EXCEL https://docs.google.com/spreadsheets/d/1eBQV5QZJ6dTlFtu-PuF3i71Cjg58DIbef2qI0ZqKfoI/edit#gid=1819929291
    public function getNombreEstado(){ 
        $estado = EstadoRendicionGastos::findOrFail($this->codEstadoRendicion);
        return $estado->nombre;

    }

    


    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoRendicion){
            case $this::getCodEstado('Creada'): 
                $color = 'rgb(215,208,239)';
                break;
            case $this::getCodEstado('Aprobada'):
                $color = 'rgb(91,79,148)';
                break;
            case $this::getCodEstado('Contabilizada'):
                $color = 'rgb(195,186,230)';
                break;
            case $this::getCodEstado('Observada'):
                $color ='rgb(35,28,85)';
                break;
            case $this::getCodEstado('Subsanada'):
                $color ='rgb(35,28,85)';
                break;
            case $this::getCodEstado('Rechazada'):
                $color ='rgb(35,28,85)';
                break;
                                    
            
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoRendicion){
            case $this::getCodEstado('Creada'): 
                $color = 'black';
                break;
            case $this::getCodEstado('Aprobada'):
                $color = 'white';
                break;
            case $this::getCodEstado('Contabilizada'):
                $color = 'black';
                break;
            case $this::getCodEstado('Observada'):
                $color = 'white';
                break;
            case $this::getCodEstado('Subsanada'):
                $color ='white';
                break;
            case $this::getCodEstado('Rechazada'):
                $color ='white';
                break;
        }
        return $color;
    }

    public function getMoneda(){
        return $this->getSolicitud()->getMoneda();
    }

    public function getSolicitud(){
        return SolicitudFondos::findOrFail($this->codSolicitud);

    }

    public static function reportePorSedes($fechaI, $fechaF){
        $listaX = DB::select('
        select sede.nombre as "Sede", SUM(RG.totalImporteRendido) as "Suma_Sede"
        from rendicion_gastos RG
            inner join solicitud_fondos USING(codSolicitud)
            inner join sede USING(codSede)
            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
            GROUP BY sede.nombre;
        ');
        return $listaX;

    }
    


    public static function reportePorEmpleados($fechaI, $fechaF){
        $listaX = DB::select('
                    select E.nombres as "NombreEmp", SUM(RG.totalImporteRendido) as "Suma_Empleado"
                        from rendicion_gastos RG
                            inner join solicitud_fondos SF USING(codSolicitud)
                            inner join empleado E on E.codEmpleado = SF.codEmpleadoSolicitante 
                            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                            GROUP BY E.nombres;
                            ');
        return $listaX;
         

    } 
    public static function reportePorProyectos($fechaI, $fechaF){
        
        $listaX = DB::select('
        select P.nombre as "NombreProy", SUM(RG.totalImporteRendido) as "Suma_Proyecto"
        from rendicion_gastos RG
            inner join solicitud_fondos SF USING(codSolicitud)
            inner join proyecto P on P.codProyecto = SF.codProyecto 
            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
            GROUP BY P.nombre;
            ');

        return $listaX;

    }


    public static function reportePorSedeYEmpleados($fechaI, $fechaF, $idSede){
        $sede = Sede::findOrFail($idSede);
        $listaX = DB::select('
        select E.nombres as "NombreEmp", SUM(RG.totalImporteRendido) as "Suma_Empleado"
            from rendicion_gastos RG
                inner join solicitud_fondos SF USING(codSolicitud)
                inner join empleado E on E.codEmpleado = SF.codEmpleadoSolicitante 
                where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                and SF.codSede = "'.$sede->codSede.'"
                GROUP BY E.nombres;
                ');     
        return $listaX;

    }

    /**ESCRIBIR NUMEROSSSSS */
    function escribirImporteRecibido(){
        return $this->convertir($this->totalImporteRecibido);
    }
    function escribirImporteRendido(){
        return $this->convertir($this->totalImporteRendido);
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
        switch (true) {
            case ( $n >= 1 && $n <= 29) : 
                return $this->basico($n); break;
            case ( $n >= 30 && $n < 100) : 
                return $this->decenas($n); break;
            case ( $n >= 100 && $n < 1000) : 
                return $this->centenas($n); break;
            case ($n >= 1000 && $n <= 999999): 
                return $this->miles($n); break;
            case ($n >= 1000000): 
                return $this->millones($n); break;
        }
    }

}
