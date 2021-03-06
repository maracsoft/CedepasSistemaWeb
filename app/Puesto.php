<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    public $timestamps = false;

    protected $table = 'puesto';

    protected $primaryKey = 'codPuesto';

    protected $fillable = [
        'nombre','estado'
    ];

    public function area(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\Area','codArea','codArea');//el tercer parametro es de Producto
    }
}
