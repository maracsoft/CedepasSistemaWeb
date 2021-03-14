<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class RendicionGastos extends Model
{
    protected $table = "rendicion_gastos";
    protected $primaryKey ="codRendicionGastos";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codSolicitud','codigoCedepas','totalImporteRecibido',
    'totalImporteRendido','saldoAFavorDeEmpleado',
    'resumenDeActividad','estadoDeReposicion','fechaRendicion'];






    public function getPDF(){
        $listaItems = DetalleRendicionGastos::where('codRendicionGastos','=',$this->codRendicionGastos)->get();
        
        
        $pdf = \PDF::loadview('vigo.pdfRendicionGastos',
            array('rendicion'=>$this,'listaItems'=>$listaItems)
                            )->setPaper('a4', 'portrait');
        return $pdf;
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
        if($estado->codEstado == $this->codEstadoSolicitud)
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

    public function getNombreSede() {
        return $this->getSolicitud()->getNombreSede();

    }
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
                $color ='black';
                break;
            case $this::getCodEstado('Rechazada'):
                $color ='white';
                break;
        }
        return $color;
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

}
