<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary">
            <i class="fas fa-bars"></i>
        </button>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link" href="https://maps.app.goo.gl/zpoLUGxmSMv2FTVE9">
                        <i class="fas fa-map-marker-alt"></i>&nbsp;
                        <?php echo "CRECE"; ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-dropdown d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                            <div class="user-avatar me-2">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2"><?php echo $_SESSION['nombre']; ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        <?php else: ?>
                            <div class="user-avatar me-2">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2">Invitado</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                            <div class="dropdown-header">
                                Sesión iniciada como<br>
                                <strong><?php echo $_SESSION['nombre']; ?></strong>
                            </div>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?c=user&a=profile"><i class="fas fa-id-card me-2"></i>Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="index.php?c=user&a=settings"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?c=login&a=logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
$(document).ready(function() {
    // Asegurarnos de que Bootstrap está cargado
    if (typeof bootstrap !== 'undefined') {
        // Inicializar los dropdowns de Bootstrap manualmente
        document.querySelectorAll('.dropdown-toggle').forEach(function(element) {
            new bootstrap.Dropdown(element);
        });
    }

    // No es necesario manejar manualmente el dropdown si data-bs-toggle está presente
    // Sidebar toggle
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
        
        // Cambiar el icono entre barras y X
        const icon = $(this).find('i');
        if (icon.hasClass('fa-bars')) {
            icon.removeClass('fa-bars').addClass('fa-times');
        } else {
            icon.removeClass('fa-times').addClass('fa-bars');
        }
    });
});
</script>

<style>
#sidebarCollapse {
    transition: all 0.3s;
}

#sidebarCollapse.active {
    background-color: var(--bordo-profundo);
    color: white;
}

/* Estilos del dropdown de usuario */
.dropdown-menu {
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 0;
    min-width: 200px;
}

.dropdown-header {
    background-color: #f8f9fa;
    padding: 10px 15px;
    font-size: 14px;
    color: #6c757d;
    text-align: center;
}

.dropdown-item {
    padding: 10px 15px;
    transition: all 0.2s;
    font-size: 14px;
}

.dropdown-item:hover {
    background-color: rgba(82, 0, 23, 0.1);
    color: var(--bordo-profundo);
}

.dropdown-item i {
    color: var(--bordo-profundo);
    width: 20px;
    text-align: center;
    font-size: 16px;
}

.dropdown-divider {
    margin: 0;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.user-dropdown {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 8px 16px;
    border-radius: 50px;
    transition: all 0.3s;
}

.user-dropdown:hover {
    background-color: rgba(0,0,0,0.05);
}

.user-avatar i {
    font-size: 22px;
    color: var(--bordo-profundo);
}

/* Solución alternativa para el dropdown */
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
}

@media (max-width: 768px) {
    .navbar-nav {
        align-items: flex-start !important;
    }
    
    .user-dropdown {
        padding-left: 0;
    }
}
</style>