<?php

namespace App\Http\Controllers;

use App\Area;
use App\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    const PAGINATION=10;

    public function listarPuestos(Request $request){
        $nombreBuscar=$request->nombreBuscar;
        $puestos=Puesto::where('estado','=',1)->where('nombre','like','%'.$nombreBuscar.'%')->paginate($this::PAGINATION);
        return view('Puestos.indexPuesto',compact('puestos','nombreBuscar'));
    }

    public function crearPuesto(){
        return view('Puestos.createPuesto');
    }

    public function guardarCrearPuesto(Request $request){
        
        $puesto=new Puesto();
        $puesto->nombre=$request->descripcion;
        $puesto->estado=1;
        $puesto->save();

        return redirect()->route('GestiónPuestos.listar');
    }

    public function editarPuesto($id){
        $puesto=Puesto::find($id);
        return view('Puestos.editPuesto',compact('puesto'));
    }

    public function guardarEditarPuesto(Request $request){

        $puesto=Puesto::find($request->codPuesto);
        $puesto->nombre=$request->descripcion;
        $puesto->save();

        return redirect()->route('GestiónPuestos.listar');
    }

    public function eliminarPuesto($id){
        $puesto=Puesto::find($id);
        $puesto->estado=0;
        $puesto->save();

        return redirect()->route('GestiónPuestos.listar');
        //return response()->json();
    }
}
