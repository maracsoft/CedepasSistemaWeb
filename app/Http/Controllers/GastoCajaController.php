<?php

namespace App\Http\Controllers;

use App\GastoCaja;
use App\PeriodoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Caja;
class GastoCajaController extends Controller
{
    
    //actualiza un gasto
    public function store(Request $request){
       //return $request;
        try{
            DB::beginTransaction();

            $gasto = new GastoCaja();
            
            
            $gasto->fechaComprobante = $request->fechaComprobante;
            $gasto->codPeriodoCaja = $request->codPeriodo;
            $gasto->concepto = $request->concepto;
            $gasto->monto = $request->monto;
            $gasto->codEmpleadoDestino = $request->codEmpleadoDestino;
            $gasto->codTipoCDP = $request->codTipoCDP;
            $gasto->nroCDP = $request->nroCDP;
            $gasto->codigoPresupuestal = $request->codigoPresupuestal;

           
            $periodo = PeriodoCaja::findOrFail($request->codPeriodo);
            
            $caja = Caja::findOrFail($periodo->codCaja);

            $periodo->montoFinal = $periodo->montoFinal - $gasto->monto;
            $caja->montoActual = $periodo->montoFinal;
            

            $gasto->nroEnPeriodo = $periodo->cantidadGastos()+1;
            

            
            //ESTA WEA ES PARA SACAR LA TERMINACIONDEL ARCHIVO
            $nombreImagen = $request->get('nombreImg');  //sacamos el nombre completo
            $vec = explode('.',$nombreImagen); //separamos con puntos en un vector 
            $terminacion = end( $vec); //ultimo elemento del vector
            
            $gasto->terminacionArchivo = $terminacion; //guardamos la terminacion para poder usarla luego

            //       cajaChica cdp      cod del periodo                  nro en periodo 
            //               CC-CDP-   000002                           -   32   .  jpg
            $nombreImagen = 'CC-CDP-'.$this->rellernarCerosIzq($periodo->codPeriodoCaja,6).'-'.$this->rellernarCerosIzq($gasto->nroEnPeriodo,2).'.'.$terminacion;
            $archivo =  $request->file('imagen');
            $fileget = \File::get( $archivo );
            
            $gasto->save();
            $caja->save();
            $periodo->save();

            Storage::disk('comprobantes')
            ->put(
                $nombreImagen
                    ,
                    $fileget );

            DB::commit();

            return redirect()->route('resp.verPeriodo',$periodo->codPeriodoCaja);
        }catch(\Throwable $th){
            error_log('
            
                HA OCURRIDO UN ERROR EN GASTO CAJA CONTROLLER : 

                '.$th.'
            
            ');

            DB::rollBack();

        }


    }
    function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
 
     }


     public function descargarCDP($id){
        $gasto = GastoCaja::findOrFail($id);
        $periodo = PeriodoCaja::findOrFail($gasto->codPeriodoCaja);

        $nombreArchivo = 'CC-CDP-'.$this->rellernarCerosIzq($periodo->codPeriodoCaja,6).
        '-'.
        $this->rellernarCerosIzq($gasto->nroEnPeriodo,2).'.'.$gasto->terminacionArchivo;
        return Storage::download("comprobantes/".$nombreArchivo);





     }


    //actualiza un gasto
    public function update(Request $request, $id){


    }

}
