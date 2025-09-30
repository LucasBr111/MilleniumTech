<link rel="stylesheet" href="assets/styles/navbar.css">
<nav class="navbar navbar-expand-lg sticky-top custom-navbar" id="main-navbar">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center logo-container" href="index.php">
                <img src="assets/img/logo.png" alt="Logo" class="d-inline-block logo-img">
                <span class="million-tech-logo">MILLION TECH</span>
            </a>
        </div>

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger-lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=home&a=index">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=productos&a=ofertas">Ofertas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?c=productos&a=novedades">Novedades</a>
                </li>
            </ul>
        </div>

        <ul class="navbar-nav d-none d-lg-flex align-items-center ms-auto">
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
            <li class="nav-item dropdown user-dropdown-item">
                <a class="nav-link dropdown-toggle user-dropdown" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                        <i class="fas fa-user-circle me-2"></i>
                        <span><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                    <?php else: ?>
                        <i class="fas fa-user-circle me-2"></i>
                        <span>Invitado</span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                        <li class="dropdown-header">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="index.php?c=cliente"><i class="fas fa-id-card me-2"></i>Mi Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="index.php?c=login&a=logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="index.php?c=login&a=index"><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="mobile-menu-overlay d-lg-none" id="mobileMenuOverlay">
    <div class="mobile-menu-container">
        <div class="mobile-menu-header">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-details">
                    <h6><?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Invitado'); ?></h6>
                    <small>
                        <?php
                        switch ($_SESSION['nivel'] ?? 2) {
                            case 1:
                                echo "Administrador";
                                break;
                            case 2:
                                echo "Cliente";
                                break;
                            default:
                                echo "Cliente ocasional";
                        }
                        ?>
                    </small>
                </div>
            </div>
            <button class="mobile-menu-close" id="mobileMenuClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-menu-body">
            <div class="mobile-nav-section">
                <h6 class="mobile-section-title">Navegación</h6>
                <ul class="mobile-nav-list">
                    <li><a href="index.php?c=home&a=index"><i class="fas fa-home"></i>Inicio</a></li>
                    <li><a href="index.php?c=productos&a=ofertas"><i class="fas fa-tags"></i>Ofertas</a></li>
                    <li><a href="index.php?c=productos&a=novedades"><i class="fas fa-star"></i>Novedades</a></li>
                </ul>
            </div>
            <div class="mobile-nav-section">
                <h6 class="mobile-section-title">Mi Cuenta</h6>
                <ul class="mobile-nav-list">
                    <li><a href="index.php?c=productos&a=favoritos"><i class="fas fa-heart"></i>Favoritos <span class="nav-badge favorites-count-mobile">0</span></a></li>
                    <li><a href="index.php?c=carrito&a=index"><i class="fas fa-shopping-cart"></i>Carrito <span class="nav-badge cart-count-mobile">0</span></a></li>
                </ul>
            </div>
            <div class="mobile-nav-section">
                <ul class="mobile-nav-list">
                    <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
                        <li><a href="index.php?c=cliente"><i class="fas fa-user"></i>Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="index.php?c=login&a=logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="index.php?c=login&a=index"><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="mobile-bottom-bar d-lg-none">
    <div class="bottom-nav-container">
        <a href="index.php?c=home&a=index" class="bottom-nav-item active">
            <div class="bottom-nav-icon">
                <i class="fas fa-home"></i>
            </div>
            <span class="bottom-nav-label">Inicio</span>
        </a>
        <a href="index.php?c=productos&a=ofertas" class="bottom-nav-item">
            <div class="bottom-nav-icon">
                <i class="fas fa-fire"></i>
            </div>
            <span class="bottom-nav-label">Ofertas</span>
        </a>
        <a href="index.php?c=productos&a=favoritos" class="bottom-nav-item">
            <div class="bottom-nav-icon">
                <i class="fas fa-heart"></i>
                <span class="fav-count favorites-count-mobile">0</span>
            </div>
            <span class="bottom-nav-label">Favoritos</span>
        </a>
        <a href="index.php?c=carrito&a=index" class="bottom-nav-item">
            <div class="bottom-nav-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count-bottom cart-count-mobile">0</span>
            </div>
            <span class="bottom-nav-label">Carrito</span>
        </a>
        <a href="#" class="bottom-nav-item" id="mobileMenuTrigger">
            <div class="bottom-nav-icon">
                <i class="fas fa-bars"></i>
            </div>
            <span class="bottom-nav-label">Menú</span>
        </a>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Variables globales para mejor rendimiento
        let updateCountersTimer;
        let isCountersUpdating = false;

        // Función principal para actualizar contadores - mejorada y optimizada
        function updateCounters() {
            if (isCountersUpdating) return;
            isCountersUpdating = true;

            $.ajax({
                url: 'index.php?c=contadores&a=obtenerContadores',
                method: 'GET',
                dataType: 'json',
                timeout: 10000,
                success: function(response) {
                    if (response && response.success && response.contadores) {
                        const contadores = response.contadores;
                        const cartItems = parseInt(contadores.carrito) || 0;
                        const favItems = parseInt(contadores.favoritos) || 0;

                        const updateBadge = (selectors, count) => {
                            const elements = $(selectors.join(', '));
                            if (count > 0) {
                                const displayCount = count > 99 ? '99+' : count.toString();
                                elements.text(displayCount).show().removeClass('empty');
                            } else {
                                elements.text('').hide().addClass('empty');
                            }
                        };

                        // Actualizar todos los contadores de carrito
                        updateBadge(['.cart-count', '.cart-count-mobile'], cartItems);

                        // Actualizar todos los contadores de favoritos
                        updateBadge(['.favorites-count', '.favorites-count-mobile'], favItems);

                        console.log('Contadores actualizados:', {
                            carrito: cartItems,
                            favoritos: favItems
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener contadores:', {
                        status: status,
                        error: error,
                        responseText: xhr.responseText
                    });
                },
                complete: function() {
                    isCountersUpdating = false;
                }
            });
        }

        // Funciones para manejar overlays móviles
        function initializeMobileOverlays() {
            const $searchOverlay = $('#mobileSearchOverlay');
            const $menuOverlay = $('#mobileMenuOverlay');
            const $body = $('body');

            $('#mobile-search-trigger').on('click', function(e) {
                e.preventDefault();
                $searchOverlay.addClass('show');
                $body.addClass('no-scroll');
                $('#mobile-search-input').focus();
            });

            $('#mobileSearchClose').on('click', function() {
                $searchOverlay.removeClass('show');
                $body.removeClass('no-scroll');
            });

            $('#mobileMenuTrigger').on('click', function(e) {
                e.preventDefault();
                $menuOverlay.addClass('show');
                $body.addClass('no-scroll');
            });

            $('#mobileMenuClose, .mobile-menu-overlay').on('click', function(e) {
                if ($(e.target).is('#mobileMenuOverlay') || $(e.target).closest('#mobileMenuClose').length) {
                    $menuOverlay.removeClass('show');
                    $body.removeClass('no-scroll');
                }
            });
        }

        // Función para manejar el scroll de la navbar
        function handleNavbarScroll() {
            const navbar = $('.custom-navbar');
            const scrollTop = $(window).scrollTop();
            if (scrollTop > 50) {
                navbar.addClass('scrolled');
            } else {
                navbar.removeClass('scrolled');
            }
        }



        // Inicializar funciones
        updateCounters(); // Primera carga de los contadores
        setInterval(updateCounters, 30000); // Actualizar contadores cada 30 segundos
        $(window).on('scroll', handleNavbarScroll);
        initializeMobileOverlays();
    });
</script>