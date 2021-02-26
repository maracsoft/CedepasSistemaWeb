
 <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

           
      <li class="nav-item has-treeview">
        <li class="nav-item has-treeview">

          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Provision de Fondos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('solicitudFondos.listarEmp')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Mis Solicitudes</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('rendicionGastos.listarEmpleado')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Mis Rendiciones</p>
              </a>
            </li>

          </ul>
        </li>
    </li>

     
      <!-----------------------------------------------UNIDAD 2----------------------------------------------------------------->
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">

          <p>
            Control Asistencia
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <?php 
          $cont=0;
          $cont2=0;
          $contratos=App\Empleado::getEmpleadoLogeado()->periodoEmpleado;
          foreach ($contratos as $itemcontrato) {
            if($itemcontrato->activo==1 && $itemcontrato->asistencia==1){
              $cont+=1;
              if(!is_null($itemcontrato->codTurno)){
                $cont2+=1;
              }
            }
          }
          ?>
          @if($cont>0)
            @if($cont2>0)
            <li class="nav-item">
              <a href="/marcarAsistencia/{{App\Empleado::getEmpleadoLogeado()->codEmpleado}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Asistencia</p>
                </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="/listarSolicitudes/{{App\Empleado::getEmpleadoLogeado()->codEmpleado}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Solicitudes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/listarJustificaciones/{{App\Empleado::getEmpleadoLogeado()->codEmpleado}}o" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Justificaciones</p>
              </a>
            </li>
          @else


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>NO NECESITA</p>
            </a>
          </li>

          
          @endif
          
        </ul>
      </li>

      
