<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Numeracion extends Model
{
    
    protected $table='numeracion';

    protected $primaryKey = 'codNumeracion';

    protected $fillable = [
        'nombreDocumento',
        'año',
        'numeroLibreActual'
    ];

    public $timestamps = false;


    //Retorna el numero que está libre de Reposicion de gastos
    public static function getNumeracionSOF(){
        return Numeracion::getNumeracionLibreDe('Solicitud de Fondos');
    }

    //Retorna el numero que está libre de Rendicion de gastos
    public static function getNumeracionREN(){
        return Numeracion::getNumeracionLibreDe('Rendicion de Gastos');
    }

    //Retorna el numero que está libre de Reposicion de gastos
    public static function getNumeracionREP(){
        return Numeracion::getNumeracionLibreDe('Reposición de Gastos');
    }

    public static function aumentarNumeracionSOF(){
        return Numeracion::aumentarNumeracionDe('Solicitud de Fondos');
    }

    //Retorna el numero que está libre de Rendicion de gastos
    public static function aumentarNumeracionREN(){
        return Numeracion::aumentarNumeracionDe('Rendicion de Gastos');
    }

    //Retorna el numero que está libre de Reposicion de gastos
    public static function aumentarNumeracionREP(){
        return Numeracion::aumentarNumeracionDe('Reposición de Gastos');
    }

    
    /* La primera persona que haga un documento en un nuevo año, obtendrá la numeración 1 y la usará, 
    por lo tanto la siguiente deberá obtener la 2 
    
    Es por esto que en realidad, en la BD nunca se almacenará el numero 1 
        (porque ahí se almacenan los nros libres y no se sabe si ya pasaron el año hasta que lo activan)
    */

    private static function aumentarNumeracionDe($nombreDocumento){
        $añoActual = Carbon::now()->format('Y');
        $numActual = Numeracion::getNumeracionLibreDe($nombreDocumento); //objeto model

      
        
        $numActual->numeroLibreActual = $numActual->numeroLibreActual + 1;
        
        //Else ya no es necesario pq Ya tenemos ese objeto del nuevo Año en numActual por la funcion  getNumeracionDe
        $numActual->save();
    }





    //Retorna el OBJETO NUMERACION que está libre del tipo  de documento pasado como parametro
    private static function getNumeracionLibreDe($nombreDocumento){
        $añoActual = Carbon::now()->format('Y');
        $lista = Numeracion::where('nombreDocumento','=',$nombreDocumento)
            ->where('año','=',$añoActual)
            ->get();
        

        if(count($lista)==0) //CASO EXCEPCION
        {   
            $ultimoAñoNumerado = Numeracion::getUltimoAñoDe($nombreDocumento);
            if($ultimoAñoNumerado== $añoActual)//SI EL AÑO ES IGUAL, ENTONCES SE MANDÓ EL NOMBRE MAL xd
                return "ERROR";

            //Si el año es diferente, entons esta es la primera llamada de este año
            $nuevoNumero = new Numeracion();
            $nuevoNumero->numeroLibreActual = 1;
            $nuevoNumero->año = $añoActual;
            $nuevoNumero->nombreDocumento = $nombreDocumento;
        }
        else
        { //CASO NORMAL
            $nuevoNumero = $lista[0];
        }

        return $nuevoNumero; //RETORNAMOS OBJETO MODELO
    }

    //retorna el ultimo año del cual está registrada la numeracion del documento indicado
    public static function getUltimoAñoDe($nombreDocumento){
        $lista = Numeracion::where('nombreDocumento','=',$nombreDocumento)
        ->get();
        $añoMayor = 0;
        foreach ($lista as $item) {
            if($añoMayor < $item->año)
                $añoMayor = $item->año;
        }
        return $añoMayor;
    }


   
    

}
