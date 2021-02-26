<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Existencia;
use App\MovimientoDetalle;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class ExistenciaController extends Controller
{
    //
    private $directory = 'existencia';
    private $mensaje = null;

    public function index(){

        $models = Existencia::all();

        return view('jorge.admin.'.$this->directory.'.index', compact(
            'models'
        ));
    }

    public function create(){

        // $model = Existencia::orderByDesc('codExistencia')->first();
                //->orderBy('codExistencia', 'desc')->first();

        $categoria = Categoria::all();

        $codigo = 1;

        // if($model != null){
        //     $codigo = $model->codExistencia;
        //     $codigo +=1;
        // }

        //dd($codigo);

        return view('jorge.admin.'.$this->directory.'.create', compact(
            'codigo','categoria'
        ));
    }

    public function store(Request $request){
        $data = $request->all();

        //dd($data);

        $rules = array(
            'codigoInterno' => 'required',
            'nombre' => 'required',
            //'stock' => 'required',
            'marca' => 'required',
            'unidad' => 'required',
            'codCategoria' => 'required',
            'modelo' => 'required'
        ); 
        
        $messages = [
            'codigoInterno.required' => 'El campo codigo es obligatorio.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            //'stock.required' => 'El campo stock es obligatorio.',
            'marca.required' => 'El campo marca es obligatorio.',
            'unidad.required' => 'El campo unidad es obligatorio.',
            'codCategoria.required' => 'El campo categoria es obligatorio.',
            'modelo.required' => 'El campo modelo es obligatorio.'
        ];

        $v = Validator::make($data, $rules, $messages);

        if ($v->fails()) {
            $errors = $v->errors();
            return Redirect::back()
                    ->withInput()
                    ->withErrors($errors);
        }

        //dd($data);

        $datos = Existencia::where('codigoInterno',$data["codigoInterno"])->get();

        if (count($datos) > 0) {
            
            $errors = ['El codigo ya existe'];
            Flash::error('El codigo ya existe');
            return Redirect::back()->withInput()->withErrors($errors);
        }

        

        $model=  Existencia::create($data);
        // $model = new Existencia;
        // $model -> codExistencia = $data["codExistencia"];
        // $model -> nombre = $data["nombre"];
        // $model -> marca  = $data["marca"];
        // $model -> unidad  = $data["unidad"];
        // $model -> codCategoria  = $data["codCategoria"];
        // $model -> modelo  = $data["modelo"];
        //dd($model);
        try {
            $model->stock = 0;
            $model->estado = 1;
            // $model->password = $password;
            $model->save();


        } catch (\Exception $e) {
            Flash::error($e->getMessage());

            error_log('ha ocurrido un erro en existencia controller
            '.$e->getMessage().'
            
            ');

        }

        $mensaje = $this->mensaje."* Existencia creada correctamente";
        Flash::success($mensaje);
        return redirect()->route('existencia.index');
    }

    public function edit($id){
        $model = Existencia::findOrFail($id);
        $categoria = Categoria::all();
        //$model = Categoria::where('codCategoria',$id)->first();
        return view('jorge.admin.' . $this->directory . '.edit', compact(
            'model' , 'categoria'
        ));
    }

    public function update($id,Request $request){
        $data = $request->all();

        $model = Existencia::findOrFail($id);

        $rules = array(
            'codigoInterno' => 'required',
            'nombre' => 'required',
            //'stock' => 'required',
            'marca' => 'required',
            'unidad' => 'required',
            'codCategoria' => 'required',
            'modelo' => 'required'
        ); 
        
        $messages = [
            'codigoInterno.required' => 'El campo codigo es obligatorio.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            //'stock.required' => 'El campo stock es obligatorio.',
            'marca.required' => 'El campo marca es obligatorio.',
            'unidad.required' => 'El campo unidad es obligatorio.',
            'codCategoria.required' => 'El campo categoria es obligatorio.',
            'modelo.required' => 'El campo modelo es obligatorio.'
        ];

        $v = Validator::make($data, $rules, $messages);

        if ($v->fails()) {
            $errors = $v->errors();
            return Redirect::back()
                    ->withInput()
                    ->withErrors($errors);
        }

        $model->fill($data);
        // dd($model);
        try {

            // $model->password = $password;
            $model->save();


        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }

        $mensaje = $this->mensaje."* Existencia editada correctamente";
        Flash::success($mensaje);
        return redirect()->route('existencia.index');
    }

    public function destroy(){
        $request = request()->all();

        //$model = Categoria::where('codCategoria',$request['id'])->first();

        $model_detalle = MovimientoDetalle::where("codExistencia",$request['id'])->get();

        //dd(count($model_detalle));

        if(count($model_detalle) == 0){
            $model = Existencia::findOrFail($request['id']);
            $model->delete();

            return response()->json([
                'status' => 200
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => "No se puede eliminar el dato por tener registrado un movimiento"
            ]);
        }

        
        

    }

    public function search(){
        $request = request()->all();
        //$model = Categoria::where('codCategoria',$request['id'])->first();

        if($request['tipo'] == 1){
            $model = Existencia::where('codigoInterno',$request['texto'])->get();
        }else{
            $model = Existencia::where('nombre', 'like', '%' . $request['texto'] . '%')->get();
        }
        
        return response()->json([
            'status' => 200,
            'data' => $model
        ]);
    }

    public function searchByCategory(){
        $request = request()->all();
        
        $model = Existencia::where('codCategoria',$request['codigo'])->get();
        
        
        return response()->json([
            'status' => 200,
            'data' => $model
        ]);
    }


}
