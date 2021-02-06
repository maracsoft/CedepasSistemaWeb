<?php

namespace App\Http\Controllers;

use App\CabeceraVenta;
use App\Cliente;
use App\DetalleVenta;
use App\Producto;
use App\Tipo;
use App\Parametro;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;


class CabeceraVentaController extends Controller
{
    const PAGINATION = 50; // PARA QUE PAGINEE DE 10 EN 10

    public function index(Request $Request)
    {
       /*  $buscarpor = $Request->buscarpor;
        $ventas = CabeceraVenta::where('estado', '=','1')
            //->where('nombres','like','%'.$buscarpor.'%')
            ->paginate($this::PAGINATION);

        //cuando vaya al index me retorne a la vista
 */
        $ventas = [];

        //return view('tablas.cabeceraventas.index',compact('ventas')); 


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* $cabecera=CabeceraVenta::where('estado', '=','1');
        $producto= Producto::all();
        $tipo=Tipo::all();
        $cliente=Cliente::all();
        $tipou=Tipo::select('tipo_id','descripcion')->orderBy('tipo_id','DESC')->get();                         
        $parametros=Parametro::findOrFail($tipou[0]->tipo_id);      */      
        return view('tablas.cabeceraventas.create');

     

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        try {
            DB::beginTransaction();        
            /* Grabar Cabecera */
            /* Obtiene codigo cliente a partir del dni */
            $cliente=Cliente::where('ruc_dni','=',$request->ruc)->get();
            $codcliente=$cliente[0]->codcliente;           
            $venta=new CabeceraVenta();
            $venta->codcliente=$codcliente;
            $venta->nrodocumento=$request->get('nrodoc');        
            $venta->tipo_id=$request->seltipo;           
            $arr = explode('/', $request->fecha);
            $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
            $venta->fecha_venta=$nFecha;    
            
            if ($request->seltipo=='2') // boleta
                {                        
                    error_log('SALIO BOLETA');
                    $venta->total=$request->total;           
                    $venta->subtotal=$request->total;
                    $venta->igv='0';
                }
            else
                {   //FACTURA
                    error_log('SALIO FACTURA');
                    $venta->total=$request->total;
                    $venta->subtotal=$request->totalSinIGV;
                    $venta->igv=$request->IGV;
                }
                    
            $venta->estado='1';
            $venta->save();
            /* Grabar Detalle */
            //$detalleventa=$request->get('detalles');         

            $producto_id = $request->get('cod_producto');
            $cantidad = $request->get('cantidad');
            $pventa = $request->get('pventa');            

            $cont = 0;
                
            while ($cont<count($producto_id)) {
                $detalle=new DetalleVenta();
                $detalle->venta_id=$venta->venta_id;
                $detalle->productoid=$producto_id[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precio=$pventa[$cont];                
                $detalle->save();
                  /* Actualizar stock */
                Producto::ActualizarStock($detalle->productoid,$detalle->cantidad);                         
                $cont=$cont+1;
            }        
            /* Actualizar el numero de documento en la tabla parametro */
           if ($venta->tipo_id=="2")
                $nroNuevo=str_pad((substr($request->get('nrodoc'),5,11)+1),6,"0", STR_PAD_LEFT);   
            elseif ($venta->tipo_id=="1")
                 $nroNuevo=str_pad((substr($request->get('nrodoc'),5,11)+1),6,"0", STR_PAD_LEFT);   
            
            Parametro::ActualizarNumero($venta->tipo_id, $nroNuevo);
            error_log( 'NUEVO NUMERO:::::::::::::::::::::::::::'.$nroNuevo);
            DB::commit();                
            return redirect()->route('cabeceraventa.index');
        } 
        catch (Exception $e) {
            error_log('HA OCURRIDO UN ERROR EN LA TRANSACCIÓN, SE HARÁ ROLLBACK POR EL SIGUIENTE ERROR 
            
            

            '.$e.'
            
            
            ');

         DB::rollback();
        }

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

    public function ProductoCodigo($producto_id){
        return DB::table('productos as p')->join('unidades as u','p.codunidad','=','u.codunidad')                 
         ->where('p.estado','=','1')->where('p.codproducto','=',$producto_id)
        ->select('p.codproducto','p.descripcion','u.descripcion as unidad','p.precio','p.stock')->get();    
    }
    public function PorTipo($descripcion)
    {        
        //return Tipo::where('descripcion','=',$descripcion)->get();
        return DB::table('tipo as t')->join('parametros as p','p.tipo_id','=','t.tipo_id')                 
         ->where('t.tipo_id','=',$descripcion)->select('t.tipo_id','t.descripcion','p.serie','p.numeracion')->get(); 
    }


    
}
