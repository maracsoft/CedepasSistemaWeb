<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Existencia;
use App\MovimientoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExportarController extends Controller
{
    //
    private $directory = 'exportar';

    public function exportar(){
        $categoria = Categoria::all();
        $fecha = Carbon::now()->format('Y-m-d');
        return view('jorge.admin.'.$this->directory.'.index',compact('categoria','fecha'));
    }

    public function imprimir(){
        $request = request()->all();
        
        $model_existencia = Existencia::where("codExistencia",$request["codigo"])->get();

        if( count($model_existencia) > 0){

            $models = MovimientoDetalle::where("codExistencia",$request["codigo"])->get();

            $pdf = \PDF::loadview('jorge.admin.'.$this->directory.'.pdf', compact('models'));

            $path = public_path('pdf/');
            //$fileName =  time().'.'. 'pdf' ;
            $fileName = "reporte";
            $pdf->save($path . '/' . $fileName);
    
            $pdf_path = public_path('pdf/'.$fileName);
            $path_local = env('APP_URL').'pdf/'.$fileName;
    
            return response()->json([
                'status' => 200,
                'data' => $path_local,
                'codigo' => $request["codigo"]
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => "No existe codigo"
            ]);
        }

        
    }

    public function reporte(){
        
            $models = DB::select('SELECT e.`nombre`,
                    e.`stock`, 
                    ifnull((select sum(md.cantidadMovida)
                        from movimiento_detalle md
                        inner join movimiento m on md.codMovimiento = m.codMovimiento
                        where m.tipoMovimiento = 1 and md.codExistencia = e.`codExistencia`),0) as ingreso,
                    ifnull((select sum(md.cantidadMovida)
                        from movimiento_detalle md
                        inner join movimiento m on md.codMovimiento = m.codMovimiento
                        where m.tipoMovimiento = 2 and md.codExistencia = e.`codExistencia`),0) as salida
                FROM `existencia` e');

            return view('jorge.admin.reporte.index',compact('models'));
    }

    public function imprimir2(){
        $request = request()->all();
        
        $models = DB::select('SELECT e.`nombre`,
                    e.`stock`, 
                    ifnull((select sum(md.cantidadMovida)
                        from movimiento_detalle md
                        inner join movimiento m on md.codMovimiento = m.codMovimiento
                        where m.tipoMovimiento = 1 and md.codExistencia = e.`codExistencia`),0) as ingreso,
                    ifnull((select sum(md.cantidadMovida)
                        from movimiento_detalle md
                        inner join movimiento m on md.codMovimiento = m.codMovimiento
                        where m.tipoMovimiento = 2 and md.codExistencia = e.`codExistencia`),0) as salida
                FROM `existencia` e');

        $pdf = \PDF::loadview('jorge.admin.'.$this->directory.'.pdf2', compact('models'));

        return $pdf->download('reporte.pdf');
    }

    public function searchReporte(){
        $request = request()->all();
        
        $models = MovimientoDetalle::where("codExistencia",$request["codigo"])->get();
        $existencia = Existencia::where("codExistencia",$request["codigo"])->first();
        
        return response()->json([
            'status' => 200,
            'html' => view('jorge.admin.exportar.tabla', compact('models','existencia'))->render()
        ]);
    }

}
