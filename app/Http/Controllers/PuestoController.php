<?php

namespace App\Http\Controllers;

use App\Area;
use App\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function listarPuestos($id){
        $area=Area::find($id);
        $puestos=Puesto::where('codArea','=',$id)->where('estado','=',1)->get();
        return view('felix.GestionarAreasPuestos.indexPuesto',compact('puestos','area'));
    }

    public function crearPuesto($id){
        $area=Area::find($id);
        return view('felix.GestionarAreasPuestos.createPuesto',compact('area'));
    }

    public function guardarCrearPuesto(Request $request){
        
        $puesto=new Puesto();
        $puesto->nombre=$request->descripcion;
        $puesto->codArea=$request->codArea;
        $puesto->estado=1;
        $puesto->save();

        return Redirect('/listarPuestos/'.$request->codArea);
    }

    public function editarPuesto($id){
        $puesto=Puesto::find($id);
        return view('felix.GestionarAreasPuestos.editPuesto',compact('puesto'));
    }

    public function guardarEditarPuesto(Request $request){

        $puesto=Puesto::find($request->codPuesto);
        $puesto->nombre=$request->descripcion;
        $puesto->save();

        return Redirect('/listarPuestos/'.$puesto->codArea);
    }

    public function eliminarPuesto($id){
        $puesto=Puesto::find($id);
        $puesto->estado=0;
        $puesto->save();

        return Redirect('/listarPuestos/'.$puesto->codArea);
        //return response()->json();
    }
}
