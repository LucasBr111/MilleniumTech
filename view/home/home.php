<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/styles/home.css">

<div class="container-fluid">
    <section id="hero-banner" class="hero-banner mb-5">
        <h1>Bienvenido a Million Tech</h1>
        <p>Descubre lo último en tecnología y gadgets. Explora nuestra exclusiva selección de productos diseñados para la innovación y el rendimiento.</p>
        <!-- Boton de agregar productos en boostrap -->

        <button data-bs-toggle="modal" data-bs-target="#crudModal" data-c="productos" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Agregar
        </button>

        <button data-bs-toggle="modal" data-bs-target="#crudModal" data-c="categorias" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Agregar categorias
        </button>
    </section>


    <section id="featured-products" class="py-5">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="section-title">Productos Destacados</h2>
                <p class="section-subtitle">Lo mejor de nuestro catálogo, seleccionado para ti.</p>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-3">
    <?php if (!empty($productos_destacados)): ?>
        <?php foreach ($productos_destacados as $producto): ?>
            <div class="col">
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="assets/uploads/productos/<?php echo $producto->imagen ?>" class="img-fluid" alt="<?= $producto->nombre_producto ?>">
                        <span class="stock-badge <?= ($producto->stock > 0) ? 'bg-success' : 'bg-danger' ?>">
                            <?= ($producto->stock > 0) ? 'En Stock' : 'Sin Stock' ?>
                        </span>
                    </div>
                    <div class="product-info">
                        <h5 class="product-title"><?= htmlspecialchars($producto->nombre_producto) ?></h5>
                        <p class="product-price">
                            <span class="currency-symbol">Gs.</span>
                            <?= number_format($producto->precio, 0, ',', '.') ?>
                        </p>
                        <div class="product-actions d-flex justify-content-between align-items-center mt-3">
                            <button class="btn btn-add-cart" data-id="<?= $producto->id_producto ?>">Añadir al carrito</button>
                            
                            <button class="btn btn-fav" data-id="<?= $producto->id_producto ?>">
                                <i class="<?= ($producto->es_favorito !== null) ? 'fas text-danger' : 'far' ?> fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center">
            <p class="text-muted">No hay productos destacados disponibles en este momento.</p>
        </div>
    <?php endif; ?>
</div>
    </section>


    <section id="category-banners" class="py-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Categorías Populares</h2>
            <p class="section-subtitle">Encuentra la tecnología que buscas.</p>
        </div>
    </div>

    <div id="categoryCarouselContainer" class="position-relative">
        <div class="row g-3" id="carouselItems">
            <?php foreach ($categorias as $r): ?>
                <div class="col-md-4 category-item d-none">
                    <a href="index.php?c=productos&a=listarcategoria&id=<?= $r->id_categoria ?>" class="d-block text-decoration-none">
                        <div class="category-banner-card">
                            <img src="assets/uploads/categorias/<?= $r->imagen ?>" alt="<?= $r->nombre_categoria ?>" class="img-fluid">
                            <div class="category-overlay">
                                <h4 class="category-title"><?= $r->nombre_categoria ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" id="prevBtn" type="button">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" id="nextBtn" type="button">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</section>



<section id="new-arrivals" class="py-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Novedades</h2>
            <p class="section-subtitle">Lo último en tecnología y lanzamientos exclusivos.</p>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-3">
        <?php if (!empty($productos_novedades)): ?>
            <?php foreach ($productos_novedades as $producto): ?>
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="<?= $producto->imagen ?>" class="img-fluid" alt="<?= $producto->nombre_producto ?>">
                            <span class="stock-badge <?= ($producto->stock > 0) ? 'bg-success' : 'bg-danger' ?>">
                                <?= ($producto->stock > 0) ? 'En Stock' : 'Sin Stock' ?>
                            </span>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title"><?= htmlspecialchars($producto->nombre_producto) ?></h5>
                            <p class="product-price">
                                <span class="currency-symbol">Gs.</span>
                                <?= number_format($producto->precio, 0, ',', '.') ?>
                            </p>
                            <div class="product-actions d-flex justify-content-between align-items-center mt-3">
                                <button class="btn btn-add-cart" data-id="<?= $producto->id_producto ?>">Añadir al carrito</button>
                                <button class="btn btn-fav" data-id="<?= $producto->id_producto ?>"><i class="fas fa-heart"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">No hay productos nuevos disponibles en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title section-title" id="loginModalLabel">Inicia Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted">Para añadir productos al carrito o a favoritos, necesitas estar registrado. ¡Únete a la experiencia Million Tech!</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="index.php?c=login&a=index" class="btn btn-login-modal">Iniciar Sesión</a>
                <a href="index.php?c=register&a=index" class="btn btn-register-modal">Registrarse</a>
            </div>
        </div>
    </div>
</div>
<?php include 'view/crudModal.php'; ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.category-item');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const totalItems = items.length;
        let startIndex = 0; // El índice del primer elemento visible

        // Función para actualizar la visibilidad de los elementos
        function updateCarousel() {
            // Oculta todos los elementos
            items.forEach(item => item.classList.add('d-none'));

            // Muestra los 3 elementos a partir del índice actual
            for (let i = 0; i < 3; i++) {
                if (startIndex + i < totalItems) {
                    items[startIndex + i].classList.remove('d-none');
                }
            }

            // Deshabilita los botones en los extremos
            prevBtn.disabled = startIndex === 0;
            nextBtn.disabled = startIndex >= totalItems - 3;
        }

        // Manejador del botón "Siguiente"
        nextBtn.addEventListener('click', function() {
            if (startIndex < totalItems - 3) {
                startIndex++;
                updateCarousel();
            }
        });

        // Manejador del botón "Anterior"
        prevBtn.addEventListener('click', function() {
            if (startIndex > 0) {
                startIndex--;
                updateCarousel();
            }
        });

        // Inicializa el carrusel al cargar la página
        updateCarousel();
    });
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
    var url = 'index.php?c=productos&a=' + action + 'favorito';
    
    $.ajax({
        url: url,
        method: 'POST',
        data: { id_producto: id },
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
            } else if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            }
        },
        error: function(xhr) {
            var errorMessage = 'Error en la petición.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        },
        complete: function() {
            button.prop('disabled', false);
        }
    });
});
</script>