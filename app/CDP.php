<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CDP extends Model
{
    protected $table = "cdp";
    protected $primaryKey ="codTipoCDP";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombreCDP'];

}
