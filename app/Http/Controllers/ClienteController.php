<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const PAGINATION = 10; // PARA QUE PAGINEE DE 10 EN 10

    public function index(Request $Request)
    {
        //
        $buscarpor = $Request->buscarpor;
        $cliente = Cliente::where('estado', '=','1')
            ->where('nombres','like','%'.$buscarpor.'%')
            ->paginate($this::PAGINATION);

        //cuando vaya al index me retorne a la vista


        return view('tablas.clientes.index',compact('cliente','buscarpor')); 
        //el compact es para pasar los datos , para meter mas variables meterle mas comas dentro del compact


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('tablas.clientes.create');
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
        $data = request()->validate(
            [
                'nombres'=>'required|max:60',
                'direccion'=>'required|max:60',
                'email'=>'required|max:60',
                'ruc_dni'=>'required|max:70'
                    
            ],[
                'nombres.required'=>'Ingrese los nombres',
                'nombres.max' => 'Maximo 60 caracteres la descripcion',

                'direccion.required'=>'Ingrese la direccion',
                'direccion.max' => 'Maximo 60 caracteres la direccion',

                'email.required'=>'Ingrese email ',
                'email.max' => 'Maximo 60 caracteres el email',

                'ruc_dni.required'=>'Ingrese DNI',
                'ruc_dni.max' => 'Maximo 11 caracteres el dni/ruc'
            ]

            );
            $cliente = new Cliente();
            $cliente->nombres=$request->nombres;
            $cliente->direccion=$request->direccion;
            $cliente->email=$request->email;
            $cliente->ruc_dni=$request->ruc_dni;
            
            $cliente->estado='1';                
            $cliente->save();

                return redirect()->route('cliente.index')->with('datos','Registro nuevo guardado');

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
        $cliente=Cliente::findOrFail($id);
        return view('tablas.clientes.edit',compact('cliente'));
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
        $data = request()->validate(
            [
                'nombres'=>'required|max:60',
                'direccion'=>'required|max:60',
                'email'=>'required|max:60',
                'ruc_dni'=>'required|max:70'
            ],[
                'nombres.required'=>'Ingrese los nombres',
                'nombres.max' => 'Maximo 60 caracteres la descripcion',

                'direccion.required'=>'Ingrese la direccion',
                'direccion.max' => 'Maximo 60 caracteres la direccion',

                'email.required'=>'Ingrese email ',
                'email.max' => 'Maximo 60 caracteres el email',

                'ruc_dni.required'=>'Ingrese DNI',
                'ruc_dni.max' => 'Maximo 11 caracteres el dni/ruc'
            ]
            );


        $cliente=Cliente::findOrFail($id);
        $cliente->nombres=$request->nombres;
        $cliente->direccion=$request->direccion;
        $cliente->email=$request->email;
        $cliente->ruc_dni=$request->ruc_dni;
            
        $cliente->save();
        return redirect()->route('cliente.index')->with('datos','Registro actualizado');
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
        $cliente = Cliente::findOrFail($id);
        $cliente->estado = '0';
        $cliente->save ();
        return redirect() -> route('cliente.index')->with('datos','Registro eliminado!!');


    }

    public function confirmar($id){

        $cliente = Cliente::findOrFail($id); 
        return view('tablas.clientes.confirmar',compact('cliente'));
    
    }
}
