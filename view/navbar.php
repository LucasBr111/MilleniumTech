<nav class="navbar navbar-expand-lg sticky-top custom-navbar">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center logo-container" href="index.php">
                <img src="assets/img/logo.png" alt="Logo" class="d-inline-block logo-img">
                <span class="million-tech-logo">MILLION TECH</span>
            </a>
        </div>

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=home&a=index">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=ofertas&a=index">Ofertas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=novedades&a=index">Novedades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=soporte&a=index">Soporte</a>
                </li>
            </ul>
        </div>

        <ul class="navbar-nav d-none d-lg-flex align-items-center ms-auto">
            <li class="nav-item me-2">
                <form class="d-flex search-form" action="index.php" method="GET">
                    <input type="hidden" name="c" value="productos">
                    <input type="hidden" name="a" value="buscar">
                    <input class="form-control" type="search" name="query" placeholder="Buscar..." aria-label="Buscar">
                    <button class="btn btn-search" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </li>
            <li class="nav-item me-2">
                <a class="nav-link nav-icon-circle" href="index.php?c=carrito&a=index">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge cart-count">0</span>
                </a>
            </li>
            <li class="nav-item me-2">
                <a class="nav-link nav-icon-circle" href="index.php?c=productos&a=favoritos">
                    <i class="fas fa-heart"></i>
                    <span class="badge favorites-count">0</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle user-dropdown" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                        <i class="fas fa-user-circle me-2"></i>
                        <span><?php echo $_SESSION['nombre']; ?></span>
                    <?php else: ?>
                        <i class="fas fa-user-circle me-2"></i>
                        <span>Invitado</span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                        <li class="dropdown-header">Hola, <?php echo $_SESSION['nombre']; ?></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="index.php?c=user&a=profile"><i class="fas fa-id-card me-2"></i>Mi Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="index.php?c=login&a=logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="index.php?c=login&a=index"><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión</a></li>
                        <li><a class="dropdown-item" href="index.php?c=register&a=index"><i class="fas fa-user-plus me-2"></i>Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="collapse navbar-collapse d-lg-none" id="mainNavbar">
    <div class="container-fluid py-2">
        <ul class="navbar-nav">
            <li class="nav-item my-2">
                <form class="d-flex search-form-mobile" action="index.php" method="GET">
                    <input type="hidden" name="c" value="productos">
                    <input type="hidden" name="a" value="buscar">
                    <input class="form-control" type="search" name="query" placeholder="Buscar..." aria-label="Buscar">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </li>
            <li class="nav-item my-2">
                <a class="nav-link" href="index.php?c=carrito&a=index"><i class="fas fa-shopping-cart me-2"></i>Carrito <span class="badge rounded-pill bg-dark">0</span></a>
            </li>
            <li class="nav-item my-2">
                <a class="nav-link" href="index.php?c=productos&a=favoritos"><i class="fas fa-heart me-2"></i>Favoritos <span class="badge rounded-pill bg-danger favorites-count-mobile">0</span></a>
            </li>
            <li class="nav-item dropdown my-2">
                <a class="nav-link dropdown-toggle" href="#" id="mobileUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-2"></i>
                    <?php echo (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) ? $_SESSION['nombre'] : 'Invitado'; ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="mobileUserDropdown">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                        <li><a class="dropdown-item" href="index.php?c=user&a=profile">Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="index.php?c=user&a=settings">Configuración</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="index.php?c=login&a=logout">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="index.php?c=login&a=index">Iniciar Sesión</a></li>
                        <li><a class="dropdown-item" href="index.php?c=register&a=index">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </div>
    
<!-- Mobile Bottom Bar -->
<div class="mobile-bottom-bar d-lg-none">
    <div class="bottom-nav-container">
        <a href="index.php?c=home&a=index" class="bottom-nav-item active">
            <div class="bottom-nav-icon">
                <i class="fas fa-home"></i>
            </div>
            <span class="bottom-nav-label">Inicio</span>
        </a>

        <a href="#" class="bottom-nav-item" id="mobile-search-trigger">
            <div class="bottom-nav-icon">
                <i class="fas fa-search"></i>
            </div>
            <span class="bottom-nav-label">Buscar</span>
        </a>

        <a href="index.php?c=productos&a=favoritos" class="bottom-nav-item">
            <div class="bottom-nav-icon">
                <i class="fas fa-heart"></i>
                <span class="fav-count empty">0</span>
            </div>
            <span class="bottom-nav-label">Favoritos</span>
        </a>

        <a href="index.php?c=carrito&a=index" class="bottom-nav-item">
            <div class="bottom-nav-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count empty"></span>
            </div>
            <span class="bottom-nav-label">Carrito</span>
        </a>

        <a href="#" class="bottom-nav-item" data-bs-toggle="dropdown">
            <div class="bottom-nav-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <span class="bottom-nav-label">Perfil</span>

            <ul class="dropdown-menu dropdown-menu-end">
                <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                    <li><a class="dropdown-item" href="index.php?c=user&a=profile">Mi Perfil</a></li>
                    <li><a class="dropdown-item" href="index.php?c=pedidos&a=index">Mis Pedidos</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="index.php?c=login&a=logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a class="dropdown-item" href="index.php?c=login&a=index">Iniciar Sesión</a></li>
                    <li><a class="dropdown-item" href="index.php?c=register&a=index">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </a>
    </div>
</div>

<!-- Mobile Search Overlay -->
<div class="mobile-search-overlay" id="mobile-search-overlay">
    <div class="mobile-search-container">
        <div class="mobile-search-header">
            <h5 style="color: var(--negro-futurista); margin: 0;">Buscar productos</h5>
            <button class="mobile-search-close" id="mobile-search-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form class="mobile-search-form" action="index.php" method="GET">
            <input type="hidden" name="c" value="productos">
            <input type="hidden" name="a" value="buscar">
            <input type="search" name="query" placeholder="¿Qué estás buscando?" required>
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
</div>

<style>
    /* Variables de color */
    :root {
        --blanco-marmol: #F8F9FA;
        --dorado-elegante: #D4AF37;
        --negro-futurista: #121212;
        --bordo-profundo: #520017;
    }

    /* Navbar general */
    .custom-navbar {
        /* Efecto de cristal esmerilado */
        background-color: rgba(248, 249, 250, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 10px;
        border-bottom: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 0.8rem 2rem;
    }

    /* Contenedor del logo para espaciado y alineación */
    .logo-container {
        gap: 10px;
        /* Espacio de 10px entre la imagen y el texto */
        margin-right: auto;
        /* Mantiene el logo a la izquierda */
    }

    /* Estilos de la imagen del logo */
    .logo-img {
        height: 80px;
        /* Tamaño fijo de la imagen */
        width: auto;
        object-fit: contain;
        /* Ajusta la imagen sin distorsionarla */
    }

    /* Logo "MILLION TECH" */
    .million-tech-logo {
        font-family: 'Cinzel', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dorado-elegante);
        letter-spacing: 2px;
        text-shadow: 1px 1px 2px rgba(212, 175, 55, 0.4);
    }

    /* Enlaces de la navbar */
    .nav-link {
        color: var(--negro-futurista) !important;
        font-family: 'Montserrat', 'Lato', sans-serif;
        ;
        font-weight: 500;
        transition: color 0.3s ease, transform 0.3s ease;
        padding: 0.5rem 1.2rem;
        /* Más espacio entre enlaces */
        position: relative;
        text-transform: uppercase;
    }

    .nav-link:hover {
        color: var(--dorado-elegante) !important;
        transform: translateY(-2px);
    }

    .nav-link::after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: var(--dorado-elegante);
        transition: width 0.3s ease, transform 0.3s ease;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* Buscador */
    .search-form {
        position: relative;
        display: flex;
        align-items: center;
        background-color: transparent;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50px;
        transition: all 0.3s ease;
        padding: 4px 15px;
        /* Más padding para un look más robusto */
    }

    .search-form:focus-within,
    .search-form:hover {
        border-color: var(--dorado-elegante);
        box-shadow: 0 0 8px rgba(212, 175, 55, 0.2);
        /* Sutil resplandor */
    }

    .search-form input {
        background: transparent;
        border: none;
        color: var(--negro-futurista);
        font-family: 'Montserrat', 'Lato', sans-serif;
        outline: none;
        box-shadow: none;
        padding: 0.5rem 0;
        width: 150px;
        /* Ancho fijo para mantener la forma */
    }

    .search-form .btn-search {
        background: transparent;
        border: none;
        color: var(--negro-futurista);
        transition: color 0.3s ease;
    }

    .search-form .btn-search:hover {
        color: var(--dorado-elegante);
    }

    /* Íconos de acción */
    .nav-icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .nav-icon-circle:hover {
        background-color: rgba(212, 175, 55, 0.1);
        border-color: var(--dorado-elegante);
    }

    .nav-icon-circle i {
        font-size: 1.2rem;
        color: var(--negro-futurista);
    }

    .nav-icon-circle:hover i {
        color: var(--dorado-elegante);
    }

    /* Dropdown de usuario */
    .user-dropdown {
        padding: 8px 15px;
        border-radius: 50px;
        background-color: rgba(212, 175, 55, 0.05);
        /* Fondo muy sutil */
        border: 1px solid rgba(212, 175, 55, 0.3);
        transition: all 0.3s ease;
    }

    .user-dropdown:hover {
        background-color: rgba(212, 175, 55, 0.15);
        color: var(--dorado-elegante) !important;
    }

    .user-dropdown i {
        color: var(--dorado-elegante) !important;
    }

    .user-dropdown span {
        color: var(--negro-futurista) !important;
    }

    .user-dropdown:hover span {
        color: var(--dorado-elegante) !important;
    }

    .dropdown-menu {
        background-color: var(--blanco-marmol);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.3s ease-out;
    }

    .dropdown-item {
        color: var(--negro-futurista);
        transition: background-color 0.3s, color 0.3s;
    }

    .dropdown-item:hover {
        background-color: var(--bordo-profundo);
        color: var(--blanco-marmol);
    }

    .dropdown-item i {
        color: var(--bordo-profundo);
        transition: color 0.3s;
    }

    .dropdown-item:hover i {
        color: var(--blanco-marmol);
    }

    .dropdown-header {
        color: var(--dorado-elegante);
        font-family: 'Cinzel', serif;
    }

    .dropdown-divider {
        background-color: rgba(212, 175, 55, 0.2);
    }

    /* Animación de entrada para dropdown */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estilos para móviles */
    @media (max-width: 991.98px) {
        .custom-navbar {
            padding: 0.8rem 1rem;
        }

        .navbar-toggler {
            border-color: transparent !important;
        }

        .navbar-toggler .fas {
            color: var(--dorado-elegante);
        }

        .nav-link,
        .user-dropdown {
            padding-left: 0;
            margin-top: 10px;
        }

        .dropdown-menu {
            position: static;
            width: 100%;
            box-shadow: none;
            border: none;
            background-color: transparent;
        }
    }
    
    /* Estilos para contadores */
    .nav-icon-circle {
        position: relative;
    }
    
    .nav-icon-circle .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        min-width: 18px;
        height: 18px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    .nav-icon-circle .badge.empty {
        display: none;
    }
    
    .favorites-count-mobile {
        background-color: #dc3545 !important;
        color: white !important;
    }
</style>
<script>
    // Update counters function
    function updateCounters() {
        $.ajax({
            url: 'index.php?c=contadores&a=obtenerContadores',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const contadores = response.contadores;
                    const cartItems = contadores.carrito || 0;
                    const favItems = contadores.favoritos || 0;

                    // Desktop counters
                    const $cartCount = $('.cart-count');
                    const $favCount = $('.favorites-count');

                    // Update cart counter
                    if (cartItems > 0) {
                        $cartCount.removeClass('empty').text(cartItems > 99 ? '99+' : cartItems);
                    } else {
                        $cartCount.addClass('empty').text('');
                    }

                    // Update favorites counter
                    if (favItems > 0) {
                        $favCount.removeClass('empty').text(favItems > 99 ? '99+' : favItems);
                    } else {
                        $favCount.addClass('empty').text('');
                    }

                    // Mobile counters
                    const $favCountMobile = $('.favorites-count-mobile');
                    if (favItems > 0) {
                        $favCountMobile.text(favItems > 99 ? '99+' : favItems);
                    } else {
                        $favCountMobile.text('');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener contadores:', error);
            }
        });
    }

    // Initialize counters when document is ready
    $(document).ready(function() {
        updateCounters();
        
        // Update counters every 30 seconds
        setInterval(updateCounters, 30000);
    });

    // Function to update counters after adding/removing favorites
    function updateFavoritesCounter() {
        updateCounters();
    }
</script>