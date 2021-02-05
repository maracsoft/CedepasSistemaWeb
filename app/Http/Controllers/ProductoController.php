<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Categoria;
use App\Unidad;


class ProductoController extends Controller
{
     const PAGINATION = '4';

    
    public function index(Request $request )
    {
        $buscarpor = $request->buscarpor;
        $producto = Producto::where('estado','=','1')
            ->where('nombre','like','%'.$buscarpor.'%')->paginate($this::PAGINATION);

        return view('tablas.productos.index',compact('producto','buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria = Categoria::where('estado','=','1')->get(); //enviamos las cat activas

        //$unidad = Unidad::where('estado','=','1')->get(); //enviamos las cat activas
        return view ('tablas.productos.create',compact('categoria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate(
            [
                'nombre'=>'required|max:100',
                'codCategoria'=>'required',
                'precio'=>'required',
            ],[
                'nombre.required'=>'Ingrese nombre de categoria',
                'nombre.max' => 'Maximo 100 caracteres la nombre',
                'codCategoria.required'=>'Debe seleccionar una categoria ',
                'precio.required'=>'Debe ingresar precio',
            ]

            );

            $producto = new Producto();
            
            $producto->nombre=$request->nombre;
            $producto->codCategoria=$request->codCategoria;
            
            
            $producto->precioActual=$request->precio;
            $producto->estado=1;              

            $producto->save();
                return redirect()->route('producto.index')->with('datos','Registro nuevo guardado');



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
    public function edit($codproducto)
    {
          $producto=Producto::findOrFail($codproducto);                                  
          $categoria = Categoria::where('estado','=','1')->get();                          
          //$unidad = Unidad::where('estado','=','1')->get();                          
          return view('tablas.productos.edit',compact('producto','categoria'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codproducto)
    {
        $data = request()->validate(
            [
                'nombre'=>'required|max:100',
                'codCategoria'=>'required',
                'precio'=>'required',
            ],[
                'nombre.required'=>'Ingrese nombre de categoria',
                'nombre.max' => 'Maximo 100 caracteres la nombre',
                'codCategoria.required'=>'Debe seleccionar una categoria ',
                'precio.required'=>'Debe ingresar precio',
            ]

            );    
               $producto=Producto::findOrFail($codproducto);
               $producto->nombre=$request->nombre;
               $producto->codCategoria=$request->codCategoria;
               
               $producto->precioActual=$request->precio;
               
               $producto->save();
               return redirect()->route('producto.index')->with('datos','Registro Actualizado!');
     
    }
    /*
    public function confirmar($codproducto)
      {
          //        
          $producto=Producto::findOrFail($codproducto);
          return view('tablas.productos.confirmar',compact('producto'));
      }
      */


    public function destroy($codproducto)
    {

    }

    public function delete($codproducto)
    {
        $producto=Producto::findOrFail($codproducto);
          $producto->estado=0;
          $producto->save();
          return redirect()->route('producto.index')->with('datos','Registro Eliminado!');

    }
}
