<?php
namespace App\Http\Controllers;

use App\Activo;
use App\Empleado;
use App\gestionInventario;
use App\Revision;
use App\RevisionDetalle;
use DateTime;
use Illuminate\Http\Request;

class GestionInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $revisiones=Revision::all();
        return view('renzo.gestionInventario.index',compact('revisiones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados=Empleado::where('activo','!=',0)->get();
        return view('renzo.gestionInventario.registrar',compact('empleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('America/Lima');
        $revision=new Revision();
        $revision->fechaHoraInicio=new DateTime();
        $revision->fechaHoraCierre=null;
        $revision->codEmpleadoResponsable=$request->codEmpleadoResponsable;
        $revision->descripcion=$request->descripcion;
        $revision->save();


        //creacion de todos los detalles
        $activos=Activo::all();
        foreach ($activos as $itemactivo) {
            $detalle=new RevisionDetalle();
            $detalle->codRevision=$revision->codRevision;
            $detalle->codActivo=$itemactivo->codActivo;
            $detalle->codEstado=1;
            $detalle->save();
        }

        return redirect()->route('gestionInventario.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('renzo.gestionInventario.ver');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $revision=Revision::find($id);
        $empleados=Empleado::where('activo','!=',0)->get();
        return view('renzo.gestionInventario.edit',compact('empleados','revision'));
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
        $revision=Revision::find($id);
        $revision->codEmpleadoResponsable=$request->codEmpleadoResponsable;
        $revision->descripcion=$request->descripcion;
        $revision->save();
        return redirect()->route('gestionInventario.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
