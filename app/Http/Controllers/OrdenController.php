<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\DetalleOrden;
use App\Empleado;
use App\Mesa;
use App\Orden;
use App\Producto;
use Illuminate\Http\Request;
use App\Sala;
class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        
        $CB1 = $request->CheckBox_1;
        $CB2 = $request->CheckBox_2;
        $CB3 = $request->CheckBox_3;
        $CB4 = $request->CheckBox_4;
        $CB5 = $request->CheckBox_5;
        $vectorCB = array($CB1,$CB2,$CB3,$CB4,$CB5);
    
        
        if($request->indicador==1){ //indicador está en 1 cuando se llega a esta funcion a traves del botón
        }else{
            $vectorCB=array("on","on","on","on","on");
        }
        
        

        
        $codSala = $request->sala; 
        $buscarpor = $request->buscarpor;
        if ($codSala != 0) { //si se seleccionó alguna sala
        
            $ordenes = Orden::where('codEstado','<','5')
            ->where('mesa.codSala','=',$codSala)
            ->where('observaciones','like','%'.$buscarpor.'%')
            ->join('mesa', 'orden.codMesa', '=', 'mesa.codMesa')
            ->orderBy('codEstado','ASC')  
            ->get();
            
        }else{ //si se selecciono todas las salas
        
            $ordenes = Orden::where('codEstado','<','5')
            ->where('observaciones','like','%'.$buscarpor.'%')
            ->orderBy('codEstado','ASC')  
            ->get();

        }
        
        
        if($vectorCB[0]!="on"){ //si no está marcada la 1, quitamos todos esos registros
            $ordenes= $ordenes->where('codEstado','!=','1');
        }
        if($vectorCB[1]!="on"){ //si no está marcada la 2, quitamos todos esos registros
            $ordenes=$ordenes->where('codEstado','!=','2');
        }
        if($vectorCB[2]!="on"){ //si no está marcada la 3, quitamos todos esos registros
            $ordenes=$ordenes->where('codEstado','!=','3');
        }
        if($vectorCB[3]!="on"){ //si no está marcada la 4, quitamos todos esos registros
            $ordenes=$ordenes->where('codEstado','!=','4');
        }
        if($vectorCB[4]!="on"){ //si no está marcada la 5, quitamos todos esos registros
            $ordenes=$ordenes->where('codEstado','!=','5');
        }
        $listaSalas = Sala::All();
        return view('tablas.ordenes.index',compact('ordenes','listaSalas','codSala','vectorCB'));
    }



    public function listarParaCaja(Request $request)
    {
        
    
        
        if($request->indicador==1){ //indicador está en 1 cuando se llega a esta funcion a traves del botón
        }else{
            $vectorCB=array("on","on","on","on","on");
        }
        
        

        
        $codSala = $request->sala; 
        $buscarpor = $request->buscarpor;
        if ($codSala != 0) { //si se seleccionó alguna sala
        
            $ordenes = Orden::where('codEstado','<','5')
            ->where('mesa.codSala','=',$codSala)
            ->where('observaciones','like','%'.$buscarpor.'%')
            ->join('mesa', 'orden.codMesa', '=', 'mesa.codMesa')
            ->orderBy('codEstado','ASC')  
            ->get();
            
        }else{ //si se selecciono todas las salas
        
            $ordenes = Orden::where('codEstado','<','5')
            ->where('observaciones','like','%'.$buscarpor.'%')
            ->orderBy('codEstado','ASC')  
            ->get();

        }
        
        
        $listaSalas = Sala::All();
        return view('tablas.ordenes.ordenesParaPagar',compact('ordenes','listaSalas','codSala','vectorCB'));
    }

    public function ventanaPago($id)
    {
        $orden = Orden::findOrFail($id);
        $listaOrdenes = DetalleOrden::where('codOrden','=',$id)->get();


        return view('tablas.ordenes.pagar',compact('orden'));





    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
 
    public function siguiente($id){
        $orden = Orden::findOrFail($id);
        $orden->codEstado = $orden->codEstado + 1;
        $orden->save();

        $nombreNuevoEstado = $orden->getEstado(); 

        return redirect()
                ->route('orden.index')
                ->with('datos','Orden Actualizada a '.$nombreNuevoEstado);
    }


    public function ordenMesa($id){
        $mesa=Mesa::find($id);
        $categorias1=Categoria::where('estado','=',1)->where('codMacroCategoria','=',1)->get();
        $productos=Producto::where('estado','=',1)->get();
        $meseros=Empleado::where('codTipoEmpleado','=',3)->get();
        return view('tablas.ordenes.ordenMesa',compact('mesa','categorias1','productos','meseros'));
    }
}
