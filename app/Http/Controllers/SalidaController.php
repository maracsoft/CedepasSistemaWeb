<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Existencia;
use App\Movimiento;
use App\MovimientoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class SalidaController extends Controller
{
    //

    private $directory = 'salida';
    private $mensaje = null;

    public function index(){

        $models = Movimiento::where("tipoMovimiento","2")->get();
        //dd($models);

        return view('jorge.admin.'.$this->directory.'.index', compact(
            'models'
        ));
    }

    public function create(){

        $empleado = Empleado::all();

        //dd($codigo);

        $fecha = Carbon::now()->format('Y-m-d');
        $idEncargado = 9;
        return view('jorge.admin.'.$this->directory.'.create', compact(
            'empleado','fecha','idEncargado'
        ));
    }

    public function store(Request $request){
        $data = $request->all();
        //dd($data);

        $rules = array(
            'codEmpleadoResponsable' => 'required',
            // 'codEmpleadoEncargadoAlmacen' => 'required',
            // 'fecha' => 'required',
            'observaciones' => 'required',
            'descripcion' => 'required'
        ); 
        
        $messages = [
            'codEmpleadoResponsable.required' => 'El campo responsable es obligatorio.',
            // 'codEmpleadoEncargadoAlmacen.required' => 'El campo encargado de almacen es obligatorio.',
            // 'fecha.required' => 'El campo fecha es obligatorio.',
            'observaciones.required' => 'El campo observaciones es obligatorio.',
            'descripcion.required' => 'El campo descripcion es obligatorio.'
        ];

        $v = Validator::make($data, $rules, $messages);

        /*$data_codigo = array();

        if($data["codArray"] != null){
        
            $data_arreglo = explode(",",$data["codArray"]);
            foreach ($data_arreglo as $value) {

                $data_objeto = explode("-",$value);

                $model_existencia = Existencia::where("codExistencia",$data_objeto[0])->first();

                $objeto["codigo"] = $data_objeto[0];
                $objeto["nombre"] = $model_existencia->nombre;
                $objeto["cantidad"] = $data_objeto[0];
                
                array_push($data_codigo,$objeto);
            }
            
        }*/

        //dd($data_codigo);

        if ($v->fails()) {
            $errors = $v->errors();
            return Redirect::back()
                    ->withInput()
                    ->withErrors($errors);
        }

        if($data["codArray"] == null){
            $errors = ['No hay existentes seleccionado'];
            Flash::error('No hay existentes seleccionado');
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $model=  Movimiento::create($data);
        //dd($model);
        try {

            // $model->password = $password;
            $idEncargado = 1;
            $fecha = Carbon::now()->format('Y-m-d');
            $model->tipoMovimiento = 2;
            $model->codEmpleadoEncargadoAlmacen = $idEncargado;
            $model->fecha = $fecha;
            $model->save();

            $id = $model->codMovimiento;

            if($data["codArray"] != null){
        
                $data_arreglo = explode(",",$data["codArray"]);
                
                foreach ($data_arreglo as $value) {
    
                    $data_objeto = explode("__",$value);
                    //dd($data_arreglo);
                    $model_exist2 = Existencia::where("codigoInterno",$data_objeto[0])->first();
                    $data_detalle["codMovimiento"] = $id;
                    $data_detalle["codExistencia"] = $model_exist2->codExistencia;
                    $data_detalle["cantidadMovida"] = $data_objeto[2];

                    $model_detalle=  MovimientoDetalle::create($data_detalle);
                    $model_detalle->save();

                    $model_exist = Existencia::findOrFail($data_detalle["codExistencia"]);
                    $data_exist["stock"] = $model_exist->stock - $data_detalle["cantidadMovida"];
                    $model_exist->fill($data_exist);
                    $model_exist->save();
                    //dd($model_exist);
    
                    //$model_existencia = Existencia::where("codExistencia",$data_objeto[0])->first();
    
                    /*$objeto["codigo"] = $data_objeto[0];
                    $objeto["nombre"] = $model_existencia->nombre;
                    $objeto["cantidad"] = $data_objeto[2];*/
                    
                    
                }
                
            }

        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }

        $mensaje = $this->mensaje."* Salida creado correctamente";
        Flash::success($mensaje);
        return redirect()->route('salida.index');


    }

    public function edit($id){
        $model = Movimiento::findOrFail($id);
        $empleado = Empleado::all();
        $model_detalle = MovimientoDetalle::where("codMovimiento",$id)->get();
        $arreglo = "";
        foreach ($model_detalle as  $value) {
            $model_existencia = Existencia::where("codExistencia",$value->codExistencia)->first();
            $arreglo .= $value->codExistencia."__".$model_existencia->nombre."__".$value->cantidadMovida.",";
        }

        $arreglo = substr($arreglo,0,strlen($arreglo)-1);

        $model->codArray=$arreglo;
        
        //$model = Categoria::where('codCategoria',$id)->first();
        return view('jorge.admin.' . $this->directory . '.edit', compact(
            'model' , 'empleado'
        ));
    }

    public function update($id,Request $request){
        $data = $request->all();

        $model = Movimiento::findOrFail($id);

        $rules = array(
            'codEmpleadoResponsable' => 'required',
            'codEmpleadoEncargadoAlmacen' => 'required',
            'fecha' => 'required',
            'observaciones' => 'required'
        ); 
        
        $messages = [
            'codEmpleadoResponsable.required' => 'El campo responsable es obligatorio.',
            'codEmpleadoEncargadoAlmacen.required' => 'El campo encargado de almacen es obligatorio.',
            'fecha.required' => 'El campo fecha es obligatorio.',
            'observaciones.required' => 'El campo observaciones es obligatorio.'
        ];

        $v = Validator::make($data, $rules, $messages);

        if ($v->fails()) {
            $errors = $v->errors();
            return Redirect::back()
                    ->withInput()
                    ->withErrors($errors);
        }

        if($data["codArray"] == null){
            $errors = ['No hay existentes seleccionado'];
            Flash::error('No hay existentes seleccionado');
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $model->fill($data);
        // dd($model);
        try {

            // $model->password = $password;
            $model->save();

            if($data["codArray"] != null){

                /*  Eliminamos el movimiento detalle antiguo y actualizamos stock */

                $model_detalle_aux = MovimientoDetalle::where("codMovimiento",$id)->get();

                foreach ($model_detalle_aux as $value) {
                    $model_exist = Existencia::findOrFail($value["codExistencia"]);
                    $data_exist["stock"] = $model_exist->stock + $value["cantidadMovida"];
                    $model_exist->fill($data_exist);
                    $model_exist->save();
                }
                $model_detalle_aux = MovimientoDetalle::where("codMovimiento",$id)->delete();
                //$model_detalle_aux->delete();


                /* guardamos datos de movimiento detalle */
        
                $data_arreglo = explode(",",$data["codArray"]);
                
                foreach ($data_arreglo as $value) {
    
                    $data_objeto = explode("__",$value);
                    //dd($data_arreglo);
                    $data_detalle["codMovimiento"] = $id;
                    $data_detalle["codExistencia"] = $data_objeto[0];
                    $data_detalle["cantidadMovida"] = $data_objeto[2];

                    $model_detalle=  MovimientoDetalle::create($data_detalle);
                    $model_detalle->save();

                    $model_exist = Existencia::findOrFail($data_detalle["codExistencia"]);
                    $data_exist["stock"] = $model_exist->stock - $data_detalle["cantidadMovida"];
                    $model_exist->fill($data_exist);
                    $model_exist->save();
                    //dd($model_exist);
    
                    //$model_existencia = Existencia::where("codExistencia",$data_objeto[0])->first();
    
                    /*$objeto["codigo"] = $data_objeto[0];
                    $objeto["nombre"] = $model_existencia->nombre;
                    $objeto["cantidad"] = $data_objeto[2];*/
                    
                    
                }
                
            }


        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }

        $mensaje = $this->mensaje."* Salida editada correctamente";
        Flash::success($mensaje);
        return redirect()->route('salida.index');
    }

    public function destroy(){
        $request = request()->all();

        $model_detalle_aux = MovimientoDetalle::where("codMovimiento",$request['id'])->get();

        foreach ($model_detalle_aux as $value) {
            $model_exist = Existencia::findOrFail($value["codExistencia"]);
            $data_exist["stock"] = $model_exist->stock + $value["cantidadMovida"];
            $model_exist->fill($data_exist);
            $model_exist->save();
        }

        Existencia::where("stock","<","0")->update(['stock' => 0]);

        MovimientoDetalle::where("codMovimiento",$request['id'])->delete();        

        $model = Movimiento::findOrFail($request['id']);
        $model->delete();

        return response()->json([
            'status' => 200
        ]);

        
        

    }

}
