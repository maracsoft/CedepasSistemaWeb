

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
        </ul>



      </li>




      
     
      

      


      



      

      <li class="nav-header">RENZO</li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Gestión de Inventario
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('gestionInventario.mostrarRevisiones')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Actualizar Activos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/gestionInventario')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Gestión de Revisiones</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{URL::to('/activos')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Gestión de Activos</p>
            </a>
          </li>
        </ul>
      </li>






      <li class="nav-header">MARSKY</li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Asistencia Contable
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">
          
          
          <li class="nav-item">
            <a href="{{route('admin.listaPeriodos')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Admin periodos</p>
            </a>
          </li>
          <li class="nav-item">
            
            <a href="{{route('resp.verPeriodo',App\Empleado::getEmpleadoLogeado()->getPeriodoCaja())}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Mi periodo actual</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('resp.listarMisPeriodos')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Mis periodos</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('caja.index')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Mant Cajas</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{route('pagoPlanilla.listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Pagos</p>
            </a>
          </li>
          
          

          


        </ul>



      </li>

      <li class="nav-header">FELIX</li>
      @if(Auth::user()->isAdmin == 1)
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">

            <p>
              Mantenedores
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
              <a href="/listarAreas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Areas/Puestos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/listarAsistencia" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Asistencias</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/listarSolicitudesJefe" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Solicitudes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/listarJustificacionesJefe" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Justificaciones</p>
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
      {{--   JORGE        ----------------------------------------------------------------- --}}
      <li class="nav-header">JORGE</li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Inventarios Jorge
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
         
               
          <li class="nav-item">
            <a href="{{ route('categoria.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>
                    Categoria
                </p>
            </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('existencia.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-database"></i>
                  <p>
                      Existencia
                  </p>
              </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('ingreso.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-arrow-circle-right"></i>
                  <p>
                      Ingreso
                  </p>
              </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('salida.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-arrow-circle-left"></i>
                  <p>
                      Salida
                  </p>
              </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('existenciaPerdida.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-exclamation-circle"></i>
                  <p>
                      Existentes Perdidos
                  </p>
              </a>
          </li>
          
          <li class="nav-item">
              <a href="{{ route('exportar') }}" class="nav-link">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p>
                      Reporte
                  </p>
              </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('reporte') }}" class="nav-link">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p>
                      Movimiento de existentes
                  </p>
              </a>
          </li>


        </ul>



      </li>


    {{-- fin jorge --}}
