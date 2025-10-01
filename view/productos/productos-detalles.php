<?php
if (!$producto) {
    header('Location: ?c=home');
    exit;
}
?>
<link rel="stylesheet" href="assets/styles/productos-detalles.css">
<div class="container my-5">
    <div class="row g-4">
        <!-- Columna de la imagen del producto -->
        <div class="col-lg-6">
            <div class="product-detail-image-container">
                <?php if ($producto->en_promocion): ?>
                    <div class="detail-badge">¡OFERTA!</div>
                <?php endif; ?>
                
                <img src="assets/uploads/productos/<?= htmlspecialchars($producto->imagen) ?>" 
                     class="product-detail-image" 
                     alt="<?= htmlspecialchars($producto->nombre_producto) ?>">
            </div>
        </div>

        <!-- Columna de información del producto -->
        <div class="col-lg-6">
            <div class="product-detail-info">
                <!-- Marca -->
                <div class="product-brand mb-2">
                    <span class="badge-brand"><?= htmlspecialchars($producto->marca) ?></span>
                </div>

                <!-- Título del producto -->
                <h1 class="product-detail-title mb-3">
                    <?= htmlspecialchars($producto->nombre_producto) ?>
                </h1>

                <!-- Precio -->
                <div class="product-detail-price mb-4">
                    <?php if ($producto->en_promocion): ?>
                        <div class="price-container">
                            <span class="detail-price-tachado">Gs. <?= number_format($producto->precio_normal, 0, ',', '.') ?></span>
                            <span class="detail-price-oferta">Gs. <?= number_format($producto->precio, 0, ',', '.') ?></span>
                            <span class="discount-badge">
                                <?= round((($producto->precio_normal - $producto->precio) / $producto->precio_normal) * 100) ?>% OFF
                            </span>
                        </div>
                    <?php else: ?>
                        <span class="detail-price-normal">Gs. <?= number_format($producto->precio, 0, ',', '.') ?></span>
                    <?php endif; ?>
                </div>

                <!-- Stock disponible -->
                <div class="stock-info mb-4">
                    <?php if ($producto->stock > 0): ?>
                        <div class="stock-available">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="#4ADE80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 10L9 12L13 8" stroke="#4ADE80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>En stock: <strong><?= $producto->stock ?> unidades disponibles</strong></span>
                        </div>
                    <?php else: ?>
                        <div class="stock-unavailable">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 7L13 13M13 7L7 13" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span><strong>Producto agotado</strong></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Descripción -->
                <div class="product-description mb-4">
                    <h3 class="section-title">Descripción</h3>
                    <p class="description-text">
                        <?= nl2br(htmlspecialchars($producto->descripcion)) ?>
                    </p>
                </div>

                <!-- Selector de cantidad y botón agregar al carrito -->
                <?php if ($producto->stock > 0): ?>
                    <div class="add-to-cart-section">
                        <div class="quantity-selector">
                            <label class="quantity-label">Cantidad:</label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn" id="decrease-qty" onclick="decreaseQuantity()">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M3 8H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                                <input type="number" 
                                       id="product-quantity" 
                                       class="quantity-input" 
                                       value="1" 
                                       min="1" 
                                       max="<?= $producto->stock ?>"
                                       readonly>
                                <button type="button" class="quantity-btn" id="increase-qty" onclick="increaseQuantity()">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 3V13M3 8H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button class="btn-add-to-cart" 
                                data-id="<?= htmlspecialchars($producto->id_producto) ?>" 
                                onclick="addToCart(<?= htmlspecialchars($producto->id_producto) ?>)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 4H5.71429L8.7 15.5C8.81671 15.9744 9.09372 16.3938 9.48564 16.6876C9.8776 16.9814 10.3602 17.1323 10.8514 17.116H18.2914C18.7716 17.1292 19.2413 16.9769 19.6231 16.6851C20.0048 16.3933 20.2754 15.9783 20.39 15.508L22.2 7.99999H7M9 21C9 21.5523 8.55228 22 8 22C7.44772 22 7 21.5523 7 21C7 20.4477 7.44772 20 8 20C8.55228 20 9 20.4477 9 21ZM20 21C20 21.5523 19.5523 22 19 22C18.4477 22 18 21.5523 18 21C18 20.4477 18.4477 20 19 20C19.5523 20 20 20.4477 20 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Agregar al carrito</span>
                        </button>
                    </div>
                <?php else: ?>
                    <div class="alert-out-of-stock">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 9V13M12 17H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Este producto no está disponible en este momento</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Especificaciones técnicas -->
    <?php if (!empty($producto->especificaciones)): ?>
        <div class="row mt-5">
            <div class="col-12">
                <div class="specifications-section">
                    <h2 class="specifications-title">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5M12 12H15M12 16H15M9 12H9.01M9 16H9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Especificaciones Técnicas
                    </h2>

                    <div class="specifications-grid">
                        <?php foreach ($producto->especificaciones as $especificacion): ?>
                            <div class="spec-item">
                                <div class="spec-label"><?= htmlspecialchars($especificacion['campo']) ?></div>
                                <div class="spec-value"><?= htmlspecialchars($especificacion['valor']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<script>
const maxStock = <?= $producto->stock ?>;

function decreaseQuantity() {
    const input = document.getElementById('product-quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function increaseQuantity() {
    const input = document.getElementById('product-quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
    }
}
function addToCart(productId) {
    // 1. Obtener la cantidad
    const quantity = parseInt(document.getElementById('product-quantity').value);

    // 2. Definir la referencia al botón (USANDO JQUERY)
    // Buscamos el botón que tiene el data-id que coincide con el productId
    const $btn = $('.btn-add-to-cart[data-id="' + productId + '"]');

    if ($btn.prop('disabled')) {
        return;
    }

    // Deshabilitar botón y mostrar spinner
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Añadiendo...');

    $.ajax({
        url: 'index.php?c=carrito&a=agregar',
        method: 'POST',
        data: {
            id_producto: productId,
            cantidad: quantity
        },
        success: function(response) {
            // Asume que 'response' es JSON y tiene una propiedad 'success'
            if (response.success) {
                // Asumiendo que 'updateCartCount' es una función global para el contador
                let currentCartCount = parseInt($('.cart-count').text()) || 0;
                // Si la respuesta indica el nuevo total del carrito, úsalo. Si no, usa la cantidad agregada.
                // Asumiremos que el backend devuelve el total. Si no, usa la línea de abajo.
                // updateCartCount(currentCartCount + quantity); 
                
                // MEJORA: Solo actualizamos el estado visual de este botón
                $btn.removeClass('btn-add-to-cart')
                    .addClass('btn-added-to-cart') // Usa una clase específica para el estado 'añadido'
                    .html('<i class="fas fa-check"></i> ¡Añadido!');
                $btn.prop('disabled', true);

                // Muestra notificación de éxito (asumiendo función global)
                showSuccessMessage('Producto añadido al carrito correctamente');
            } else {
                 // Si el backend responde con éxito: false
                 $btn.prop('disabled', false).html('<svg>...</svg><span>Agregar al carrito</span>');
                 showErrorMessage(response.message || 'Error al añadir el producto.');
            }
        },
        error: function() {
            // Si falla la petición AJAX
            $btn.prop('disabled', false).html('<svg>...</svg><span>Agregar al carrito</span>');
            showErrorMessage('Error al añadir el producto. Intenta nuevamente.');
        }
    });
}
</script>