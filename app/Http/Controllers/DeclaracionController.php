
<?php

namespace App\Http\Controllers;

use App\Declaracion;
use Illuminate\Http\Request;
use App\Empleado;

class DeclaracionController extends Controller
{


    public function listar(){
        $listaDeclaraciones=Declaracion::All();

        



        return view('marsky.pagos.index',compact('listaDeclaraciones'));
    }

    public function ver($id){
        $declaracion = Declaracion::findOrFail($id);
        return view('marsky.pagos.registrar');
    }


    public function create(){
        $listaEmpleados = [];

        $listaEmpleados = Empleado::getEmpleadosModalidadPlazoFijo();

        $vector =[];

        $diasLaborablesDelMes = 30;

        for ($i=0; $i <count( $listaEmpleados) ; $i++) { 
            
            $itemEmp = $listaEmpleados[$i];


            $mes = Empleado::getMesActual();

            error_log('
            
            
            
            '.$mes.'
            
            
            
            
            ');

            $sueldoContrato = $itemEmp->getSueldoContrato();
            $costoDiario = $sueldoContrato/$diasLaborablesDelMes;
            $diasVac = $itemEmp->cantDiasVacacionesEnElMes($mes);
            $diasFalta = $itemEmp->cantFaltasEnElMes($mes);
            $sueldoBrutoXTrabajar = $costoDiario*($diasLaborablesDelMes-$diasVac);
            $montoPagadoVacaciones = $diasVac*$costoDiario;
            $baseImpAntesDeFaltas = $sueldoBrutoXTrabajar + $montoPagadoVacaciones;
            $descFaltas = $diasFalta *$costoDiario;;
            $baseImponible = $baseImpAntesDeFaltas - $descFaltas;
            
            $objAFP = $itemEmp->getAFP(); 

           
            if($objAFP->nombre=='SNP'){
                $SNP = 0.13*$baseImponible;
                $aporteObligatorio = '0';
                $comisionMixta = '0';
                $primaSeguro = '0';
                
            }else{

                $SNP = '0';
                $aporteObligatorio = $objAFP->aporteObligatorio*$baseImponible/100;

                
                $comisionMixta = $objAFP->comisionMixta*$baseImponible/100;
                
              
                $primaSeguro = $objAFP->primaDeSeguro*$baseImponible/100;
                

            }
            
            
            $totalDesctos = $SNP + $aporteObligatorio + $comisionMixta +  $primaSeguro ;
                $netoAPagar = $baseImponible-$totalDesctos;
            


            $item=array(
                'nombre' => $itemEmp->getNombreCompleto(),
                'dni'=> $itemEmp->dni,
                'afp'=> $itemEmp->getAFP()->nombre,
                'sueldoContrato'=> $sueldoContrato,
                'costoDiario'=> $costoDiario,
                'diasVac'=> $diasVac,
                'diasFalta'=> $diasFalta,
                'sueldoBrutoXTrabajar'=> $sueldoBrutoXTrabajar,
                'montoPagadoVacaciones'=> $montoPagadoVacaciones,
                'baseImpAntesDeFaltas'=> $baseImpAntesDeFaltas,
                'descFaltas'=> $descFaltas,
                'baseImponible'=> $baseImponible,
                'SNP'=> $SNP,
                'aporteObligatorio'=> $aporteObligatorio,
                'comisionMixta'=> $comisionMixta,
                'primaSeguro'=> $primaSeguro,
                'totalDesctos'=> $totalDesctos,
                'netoAPagar'=> $netoAPagar
                

            );


            array_push($vector,$item);

        }

        return view('marsky.pagos.registrar',compact('listaEmpleados','vector'));
    }
}
