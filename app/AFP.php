<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AFP extends Model
{
    public $timestamps = false;

    protected $table = 'afp';

    protected $primaryKey = 'codAFP';

    protected $fillable = [
        'nombre','aporteObligatorio','comisionFlujo','comisionMixta','primaDeSeguro'
    ];

    



}
