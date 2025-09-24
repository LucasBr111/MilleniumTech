<style>/* ========================================================================= */
/* Variables                                 */
/* ========================================================================= */
:root {
    --blanco-marmol: #F8F9FA;
    --dorado-elegante: #D4AF37;
    --negro-futurista: #121212;
    --bordo-profundo: #520017;
    --gris-elegante: #6c757d;
    --azul-tecnologia: #0066cc;
    --sombra-sutil: 0 4px 25px rgba(0, 0, 0, 0.08);
    --sombra-densa: 0 6px 30px rgba(0, 0, 0, 0.15);
}

/* ========================================================================= */
/* Globales                                  */
/* ========================================================================= */
body {
    font-family: 'Montserrat', sans-serif;
    color: var(--negro-futurista);
    background-color: #f4f5f8;
}

h1, h2, h3, h4, h5, h6, .million-tech-logo {
    font-family: 'Cinzel', serif;
}

.no-scroll {
    overflow: hidden;
}

/* ========================================================================= */
/* Navbar                                   */
/* ========================================================================= */
.custom-navbar {
    background-color: rgba(248, 249, 250, 0.98);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(212, 175, 55, 0.1);
    box-shadow: var(--sombra-sutil);
    padding: 0.8rem 1.5rem;
    transition: all 0.3s ease;
}

.custom-navbar.scrolled {
    padding: 0.5rem 1.5rem;
    box-shadow: var(--sombra-densa);
}

/* --- Logo --- */
.logo-container {
    gap: 12px;
}

.logo-img {
    height: 65px;
    width: auto;
    object-fit: contain;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.logo-img:hover {
    transform: scale(1.05);
}

.million-tech-logo {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--dorado-elegante);
    letter-spacing: 1.5px;
    text-shadow: 2px 2px 4px rgba(212, 175, 55, 0.3);
}

/* --- Enlaces de navegación --- */
.nav-link {
    color: var(--negro-futurista) !important;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 0.7rem 1.2rem;
    position: relative;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.nav-link:hover {
    color: var(--dorado-elegante) !important;
    transform: translateY(-2px);
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 5px;
    left: 50%;
    background: linear-gradient(90deg, var(--dorado-elegante), var(--bordo-profundo));
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover::after {
    width: 70%;
}

/* --- Botón Hamburguesa --- */
.custom-toggler {
    border: none;
    background: transparent;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1001;
}

.custom-toggler:focus {
    box-shadow: none;
}

.hamburger-lines {
    width: 24px;
    height: 18px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
}

.hamburger-lines span {
    display: block;
    height: 3px;
    width: 100%;
    background: var(--dorado-elegante);
    border-radius: 2px;
    transition: all 0.3s ease;
    transform-origin: center;
}

.custom-toggler[aria-expanded="true"] .hamburger-lines span:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.custom-toggler[aria-expanded="true"] .hamburger-lines span:nth-child(2) {
    opacity: 0;
}

.custom-toggler[aria-expanded="true"] .hamburger-lines span:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -6px);
}

/* --- Iconos y Badges Desktop --- */
.nav-icon-circle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    text-decoration: none;
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

.nav-icon-circle .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: var(--bordo-profundo);
    color: white;
    border-radius: 50%;
    min-width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-weight: 600;
}

.nav-icon-circle .badge.empty {
    display: none;
}

/* --- Dropdown de Usuario --- */
.user-dropdown {
    padding: 8px 15px;
    border-radius: 50px;
    background-color: rgba(212, 175, 55, 0.05);
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
    box-shadow: var(--sombra-sutil);
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

/* ========================================================================= */
/* Buscador Ajax                              */
/* ========================================================================= */
/* --- Desktop Search --- */
.search-container-desktop {
    position: relative;
}

.search-form-desktop {
    position: relative;
    background: var(--blanco-marmol);
    border-radius: 50px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    width: 250px;
    display: flex;
    align-items: center;
    padding: 4px 15px;
}

.search-form-desktop:focus-within {
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    border-color: var(--dorado-elegante);
}

#desktop-search-input {
    border: none;
    background: transparent;
    padding: 8px 10px 8px 0;
    width: 100%;
    outline: none;
    font-size: 0.95rem;
    color: var(--negro-futurista);
}

.search-icon-desktop {
    color: var(--gris-elegante);
    font-size: 0.95rem;
    transition: color 0.3s ease;
    margin-right: 8px;
}

.search-form-desktop:focus-within .search-icon-desktop {
    color: var(--dorado-elegante);
}

/* --- Resultados en Dropdown --- */
.search-results-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    max-height: 400px;
    overflow-y: auto;
    background-color: var(--blanco-marmol);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    box-shadow: var(--sombra-sutil);
    z-index: 1000;
    margin-top: 10px;
    padding: 10px 0;
    display: flex;
    flex-direction: column;
}

.search-results-dropdown .no-results,
.search-results-dropdown .loading-spinner {
    padding: 15px;
    text-align: center;
    color: var(--gris-elegante);
    font-style: italic;
}

.search-result-item {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    gap: 15px;
    text-decoration: none;
    color: var(--negro-futurista);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: background-color 0.2s ease;
}

.search-result-item:hover {
    background-color: rgba(212, 175, 55, 0.1);
}

.search-result-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

.search-result-item .result-name {
    font-weight: 500;
    font-size: 0.95rem;
    margin: 0;
}

.search-result-item .result-price {
    font-weight: 700;
    color: var(--dorado-elegante);
    font-size: 0.9rem;
}

.search-results-title {
    font-size: 0.9rem;
    color: var(--gris-elegante);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0 20px 10px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
}

/* ========================================================================= */
/* Móvil                                   */
/* ========================================================================= */
@media (max-width: 991.98px) {
    /* Oculta los enlaces de navegación */
    .navbar-collapse {
        display: none !important;
    }

    /* Oculta las acciones rápidas de carrito, favoritos, etc. */
    .mobile-quick-actions {
        display: none;
    }
    
    /* Muestra solo el icono de búsqueda en el lado derecho */
    .mobile-search-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: var(--dorado-elegante);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .mobile-search-icon i {
        font-size: 1.2rem;
    }

    .mobile-search-icon:hover {
        background: var(--dorado-elegante);
        color: white;
        transform: scale(1.05);
    }
    
    /* Asegura que el logo y el botón de búsqueda se alineen correctamente */
    .custom-navbar .container-fluid {
        justify-content: space-between;
        align-items: center;
    }

    /* Oculta la columna de iconos y el menú hamburguesa */
    .custom-navbar .d-lg-none.d-flex.align-items-center {
        display: none !important;
    }
}

/* --- Acciones Rápidas --- */
.mobile-quick-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.mobile-quick-icon {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(212, 175, 55, 0.1);
    border: 1px solid rgba(212, 175, 55, 0.3);
    color: var(--dorado-elegante);
    text-decoration: none;
    transition: all 0.3s ease;
}

.mobile-quick-icon:hover {
    background: var(--dorado-elegante);
    color: white;
    transform: scale(1.05);
}

.quick-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: var(--bordo-profundo);
    color: white;
    border-radius: 50%;
    min-width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

/* --- Menú y Overlay --- */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-menu-overlay.show {
    opacity: 1;
    visibility: visible;
}

.mobile-menu-container {
    position: absolute;
    top: 0;
    right: 0;
    width: 320px;
    max-width: 80%;
    height: 100%;
    background: var(--blanco-marmol);
    box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
    transform: translateX(100%);
    transition: transform 0.3s ease;
    overflow-y: auto;
}

.mobile-menu-overlay.show .mobile-menu-container {
    transform: translateX(0);
}

.mobile-menu-header {
    background: linear-gradient(135deg, var(--dorado-elegante), var(--bordo-profundo));
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
}

.user-details h6 {
    margin: 0;
    font-weight: 600;
    font-size: 1rem;
}

.user-details small {
    opacity: 0.9;
    font-size: 0.8rem;
}

.mobile-menu-close {
    background: transparent;
    border: none;
    color: white;
    font-size: 1.2rem;
    padding: 5px;
    border-radius: 50%;
    transition: background 0.3s ease;
}

.mobile-menu-close:hover {
    background: rgba(255, 255, 255, 0.1);
}

.mobile-menu-body {
    padding: 20px;
}

.mobile-nav-section {
    margin-bottom: 25px;
}

.mobile-section-title {
    color: var(--dorado-elegante);
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
    padding-bottom: 5px;
    border-bottom: 1px solid rgba(212, 175, 55, 0.2);
}

.mobile-nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-nav-list li {
    margin-bottom: 8px;
}

.mobile-nav-list a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 15px;
    border-radius: 10px;
    color: var(--negro-futurista);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.mobile-nav-list a:hover {
    background: rgba(212, 175, 55, 0.1);
    color: var(--dorado-elegante);
    transform: translateX(5px);
}

.mobile-nav-list a i {
    width: 20px;
    text-align: center;
    color: var(--dorado-elegante);
}

.nav-badge {
    background: var(--bordo-profundo);
    color: white;
    border-radius: 12px;
    padding: 2px 8px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-left: auto;
}

/* --- Overlay de Búsqueda Móvil --- */
.mobile-search-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--blanco-marmol);
    z-index: 1055;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    overflow-y: auto;
}

.mobile-search-overlay.show {
    opacity: 1;
    visibility: visible;
}

.mobile-search-container {
    padding: 20px;
}

.mobile-search-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--dorado-elegante);
}

.mobile-search-header h5 {
    color: var(--negro-futurista);
    font-weight: 600;
    margin: 0;
}

.mobile-search-close {
    background: transparent;
    border: none;
    color: var(--dorado-elegante);
    font-size: 1.3rem;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.mobile-search-close:hover {
    background: rgba(212, 175, 55, 0.1);
    transform: rotate(90deg);
}

.search-input-container {
    position: relative;
    margin-bottom: 30px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--dorado-elegante);
    font-size: 1.1rem;
}

.mobile-search-form input {
    width: 100%;
    padding: 15px 15px 15px 50px;
    border: 2px solid rgba(212, 175, 55, 0.3);
    border-radius: 25px;
    background: white;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.mobile-search-form input:focus {
    outline: none;
    border-color: var(--dorado-elegante);
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
}

.search-submit {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--dorado-elegante);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.search-submit:hover {
    background: var(--bordo-profundo);
    transform: translateY(-50%) scale(1.05);
}

.search-suggestions {
    margin-top: 30px;
}

.search-suggestions h6 {
    color: var(--gris-elegante);
    font-size: 0.9rem;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.suggestion-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.suggestion-tag {
    background: rgba(212, 175, 55, 0.1);
    color: var(--dorado-elegante);
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid rgba(212, 175, 55, 0.3);
}

.suggestion-tag:hover {
    background: var(--dorado-elegante);
    color: white;
    transform: translateY(-2px);
}

/* ========================================================================= */
/* Barra Inferior                             */
/* ========================================================================= */
.mobile-bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(248, 249, 250, 0.98);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-top: 1px solid rgba(212, 175, 55, 0.2);
    box-shadow: 0 -2px 20px rgba(0, 0, 0, 0.08);
    z-index: 1000;
    padding: 8px 0;
}

.bottom-nav-container {
    display: flex;
    justify-content: space-around;
    align-items: center;
    max-width: 500px;
    margin: 0 auto;
}

.bottom-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: var(--gris-elegante);
    transition: all 0.3s ease;
    padding: 8px 4px;
    border-radius: 12px;
    position: relative;
    min-width: 60px;
}

.bottom-nav-item.active {
    color: var(--dorado-elegante);
    transform: translateY(-2px);
}

.bottom-nav-item:hover {
    color: var(--dorado-elegante);
    text-decoration: none;
}

.bottom-nav-icon {
    position: relative;
    margin-bottom: 4px;
    font-size: 1.2rem;
}

.bottom-nav-label {
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.fav-count, .cart-count-bottom {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--bordo-profundo);
    color: white;
    border-radius: 50%;
    min-width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    animation: pulse 2s infinite;
}

.fav-count.empty, .cart-count-bottom.empty {
    display: none;
}

/* ========================================================================= */
/* Animaciones                               */
/* ========================================================================= */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

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

.fade-in {
    animation: fadeIn 0.5s ease-out;
}

/* ========================================================================= */
/* Media Queries                             */
/* ========================================================================= */
@media (max-width: 991.98px) {
    .custom-navbar {
        padding: 0.8rem 1rem;
    }

    .million-tech-logo {
        font-size: 1.4rem;
    }

    .logo-img {
        height: 55px;
    }
}

@media (max-width: 768px) {
    .million-tech-logo {
        font-size: 1.2rem;
        letter-spacing: 1px;
    }

    .logo-img {
        height: 50px;
    }
}

/* Reducir movimiento para accesibilidad */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}</style>




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
            <li class="nav-item me-2 search-container-desktop">
                <div class="search-form-desktop position-relative">
                    <input class="form-control" type="search" id="desktop-search-input" placeholder="Buscar..." aria-label="Buscar">
                    <i class="fas fa-search search-icon-desktop"></i>
                    <div id="desktop-search-results" class="search-results-dropdown"></div>
                </div>
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
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?c=user&a=profile"><i class="fas fa-id-card me-2"></i>Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?c=login&a=logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="index.php?c=login&a=index"><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión</a></li>
                        <li><a class="dropdown-item" href="index.php?c=register&a=index"><i class="fas fa-user-plus me-2"></i>Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
        
        <div class="d-lg-none mobile-quick-actions">
            <a href="#" class="mobile-quick-icon" id="mobile-search-trigger">
                <i class="fas fa-search"></i>
            </a>
            <a href="index.php?c=carrito&a=index" class="mobile-quick-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="quick-badge cart-count-mobile">0</span>
            </a>
        </div>
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
                        case 1: echo "Administrador"; break;
                        case 2: echo "Cliente"; break;
                        default: echo "Cliente ocasional";
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
                    <li><a href="index.php?c=ofertas&a=index"><i class="fas fa-tags"></i>Ofertas</a></li>
                    <li><a href="index.php?c=novedades&a=index"><i class="fas fa-star"></i>Novedades</a></li>
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
                        <li><a href="index.php?c=user&a=profile"><i class="fas fa-user"></i>Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="index.php?c=login&a=logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="index.php?c=login&a=index"><i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión</a></li>
                        <li><a class="dropdown-item" href="index.php?c=register&a=index"><i class="fas fa-user-plus me-2"></i>Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="mobile-search-overlay" id="mobileSearchOverlay">
    <div class="mobile-search-container">
        <div class="mobile-search-header">
            <h5>Buscar productos</h5>
            <button class="mobile-search-close" id="mobileSearchClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-search-form">
            <div class="search-input-container">
                <i class="fas fa-search search-icon"></i>
                <input type="search" id="mobile-search-input" placeholder="¿Qué estás buscando?" required>
                <button type="submit" class="search-submit">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            <div id="mobile-search-results" class="search-suggestions"></div>
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
        <a href="index.php?c=ofertas&a=index" class="bottom-nav-item">
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

                    console.log('Contadores actualizados:', { carrito: cartItems, favoritos: favItems });
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

    /**
     * Lógica de búsqueda con AJAX
     */
    function setupAjaxSearch() {
        const $desktopInput = $('#desktop-search-input');
        const $desktopResults = $('#desktop-search-results');
        const $mobileInput = $('#mobile-search-input');
        const $mobileResults = $('#mobile-search-results');
        
        let typingTimer;
        const doneTypingInterval = 500; // 0.5 segundos

        // Escucha en ambos inputs de búsqueda
        $([$desktopInput[0], $mobileInput[0]]).on('input', function() {
            clearTimeout(typingTimer);
            const query = $(this).val();
            const $resultsContainer = $(this).is($desktopInput) ? $desktopResults : $mobileResults;

            if (query.length > 2) {
                $resultsContainer.html('<div class="loading-spinner"></div>');
                typingTimer = setTimeout(() => {
                    performSearch(query, $resultsContainer);
                }, doneTypingInterval);
            } else {
                $resultsContainer.empty();
                // Mostrar sugerencias populares si el input está vacío o tiene pocos caracteres
                if (query.length === 0) {
                    showPopularSuggestions($resultsContainer);
                }
            }
        });

        // Manejar clic fuera del dropdown para ocultarlo
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-container-desktop').length && !$(e.target).closest('.mobile-search-container').length) {
                $('.search-results-dropdown').empty();
            }
        });

        // Manejar clic en los tags de sugerencias
        $(document).on('click', '.suggestion-tag', function() {
            const query = $(this).text();
            $('#mobile-search-input').val(query);
            performSearch(query, $('#mobile-search-results'));
        });

        function performSearch(query, $resultsContainer) {
            // Se puede agregar una clase de "cargando" para feedback visual
            $resultsContainer.addClass('loading');
            $.ajax({
                url: 'index.php?c=productos&a=buscarAjax', // Un endpoint para búsqueda en tiempo real
                method: 'GET',
                dataType: 'json',
                data: { query: query },
                success: function(response) {
                    $resultsContainer.removeClass('loading').empty();
                    if (response.success && response.productos.length > 0) {
                        renderSearchResults(response.productos, $resultsContainer);
                    } else {
                        $resultsContainer.append('<div class="no-results">No se encontraron productos.</div>');
                    }
                },
                error: function() {
                    $resultsContainer.removeClass('loading').empty();
                    $resultsContainer.append('<div class="no-results error">Ocurrió un error al buscar.</div>');
                }
            });
        }

        function renderSearchResults(productos, $container) {
            const html = productos.map(p => `
                <a href="index.php?c=productos&a=ver&id=${p.id}" class="search-result-item">
                    <img src="${p.imagen_url}" alt="${p.nombre}">
                    <div class="result-details">
                        <div class="result-name">${p.nombre}</div>
                        <div class="result-price">$${parseFloat(p.precio).toLocaleString('es-AR')}</div>
                    </div>
                </a>
            `).join('');
            $container.append('<h6 class="search-results-title">Productos encontrados</h6>' + html);
        }

        function showPopularSuggestions($container) {
            $container.empty().append(`
                <h6>Búsquedas populares</h6>
                <div class="suggestion-tags">
                    <span class="suggestion-tag">Laptops</span>
                    <span class="suggestion-tag">Smartphones</span>
                    <span class="suggestion-tag">Auriculares</span>
                    <span class="suggestion-tag">Gaming</span>
                </div>
            `);
        }
    }

    // Inicializar funciones
    updateCounters(); // Primera carga de los contadores
    setInterval(updateCounters, 30000); // Actualizar contadores cada 30 segundos
    $(window).on('scroll', handleNavbarScroll);
    initializeMobileOverlays();
    setupAjaxSearch();
});
</script>