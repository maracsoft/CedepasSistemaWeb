<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function listarAreas(){
        $areas=Area::where('estado','=',1)->get();
        return view('felix.GestionarAreasPuestos.index',compact('areas'));
    }

    public function crearArea(){
        return view('felix.GestionarAreasPuestos.create');
    }

    public function guardarCrearArea(Request $request){
        
        $area=new Area();
        $area->nombre=$request->descripcion;
        $area->estado=1;
        $area->save();

        return Redirect('listarAreas');
    }

    public function editarArea($id){
        $area=Area::find($id);    
        return view('felix.GestionarAreasPuestos.edit',compact('area'));
    }

    public function guardarEditarArea(Request $request){

        $area=Area::find($request->codArea);
        $area->nombre=$request->descripcion;
        $area->save();

        return Redirect('listarAreas');
    }

    public function eliminarArea($id){
        $area=Area::find($id);
        $area->estado=0;
        $area->save();
        
        return Redirect('listarAreas');
        //return response()->json();
    }
}
