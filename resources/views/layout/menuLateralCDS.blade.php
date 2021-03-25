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
         

              <li class="nav-item">
                <a href="{{route('SolicitudFondos.empleado.listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Empleado</p>
                </a>
              </li>
          
         
              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Gerente.listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Gerente</p>
                </a>
              </li>
          

              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Administracion.listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Solicitudes para abonar</p>
                </a>
              </li>

            
              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Contador.listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Solicitudes</p>
                </a>
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
         
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Empleado.listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Empleado</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Gerente.listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Gerente</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Administracion.listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Adminsitracion</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('rendicionGastos.Contador.listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Contabilidad</p>
              </a>
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
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Empleado.listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Empleado</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Gerente.listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Gerente</p>
            </a>
          </li>
          

          
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Administracion.listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Administracion</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Contador.listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Contador</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-header">--------- Admin</li>

   
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">

            <p>
              PERSONAL
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('GestionUsuarios.listar')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Empleados</p>
              </a>
            </li>
          
            <li class="nav-item">
              <a href="{{route('GestiónPuestos.listar')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Puestos</p>
              </a>
            </li>
           
            
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{route('GestiónProyectos.listar')}}" class="nav-link">
           
            <p>Proyectos</p>
          </a>
        </li>
     







      <!-----------------------------------------------UNIDAD 2----------------------------------------------------------------->
     
