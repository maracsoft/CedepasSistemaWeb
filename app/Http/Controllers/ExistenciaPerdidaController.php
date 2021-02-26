<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Existencia;
use App\ExistenciaPerdida;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class ExistenciaPerdidaController extends Controller
{
    //
    private $directory = 'existencia-perdida';
    private $mensaje = null;

    public function index(){

        $models = ExistenciaPerdida::all();

        return view('jorge.admin.'.$this->directory.'.index', compact(
            'models'
        ));
    }

    public function create(){

        $empleado = Empleado::all();

        $idEncargado = 9;
        $fecha = Carbon::now()->format('Y-m-d');

        return view('jorge.admin.'.$this->directory.'.create', compact(
            'empleado','fecha','idEncargado'
        ));
    }

    public function store(Request $request){
        $data = $request->all();

        $rules = array(
            //'codCategoria' => 'required',
            // 'codEmpleadoEncargadoAlmacen' => 'required',
            // 'fecha' => 'required'
            'descripcion' => 'required'
        ); 
        
        $messages = [
            //'codCategoria.required' => 'El campo codigo es obligatorio.',
            // 'codEmpleadoEncargadoAlmacen.required' => 'El campo encargado es obligatorio.',
            // 'fecha.required' => 'El campo fecha es obligatorio.'
            'descripcion.required' => 'El campo descripcion es obligatorio.'
        ];

        $v = Validator::make($data, $rules, $messages);

        if ($v->fails()) {
            $errors = $v->errors();
            return Redirect::back()
                    ->withInput()
                    ->withErrors($errors);
        }

        //dd($data);

        $datos = Existencia::where('codigoInterno',$data["codExistencia"])->get();

        if (count($datos) == 0) {
            
            $errors = ['El codigo no existe'];
            Flash::error('El codigo no existe');
            return Redirect::back()->withInput()->withErrors($errors);
        }

        if($data["cantidad"] <= 0){
            $errors = ['La cantidad debe ser mayor a cero'];
            Flash::error('La cantidad debe ser mayor a cero');
            return Redirect::back()->withInput()->withErrors($errors);
        }

        //dd($data);

        $model=  ExistenciaPerdida::create($data);
        // dd($model);
        try {

            //$model->password = $password;
            $idEncargado = 1;
            $fecha = Carbon::now()->format('Y-m-d');
            $model->codEmpleadoEncargadoAlmacen = $idEncargado;
            $model->fecha = $fecha;
            $model->codExistencia = $datos[0]->codExistencia;
            $model->save();


        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }

        $mensaje = $this->mensaje."* Existencia creada correctamente";
        Flash::success($mensaje);
        return redirect()->route('existenciaPerdida.index');
    }

    public function edit($id){
        $model = ExistenciaPerdida::findOrFail($id);
        $empleado = Empleado::all();
        //$model = Categoria::where('codCategoria',$id)->first();
        return view('jorge.admin.' . $this->directory . '.edit', compact(
            'model' ,'empleado'
        ));
    }

    public function update($id,Request $request){
        $data = $request->all();

        $model = ExistenciaPerdida::findOrFail($id);

        $rules = array(
            //'codCategoria' => 'required',
            'codEmpleadoEncargadoAlmacen' => 'required',
            'fecha' => 'required'
        ); 
        
        $messages = [
            //'codCategoria.required' => 'El campo codigo es obligatorio.',
            'codEmpleadoEncargadoAlmacen.required' => 'El campo encargado es obligatorio.',
            'fecha.required' => 'El campo fecha es obligatorio.'
        ];

        $v = Validator::make($data, $rules, $messages);

        if ($v->fails()) {
            $errors = $v->errors();
            return Redirect::back()
                    ->withInput()
                    ->withErrors($errors);
        }

        $datos = Existencia::where('codExistencia',$data["codExistencia"])->get();

        if (count($datos) == 0) {
            
            $errors = ['El codigo no existe'];
            Flash::error('El codigo no existe');
            return Redirect::back()->withInput()->withErrors($errors);
        }

        if($data["cantidad"] <= 0){
            $errors = ['La cantidad debe ser mayor a cero'];
            Flash::error('La cantidad debe ser mayor a cero');
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $model->fill($data);
        // dd($model);
        try {

            // $model->password = $password;
            $model->save();


        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }

        $mensaje = $this->mensaje."* Existencia Perdida editada correctamente";
        Flash::success($mensaje);
        return redirect()->route('existenciaPerdida.index');
    }

    public function destroy(){
        $request = request()->all();
        //$model = Categoria::where('codCategoria',$request['id'])->first();
        $model = ExistenciaPerdida::findOrFail($request['id']);

        $model->delete();
        return response()->json([
            'status' => 200
        ]);

    }


}
