<?php
namespace App\Http\Controllers;

use App\Activo;
use App\CategoriaActivo;
use App\Empleado;
use App\EstadoActivo;
use App\EstadoPeriodoCaja;
use App\gestionInventario;
use App\Proyecto;
use App\Revision;
use App\RevisionDetalle;
use App\Sede;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GestionInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$revisiones=Revision::where('codRevision','>',0)->orderBy('fechaHoraInicio','desc')->get();
        $revisiones=Revision::all();
        $band=1;
        foreach ($revisiones as $itemrevision) {
            if(is_null($itemrevision->fechaHoraCierre)){$band=0;}
        }
        return view('renzo.gestionInventario.index',compact('revisiones','band'));
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
        $activos=Activo::where('activo','=',1)->get();
        foreach ($activos as $itemactivo) {
            $detalle=new RevisionDetalle();
            $detalle->codRevision=$revision->codRevision;
            $detalle->codActivo=$itemactivo->codActivo;
            $detalle->codEstado=$itemactivo->codEstado;
            $detalle->activo=1;
            $detalle->seReviso=0;
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
        $sedes=Sede::all();
        $detalles=Revision::find($id)->getDetalles();
        $revision=Revision::find($id);
        $proyectos=Proyecto::all();
        $categorias=CategoriaActivo::all();
        return view('renzo.gestionInventario.ver',compact('sedes','detalles','proyectos','categorias','revision'));
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
    public function delete($id)
    {
        date_default_timezone_set('America/Lima');
        $revision=Revision::find($id);
        $revision->fechaHoraCierre=new DateTime();
        $revision->save();

        foreach ($revision->getDetalles() as $itemdetalle) {
            if($itemdetalle->codEstado==1){
                $itemdetalle->activo=1;
                $itemdetalle->seReviso=1;
                $itemdetalle->save();
            }
            $activo=Activo::find($itemdetalle->codActivo);
            $activo->codEstado=$itemdetalle->codEstado;
            $activo->save();
        }


        return redirect()->route('gestionInventario.index');
    }



    public function cambiarEstadoDetalle($id)
    {
        $arr = explode('*', $id);
        $detalle=RevisionDetalle::find($arr[0]);
        $detalle->codEstado=$arr[1];
        $detalle->save();
        /*
        $activo=$detalle->getActivo();
        $activo->codEstado=$arr[1];
        $activo->save();
        */
        return redirect()->route('gestionInventario.show',$detalle->codRevision);
    }



    public function filtroDetalles($id){
        $arr = explode('*', $id);
        //agrega filtros a los activos, si estos filtros no son igual a cero
        $cont=0;

        //$filtro1=RevisionDetalle::where('codRevision','=',$arr[3]);

        $filtro1=DB::TABLE('revision_detalle')->JOIN('activo', 'revision_detalle.codActivo', '=', 'activo.codActivo')
        ->SELECT('revision_detalle.codRevisionDetalle as codRevisionDetalle', 'revision_detalle.codRevision as codRevision',  
                    'revision_detalle.codActivo as codActivo','revision_detalle.codEstado as codEstado',  
                    
                    'activo.codProyectoDestino as codProyectoDestino','activo.nombreDelBien as nombreDelBien',
                    'activo.caracteristicas as caracteristicas','activo.codCategoriaActivo as codCategoriaActivo',
                    'activo.codSede as codSede','activo.placa as placa');


        $filtro1=DB::TABLE('revision_detalle')
        ->JOIN('revision','revision.codRevision','=','revision_detalle.codRevision')
        ->JOIN('activo', 'revision_detalle.codActivo', '=', 'activo.codActivo')
        ->SELECT('revision_detalle.codRevisionDetalle as codRevisionDetalle', 'revision_detalle.codRevision as codRevision',  
                    'revision_detalle.codActivo as codActivo','revision_detalle.codEstado as codEstado',  
                    
                    'activo.codProyectoDestino as codProyectoDestino','activo.nombreDelBien as nombreDelBien',
                    'activo.caracteristicas as caracteristicas','activo.codCategoriaActivo as codCategoriaActivo',
                    'activo.codSede as codSede','activo.placa as placa','revision.fechaHoraCierre as isCerrado');

        if($arr[0]!=0){
            $filtro1=$filtro1->where('activo.codSede','=',$arr[0]);
        }
        if($arr[1]!=-1){
            $filtro1=$filtro1->where('activo.codProyectoDestino','=',$arr[1]);
        }
        if($arr[2]!=0){
            $filtro1=$filtro1->where('activo.codCategoriaActivo','=',$arr[2]);
        }
        $filtro1=$filtro1->where('revision.codRevision','=',$arr[3]);
        $activos=$filtro1->get();

        //$detalles=RevisionDetalle::where('codRevision','=',$arr[3])->get();



        //$activos=$filtro1->get();
        foreach ($activos as $itemactivo) {
            $itemactivo->codSede=Sede::find($itemactivo->codSede)->nombre;
            $itemactivo->codProyectoDestino=Proyecto::find($itemactivo->codProyectoDestino)->nombre;
            $itemactivo->codCategoriaActivo=CategoriaActivo::find($itemactivo->codCategoriaActivo)->nombre;
            $itemactivo->codEstado=EstadoActivo::find($itemactivo->codEstado)->nombre;
            if(is_null($itemactivo->placa)){$itemactivo->placa='';}
            if(is_null($itemactivo->isCerrado)){$itemactivo->isCerrado='';}
        }
        //$TEMP=Activo::where('codSede','=',$arr[0])->where('codProyectoDestino','=',$arr[1]);
        //$activos=$TEMP->where('codCategoriaActivo','=',$arr[2])->get();
        return response()->json(['activos'=>$activos]);
    }



    /**PARA VERIFICAR ESTADOS DE ACTIVOS */
    public function mostrarRevisiones()
    {
        $revisiones=Revision::where('fechaHoraCierre','!=',NULL)->orderBy('fechaHoraInicio','desc')->get();
        return view('renzo.verificarActivos.mostrarRevisiones',compact('revisiones'));
    }

    
    public function cambiarEstado($id)
    {
        $arr = explode('*', $id);
        $detalle=RevisionDetalle::find($arr[0]);
        $detalle->activo=$arr[1];
        $detalle->seReviso=1;
        $detalle->save();

        $activo=Activo::find($detalle->codActivo);
        $activo->activo=$arr[1];
        $activo->save();
        return redirect()->route('activos.mostrarActivos',$detalle->codRevision);
    }
}
