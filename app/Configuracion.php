<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    const enProduccion = false;
    const pesoMaximoArchivoMB = 5;

    //en caracteres

    const tamañoMaximoCodigoPresupuestal= 11;//detalles

    const tamañoMaximoConcepto= 60;//detalles

    const tamañoMaximoNroEnRendicion= 100;
    const tamañoMaximoNroEnReposicion= 100;
    const valorMaximoNroItem= 100;//solicitud-rendicion (tiny Int)

    const tamañoMaximoNroComprobante= 20;
    
    const tamañoMaximoResumenDeActividad= 300;//rendicion
    const tamañoMaximoResumen= 300;//rendicion
    const tamañoMaximoJustificacion= 300;//solicitud
    
    const tamañoMaximoObservacion= 200;
    const valorMaximoCantArchivos= 100;//(tiny Int)


    //ultimas
    const tamañoMaximoGiraraAOrdenDe= 50;//solicitud
    const tamañoMaximoNroCuentaBanco= 50;//solicitud-reposicion

}
