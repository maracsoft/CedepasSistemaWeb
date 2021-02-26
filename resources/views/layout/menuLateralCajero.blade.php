
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Caja Chica
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">
          
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

        </ul>



      </li>

   