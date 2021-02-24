<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisionDetalle extends Model
{
    protected $table = "revision_detalle";
    protected $primaryKey ="codRevisionDetalle";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codRevision','codActivo','codEstado','activo','seReviso'];

    function getActivo(){
        return Activo::find($this->codActivo);
    }
    function getEstado(){
        return EstadoActivo::find($this->codEstado);
    }
}
