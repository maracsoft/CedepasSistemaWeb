

<!-- Sidebar Menu -->
    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-header">VIGO</li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Provision de Fondos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Empleado
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

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                gerente
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('solicitudFondos.listarGerente')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Listar Fondos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('rendicionGastos.listarGerente')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Listar Rendic</p>
                </a>
              </li>

              

              
            </ul>
          </li>

          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Jefe Admin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('solicitudFondos.listarJefeAdmin')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Solicitudes para abonar</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('rendicionGastos.listarJefeAdmin')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Rendiciones para Reponer</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('solicitudFondos.reportes')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reportes</p>
                </a>
              </li>
              

            </ul>

          </li>




          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Contabilidad
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('solicitudFondos.listarContador')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Solicitudes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('rendicionGastos.listarContador')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Rendiciones</p>
                </a>
              </li>
              
            
            </ul>
          </li>






        </ul>



      </li>




      
     
      

      


      



      




      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Reposicion de Gastos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Empleado
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('reposicionGastos.listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Mis Reposicion</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                gerente
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('reposicionGastos.verificar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Evaluar Reposiciones</p>
                </a>
              </li>
            </ul>
          </li>
          

          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Jefe Admin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('reposicionGastos.verificarJefe')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Reposiciones para aceptar</p>
                </a>
              </li>
            </ul>

          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Contador
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('reposicionGastos.verificarConta')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Contabilizar</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
        


   
      @if(Auth::user()->isAdmin == 1)
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">

            <p>
              PERSONAL
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/listarEmpleados" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Empleados</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/asignarGerentes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gerentes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/listarAreas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Areas/Puestos</p>
              </a>
            </li>
           
            
          </ul>
        </li>
      @endif








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
          $contratos=App\Empleado::getEmpleadoLogeado()->periodoEmpleado;
          foreach ($contratos as $itemcontrato) {
            if($itemcontrato->activo==1 && $itemcontrato->asistencia==1){
              $cont+=1;
            }
          }
          ?>
          @if($cont>0)
            <li class="nav-item">
              <a href="/marcarAsistencia/{{App\Empleado::getEmpleadoLogeado()->codEmpleado}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Asistencia</p>
                </a>
            </li>
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


    {{-- fin jorge --}}
