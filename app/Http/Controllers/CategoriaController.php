<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class CategoriaController extends Controller
{
    private $directory = 'categoria';
    private $mensaje = null;

    public function index(){

        $models = Categoria::all();

        return view('jorge.admin.'.$this->directory.'.index', compact(
            'models'
        ));
    }

    public function create(){
        return view('jorge.admin.'.$this->directory.'.create');
    }

    public function store(Request $request){
        $data = $request->all();

        $rules = array(
            //'codCategoria' => 'required',
            'nombre' => 'required'
        ); 
        
        $messages = [
            //'codCategoria.required' => 'El campo codigo es obligatorio.',
            'nombre.required' => 'El campo nombre es obligatorio.'
        ];

        $v = Validator::make($data, $rules, $messages);

        if ($v->fails()) {
            $errors = $v->errors();
            return Redirect::back()
                    ->withInput()
                    ->withErrors($errors);
        }

        //dd($data);

        /*$datos = Categoria::where('codCategoria',$data["codCategoria"])->get();

        if (count($datos) > 0) {
            
            $errors = ['El codigo ya existe'];
            Flash::error('El codigo ya existe');
            return Redirect::back()->withInput()->withErrors($errors);
        }*/

        $model=  Categoria::create($data);
        // dd($model);
        try {

            // $model->password = $password;
            $model->save();


        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }

        $mensaje = $this->mensaje."* Categoria creada correctamente";
        Flash::success($mensaje);
        return redirect()->route('categoria.index');
    }

    public function edit($id){
        $model = Categoria::findOrFail($id);
        //$model = Categoria::where('codCategoria',$id)->first();
        return view('jorge.admin.' . $this->directory . '.edit', compact(
            'model' 
        ));
    }

    public function update($id,Request $request){
        $data = $request->all();

        $model = Categoria::findOrFail($id);

        //$model = Categoria::where('codCategoria',$id)->first();

        

        $rules = array(
            //'codCategoria' => 'required',
            'nombre' => 'required'
        ); 
        
        $messages = [
            //'codCategoria.required' => 'El campo codigo es obligatorio.',
            'nombre.required' => 'El campo nombre es obligatorio.'
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

        $mensaje = $this->mensaje."* Categoria editada correctamente";
        Flash::success($mensaje);
        return redirect()->route('categoria.index');
    }

    public function destroy(){
        $request = request()->all();
        //$model = Categoria::where('codCategoria',$request['id'])->first();
        $model = Categoria::findOrFail($request['id']);

        $model->delete();
        return response()->json([
            'status' => 200
        ]);

    }
}
