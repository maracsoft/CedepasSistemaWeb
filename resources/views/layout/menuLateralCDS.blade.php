

<!-- Sidebar Menu -->
    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-header">---------</li>
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Solicitud de Fondos
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
           
              
            
            </ul>
          </li>

        </ul>

      </li>


      <li class="nav-header">---------</li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Rendicion de Gastos
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
                <a href="{{route('rendicionGastos.listarJefeAdmin')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Rendiciones</p>
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
                <a href="{{route('rendicionGastos.listarContador')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Rendiciones</p>
                </a>
              </li>
              
            
            </ul>
          </li>

        </ul>

      </li>



      
     
      <li class="nav-header">---------</li>

      


      



      




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
                <a href="{{route('reposicionGastos.listarRepoOfGerente')}}" class="nav-link">
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
                <a href="{{route('reposicionGastos.listarRepoOfJefe')}}" class="nav-link">
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
                <a href="{{route('reposicionGastos.listarRepoOfContador')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Contabilizar</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="nav-header">--------- Admin</li>

   
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
              <a href="{{route('GestionUsuarios.listarEmpleados')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Empleados</p>
              </a>
            </li>
          
            <li class="nav-item">
              <a href="{{route('GestiónPuestos.listarPuestos')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Puestos</p>
              </a>
            </li>
           
            
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">

            <p>
              SERVICIOS
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('proyecto.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Proyectos</p>
              </a>
            </li>
              
          </ul>
        </li>
      @endif








      <!-----------------------------------------------UNIDAD 2----------------------------------------------------------------->
     
