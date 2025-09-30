<div>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/home.css">
</div>
<div class="animated-bg"></div>

<!-- Admin Controls -->
<?php if (isset($_SESSION['nivel']) && $_SESSION['nivel'] === '1'): ?>
    <div class="admin-controls d-none d-md-flex">
        <button class="admin-btn" data-bs-toggle="modal" data-bs-target="#crudModal" data-c="productos">
            <i class="fas fa-plus me-2"></i>Productos
        </button>
        <button class="admin-btn" data-bs-toggle="modal" data-bs-target="#crudModal" data-c="categorias">
            <i class="fas fa-plus me-2"></i>Categorías
        </button>
    </div>
<?php endif; ?>

<div class="container-fluid px-4">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-carousel">
            <!-- Slide 1: Gaming Revolution -->
            <div class="hero-slide active" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">Gaming Revolution</h1>
                        <p class="hero-description">Descubre la última tecnología gaming con equipos de alto rendimiento que llevarán tu experiencia al siguiente nivel. Componentes premium para gamers exigentes.</p>
                        <a href="#featured-products" class="hero-cta">
                            <i class="fas fa-gamepad"></i>
                            Explorar Gaming
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Periféricos Pro -->
            <div class="hero-slide" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1593305841991-05c297ba4575?ixlib=rb-4.0.3&auto=format&fit=crop&w=2057&q=80');">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">Periféricos Pro</h1>
                        <p class="hero-description">Teclados mecánicos, ratones gaming y auriculares de última generación. Precisión y comodidad para dominar cualquier partida con estilo profesional.</p>
                        <a href="#categories" class="hero-cta">
                            <i class="fas fa-mouse"></i>
                            Ver Periféricos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Streaming Setup -->
            <div class="hero-slide" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1587202372634-32705e3bf49c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2058&q=80');">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">Streaming Pro</h1>
                        <p class="hero-description">Todo lo que necesitas para crear el setup de streaming perfecto. Cámaras, micrófonos, iluminación y software para compartir tu pasión con el mundo.</p>
                        <a href="#new-arrivals" class="hero-cta">
                            <i class="fas fa-video"></i>
                            Setup Streaming
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 4: Monitores 4K -->
            <div class="hero-slide" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1580894894513-541e068a3e2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">Visual Experience</h1>
                        <p class="hero-description">Monitores gaming 4K con frecuencias de actualización ultrarrápidas. Experimenta cada detalle con claridad cristalina y colores vibrantes.</p>
                        <a href="#featured-products" class="hero-cta">
                            <i class="fas fa-desktop"></i>
                            Ver Monitores
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 5: Million Tech -->
            <div class="hero-slide" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=2025&q=80');">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">Million Tech Store</h1>
                        <p class="hero-description">Tu tienda especializada en gaming y tecnología. Calidad garantizada, precios competitivos, envío rápido y la mejor atención al cliente del país.</p>
                        <a href="#about-us" class="hero-cta">
                            <i class="fas fa-star"></i>
                            Conocer Más
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Indicators -->
        <div class="hero-indicators">
            <div class="hero-indicator active" data-slide="0"></div>
            <div class="hero-indicator" data-slide="1"></div>
            <div class="hero-indicator" data-slide="2"></div>
            <div class="hero-indicator" data-slide="3"></div>
            <div class="hero-indicator" data-slide="4"></div>
        </div>
    </section>

    <!-- Promotional Banner 1 -->
    <section class="promo-banner mb-5">
        <div class="promo-content">
            <h3 class="promo-title">🔥 OFERTAS ESPECIALES 🔥</h3>
            <p class="promo-text">Descuentos de hasta 30% en productos seleccionados. ¡Por tiempo limitado!</p>
            <button class="promo-btn">Ver Ofertas</button>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="py-5 fade-in-up">
        <div class="text-center mb-5">
            <h2 class="section-title">Productos Destacados</h2>
            <p class="section-subtitle">Lo mejor de nuestro catálogo gaming, seleccionado especialmente para ofrecerte la máxima calidad y rendimiento</p>
        </div>
        <div class="product-grid" id="featured-products-grid">
            <!-- PHP Loop for Featured Products -->
            <?php if (!empty($productos_destacados)): ?>
                <?php foreach ($productos_destacados as $producto): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="assets/uploads/productos/<?php echo $producto->imagen ?>" alt="<?= htmlspecialchars($producto->nombre_producto) ?>">
                            <div class="stock-badge <?= ($producto->stock > 0) ? 'in-stock' : 'out-of-stock' ?>">
                                <?= ($producto->stock > 0) ? 'En Stock' : 'Sin Stock' ?>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title"><?= htmlspecialchars($producto->nombre_producto) ?></h5>
                            <p class="product-price">Gs. <?= number_format($producto->precio, 0, ',', '.') ?></p>
                            <div class="product-actions">
                                <button class="btn btn-primary-custom btn-add-cart" data-id="<?= $producto->id_producto ?>" <?= ($producto->stock <= 0) ? 'disabled' : '' ?>>
                                    <i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito
                                </button>
                                <button class="btn btn-favorite btn-fav <?= (isset($producto->es_favorito) && $producto->es_favorito) ? 'active' : '' ?>" data-id="<?= $producto->id_producto ?>">
                                    <i class="<?= (isset($producto->es_favorito) && $producto->es_favorito) ? 'fas text-danger' : 'far' ?> fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info" style="background: var(--card-bg); border: 1px solid var(--accent-blue); color: var(--accent-blue);">
                        <i class="fas fa-info-circle me-2"></i>
                        No hay productos destacados disponibles en este momento.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="categories-section py-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Categorías Gaming</h2>
            <p class="section-subtitle">Explora nuestras categorías especializadas y encuentra exactamente lo que necesitas para tu setup perfecto</p>
        </div>
        <div class="categories-grid" id="categories-container">
            <!-- Initial 6 categories will be loaded here -->
            <?php if (!empty($categorias)): ?>
                <?php $count = 0; ?>
                <?php foreach ($categorias as $categoria): ?>
                    <?php if ($count < 6): ?>
                        <div class="category-card category-item" data-category-id="<?= $categoria->id_categoria ?>" onclick="location.href='index.php?c=productos&id_categoria=<?= $categoria->id_categoria ?>'">
                            <img src="assets/uploads/categorias/<?= $categoria->imagen ?>" alt="<?= htmlspecialchars($categoria->nombre_categoria) ?>" class="category-image">
                            <div class="category-content">
                                <h4 class="category-title"><?= htmlspecialchars($categoria->nombre_categoria) ?></h4>
                                <p class="category-description">Descubre los mejores productos de esta categoría</p>
                            </div>
                        </div>
                        <?php $count++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info" style="background: var(--card-bg); border: 1px solid var(--accent-blue); color: var(--accent-blue);">
                        <i class="fas fa-info-circle me-2"></i>
                        No hay categorías disponibles en este momento.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Load More Categories Button -->
        <?php if (count($categorias) > 6): ?>
            <div class="text-center mt-4">
                <button class="load-more-btn" id="load-more-categories" data-loaded="6" data-total="<?= count($categorias) ?>">
                    <i class="fas fa-plus me-2"></i>Ver Más Categorías
                    <span class="ms-2">(<?= count($categorias) - 6 ?> restantes)</span>
                </button>
            </div>
        <?php endif; ?>
    </section>

    <!-- Featured Banner -->
    <div class="featured-banner">
        <h3 class="orbitron" style="font-size: 2.5rem; color: var(--primary-gold); margin-bottom: 1rem; position: relative; z-index: 1;">
            🏆 Setup Gaming Profesional
        </h3>
        <p style="font-size: 1.2rem; color: var(--text-secondary); position: relative; z-index: 1; margin-bottom: 2rem;">
            Lleva tu experiencia gaming al próximo nivel con nuestros equipos profesionales y accesorios de alta gama
        </p>
        <button class="hero-cta" style="position: relative; z-index: 1;">
            <i class="fas fa-trophy me-2"></i>
            Ver Setup Completo
        </button>
    </div>

    <!-- Best Products Section -->
    <section id="best-products" class="py-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Productos Más Vendidos</h2>
            <p class="section-subtitle">Los productos favoritos de nuestra comunidad gaming. Calidad y rendimiento comprobados por miles de usuarios</p>
        </div>
        <div class="product-grid">
            <!-- Recorrer productos desde php -->
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="assets/uploads/productos/<?php echo $producto->imagen ?>" alt="<?= htmlspecialchars($producto->nombre_producto) ?>">
                            <div class="stock-badge <?= ($producto->stock > 0) ? 'in-stock' : 'out-of-stock' ?>">
                                <?= ($producto->stock > 0) ? 'En Stock' : 'Sin Stock' ?>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title"><?= htmlspecialchars($producto->nombre_producto) ?></h5>
                            <p class="product-price">Gs. <?= number_format($producto->precio, 0, ',', '.') ?></p>
                            <div class="product-actions">
                                                                <!-- Boton de editar si sos admin -->
                                                                <?php if ($_SESSION['nivel'] === '1'): ?>
                                    <button class="btn btn-warning btn-edit-product" data-bs-toggle="modal" data-bs-target="#crudModal" data-c="productos" data-id="<?= $producto->id_producto ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-primary-custom btn-add-cart" data-id="<?= $producto->id_producto ?>" <?= ($producto->stock <= 0) ? 'disabled' : '' ?>>
                                    <i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito
                                </button>
                                <button class="btn btn-favorite btn-fav <?= (isset($producto->es_favorito) && $producto->es_favorito) ? 'active' : '' ?>" data-id="<?= $producto->id_producto ?>">
                                    <i class="<?= (isset($producto->es_favorito) && $producto->es_favorito) ? 'fas text-danger' : 'far' ?> fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        padding: 40px;
        background-color: #2a2a35; /* Un tono más oscuro para el contraste */
        border: 2px dashed #4e4e5e;
        border-radius: 12px;
        color: #e0e0e0;
        font-size: 1.2rem;
        margin-top: 2rem;
        margin-bottom: 2rem;
    ">
                    <i class="fas fa-box-open" style="font-size: 3rem; color: #f5b721; margin-bottom: 1rem;"></i>
                    <h4 style="margin: 0;">¡Lo sentimos!</h4>
                    <p style="margin: 0.5rem 0 0;">No hay productos disponibles en este momento.</p>
                    <p style="margin: 0; font-size: 0.9rem; color: #a0a0a0;">Vuelve pronto para ver las novedades.</p>
                </div>
            <?php endif; ?>


        </div>
    </section>

    <!-- Promotional Banner 2 -->
    <section class="promo-banner" style="background: var(--gradient-secondary);">
        <div class="promo-content">
            <h3 class="promo-title">💻 NUEVOS ARRIVALS 💻</h3>
            <p class="promo-text">Las últimas tecnologías en gaming ya están aquí. Sé el primero en probarlas.</p>
            <button class="promo-btn">Ver Novedades</button>
        </div>
    </section>

</div>

<!-- Footer -->
<!-- <footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-section">
                    <h5><i class="fas fa-gamepad me-2"></i>Million Tech</h5>
                    <p class="text-muted">Tu tienda especializada en gaming y tecnología. Ofrecemos los mejores productos con calidad garantizada y precios competitivos.</p>
                    <div class="social-links">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" title="Discord"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <div class="footer-section">
                    <h5>Categorías</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-desktop me-2"></i>Monitores</a></li>
                        <li><a href="#"><i class="fas fa-keyboard me-2"></i>Periféricos</a></li>
                        <li><a href="#"><i class="fas fa-microchip me-2"></i>Componentes</a></li>
                        <li><a href="#"><i class="fas fa-chair me-2"></i>Sillas Gaming</a></li>
                        <li><a href="#"><i class="fas fa-headphones me-2"></i>Audio</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <div class="footer-section">
                    <h5>Ayuda</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-question-circle me-2"></i>FAQ</a></li>
                        <li><a href="#"><i class="fas fa-shipping-fast me-2"></i>Envíos</a></li>
                        <li><a href="#"><i class="fas fa-undo me-2"></i>Devoluciones</a></li>
                        <li><a href="#"><i class="fas fa-tools me-2"></i>Soporte</a></li>
                        <li><a href="#"><i class="fas fa-shield-alt me-2"></i>Garantías</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-section">
                    <h5><i class="fas fa-envelope me-2"></i>Contacto</h5>
                    <ul>
                        <li><i class="fas fa-map-marker-alt me-2"></i>Ciudad del Este, Paraguay</li>
                        <li><i class="fas fa-phone me-2"></i>+595 61 123-4567</li>
                        <li><i class="fas fa-envelope me-2"></i>info@milliontech.com</li>
                        <li><i class="fas fa-clock me-2"></i>Lun - Sáb: 8:00 - 20:00</li>
                    </ul>
                    <div class="mt-3">
                        <h6 class="text-muted mb-2">Newsletter</h6>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Tu email" style="background: var(--card-bg); border: 1px solid var(--primary-gold); color: var(--text-primary);">
                            <button class="btn btn-primary-custom">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p>&copy; 2024 Million Tech. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="me-3">
                        <i class="fas fa-credit-card me-2"></i>Métodos de pago:
                    </span>
                    <i class="fab fa-cc-visa text-primary me-2"></i>
                    <i class="fab fa-cc-mastercard text-warning me-2"></i>
                    <i class="fab fa-cc-paypal text-info me-2"></i>
                </div>
            </div>
        </div>
    </div>
</footer> -->
<?php include ('view/crudModal.php') ?>


<script>
    // Hero Carousel Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.hero-indicator');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            slides[index].classList.add('active');
            indicators[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopSlideshow() {
            clearInterval(slideInterval);
        }

        // Indicator click handlers
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
                stopSlideshow();
                setTimeout(startSlideshow, 1000);
            });
        });

        // Pause on hover
        const heroCarousel = document.querySelector('.hero-carousel');
        heroCarousel.addEventListener('mouseenter', stopSlideshow);
        heroCarousel.addEventListener('mouseleave', startSlideshow);

        // Start the slideshow
        startSlideshow();
    });

    // Categories Load More Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more-categories');

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const loaded = parseInt(this.dataset.loaded);
                const total = parseInt(this.dataset.total);
                const container = document.getElementById('categories-container');

                // Add loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Cargando...';
                this.disabled = true;

                // Simulate loading (replace with actual PHP/AJAX call)
                setTimeout(() => {
                    const categoriesToShow = Math.min(3, total - loaded);
                    const newLoaded = loaded + categoriesToShow;

                    // Here you would normally make an AJAX call to get more categories
                    // For demo purposes, we'll show placeholder categories
                    for (let i = 0; i < categoriesToShow; i++) {
                        const categoryCard = document.createElement('div');
                        categoryCard.className = 'category-card category-item fade-in-up';
                        categoryCard.innerHTML = `
                                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Categoría" class="category-image">
                                <div class="category-content">
                                    <h4 class="category-title">Categoría ${loaded + i + 1}</h4>
                                    <p class="category-description">Descubre los mejores productos</p>
                                </div>
                            `;
                        container.appendChild(categoryCard);
                    }

                    this.dataset.loaded = newLoaded;

                    if (newLoaded >= total) {
                        this.style.display = 'none';
                    } else {
                        this.innerHTML = '<i class="fas fa-plus me-2"></i>Ver Más Categorías <span class="ms-2">(' + (total - newLoaded) + ' restantes)</span>';
                        this.disabled = false;
                    }
                }, 1000);
            });
        }
    });

    // Original Scripts - MANTENER SIN CAMBIOS
    $(document).on('click', '.btn-fav', function() {
        var button = $(this);
        var id = button.data('id');
        var isLoggedIn = <?= isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] ? 'true' : 'false' ?>;

        if (!isLoggedIn) {
            Swal.fire({
                icon: 'warning',
                title: 'Debes iniciar sesión',
                text: 'Para añadir productos a favoritos necesitas iniciar sesión.',
                confirmButtonText: 'Ir al login'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php?c=login";
                }
            });
            return;
        }

        button.prop('disabled', true);

        // Determinar si la acción es "agregar" o "eliminar"
        var action = button.find('i').hasClass('text-danger') ? 'remove' : 'add';
        var url = 'index.php?c=favoritos&a=' + action;

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                id_producto: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (action === 'add') {
                        button.find('i').removeClass('far').addClass('fas text-danger');
                        console.log(response.success);
                    } else {
                        // Si se eliminó, cambia el icono a vacío y gris
                        button.find('i').removeClass('fas text-danger').addClass('far');
                    }

                    updateCounters();

                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error
                    });
                }
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });


    // Smooth scrolling para los enlaces del hero
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animaciones al scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);

    // Observar elementos para animaciones
    document.querySelectorAll('.product-card, .category-card, .section-title').forEach(el => {
        observer.observe(el);
    });

    // Newsletter subscription
    document.addEventListener('DOMContentLoaded', function() {
        const newsletterForm = document.querySelector('.input-group');
        if (newsletterForm) {
            const submitBtn = newsletterForm.querySelector('button');
            const emailInput = newsletterForm.querySelector('input[type="email"]');

            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const email = emailInput.value.trim();

                if (!email) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Email requerido',
                        text: 'Por favor ingresa tu email.'
                    });
                    return;
                }

                if (!isValidEmail(email)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email inválido',
                        text: 'Por favor ingresa un email válido.'
                    });
                    return;
                }

                // Aquí puedes agregar la lógica para suscribir al newsletter
                Swal.fire({
                    icon: 'success',
                    title: '¡Suscrito!',
                    text: 'Te has suscrito exitosamente a nuestro newsletter.',
                    timer: 2000,
                    showConfirmButton: false
                });

                emailInput.value = '';
            });
        }
    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Función para actualizar contadores (si existe)
    function updateCounters() {
        if (typeof updateFavoritesCounter === 'function') {
            updateFavoritesCounter();
        }
        if (typeof updateCartCounter === 'function') {
            updateCartCounter();
        }
    }

    // Lazy loading para imágenes
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Preloader para mejorar UX
    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 300);
        }
    });

    // Función para mostrar tooltips en botones deshabilitados
    document.addEventListener('DOMContentLoaded', function() {
        const disabledButtons = document.querySelectorAll('button:disabled');
        disabledButtons.forEach(btn => {
            btn.setAttribute('title', 'Producto sin stock');
            btn.style.cursor = 'not-allowed';
        });
    });
</script>