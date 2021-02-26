<?php

namespace App\Http\Controllers;

use App\DetalleGastoPlanilla;
use App\GastoPlanilla;
use Illuminate\Http\Request;
use App\Empleado;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Carbon;
class GastoPlanillaController extends Controller
{
    


    public function listar(){
        $listaGastosPlanilla=GastoPlanilla::All();


        return view('marsky.pagos.index',compact('listaGastosPlanilla'));
    }



    public function create($mes){
        $listaEmpleados = [];
        $listaEmpleados = Empleado::getEmpleadosModalidadPlazoFijo();
        $vector =[];
        $diasLaborablesDelMes = 30;

        $montoTotal = 0;
        for ($i=0; $i <count( $listaEmpleados) ; $i++) { 
            
            $itemEmp = $listaEmpleados[$i];
            error_log(' GastoPlanillaController
            
                abriendo vista crear para mes
            
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
            
            $montoTotal+=$netoAPagar ;

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

        return view('marsky.pagos.registrar',compact('listaEmpleados','vector','mes','montoTotal'));
    }


    public function ver($mes){
        
  
        $listaEmpleados = [];
        $listaEmpleados = Empleado::getEmpleadosModalidadPlazoFijo();
        $vector =[];
        $diasLaborablesDelMes = 30;

        $montoTotal = 0;
        for ($i=0; $i <count( $listaEmpleados) ; $i++) { 
            
            $itemEmp = $listaEmpleados[$i];
            error_log(' GastoPlanillaController
            
                abriendo vista crear para mes
            
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
            
            $montoTotal+=$netoAPagar ;

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

        return view('marsky.pagos.ver',compact('listaEmpleados','vector','mes','montoTotal'));
    

    }






    
    public function store($mes){

    try {
        db::beginTransaction();
        $gastoPlanilla = new GastoPlanilla();
        $gastoPlanilla->fechaGeneracion =  Carbon::now()->format('Y-m-d');
        $gastoPlanilla->mes = $mes;
        $gastoPlanilla->año = 2021;
        $gastoPlanilla->montoTotal = 0;
        $gastoPlanilla->codEmpleadoCreador = Empleado::getEmpleadoLogeado()->codEmpleado;
        $gastoPlanilla->save();
        



        $listaEmpleados = [];
        $listaEmpleados = Empleado::getEmpleadosModalidadPlazoFijo();
        $diasLaborablesDelMes = 30;
        $totalSuma=0;
        for ($i=0; $i <count( $listaEmpleados) ; $i++) { 
            
            $itemEmp = $listaEmpleados[$i];
            error_log(' GastoPlanillaController STORE
            
                abriendo vista crear para mes
            
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
            


            $detalleGastoPlanilla = new DetalleGastoPlanilla();
            $detalleGastoPlanilla->sueldoContrato= $sueldoContrato ;
            $detalleGastoPlanilla->costoDiario =$costoDiario;
            $detalleGastoPlanilla->diasVac =$diasVac;
            $detalleGastoPlanilla->diasFalta= $diasFalta;
            $detalleGastoPlanilla->sueldoBrutoXTrabajar= $sueldoBrutoXTrabajar;
            $detalleGastoPlanilla->montoPagadoVacaciones= $montoPagadoVacaciones;
            $detalleGastoPlanilla->baseImpAntesDeFaltas= $baseImpAntesDeFaltas;
            $detalleGastoPlanilla->descFaltas = $descFaltas;
            $detalleGastoPlanilla->baseImponible= $baseImponible;
            $detalleGastoPlanilla->SNP= $SNP;
            $detalleGastoPlanilla->aporteObligatorio =$aporteObligatorio;
            $detalleGastoPlanilla->comisionMixta= $comisionMixta;
            $detalleGastoPlanilla->primaSeguro =$primaSeguro;
            $detalleGastoPlanilla->totalDesctos =$totalDesctos;
            $detalleGastoPlanilla->netoAPagar= $netoAPagar;

            $detalleGastoPlanilla->codGastoPlanilla= (GastoPlanilla::latest('codGastoPlanilla')->first())->codGastoPlanilla;
            $detalleGastoPlanilla->codAFP = $objAFP->codAFP;
            $detalleGastoPlanilla->codEmpleado = $itemEmp->codEmpleado;    

            $detalleGastoPlanilla->save();
            $totalSuma+= $netoAPagar;
        }


        $gastoPlanilla->montoTotal = $totalSuma;
        $gastoPlanilla->save();

        db::commit();
        return redirect()->route('pagoPlanilla.listar');
            



        
    } catch (\Throwable $th) {
        error_log('
        HA OCURRIDO UN ERROR EN GASTO PLANILLA CONTROLLER STORE 
        
        '.$th.'

        ');
        db::rollBack();




    }


    }






}
