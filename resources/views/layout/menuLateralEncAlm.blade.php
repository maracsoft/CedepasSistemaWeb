

      {{--   JORGE        ----------------------------------------------------------------- --}}

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Gestión de Almacén
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
