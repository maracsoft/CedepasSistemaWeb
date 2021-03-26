<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Collection;
class ReposicionGastos extends Model
{
    protected $table = "reposicion_gastos";
    protected $primaryKey ="codReposicionGastos";

    public $timestamps = false;  //para que no trabaje con los campos fecha 
    const raizArchivo = "RepGast-CDP-";
    const RaizCodigoCedepas = "REP";

    // le indicamos los campos de la tabla 
    protected $fillable = ['codEstadoReposicion','codEmpleadoSolicitante','codEmpleadoEvaluador','codEmpleadoAdmin','codEmpleadoConta',
    'codProyecto','codMoneda','totalImporte',
    'fechaHoraEmision','codigoCedepas','girarAOrdenDe','codBanco','resumen',
    'fechaHoraRevisionGerente','fechaHoraRevisionAdmin','fechaHoraRevisionConta','observacion'];


    public static function calcularCodigoCedepas($objNumeracion){
        return  ReposicionGastos::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                ReposicionGastos::rellernarCerosIzq($objNumeracion->numeroLibreActual,6);
    }

    public function getFechaHoraEmision(){
        return str_replace('-','/',$this->fechaHoraEmision);

    }

    public function getFechaHoraRevisionGerente(){
        return str_replace('-','/',$this->fechaHoraRevisionGerente);


    }

    public function getFechaHoraRevisionAdmin(){
        return str_replace('-','/',$this->fechaHoraRevisionAdmin);


    }

    public function getFechaHoraRevisionConta(){
        return str_replace('-','/',$this->fechaHoraRevisionConta);


    }

    

    

    public function getPDF(){
        $reposicion = $this;
        $detalles=$this->detalles();
        $pdf = \PDF::loadview('ReposicionGastos.pdfReposicion',
            compact('reposicion','detalles'))
            ->setPaper('a4', 'portrait');
        return $pdf;
    }

    //               RendGast-CDP-   000002                           -   5   .  jpg
    public static function getFormatoNombreCDP($codRendicionGastos,$i,$terminacion){
        return  ReposicionGastos::raizArchivo.
                ReposicionGastos::rellernarCerosIzq($codRendicionGastos,6).
                '-'.
                ReposicionGastos::rellernarCerosIzq($i,2).
                '.'.
                $terminacion;
    }


    public function borrarArchivosCDP(){ //borra todos los archivos que sean de esa rendicion
        
        $vectorTerminaciones = explode('/',$this->terminacionesArchivos);
        
        for ($i=1; $i <=  $this->cantArchivos; $i++) { 
            $nombre = $this::raizArchivo.
                        $this->rellernarCerosIzq($this->codReposicionGastos,6).
                        '-'.
                        $this->rellernarCerosIzq($i,2).
                        '.'.
                        $vectorTerminaciones[$i-1];
            Storage::disk('reposiciones')->delete($nombre);
            Debug::mensajeSimple('Se acaba de borrar el archivo:'.$nombre);
        }
    }




    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
 
    }
    
    //la primera es la 1 OJO
    public function getTerminacionNro($index){
        $vector = explode('/',$this->terminacionesArchivos);
        return $vector[$index-1];

    }


    /* Retorna el codigo del estado indicado por el str parametro */
    public static function getCodEstado($nombreEstado){
        $lista = EstadoReposicionGastos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return 'Nombre no valido';
        
        return $lista[0]->codEstadoReposicion;

    }
    
    public function getNombreEstado(){ 
        $estado = EstadoReposicionGastos::findOrFail($this->codEstadoReposicion);
        return $estado->nombre;
    }

    /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
    public function verificarEstado($nombreEstado){
        $lista = EstadoReposicionGastos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return false;
        
        
        $estado = $lista[0];
        
        if($estado->codEstadoReposicion == $this->codEstadoReposicion)
            return true;
        
        return false;
        
    }



    

    //ingresa una coleccion y  el codEstadoSolicitud y retorna otra coleccion  con los elementos de esa coleccion que están en ese estado
    public static function separarDeColeccion($coleccion, $codEstadoReposicion){
        $listaNueva = new Collection();
        foreach ($coleccion as $item) {
            if($item->codEstadoReposicion == $codEstadoReposicion)
                $listaNueva->push($item);
        }
        return $listaNueva;
    }

    
    

    //Observadsa -> subsanadas -> Creadas -> Aprobadas -> abonadas -> rechazadas->contabilizadas -> canceladas
    public static function ordenarParaEmpleado($coleccion){
        
        $observadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Observada'));
        $subsanada = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Subsanada')); 
        $creadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Creada')); 
        $aprobadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Aprobada')); 
        $abonadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Abonada')); 

        $contabilizadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Contabilizada')); 
        $canceladas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Cancelada')); 
        $rechazadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Rechazada')); 


        $listaOrdenada = new Collection();
        $listaOrdenada= $listaOrdenada->concat($observadas);
        $listaOrdenada= $listaOrdenada->concat($subsanada);
        $listaOrdenada= $listaOrdenada->concat($creadas);
        $listaOrdenada= $listaOrdenada->concat($aprobadas);
        
        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($rechazadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        $listaOrdenada= $listaOrdenada->concat($canceladas);
        
        return $listaOrdenada;

    }
    

    //Creadas -> Subsanadas -> Aprobadas->abonadas -> Contabilizadas
    public static function ordenarParaGerente($coleccion){
            
        $observadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Observada'));
        $subsanada = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Subsanada')); 
        $creadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Creada')); 
        $aprobadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Aprobada')); 
        $abonadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Abonada')); 

        $contabilizadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Contabilizada')); 
        $canceladas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Cancelada')); 
        $rechazadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Rechazada')); 


        $listaOrdenada = new Collection();
        $listaOrdenada= $listaOrdenada->concat($creadas);
        $listaOrdenada= $listaOrdenada->concat($subsanada);
        $listaOrdenada= $listaOrdenada->concat($aprobadas);
        
        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        
        return $listaOrdenada;

    }


    //Aprobadas->abonadas -> Contabilizadas
    public static function ordenarParaAdministrador($coleccion){
            
        $observadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Observada'));
        $subsanada = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Subsanada')); 
        $creadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Creada')); 
        $aprobadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Aprobada')); 
        $abonadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Abonada')); 

        $contabilizadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Contabilizada')); 
        $canceladas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Cancelada')); 
        $rechazadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Rechazada')); 


        $listaOrdenada = new Collection();
 
        $listaOrdenada= $listaOrdenada->concat($aprobadas);
        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        
        return $listaOrdenada;

    }




    //Creadas -> Subsanadas -> Aprobadas->abonadas -> Contabilizadas
    public static function ordenarParaContador($coleccion){
                
        $observadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Observada'));
        $subsanada = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Subsanada')); 
        $creadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Creada')); 
        $aprobadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Aprobada')); 
        $abonadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Abonada')); 

        $contabilizadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Contabilizada')); 
        $canceladas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Cancelada')); 
        $rechazadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Rechazada')); 


        $listaOrdenada = new Collection();
        
        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        
        return $listaOrdenada;

    }











    public function listaParaAprobar(){
        return $this->verificarEstado('Creada') ||
        $this->verificarEstado('Subsanada'); 

    }
    


    public function listaParaActualizar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Observada') || 
        $this->verificarEstado('Subsanada'); 

    }

    
    public function listaParaObservar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Aprobada'); 

    }
    public function listaParaRechazar(){

        return $this->listaParaObservar();
    }

    public function listaParaAbonar(){
        return $this->verificarEstado('Aprobada');

    }


    public function listaParaContabilizar(){
        return $this->verificarEstado('Abonada');

    }

    public function listaParaCancelar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Aprobada');

    }




    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoReposicion){
            case 1: //creada
                $color = 'rgb(255,193,7)';
                break;
            case 2: //aprobada
                $color = 'rgb(0,154,191)';
                break;
            case 3: //abonada
                $color = 'rgb(243,141,57)';
                break;
            case 4: //contabilizada
                $color ='rgb(40,167,69)';
                break;
            case 5:
                $color ='rgb(255,201,7)';
                break;
            case 6:
                $color ='rgb(27,183,152)';
                break;
            case 7: //rechazada
                $color ='rgb(192,0,0)';
                break;
            case 8: //cancelada
                $color ='rgb(149,51,203)';
                break;
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoReposicion){
            case 1: 
                $color = 'black';
                break;
            case 2:
                $color = 'white';
                break;
            case 3:
                $color = 'white';
                break;
            case 4:
                $color = 'white';
                break;
            case 5:
                $color ='black';
                break;
            case 6:
                $color ='white';
                break;
            case 7:
                $color ='white';
                break;
            case 8:
                $color ='white';
                break;
        }
        return $color;
    }

    public function getEmpleadoSolicitante(){
        $empleado=Empleado::find($this->codEmpleadoSolicitante);
        return $empleado;
    }

    public function evaluador(){
        $empleado=Empleado::find($this->codEmpleadoEvaluador);
        return $empleado;
    }
    public function getProyecto(){
        $proyecto=Proyecto::find($this->codProyecto);
        return $proyecto;
    }
    public function getBanco(){
        $banco=Banco::find($this->codBanco);
        return $banco;
    }
    public function getMoneda(){
        return Moneda::find($this->codMoneda);
    }
    
    public function detalles(){
        return DetalleReposicionGastos::where('codReposicionGastos','=',$this->codReposicionGastos)->get();
    }
    public function monto(){
        $total=0;
        foreach ($this->detalles() as $itemdetalle) {
            $total+=$itemdetalle->importe;
        }
        return $total;
    }
}
