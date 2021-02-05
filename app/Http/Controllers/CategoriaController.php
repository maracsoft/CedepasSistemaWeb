<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\MacroCategoria;

use function GuzzleHttp\Promise\all;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const PAGINATION = 10; // PARA QUE PAGINEE DE 10 EN 10

    public function index(Request $Request)
    {
        $buscarpor = $Request->buscarpor;
        $categoria = Categoria::where('estado','=',1)
            ->where('nombre','like','%'.$buscarpor.'%')
            ->paginate($this::PAGINATION);

        //cuando vaya al index me retorne a la vista
        return view    ('tablas.categorias.index',compact('categoria','buscarpor')); //el compact es para pasar los datos , para meter mas variables meterle mas comas dentro del compact


        // otra forma sería hacer ['categoria'] => $categoria
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $macros=MacroCategoria::all();
        return view ('tablas.categorias.create',compact('macros'));
    }
    


    /*
    public function retornarBienvenido()
    {
        return view ('bienvenido');

    }
    */

    
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
                    'nombre'=>'required|max:100'

                ],[
                    'nombre.required'=>'Ingrese nombre de categoria',
                    'nombre.max' => 'Maximo 100 caracteres la nombre'
                ]

                );
                $categoria = new Categoria();
                $categoria->nombre=$request->nombre;
                $categoria->codMacroCategoria=$request->codMacroCategoria;
                $categoria->estado=1;
                $categoria->save();
                    return redirect()->route('categoria.index')->with('datos','Registro nuevo guardado');

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
        
        $categoria=Categoria::findOrFail($id);
        $macros=MacroCategoria::all();
        return view('tablas.categorias.edit',compact('categoria','macros'));
    }
    /*
    public function confirmar($id){
        $categoria = Categoria::findOrFail($id); 
        return view('tablas.categorias.confirmar',compact('categoria'));
    }
    */
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
            'nombre'=>'required|max:100'
            ],[
            'nombre.required'=>'Ingrese nombre de categoria',
            'nombre.max'=>'Ingrese un maximo de 100 caracteres'
        ]);

        $categoria=Categoria::find($id);
        //var_dump($categoria->nombre);
        $categoria->nombre=$request->nombre;
        $categoria->codMacroCategoria=$request->codMacroCategoria;
        //var_dump($categoria->nombre);
        
        $categoria->save();
        //var_dump($categoria->nombre);
        //die();
        return redirect()->route('categoria.index')->with('datos','Registro actualizado');
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

    public function delete($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->estado = 0;
        $categoria->save ();
        return redirect() -> route('categoria.index')->with('datos','Registro eliminado!!');
    }


}
