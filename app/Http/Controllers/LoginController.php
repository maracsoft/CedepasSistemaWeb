<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function validarLogin(Request $request){
    /*
        $Usuario = Usuario::where('usuario','=',$request->usuario)->where('contraseña','=',$request->contraseña);

        
        

        if(count($Usuario)==0){
            return view('Login.login');
        }else{
            return view('GestionarEmpresas.listarEmpresas')->with(array('codUsuario'=>$Usuario->codUsuario, 'nombreUsuario'=>$Usuario->nombres));
        }

    */

        $credentials = $request->only('usuario', 'password');

        //var_dump($credentials);
        //die();

            if (Auth::attempt($credentials)) {
                
                    return redirect()->intended('/listarEmpleados');
                    //return Redirect('/')->with('login_errors', true);

            } else {
                //echo "credenciales incorrectas";
                return Redirect('/')->with('login_errors', true); //*** usuario o contraseña no coinciden
            }
    }

}
