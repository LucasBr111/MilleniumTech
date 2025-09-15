<?php
// Lógica específica para cada nivel de usuario
$nivel = $_SESSION['nivel'];
?>

<nav id="sidebar" class="sidebar p-3">
    <div class="sidebar-header text-center py-4">
        <img src="assets/img/logo.png" alt="Logo R&F Automotores" class="img-fluid" style="max-height: 200px;">
    </div>

    <ul class="list-unstyled sidebar-menu">
        <li class="nav-item">
            <a href="?c=home" class="nav-link" data-tooltip="Inicio">
                <i class="bi bi-house-door-fill me-2"></i>
                <span>Inicio</span>
            </a>
        </li>

        <?php
        switch ($nivel) {
            case 1: // Administrador
        ?>
                <li class="nav-item">
                    <a href="#adminMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Administración">
                        <i class="bi bi-gear-fill me-2"></i>
                        <span>Administración</span>
                    </a>
                    <ul class="collapse list-unstyled" id="adminMenu">
                        <li><a href="?c=usuario" class="nav-link"><i class="bi bi-person-circle me-2"></i><span>Usuarios</span></a></li>
                        <li><a href="?c=metodo" class="nav-link"><i class="bi bi-credit-card-2-front me-2"></i><span>Métodos de pago</span></a></li>
                        <li><a href="?c=ingreso&a=balance" class="nav-link"><i class="bi bi-graph-up-arrow me-2"></i><span>Balance</span></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#gestionMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Gestión General">
                        <i class="bi bi-hdd-fill me-2"></i>
                        <span>Gestión General</span>
                    </a>
                    <ul class="collapse list-unstyled" id="gestionMenu">
                        <li><a href="?c=cliente" class="nav-link"><i class="bi bi-people me-2"></i><span>Personas</span></a></li>
                        <li><a href="?c=cuota" class="nav-link"><i class="bi bi-cash-stack me-2"></i><span>Cuotas</span></a></li>
                        <li><a href="?c=ingreso" class="nav-link"><i class="bi bi-arrow-up-circle me-2"></i><span>Ingresos</span></a></li>
                        <li><a href="?c=egreso" class="nav-link"><i class="bi bi-arrow-down-circle me-2"></i><span>Egresos</span></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#productoMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Productos">
                        <i class="bi bi-box-fill me-2"></i>
                        <span>Productos</span>
                    </a>
                    <ul class="collapse list-unstyled" id="productoMenu">
                        <li><a href="?c=vehiculos" class="nav-link"><i class="bi bi-car-front-fill me-2"></i><span>Vehículos</span></a></li>
                        <li><a href="?c=marca" class="nav-link"><i class="bi bi-tag-fill me-2"></i><span>Marcas</span></a></li>
                    </ul>
                </li>
              
                <li class="nav-item">
                    <a href="#ventasMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Ventas">
                        <i class="bi bi-bag-fill me-2"></i>
                        <span>Ventas</span>
                    </a>
                    <ul class="collapse list-unstyled" id="ventasMenu">
                        <li><a href="?c=venta" class="nav-link"><i class="bi bi-bag me-2"></i><span>Ventas</span></a></li>
                        <li><a href="?c=presupuesto" class="nav-link"><i class="bi bi-receipt me-2"></i><span>Presupuestos</span></a></li>
                       
                    </ul>

                </li>
                <li class="nav-item"><a href="?c=presupuesto&a=financiar" class="nav-link"><i class="bi bi-plus-circle-fill me-2"></i><span>+ Financiar</span></a></li>
        <?php
                break;

            case 2: // Secretaria
        ?>
                <li class="nav-item">
                    <a href="#secretariaMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Gestión">
                        <i class="bi bi-hdd-fill me-2"></i>
                        <span>Gestión</span>
                    </a>
                    <ul class="collapse list-unstyled" id="secretariaMenu">
                        <li><a href="?c=cliente" class="nav-link"><i class="bi bi-people me-2"></i><span>Personas</span></a></li>
                        <li><a href="?c=cuota" class="nav-link"><i class="bi bi-cash-stack me-2"></i><span>Cuotas</span></a></li>
                        <li><a href="?c=ingreso" class="nav-link"><i class="bi bi-arrow-up-circle me-2"></i><span>Ingresos</span></a></li>
                        <li><a href="?c=egreso" class="nav-link"><i class="bi bi-arrow-down-circle me-2"></i><span>Egresos</span></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#ventasSecMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Ventas">
                        <i class="bi bi-bag-fill me-2"></i>
                        <span>Ventas</span>
                    </a>
                    <ul class="collapse list-unstyled" id="ventasSecMenu">
                        <li><a href="?c=venta" class="nav-link"><i class="bi bi-bag me-2"></i><span>Ventas</span></a></li>
                        <li><a href="?c=venta_tmp" class="nav-link"><i class="bi bi-plus-circle me-2"></i><span>+ Nueva venta</span></a></li>
                        <li><a href="?c=devolucion_ventas" class="nav-link"><i class="bi bi-arrow-return-left me-2"></i><span>Devoluciones</span></a></li>
                        <li><a href="?c=presupuesto" class="nav-link"><i class="bi bi-receipt me-2"></i><span>Presupuestos</span></a></li>
                        <li><a href="?c=presupuesto" class="nav-link"><i class="bi bi-plus-circle-fill me-2"></i><span>+ Financiar</span></a></li>
                    </ul>
                </li>
        <?php
                break;

            case 3: // Vendedor
        ?>
                <li class="nav-item">
                    <a href="#ventasVenMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Ventas">
                        <i class="bi bi-bag-fill me-2"></i>
                        <span>Ventas</span>
                    </a>
                    <ul class="collapse list-unstyled" id="ventasVenMenu">
                        <li><a href="?c=cuotas" class="nav-link"><i class="bi bi-people me-2"></i><span>Clientes</span></a></li>
                        <li><a href="?c=presupuesto" class="nav-link"><i class="bi bi-receipt me-2"></i><span>Presupuestos</span></a></li>
                        <li><a href="?c=presupuesto" class="nav-link"><i class="bi bi-plus-circle me-2"></i><span>+ Financiar</span></a></li>
                        <li><a href="?c=venta_tmp" class="nav-link"><i class="bi bi-plus-circle-fill me-2"></i><span>+ Nueva venta</span></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#infoMenu" data-bs-toggle="collapse" class="dropdown-toggle nav-link" data-tooltip="Información">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <span>Información</span>
                    </a>
                    <ul class="collapse list-unstyled" id="infoMenu">
                        <li><a href="?c=vehiculos" class="nav-link"><i class="bi bi-car-front-fill me-2"></i><span>Vehículos</span></a></li>
                    </ul>
                </li>
        <?php
                break;
        }
        ?>
    </ul>
</nav>