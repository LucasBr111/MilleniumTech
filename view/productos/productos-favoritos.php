<link rel="stylesheet" href="assets/styles/favoritos.css">
<div class="fav-container">
    <div class="fav-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fav-title">Mi Lista de Deseos</h3>
                <span class="fav-countt" id="products-count">(<?= count($productos ?? []) ?> productos guardados)</span>
            </div>
            <div class="col-md-4 text-end">
                <a href="#" id="clear-fav-list" class="fav-clear-btn">
                    <i class="fas fa-trash me-1"></i>
                    Limpiar lista
                </a>
            </div>
        </div>
    </div>

    <div id="products-container">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <?php
                $stockStatus = '';
                $stockText = '';
                $isDisabled = false;

                if ($producto->stock <= 0) {
                    $stockStatus = 'no-stock';
                    $stockText = 'Sin stock';
                    $isDisabled = true;
                } elseif ($producto->stock <= 5) {
                    $stockStatus = 'low-stock';
                    $stockText = 'Últimas unidades';
                } else {
                    $stockStatus = 'in-stock';
                    $stockText = 'Disponible';
                }
                ?>

                <div class="fav-product-card" data-id="<?= htmlspecialchars($producto->id_producto) ?>">
                    <!-- Badge de stock -->
                    <div class="stock-badge <?= $stockStatus ?>"><?= $stockText ?></div>

                    <div class="row align-items-center">
                        <!-- Columna de imagen -->
                        <div class="col-md-3 col-sm-4">
                            <div class="product-image-container">
                                <img src="assets/uploads/productos/<?= htmlspecialchars($producto->imagen) ?>"
                                    alt="<?= htmlspecialchars($producto->nombre_producto) ?>"
                                    class="product-image">
                            </div>
                        </div>

                        <!-- Columna de detalles del producto -->
                        <div class="col-md-4 col-sm-8">
                            <div class="product-details">
                                <h5><?= htmlspecialchars($producto->nombre_producto) ?></h5>
                                <p class="mb-2">
                                    <span class="product-code">ID: <?= htmlspecialchars($producto->id_producto) ?></span>
                                </p>
                                <p class="mb-0">
                                    <span class="product-brand"><?= htmlspecialchars($producto->marca) ?></span>
                                </p>
                            </div>
                        </div>

                        <!-- Columna de cantidad y precio -->
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center mb-3">
                                <div class="quantity-control mx-auto mb-3"
                                    data-stock="<?= $producto->stock ?>"
                                    data-id="<?= $producto->id_producto ?>">
                                    <button class="btn-quantity-minus" <?= $isDisabled ? 'disabled' : '' ?>>-</button>
                                    <span class="quantity">1</span>
                                    <button class="btn-quantity-plus" <?= $isDisabled ? 'disabled' : '' ?>>+</button>
                                </div>
                                <p class="product-price">Gs. <?= number_format($producto->precio, 0, ',', '.') ?></p>
                            </div>
                        </div>

                        <!-- Columna de acciones -->
                        <div class="col-md-2 col-sm-6">
                            <div class="action-buttons">
                                <button class="remove-item-btn" data-id="<?= htmlspecialchars($producto->id_producto) ?>">
                                    <i class="fas fa-times"></i>
                                    Quitar
                                </button>
                                <button class="add-to-cart-btn"
                                    data-id="<?= htmlspecialchars($producto->id_producto) ?>"
                                    <?= $isDisabled ? 'disabled' : '' ?>>
                                    <i class="fas fa-cart-plus me-1"></i>
                                    <?= $isDisabled ? 'Sin stock' : 'Al carrito' ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="fav-summary">
                <span class="subtotal-label">Total estimado:</span>
                <span class="subtotal-value" id="total-value">Gs. <?= number_format(array_sum(array_column($productos, 'precio')), 0, ',', '.') ?></span>
            </div>
        <?php else: ?>
            <div class="empty-list">
                <div class="empty-icon">
                    <i class="fas fa-heart-broken"></i>
                </div>
                <h4>Tu lista de deseos está vacía</h4>
                <p>Descubre productos increíbles y añádelos a tu lista de deseos</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    // Manejador para el botón de AÑADIR AL CARRITO
    $('.add-to-cart-btn').on('click', function() {
        const $btn = $(this);
        const $card = $btn.closest('.fav-product-card');
        const productId = $card.data('id');
        const quantity = parseInt($card.find('.quantity').text());

        if ($btn.prop('disabled')) {
            return;
        }

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Añadiendo...');

        $.ajax({
            url: 'index.php?c=carrito&a=agregar',
            method: 'POST',
            data: {
                id_producto: productId,
                cantidad: quantity
            },
            success: function(response) {
                let currentCartCount = parseInt($('.cart-count').text()) || 0;
                updateCartCount(currentCartCount + quantity);

                // Cambia el estado del botón en la tarjeta actual
                $btn.removeClass('add-to-cart-btn').addClass('in-cart-btn').html('<i class="fas fa-check"></i> En el carrito');
                $btn.prop('disabled', true);
                $card.data('is-in-cart', 'true'); // Actualiza el estado de la tarjeta

                // Deshabilita los botones de cantidad para este producto
                $card.find('.quantity-control button').prop('disabled', true);

                // Muestra notificación de éxito
                showSuccessMessage('Producto añadido al carrito correctamente');
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-cart-plus me-1"></i> Al carrito');
                showErrorMessage('Error al añadir el producto. Intenta nuevamente.');
            }
        });
    });

    // Manejador para el botón de AUMENTAR CANTIDAD
    $('.btn-quantity-plus').on('click', function() {
        const $btn = $(this);
        const $quantityControl = $btn.closest('.quantity-control');
        const $quantitySpan = $quantityControl.find('.quantity');
        let quantity = parseInt($quantitySpan.text());
        const stock = parseInt($quantityControl.data('stock'));

        if (quantity < stock) {
            quantity++;
            $quantitySpan.text(quantity);
            $btn.siblings('.btn-quantity-minus').prop('disabled', false);
        }

        if (quantity >= stock) {
            $btn.prop('disabled', true);
        }
        
        updateSubtotal();
    });

    // Manejador para el botón de DISMINUIR CANTIDAD
    $('.btn-quantity-minus').on('click', function() {
        const $btn = $(this);
        const $quantityControl = $btn.closest('.quantity-control');
        const $quantitySpan = $quantityControl.find('.quantity');
        let quantity = parseInt($quantitySpan.text());

        if (quantity > 1) {
            quantity--;
            $quantitySpan.text(quantity);
            $btn.siblings('.btn-quantity-plus').prop('disabled', false);
        }
        
        if (quantity <= 1) {
            $btn.prop('disabled', true);
        }
        
        updateSubtotal();
    });

    // Manejador para la eliminación de un producto
    $('.remove-item-btn').on('click', function() {
        const $btn = $(this);
        const productId = $btn.data('id');
        const $itemElement = $btn.closest('.fav-product-card');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Remover este producto de tu lista de deseos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, remover',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Removiendo...');
                $.ajax({
                    url: 'index.php?c=favoritos&a=remove',
                    method: 'POST',
                    data: {
                        id_producto: productId
                    },
                    success: function(response) {
                        $itemElement.addClass('removing');
                        $itemElement.fadeOut(400, function() {
                            $(this).remove();
                            updateProductCount();
                            updateSubtotal();
                            checkEmptyList();
                        });
                    },
                    error: function() {
                        $btn.prop('disabled', false).html('<i class="fas fa-times"></i> Quitar');
                    }
                });
            }
        });
    });

    // Función para limpiar toda la lista
    $('#clear-fav-list').on('click', function(e) {
        e.preventDefault();
        if ($('.fav-product-card').length === 0) {
            return;
        }

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminarán todos los productos de tu lista de deseos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, limpiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const $btn = $('#clear-fav-list');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Limpiando...');
                $.ajax({
                    url: 'index.php?c=favoritos&a=clean',
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('.fav-product-card').fadeOut(400, function() {
                                $(this).remove();
                                updateProductCount();
                                updateSubtotal();
                                checkEmptyList();
                            });
                            Swal.fire('¡Listo!', response.success, 'success');
                        } else if (response.error) {
                            Swal.fire('Error', response.error, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo limpiar la lista. Intenta nuevamente.', 'error');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html('<i class="fas fa-trash"></i> Limpiar lista');
                    }
                });
            }
        });
    });
    
    // Funciones auxiliares
    function updateProductCount(count = null) {
        if (count === null) {
            count = $('.fav-product-card').length;
        }
        $('#products-count').text(`(${count} productos guardados)`);
    }

    function updateSubtotal() {
        let total = 0;
        $('.fav-product-card').each(function() {
            const priceText = $(this).find('.product-price').text();
            const price = parseInt(priceText.replace(/[^\d]/g, ''));
            const quantity = parseInt($(this).find('.quantity').text());

            if (!isNaN(price) && !isNaN(quantity)) {
                total += price * quantity;
            }
        });
        $('#total-value').text(`Gs. ${total.toLocaleString('es-PY')}`);
    }

    function checkEmptyList() {
        if ($('.fav-product-card').length === 0) {
            showEmptyState();
        }
    }

    function showEmptyState() {
        $('#products-container').html(`
            <div class="empty-list">
                <div class="empty-icon">
                    <i class="fas fa-heart-broken"></i>
                </div>
                <h4>Tu lista de deseos está vacía</h4>
                <p>Descubre productos increíbles y añádelos a tu lista de deseos</p>
            </div>
        `);
    }

    function updateCartCount(count) {
        $('.cart-count').text(count);
    }
    
    function showSuccessMessage(message) {
        const $alert = $(`
            <div class="alert alert-success alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;">
                <i class="fas fa-check-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('body').append($alert);
        setTimeout(() => {
            $alert.fadeOut(() => $alert.remove());
        }, 4000);
    }

    function showErrorMessage(message) {
        const $alert = $(`
            <div class="alert alert-danger alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;">
                <i class="fas fa-exclamation-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('body').append($alert);
        setTimeout(() => {
            $alert.fadeOut(() => $alert.remove());
        }, 4000);
    }

    // Inicialización del estado de los botones al cargar la página
    $('.fav-product-card').each(function() {
        const $card = $(this);
        const stock = parseInt($card.find('.quantity-control').data('stock'));
        const $minusBtn = $card.find('.btn-quantity-minus');

        // Deshabilitar botón de "menos" por defecto
        $minusBtn.prop('disabled', true);

        // Si no hay stock, deshabilitar todos los controles de cantidad y el botón de "Añadir al carrito"
        if (stock <= 0) {
            $card.find('.quantity-control button').prop('disabled', true);
        }
    });

    // Llama a la función para establecer el estado de los botones (en caso de que ya estén en el carrito)
    checkCartStatus();
    
    // Llamar a updateSubtotal al inicio para que el total se muestre correctamente
    updateSubtotal();
});
</script>