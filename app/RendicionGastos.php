<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionGastos extends Model
{
    protected $table = "rendicion_gastos";
    protected $primaryKey ="codRendicionGastos";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codSolicitud','codigoCedepas','totalImporteRecibido',
    'totalImporteRendido','saldoAFavorDeEmpleado',
    'resumenDeActividad','estadoDeReposicion'];


    public function getNombreSede() {
        return $this->getSolicitud()->getNombreSede();

    }
    public function getNombreSolicitante(){
        return $this->getSolicitud()->getNombreSolicitante();
    }

    public function getNombreProyecto(){
        return $this->getSOlicitud()->getNombreProyecto();
    }


    //VER EXCEL https://docs.google.com/spreadsheets/d/1eBQV5QZJ6dTlFtu-PuF3i71Cjg58DIbef2qI0ZqKfoI/edit#gid=1819929291
    public function getNombreEstado(){ 
        $estado = '';
        switch ($this->estadoDeReposicion) {
            case '0': //jamas debería estar en este estado
                $estado = 'Momentaneo';
                break;
            case '1':
                $estado = 'Esperando Reposición';
            break;
            case '11':
                $estado = 'Repuesta y finalizada';
            break;
            case '2':
                $estado = 'Devuelta y finalizada';
                break;

            default:
                # code...
                break;
        }
        return $estado;

    }

    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->estadoDeReposicion){
            case '0': 
                $color = 'rgb(215,208,239)';
                break;
            case '1': 
                $color = 'rgb(91,79,148)';
                break;
            case '11':
                $color = 'rgb(195,186,230)';
                break;
            case '2':
                $color ='rgb(35,28,85)';
                break;
          
            
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->estadoDeReposicion){
            case '0': 
                $color = 'black';
                break;
            case '1': 
                $color = 'white';
                break;
            case '11':
                $color = 'black';
                break;
            case '2': 
                $color = 'white';
                break;
         
        }
        return $color;
    }


    public function getSolicitud(){
        return SolicitudFondos::findOrFail($this->codSolicitud);

    }

    


}
