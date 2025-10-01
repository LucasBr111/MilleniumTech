<?php
// Define el nivel de acceso para el administrador (ajusta esto según tu lógica)
$es_admin = (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 1);
// Ajuste para que el controlador siempre sea 'dashboard'
$controlador_actual = 'dashboard'; 
$accion_actual = $_GET['a'] ?? 'inicio'; // Asume 'inicio' como acción por defecto

// Función auxiliar para determinar si una opción está activa
function esActivo($a, $accion_actual) {
    // Si la acción es 'index', la comparamos con 'inicio' si es la predeterminada.
    // Para simplificar, comparamos directamente la acción
    return ($accion_actual === $a) ? 'active' : '';
}
?>

<nav id="sidebar" class="d-flex flex-column h-100">
    <div class="sidebar-header p-3 border-bottom">
        <h3 class="fw-bold text-primary">Admin Panel</h3>
    </div>

    <ul class="list-unstyled flex-grow-1 overflow-auto pt-2">
        <?php if ($es_admin) { // Solo si el usuario es un administrador ?>

            <li class="nav-item">
                <p class="text-muted small fw-bold text-uppercase px-3 pt-3 mb-0">Principal</p>
            </li>
            
            <li class="nav-item <?php echo esActivo('inicio', $accion_actual); ?>">
                <a href="?c=dashboard&a=inicio" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-chart-line me-3 fa-fw"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item <?php echo esActivo('pedidos_pendientes', $accion_actual); ?>">
                <a href="?c=dashboard&a=pedidos_pendientes" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-shopping-cart me-3 fa-fw"></i> Pedidos Pendientes <span class="badge rounded-pill bg-danger ms-auto">23</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo esActivo('listado_ventas', $accion_actual); ?>">
                <a href="?c=dashboard&a=listado_ventas" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-file-invoice-dollar me-3 fa-fw"></i> Listado de Ventas
                </a>
            </li>

            <li class="nav-item mt-3 border-top">
                <p class="text-muted small fw-bold text-uppercase px-3 pt-3 mb-0">Catálogo</p>
            </li>
            
            <li class="nav-item <?php echo esActivo('productos', $accion_actual); ?>">
                <a href="?c=dashboard&a=productos" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-box-open me-3 fa-fw"></i> Productos
                </a>
            </li>
            
            <li class="nav-item <?php echo esActivo('categorias', $accion_actual); ?>">
                <a href="?c=dashboard&a=categorias" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-tags me-3 fa-fw"></i> Categorías
                </a>
            </li>
            
            <?php $submenu_caja_activa = in_array($accion_actual, ['metodos_pago', 'impuestos', 'monedas']); ?>
            
            <li class="nav-item <?php if ($submenu_caja_activa) echo 'active-parent'; ?>">
                <a href="#configSubmenu" data-bs-toggle="collapse" aria-expanded="<?php echo $submenu_caja_activa ? 'true' : 'false'; ?>" 
                   class="nav-link py-2 d-flex align-items-center dropdown-toggle <?php echo $submenu_caja_activa ? '' : 'collapsed'; ?>">
                    <i class="fas fa-cog me-3 fa-fw"></i> Config. Venta
                </a>
                
                <ul class="collapse list-unstyled <?php if ($submenu_caja_activa) echo 'show'; ?>" id="configSubmenu">
                    <li class="<?php echo esActivo('metodos_pago', $accion_actual); ?>">
                        <a href="?c=dashboard&a=metodos_pago" class="nav-link py-2 d-flex align-items-center submenu-link">
                            <i class="far fa-credit-card me-3 fa-fw"></i> Métodos de Pago
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-3 border-top">
                <p class="text-muted small fw-bold text-uppercase px-3 pt-3 mb-0">Administración</p>
            </li>
            
            <li class="nav-item <?php echo esActivo('clientes', $accion_actual); ?>">
                <a href="?c=dashboard&a=clientes" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-users me-3 fa-fw"></i> Clientes
                </a>
            </li>
<!--             
            <li class="nav-item <?php echo esActivo('usuarios_roles', $accion_actual); ?>">
                <a href="?c=dashboard&a=usuarios_roles" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-user-shield me-3 fa-fw"></i> Usuarios & Roles
                </a>
            </li> -->

            <li class="nav-item <?php echo esActivo('reportes', $accion_actual); ?>">
                <a href="?c=dashboard&a=reportes" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-chart-pie me-3 fa-fw"></i> Reportes & Analíticas
                </a>
            </li>
            
            <li class="nav-item mt-3 border-top">
                <p class="text-muted small fw-bold text-uppercase px-3 pt-3 mb-0">Utilidades</p>
            </li>
            
            <li class="nav-item <?php echo esActivo('chat_ia', $accion_actual); ?>">
                <a href="?c=dashboard&a=chat_ia" class="nav-link py-2 d-flex align-items-center">
                    <i class="fas fa-robot me-3 fa-fw"></i> Chat IA Soporte
                </a>
            </li>
    
            <div class="mt-auto border-top p-3">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-danger btn-sm text-start" href="index.php?c=login&a=logout">
                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                    </a>
                </li>
            </div>

        <?php } ?>
    </ul>
</nav>

<style>
    /* Estilos Generales y Reset Básico */
body {
    font-family: 'Poppins', sans-serif; /* Se asume esta fuente moderna */
    background: #f8f9fa; /* Fondo muy claro de Bootstrap */
    color: #343a40;
    margin: 0;
}

/* Contenedor principal que envuelve sidebar y contenido */
#wrapper {
    display: flex;
    width: 100%;
    min-height: 100vh; /* Asegura que ocupe toda la altura */
}

/* Sidebar Estilos - Fijo y Moderno */
#sidebar {
    min-width: 250px;
    max-width: 250px;
    background: #ffffff; /* Fondo blanco */
    color: #495057; /* Texto más oscuro para mejor contraste */
    transition: all 0.3s;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02); /* Sombra más moderna */
    height: 100vh;
    position: fixed;
    /* Usamos flex-column y flex-grow-1 en el HTML para el scroll y el footer */
}

/* Encabezado de la Sidebar */
.sidebar-header {
    /* Clases de Bootstrap aplicadas en HTML */
}

/* Estilos de los Grupos (los <p> que ahora son clases de Bootstrap) */
.list-unstyled p {
    color: #adb5bd !important; /* Gris claro para los títulos */
    letter-spacing: 0.5px; /* Espaciado sutil */
}

/* Estilos de los Enlaces (Links) */
#sidebar ul li a {
    color: #495057;
    text-decoration: none;
    transition: all 0.2s;
    font-weight: 500;
    border-radius: 4px; /* Bordes redondeados sutiles */
    margin: 0 10px; /* Margen para no tocar los bordes */
    padding-left: 10px !important; /* Ajuste para el ícono y el texto */
}
#sidebar ul li a:hover {
    color: #0d6efd; /* Color primario de Bootstrap */
    background: #e9ecef; /* Fondo muy claro al pasar el ratón */
}

/* Estado Activo */
#sidebar ul li.active > a, 
#sidebar ul li.active-parent > a, /* Para el elemento padre del submenú */
#sidebar a[aria-expanded="true"] {
    color: #ffffff; /* Texto blanco para resaltar */
    background: #0d6efd; /* Color primario de Bootstrap (Azul) */
    font-weight: 600; /* Un poco más de peso */
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3); /* Sombra para el activo */
}
/* Asegura que el ícono tenga color blanco en estado activo */
#sidebar ul li.active > a i,
#sidebar ul li.active-parent > a i {
    color: #ffffff;
}

/* Iconos */
.fa-fw {
    width: 1.25em; /* Ancho fijo para alineación perfecta */
}
.fa-fw {
    color: #6c757d; /* Color por defecto de los iconos */
}

/* Estilos del Submenú */
#configSubmenu {
    background: #f8f9fa; /* Fondo sutilmente diferente */
    padding-left: 15px; /* Sangría */
    margin-top: 5px;
    margin-bottom: 5px;
}
.submenu-link {
    padding-left: 15px !important; /* Más sangría para los enlaces hijos */
}
.submenu-link i {
    font-size: 0.8em; /* Iconos más pequeños en el submenú */
    color: #6c757d;
}
/* Estado Activo en el Submenú */
#configSubmenu li.active a {
    background: #cfe2ff; /* Azul claro para enlaces activos del submenú */
    color: #0d6efd;
    font-weight: 500;
}
#configSubmenu li.active a i {
    color: #0d6efd;
}

/* Contenido Principal (Dashboard) */
#content {
    width: 100%;
    padding: 20px;
    transition: all 0.3s;
    margin-left: 250px; /* Hace espacio para la sidebar fija */
}

/* Badge de Notificaciones */
.badge {
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
}
</style>