<link rel="stylesheet" href="assets/styles/carrito.css">
<div class="cart-container">
    <div class="cart-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="cart-title">Mi Carrito de Compras</h3>
                <span class="cart-count-display" id="items-count">(<?= count($productos ?? []) ?> productos seleccionados)</span>
            </div>
            <div class="col-md-4 text-end">
                <a id="clear-cart" class="cart-clear-btn">
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
                $precio_unitario = $producto->precio_final ?? $producto->precio; // Usa precio_final si está disponible
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
        const FORMAT_OPTIONS = {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        };
        const LOCALE = 'es-PY';

        // --- FUNCIONES AUXILIARES DE CÁLCULO Y VISTA ---

        // Función para formatear números como moneda (Gs.)
        function formatCurrency(number) {
            // Asegura que el número se formatee sin decimales
            return `Gs. ${Math.round(number).toLocaleString(LOCALE, FORMAT_OPTIONS)}`;
        }

        // Actualiza el subtotal de una tarjeta de producto
        function updateProductSubtotal($productCard) {
            const quantity = parseInt($productCard.find('.quantity').text());
            // Se usa .data() para obtener el valor numérico
            const basePrice = parseInt($productCard.find('.product-subtotal').data('base-price'));
            const newSubtotal = basePrice * quantity;

            $productCard.find('.product-subtotal').text(formatCurrency(newSubtotal));
        }

        // Actualiza el subtotal y el total del resumen del carrito
        function updateCartTotals() {
            let subtotal = 0;
            let totalItems = 0;

            $('.cart-product-card').each(function() {
                const quantity = parseInt($(this).find('.quantity').text());
                const basePrice = parseInt($(this).find('.product-subtotal').data('base-price'));
                subtotal += basePrice * quantity;
                totalItems += quantity; // Acumular la cantidad total de productos
            });

            const total = subtotal + SHIPPING_COST;

            $('#cart-subtotal').text(formatCurrency(subtotal));
            $('#cart-total').text(formatCurrency(total));

            // Actualiza el contador en el resumen
            $('.summary-row:first-child span:first-child').text(`Subtotal (${$('.cart-product-card').length} productos):`);

            // Actualiza el contador en el header del carrito
            updateItemsCount();
        }

        // Actualiza el texto del contador de productos
        function updateItemsCount() {
            const count = $('.cart-product-card').length;
            $('#items-count').text(`(${count} productos seleccionados)`);
        }

        // Muestra el estado de carrito vacío si no hay productos
        function checkEmptyCart() {
            if ($('.cart-product-card').length === 0) {
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
                // Deshabilita el botón de checkout
                $('#proceed-checkout').prop('disabled', true);
                $('#clear-cart').hide();
            } else {
                $('#proceed-checkout').prop('disabled', false);
                $('#clear-cart').show();
            }
        }

        // Función de SweetAlert genérica
        function fireAlert(icon, title, text) {
            Swal.fire({
                icon,
                title,
                text
            });
        }

        // --- MANEJADORES DE EVENTOS ---

        // Función para actualizar cantidad en el servidor y vista
        function updateQuantityInServer(productId, newQuantity, $quantitySpan, $quantityControl) {
            const originalQuantity = parseInt($quantitySpan.data('original'));

            // Mostrar indicador de carga/proceso temporal
            $quantitySpan.addClass('loading-quantity').html('<i class="fas fa-circle-notch fa-spin"></i>');

            $.ajax({
                url: 'index.php?c=carrito&a=actualizar',
                method: 'POST',
                data: {
                    id_producto: productId,
                    cantidad: newQuantity
                },
                success: function(response) {
                    $quantitySpan.removeClass('loading-quantity');

                    // Asumiendo que el servidor devuelve un JSON con 'success: true'
                    if (response && response.success) {
                        $quantitySpan.text(newQuantity).data('original', newQuantity);

                        // Actualizar botones de cantidad
                        const stock = parseInt($quantityControl.data('stock'));
                        $quantityControl.find('.btn-quantity-minus').prop('disabled', newQuantity <= 1);
                        $quantityControl.find('.btn-quantity-plus').prop('disabled', newQuantity >= stock);

                        // Actualizar subtotal y totales
                        updateProductSubtotal($quantityControl.closest('.cart-product-card'));
                        updateCartTotals();

                    } else {
                        $quantitySpan.text(originalQuantity); // Revertir en caso de error del servidor
                        fireAlert('error', 'Error', response.error || 'No se pudo actualizar la cantidad. Intenta nuevamente.');
                    }
                },
                error: function() {
                    $quantitySpan.removeClass('loading-quantity').text(originalQuantity);
                    fireAlert('error', 'Error', 'Error de comunicación con el servidor. Intenta nuevamente.');
                }
            });
        }

        // 1. Manejador de botones de cantidad (usando delegación para elementos dinámicos)
        $('#cart-products-container').on('click', '.btn-quantity-plus', function() {
            const $btn = $(this);
            const $quantityControl = $btn.closest('.quantity-control');
            const $quantitySpan = $quantityControl.find('.quantity');
            const productId = $quantityControl.data('id');
            let quantity = parseInt($quantitySpan.text());
            const stock = parseInt($quantityControl.data('stock'));

            if (quantity < stock) {
                quantity++;
                updateQuantityInServer(productId, quantity, $quantitySpan, $quantityControl);
            } else {
                fireAlert('warning', 'Stock limitado', `Solo hay ${stock} unidades disponibles.`);
            }
        }).on('click', '.btn-quantity-minus', function() {
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

        // 2. Función para eliminar producto del carrito
        function removeFromCart(productId, $productCard) {
            $.ajax({
                url: 'index.php?c=carrito&a=eliminar',
                method: 'POST',
                data: {
                    id_producto: productId
                },
                success: function(response) {
                    // Asumiendo que el servidor responde con JSON
                    if (response && response.success) {
                        $productCard.fadeOut(400, function() {
                            $(this).remove();
                            updateCartTotals(); // Recalcula totales y actualiza conteo
                            checkEmptyCart(); // Revisa si queda vacío
                        });
                        fireAlert('success', 'Eliminado', 'Producto eliminado del carrito.');
                    } else {
                        fireAlert('error', 'Error', response.error || 'Error al eliminar el producto.');
                    }
                },
                error: function() {
                    fireAlert('error', 'Error', 'Error de comunicación al intentar eliminar.');
                }
            });
        }

        // Manejador para eliminar producto (usando delegación)
        $('#cart-products-container').on('click', '.remove-from-cart-btn', function() {
            const $btn = $(this);
            const $productCard = $btn.closest('.cart-product-card');
            const productId = $productCard.data('id');
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

        // 3. Manejador para vaciar carrito
        $('#clear-cart').on('click', function(e) {
            e.preventDefault();

            // Se asegura que haya productos antes de mostrar el SweetAlert
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
                    $.ajax({
                        url: 'index.php?c=carrito&a=vaciar',
                        method: 'POST',
                        success: function(response) {
                            // Asumiendo que el servidor responde con JSON
                            if (response && response.success) {
                                $('.cart-product-card').fadeOut(400, function() {
                                    $(this).remove();
                                    updateCartTotals();
                                    checkEmptyCart(); // Muestra el estado de carrito vacío
                                });
                                fireAlert('success', 'Éxito', 'Carrito vaciado correctamente.');
                            } else {
                                fireAlert('error', 'Error', response.error || 'Error al vaciar el carrito.');
                            }
                        },
                        error: function() {
                            fireAlert('error', 'Error', 'Error de comunicación al intentar vaciar el carrito.');
                        }
                    });
                }
            });
        });

        // 4. Procesar Venta / Checkout
        $('#proceed-checkout').on('click', function() {
            const $btn = $(this);

            if ($('.cart-product-card').length === 0) {
                fireAlert('error', 'Error', 'Tu carrito está vacío, no se puede procesar la compra.');
                return;
            }

            let productosVenta = [];
            let totalVenta = 0;

            // Recopila datos del DOM para enviar la lista final al servidor
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

            // Deshabilita el botón e indica el proceso
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Procesando...');

            $.ajax({
                url: 'index.php?c=venta&a=guardar',
                method: 'POST',
                data: {
                    productos: productosVenta,
                    total: totalConEnvio,
                    // Estos parámetros probablemente deberían ser dinámicos, pero se mantienen como ejemplo
                    metodo_pago: 'Pendiente',
                    estado_pago: 'Pendiente',
                    id_cliente: <?= $_SESSION['user_id'] ?>
                },
                dataType: 'json',
                success: function(response) {
                    // Vuelve a habilitar el botón y su texto original
                    $btn.prop('disabled', false).html('<i class="fas fa-credit-card me-2"></i>Comprar ahora');
                    console.log(response);
                    if (response.success) {
                        Swal.fire({
                            title: '¡Felicidades por tu Compra! 🎉',
                            html: `
            Tu pedido ha sido registrado correctamente.
            <br><br>
            <strong>Es necesario que confirmes tu dirección de envío.</strong>
            <br>
            Te redirigiremos a tu perfil para que lo hagas.
        `,
                            icon: 'success',
                            showCancelButton: false,
                            showDenyButton: false,

                            confirmButtonColor: '#3085d6', // Azul para una acción positiva
                            confirmButtonText: 'Ir a mi Perfil (Confirmar Envío)',
                            footer: 'Recibirás los detalles de tu compra por correo electrónico/WhatsApp.'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php?c=cliente';
                            } else {
                                window.location.href = 'index.php?c=cliente';
                            }
                        });
                    } else {
                        fireAlert('error', 'Error en la Compra', response.error || 'No se pudo completar la compra. Revisa el stock.');
                    }
                },
                error: function() {
                    // Revertir el estado del botón en caso de error
                    $btn.prop('disabled', false).html('<i class="fas fa-credit-card me-2"></i>Comprar ahora');
                    fireAlert('error', 'Error', 'Error de comunicación al procesar la venta.');
                }
            });
        });

        // --- INICIALIZACIÓN ---
        // Recalcula los totales al cargar la página para asegurar consistencia
        updateCartTotals();
        checkEmptyCart(); // Comprueba si el carrito está vacío al iniciar
    });
</script>