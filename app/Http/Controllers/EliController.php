<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class EliController extends Controller
{




    function f12(){
        return $this->central(12);
    }
    function f13(){
        return $this->central(13); //clase ingles
    }
    function f14(){
        return $this->central(14);//clase ingles
    }
    function f15(){
        return $this->central(15);
    }
    function f16(){
        return $this->central(16);
    }
    function f17(){
        return $this->central(17);
    }
    function f18(){
        return $this->central(18);
    }
    function f19(){
        return $this->central(19);
    }
    function f20(){
        return $this->central(20);//clase ingles
    }
    function f21(){
        return $this->central(21);//clase ingles
    }
    function f22(){
        return $this->central(22);
    }
    function f23(){
        return $this->central(23);
    }
    function f24(){
        return $this->central(24);
    }
    function f25(){
        return $this->central(25);
    }
    function f26(){
        return $this->central(26);
    }
    
    
    

    function central($nDia){

        $mensaje='';
        $error=false;
        $nombreImagen='';
        switch ($nDia) {
            case 12:
                $mensaje = "Bienvenida :3 espero te guste esta wea xd, tkm mucho pq eres como mimir y a mí me gusta mucho mimir";
                $nombreImagen="metete.png";
                break;
            case 13:    //clase ingles
                $mensaje = "";
                $nombreImagen="embeces.PNG";
                break; 
            case 14:      //clase ingles
                $mensaje = "Tal vez no estés aquí pero sí estás uwuwuwuwu <3";
                break;
            case 15:
                $mensaje = "";
                $nombreImagen="fresa.PNG";
                break;
            case 16:
                $mensaje = "Listo pa construir un futuro atulado mailov";
                break;
            case 17:
                $nombreImagen = "lengua.PNG";
                break;
            case 18:
                $mensaje = "Cuídate mucho, sino con quién me wa casar u.u";
                $nombreImagen="";
                break;                                              
            case 19:
                $mensaje = "";
                $nombreImagen="quesesiente.PNG";
                break;
            case 20: //clase ingles
                $mensaje = "K casualidad k los 2 tengamos boca, nos besamos o k";
                $nombreImagen="";
                break;
            case 21: //posible dia de operacion //clase ingles
                $mensaje = "";
                $nombreImagen="suerte.PNG";
                break;
            case 22://posible dia de operacion
                $mensaje = "";
                $nombreImagen="triste.PNG";
                break;
            case 23:
                $mensaje = "por un lado me gustas por otro mencantas";
                break;
            case 24:
                $mensaje = "FELIZ ANIVERSARIO MAILOVVVVVVVVVVVVVVV";
                $nombreImagen="aniversario.jpg";
                break;
            case 25:

                $mensaje = "Ya falta poco owo vente pa besukearnos. ¡Buen Viaje Eli!";
                break;
            case 26:
                $mensaje = "";
                $nombreImagen="misojitos.PNG";
                break;
         
        }


        $diaDeHoy = Carbon::now()->format('d');
        //el primer dia es el 12
        $diaQueSolicitaVer = $nDia;
        if($diaQueSolicitaVer > $diaDeHoy ){
            $mensaje= 
                "Estás solicitando ver el msje del día "
                .$diaQueSolicitaVer.
                " pero recien estamos ".
                $diaDeHoy. " XD Diosito te ve cuando mientes";
            $error = true;
            
        }

        //return "el dia de hoy es :".$diaDeHoy;
        


        return view('eli',compact('mensaje','error','nombreImagen'));


    }    


}
