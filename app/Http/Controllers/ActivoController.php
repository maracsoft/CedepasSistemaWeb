<?php

namespace App\Http\Controllers;

use App\Activo;
use App\CategoriaActivo;
use App\DetalleRendicionGastos;
use App\EstadoActivo;
use App\Proyecto;
use App\RevisionDetalle;
use App\Sede;
use Illuminate\Http\Request;

class ActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activos=Activo::all();
        return view('renzo.activos.index',compact('activos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria=CategoriaActivo::all();
        $sedes=Sede::all();
        $estados=EstadoActivo::all();
        $proyectos=Proyecto::where('codProyecto','!=',0)->get();
        return view('renzo.activos.agregar',compact('categoria','sedes','estados','proyectos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activo=new Activo();
        $activo->codProyectoDestino=$request->codProyectoDestino;
        $activo->nombreDelBien=$request->nombre;
        $activo->caracteristicas=$request->caracteristicas;
        $activo->codCategoriaActivo=$request->codCategoriaActivo;
        $activo->codSede=$request->codSede;
        $activo->placa=$request->placa;
        $activo->codEstado=1;
        $activo->save();

        return redirect()->route('activos.index')->with('datos','Registro nuevo guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activo=Activo::find($id);
        $categoria=CategoriaActivo::all();
        $sedes=Sede::all();
        $estados=EstadoActivo::all();
        $proyectos=Proyecto::where('codProyecto','!=',0)->get();
        return view('renzo.activos.editar',compact('categoria','sedes','estados','proyectos','activo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $activo=Activo::find($id);
        $activo->codProyectoDestino=$request->codProyectoDestino;
        $activo->nombreDelBien=$request->nombre;
        $activo->caracteristicas=$request->caracteristicas;
        $activo->codCategoriaActivo=$request->codCategoriaActivo;
        $activo->codSede=$request->codSede;
        $activo->placa=$request->placa;
        $activo->save();

        return redirect()->route('activos.index')->with('datos','Registro editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
























