<link rel="stylesheet" href="assets/styles/carrito.css">
<div class="cart-container">
    <div class="cart-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="cart-title">Mi Carrito de Compras</h3>
                <span class="cart-count-display" id="items-count">(<?= count($productos ?? []) ?> productos seleccionados)</span>
            </div>
            <div class="col-md-4 text-end">
                <a href="#" id="clear-cart" class="cart-clear-btn">
                    <i class="fas fa-trash-alt me-1"></i>
                    Vaciar carrito
                </a>
            </div>
        </div>
    </div>

    <div id="cart-products-container">
        <?php if (!empty($productos)): ?>
            <?php
            $subtotal = 0;
            foreach ($productos as $item):
                $producto = $item->producto ?? $item; // Flexibilidad en la estructura de datos
                $cantidad = $item->cantidad ?? 1;
                $precio_unitario = $producto->precio;
                $precio_total = $precio_unitario * $cantidad;
                $subtotal += $precio_total;

                // Estado del stock
                $stockStatus = '';
                $stockText = '';
                $isDisabled = false;

                if ($producto->stock <= 0) {
                    $stockStatus = 'no-stock';
                    $stockText = 'Sin stock';
                    $isDisabled = true;
                } elseif ($producto->stock <= 5) {
                    $stockStatus = 'low-stock';
                    $stockText = 'Stock bajo';
                } else {
                    $stockStatus = 'in-stock';
                    $stockText = 'Disponible';
                }
            ?>
                <div class="cart-product-card" data-id="<?= htmlspecialchars($producto->id_producto) ?>">
                    <!-- Badge de stock -->
                    <div class="stock-badge <?= $stockStatus ?>"><?= $stockText ?></div>

                    <div class="row align-items-center">
                        <!-- Columna de imagen -->
                        <div class="col-md-2 col-sm-3">
                            <div class="product-image-container">
                                <img src="assets/uploads/productos/<?= htmlspecialchars($producto->imagen) ?>"
                                    alt="<?= htmlspecialchars($producto->nombre_producto) ?>"
                                    class="product-image">
                            </div>
                        </div>

                        <!-- Columna de detalles del producto -->
                        <div class="col-md-4 col-sm-9">
                            <div class="product-details">
                                <h5><?= htmlspecialchars($producto->nombre_producto) ?></h5>
                                <p class="mb-2">
                                    <span class="product-code">SKU: <?= htmlspecialchars($producto->id_producto) ?></span>
                                    <span class="product-brand ms-2"><?= htmlspecialchars($producto->marca) ?></span>
                                </p>
                                <div class="product-unit-price">
                                    <span class="price-label">Precio unitario:</span>
                                    <span class="unit-price">Gs. <?= number_format($precio_unitario, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Columna de cantidad -->
                        <div class="col-md-2 col-sm-6">
                            <div class="quantity-section">
                                <label class="quantity-label">Cantidad</label>
                                <div class="quantity-control"
                                    data-stock="<?= $producto->stock ?>"
                                    data-id="<?= $producto->id_producto ?>"
                                    data-price="<?= $precio_unitario ?>">
                                    <button class="btn-quantity-minus" <?= ($cantidad <= 1 || $isDisabled) ? 'disabled' : '' ?>>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="quantity" data-original="<?= $cantidad ?>"><?= $cantidad ?></span>
                                    <button class="btn-quantity-plus" <?= ($cantidad >= $producto->stock || $isDisabled) ? 'disabled' : '' ?>>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Columna de subtotal -->
                        <div class="col-md-2 col-sm-6">
                            <div class="subtotal-section">
                                <label class="subtotal-label">Subtotal</label>
                                <div class="product-subtotal" data-base-price="<?= $precio_unitario ?>">
                                    Gs. <?= number_format($precio_total, 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>

                        <!-- Columna de acciones -->
                        <div class="col-md-2">
                            <div class="action-buttons">
                                <button class="remove-from-cart-btn" data-id="<?= htmlspecialchars($producto->id_producto) ?>" title="Eliminar del carrito">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="move-to-favorites-btn" data-id="<?= htmlspecialchars($producto->id_producto) ?>" title="Mover a favoritos">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Resumen del carrito -->
            <div class="cart-summary">
                <div class="row">
                    <div class="col-md-8">
                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Subtotal (<?= count($productos) ?> productos):</span>
                                <span id="cart-subtotal">Gs. <?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>
                            <div class="summary-row">
                                <span>Envío:</span>
                                <span id="shipping-cost">Gs. 25.000</span>
                            </div>
                            <div class="summary-row discount-row" style="display: none;">
                                <span>Descuento:</span>
                                <span id="discount-amount" class="text-success">- Gs. 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="total-section">
                            <div class="total-label">Total a pagar:</div>
                            <div class="total-amount" id="cart-total">Gs. <?= number_format($subtotal + 25000, 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>

                <div class="checkout-actions mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="index.php?c=productos" class="continue-shopping-btn">
                                <i class="fas fa-arrow-left me-2"></i>
                                Continuar comprando
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="checkout-btn" id="proceed-checkout">
                                <i class="fas fa-credit-card me-2"></i>
                                Comprar ahora
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h4>Tu carrito está vacío</h4>
                <p>Explora nuestro catálogo y encuentra los productos perfectos para ti</p>
                <a href="index.php?c=productos" class="explore-products-btn">
                    <i class="fas fa-search me-2"></i>
                    Explorar productos
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).ready(function() {
                const SHIPPING_COST = 25000;

                // Manejador para aumentar cantidad
                $('.btn-quantity-plus').on('click', function() {
                    const $btn = $(this);
                    const $quantityControl = $btn.closest('.quantity-control');
                    const $quantitySpan = $quantityControl.find('.quantity');
                    const productId = $quantityControl.data('id');
                    let quantity = parseInt($quantitySpan.text());
                    const stock = parseInt($quantityControl.data('stock'));

                    if (quantity < stock) {
                        quantity++;
                        updateQuantityInServer(productId, quantity, $quantitySpan, $quantityControl);
                    }
                });

                // Manejador para disminuir cantidad
                $('.btn-quantity-minus').on('click', function() {
                    const $btn = $(this);
                    const $quantityControl = $btn.closest('.quantity-control');
                    const $quantitySpan = $quantityControl.find('.quantity');
                    const productId = $quantityControl.data('id');
                    let quantity = parseInt($quantitySpan.text());

                    if (quantity > 1) {
                        quantity--;
                        updateQuantityInServer(productId, quantity, $quantitySpan, $quantityControl);
                    }
                });

                // Función para actualizar cantidad en el servidor
                function updateQuantityInServer(productId, newQuantity, $quantitySpan, $quantityControl) {
                    const originalQuantity = parseInt($quantitySpan.data('original'));

                    $.ajax({
                        url: 'index.php?c=carrito&a=actualizar',
                        method: 'POST',
                        data: {
                            id_producto: productId,
                            cantidad: newQuantity
                        },
                        success: function(response) {
                            $quantitySpan.text(newQuantity).data('original', newQuantity);

                            // Actualizar botones de cantidad
                            const stock = parseInt($quantityControl.data('stock'));
                            $quantityControl.find('.btn-quantity-minus').prop('disabled', newQuantity <= 1);
                            $quantityControl.find('.btn-quantity-plus').prop('disabled', newQuantity >= stock);

                            // Actualizar subtotal del producto
                            updateProductSubtotal($quantityControl.closest('.cart-product-card'));

                            // Actualizar totales
                            updateCartTotals();

                            showSuccessMessage('Cantidad actualizada correctamente');
                        },
                        error: function() {
                            $quantitySpan.text(originalQuantity);
                            showErrorMessage('Error al actualizar la cantidad. Intenta nuevamente.');
                        }
                    });
                }

                // Manejador para eliminar producto del carrito
                $('.remove-from-cart-btn').on('click', function() {
                    const $btn = $(this);
                    const productId = $btn.data('id');
                    const $productCard = $btn.closest('.cart-product-card');
                    const productName = $productCard.find('h5').text();

                    Swal.fire({
                        title: '¿Eliminar producto?',
                        text: `¿Deseas quitar "${productName}" del carrito?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#520017',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            removeFromCart(productId, $productCard);
                        }
                    });
                });

                // Función para eliminar del carrito
                function removeFromCart(productId, $productCard) {
                    $.ajax({
                        url: 'index.php?c=carrito&a=eliminar',
                        method: 'POST',
                        data: {
                            id_producto: productId
                        },
                        success: function(response) {
                            $productCard.addClass('removing');
                            $productCard.fadeOut(400, function() {
                                $(this).remove();
                                updateItemsCount();
                                updateCartTotals();
                                checkEmptyCart();
                            });

                            // Actualizar contador global del carrito
                            let currentCartCount = parseInt($('.cart-count').text()) || 0;
                            const removedQuantity = parseInt($productCard.find('.quantity').text());
                            updateGlobalCartCount(Math.max(0, currentCartCount - removedQuantity));

                            showSuccessMessage('Producto eliminado del carrito');
                        },
                        error: function() {
                            showErrorMessage('Error al eliminar el producto. Intenta nuevamente.');
                        }
                    });
                }

                // Manejador para mover a favoritos
                $('.move-to-favorites-btn').on('click', function() {
                    const $btn = $(this);
                    const productId = $btn.data('id');
                    const $productCard = $btn.closest('.cart-product-card');

                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: 'index.php?c=favoritos&a=agregar',
                        method: 'POST',
                        data: {
                            id_producto: productId
                        },
                        success: function(response) {
                            // Eliminar del carrito después de añadir a favoritos
                            removeFromCart(productId, $productCard);
                            showSuccessMessage('Producto movido a favoritos');
                        },
                        error: function() {
                            $btn.prop('disabled', false).html('<i class="fas fa-heart"></i>');
                            showErrorMessage('Error al mover a favoritos. Intenta nuevamente.');
                        }
                    });
                });

                // Manejador para vaciar carrito
                $('#clear-cart').on('click', function(e) {
                    e.preventDefault();

                    if ($('.cart-product-card').length === 0) {
                        return;
                    }

                    Swal.fire({
                        title: '¿Vaciar carrito?',
                        text: "Se eliminarán todos los productos del carrito",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#520017',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, vaciar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            clearCart();
                        }
                    });
                });

                // Función para vaciar carrito
                function clearCart() {
                    $.ajax({
                        url: 'index.php?c=carrito&a=vaciar',
                        method: 'POST',
                        success: function(response) {
                            $('.cart-product-card').fadeOut(400, function() {
                                $(this).remove();
                                updateItemsCount();
                                updateCartTotals();
                                checkEmptyCart();
                            });

                            updateGlobalCartCount(0);
                            showSuccessMessage('Carrito vaciado correctamente');
                        },
                        error: function() {
                            showErrorMessage('Error al vaciar el carrito. Intenta nuevamente.');
                        }
                    });
                }

                // --- LÓGICA DE FINALIZAR COMPRA ---
                $('#proceed-checkout').on('click', function() {
                    const $btn = $(this);

                    if ($('.cart-product-card').length === 0) {
                        showErrorMessage('Tu carrito está vacío');
                        return;
                    }

                    // Recopila los datos de los productos del carrito
                    let productosVenta = [];
                    let totalVenta = 0;
                    $('.cart-product-card').each(function() {
                        const productId = $(this).data('id');
                        const quantity = parseInt($(this).find('.quantity').text());
                        const unitPrice = parseInt($(this).find('.product-subtotal').data('base-price'));

                        productosVenta.push({
                            id_producto: productId,
                            cantidad: quantity,
                            precio_unitario: unitPrice
                        });

                        totalVenta += unitPrice * quantity;
                    });

                    const totalConEnvio = totalVenta + SHIPPING_COST;

                    // Deshabilita el botón mientras se procesa la venta
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Procesando...');

                    // Envía los datos de la venta al servidor
                    $.ajax({
                        url: 'index.php?c=venta&a=guardar',
                        method: 'POST',
                        data: {
                            productos: productosVenta,
                            total: totalConEnvio,
                            metodo_pago: 'Pendiente', // O el método de pago que elijas
                            estado_pago: 'Pendiente'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: '¡Compra exitosa! 🎉',
                                    text: '¿Deseas generar una factura o un ticket?',
                                    icon: 'success',
                                    showCancelButton: true,
                                    showDenyButton: true,
                                    confirmButtonColor: '#28a745',
                                    denyButtonColor: '#17a2b8',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Generar Factura',
                                    denyButtonText: 'Generar Ticket',
                                    cancelButtonText: 'Solo finalizar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Lógica para generar factura
                                        // Redirige o llama a tu controlador de facturas
                                        window.location.href = response.redirect_url + '&a=factura';
                                    } else if (result.isDenied) {
                                        // Lógica para generar ticket
                                        // Redirige o llama a tu controlador de tickets
                                        window.location.href = response.redirect_url + '&a=ticket';
                                    } else {
                                        // Solo redirige a la página de confirmación sin generar documento
                                        window.location.href = response.redirect_url;
                                    }
                                });
                            } else {
                                Swal.fire('Error', response.error || 'No se pudo completar la compra.', 'error');
                            }
                        },
                    });

                    // Funciones auxiliares
                    function updateProductSubtotal($productCard) {
                        const quantity = parseInt($productCard.find('.quantity').text());
                        const basePrice = parseInt($productCard.find('.product-subtotal').data('base-price'));
                        const newSubtotal = basePrice * quantity;

                        $productCard.find('.product-subtotal').text(`Gs. ${newSubtotal.toLocaleString('es-PY')}`);
                    }

                    function updateCartTotals() {
                        let subtotal = 0;

                        $('.cart-product-card').each(function() {
                            const quantity = parseInt($(this).find('.quantity').text());
                            const basePrice = parseInt($(this).find('.product-subtotal').data('base-price'));
                            subtotal += basePrice * quantity;
                        });

                        const total = subtotal + SHIPPING_COST;

                        $('#cart-subtotal').text(`Gs. ${subtotal.toLocaleString('es-PY')}`);
                        $('#cart-total').text(`Gs. ${total.toLocaleString('es-PY')}`);
                    }

                    function updateItemsCount() {
                        const count = $('.cart-product-card').length;
                        $('#items-count').text(`(${count} productos seleccionados)`);
                    }

                    function checkEmptyCart() {
                        if ($('.cart-product-card').length === 0) {
                            showEmptyCartState();
                        }
                    }

                    function showEmptyCartState() {
                        $('#cart-products-container').html(`
            <div class="empty-cart">
                <div class="empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h4>Tu carrito está vacío</h4>
                <p>Explora nuestro catálogo y encuentra los productos perfectos para ti</p>
                <a href="index.php?c=productos" class="explore-products-btn">
                    <i class="fas fa-search me-2"></i>
                    Explorar productos
                </a>
            </div>
        `);
                    }

                    function updateGlobalCartCount(count) {
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

                    // Inicialización
                    updateCartTotals();
                });
</script>