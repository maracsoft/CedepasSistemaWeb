<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Unidad;

class UnidadController extends Controller
{

    const PAGINATION = '4';

    public function index(Request $request)
    {
        $buscarpor = $request->buscarpor;
        $unidad = Unidad::where('estado','=','1')
            ->where('descripcion','like','%'.$buscarpor.'%')->paginate($this::PAGINATION);
        
        return view('tablas.unidades.index',compact('unidad','buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidad = Unidad::where('estado','=','1')->get();
        return view ('tablas.unidades.create',compact('unidad'));
     
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
                'descripcion'=>'required|max:30'

            ],[
                'descripcion.required'=>'Ingrese descripcion',
                'descripcion.max' => 'Maximo 30 caracteres la descripcion'
            ]

            );
            $unidad = new Unidad();
            $unidad->descripcion=$request->descripcion;
            $unidad->estado='1';                
            $unidad->save();
                return redirect()->route('unidad.index')->with('datos','Registro nuevo guardado');//
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
                // EDITAR 
                $unidad=Unidad::findOrFail($id);
                return view('tablas.unidades.edit',compact('unidad'));
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
        $data=request()->validate([
            'descripcion'=>'required|max:30'
            ],[
            'descripcion.required'=>'Ingrese descripcion',
            'descripcion.max'=>'Ingrese un maximo de 30 caracteres'
        ]);
        $unidad=Unidad::findOrFail($id);
        $unidad->descripcion=$request->descripcion;
        $unidad->estado='1';
        
        $unidad->save();
        return redirect()->route('unidad.index')->with('datos','Registro actualizado');
    }

    
    public function destroy($id)
    {
        $unidad = Unidad::findOrFail($id);
        $unidad->estado = '0';
        $unidad->save ();
        return redirect() -> route('unidad.index')->with('datos','Registro eliminado!!');

    }
    public function confirmar($id){
        $unidad = Unidad::findOrFail($id); 
        return view('tablas.unidades.confirmar',compact('unidad'));
    }


}

