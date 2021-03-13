<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ReposicionGastos;
use Illuminate\Http\Request;

class ReposicionGastosController extends Controller
{
    public function listar(){
        $reposiciones=ReposicionGastos::all();
    }
}
