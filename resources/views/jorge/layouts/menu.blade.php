<aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
        <img src="{{env('APP_URL')}}dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">E-Commerce</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="{{env('APP_URL')}}dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="../../index.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v1</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../index2.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v2</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../index3.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v3</p>
                    </a>
                </li>
                </ul>
            </li> -->
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
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>