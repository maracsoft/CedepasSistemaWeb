
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
      </li>


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

      <!-----------------------------------------------UNIDAD 2----------------------------------------------------------------->
    

     


      <li class="nav-item">
        <a href="{{route('user.cerrarSesion')}}" class="nav-link">
          <i class="fas fa-sign-out-alt"></i>
          <p>
            Cerrar Sesión
          </p>
        </a>
      </li>


