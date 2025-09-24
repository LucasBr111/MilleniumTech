<?php
// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?c=login');
    exit;
}
?>

<style>
    /* Estilos Específicos para la Vista de Carrito */
    :root {
        --blanco-marmol: #F8F9FA;
        --dorado-elegante: #D4AF37;
        --bordo-profundo: #520017;
        --verde-jade: #006B54;
        --negro-futurista: #121212;
        --gris-claro: #EFEFEF;
        --gris-texto: #6c757d;
    }

    .cart-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 25px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(212, 175, 55, 0.1);
    }

    .cart-header {
        background: linear-gradient(135deg, var(--verde-jade), #005a4a);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .cart-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100%;
        background: linear-gradient(45deg, var(--dorado-elegante), #f4d03f);
        opacity: 0.1;
        transform: skewX(-20deg);
    }

    .cart-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
        position: relative;
        z-index: 1;
        color: var(--blanco-marmol);
    }

    .cart-count {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 300;
        display: block;
        margin-top: 5px;
    }

    .cart-clear-btn {
        color: white;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 16px;
        border-radius: 25px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .cart-clear-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateY(-2px);
    }

    /* Tarjeta de producto del carrito */
    .cart-product-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .cart-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }

    .product-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.05);
    }

    .stock-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .stock-badge.in-stock {
        background: var(--verde-jade);
        color: white;
    }

    .stock-badge.low-stock {
        background: var(--dorado-elegante);
        color: var(--negro-futurista);
    }

    .stock-badge.no-stock {
        background: #dc3545;
        color: white;
    }

    .product-details h5 {
        font-weight: 600;
        color: var(--negro-futurista);
        margin-bottom: 8px;
    }

    .product-code {
        font-size: 0.85rem;
        color: var(--gris-texto);
        background: var(--gris-claro);
        padding: 2px 6px;
        border-radius: 4px;
    }

    .product-brand {
        font-size: 0.9rem;
        color: var(--bordo-profundo);
        font-weight: 500;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .btn-quantity-minus,
    .btn-quantity-plus {
        width: 35px;
        height: 35px;
        border: 2px solid var(--dorado-elegante);
        background: white;
        color: var(--dorado-elegante);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-quantity-minus:hover,
    .btn-quantity-plus:hover {
        background: var(--dorado-elegante);
        color: white;
    }

    .btn-quantity-minus:disabled,
    .btn-quantity-plus:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .quantity {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--negro-futurista);
        min-width: 30px;
        text-align: center;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--verde-jade);
        margin: 0;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .remove-item-btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .remove-item-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .add-to-cart-btn {
        background: var(--verde-jade);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .add-to-cart-btn:hover:not(:disabled) {
        background: #005a4a;
        transform: translateY(-2px);
    }

    .add-to-cart-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }

    .cart-summary {
        background: linear-gradient(135deg, var(--bordo-profundo), #6d001d);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-top: 30px;
        text-align: center;
    }

    .subtotal-label {
        font-size: 1.1rem;
        font-weight: 500;
        display: block;
        margin-bottom: 10px;
    }

    .subtotal-value {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Cinzel', serif;
    }

    .checkout-btn {
        background: var(--dorado-elegante);
        color: var(--negro-futurista);
        border: none;
        padding: 15px 30px;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: 600;
        margin-top: 20px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .checkout-btn:hover {
        background: #f4d03f;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
        color: var(--negro-futurista);
        text-decoration: none;
    }

    .empty-list {
        text-align: center;
        padding: 60px 20px;
        color: var(--gris-texto);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gris-claro);
        margin-bottom: 20px;
    }

    .empty-list h4 {
        color: var(--negro-futurista);
        margin-bottom: 10px;
    }

    .removing {
        opacity: 0.5;
        transform: scale(0.95);
    }

    @media (max-width: 768px) {
        .cart-container {
            margin: 20px;
            padding: 15px;
        }
        
        .cart-product-card {
            padding: 15px;
        }
        
        .product-image {
            height: 100px;
        }
    }
</style>

<div class="cart-container">
    <div class="cart-header">
        <h1 class="cart-title">
            <i class="fas fa-shopping-cart me-2"></i>
            Mi Carrito
        </h1>
        <span class="cart-count" id="cart-count"><?= count($productos) ?> productos</span>
        
        <?php if (!empty($productos)): ?>
            <a href="#" id="clear-cart-list" class="cart-clear-btn">
                <i class="fas fa-trash me-1"></i>
                Limpiar carrito
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <?php
            // Determinar estado del stock
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

            <div class="cart-product-card" data-id="<?= htmlspecialchars($producto->id_producto) ?>">
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
                                <span class="quantity"><?= $producto->cantidad ?></span>
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
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="cart-summary">
            <span class="subtotal-label">Total estimado:</span>
            <span class="subtotal-value" id="total-value">Gs. <?= number_format(array_sum(array_column($productos, 'precio')), 0, ',', '.') ?></span>
            <br>
            <a href="#" class="checkout-btn" id="checkout-btn">
                <i class="fas fa-credit-card me-2"></i>
                Proceder al Pago
            </a>
        </div>
    <?php else: ?>
        <div class="empty-list">
            <div class="empty-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h4>Tu carrito está vacío</h4>
            <p>Descubre productos increíbles y añádelos a tu carrito</p>
            <a href="index.php?c=home" class="btn btn-primary mt-3">
                <i class="fas fa-home me-2"></i>
                Ir al Inicio
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function() {
        // Función para manejar la eliminación de un producto del carrito
        $('.remove-item-btn').on('click', function() {
            const $btn = $(this);
            const productId = $btn.data('id');
            const $itemElement = $btn.closest('.cart-product-card');

            // Confirmación elegante con SweetAlert2
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Remover este producto de tu carrito",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, remover',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Deshabilitar botón durante la operación
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Removiendo...');

                    $.ajax({
                        url: 'index.php?c=carrito&a=remove',
                        method: 'POST',
                        data: {
                            id_producto: productId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $itemElement.addClass('removing');
                                $itemElement.fadeOut(400, function() {
                                    $(this).remove();
                                    updateProductCount();
                                    updateSubtotal();
                                    checkEmptyList();
                                    
                                    // Actualizar contadores en el navbar
                                    if (typeof updateFavoritesCounter === 'function') {
                                        updateFavoritesCounter();
                                    }
                                });
                                
                                Swal.fire('¡Listo!', response.success, 'success');
                            } else if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Error al remover producto.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }
                            Swal.fire('Error', errorMessage, 'error');
                        },
                        complete: function() {
                            $btn.prop('disabled', false).html('<i class="fas fa-times"></i> Quitar');
                        }
                    });
                }
            });
        });

        // Función para limpiar todo el carrito
        $('#clear-cart-list').on('click', function(e) {
            e.preventDefault();

            if ($('.cart-product-card').length === 0) {
                return;
            }

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminarán todos los productos de tu carrito",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, limpiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const $btn = $('#clear-cart-list');
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Limpiando...');

                    $.ajax({
                        url: 'index.php?c=carrito&a=clean',
                        method: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('.cart-product-card').fadeOut(400, function() {
                                    $(this).remove();
                                    updateProductCount();
                                    updateSubtotal();
                                    checkEmptyList();
                                    
                                    // Actualizar contadores en el navbar
                                    if (typeof updateFavoritesCounter === 'function') {
                                        updateFavoritesCounter();
                                    }
                                });

                                Swal.fire('¡Listo!', response.success, 'success');
                            } else if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'No se pudo limpiar el carrito. Intenta nuevamente.', 'error');
                        },
                        complete: function() {
                            $btn.prop('disabled', false).html('<i class="fas fa-trash"></i> Limpiar carrito');
                        }
                    });
                }
            });
        });

        // Función para manejar el checkout
        $('#checkout-btn').on('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Proceder al Pago',
                text: 'Esta funcionalidad estará disponible próximamente',
                icon: 'info',
                confirmButtonText: 'Entendido'
            });
        });

        // Función para actualizar la cantidad de productos
        function updateProductCount() {
            const count = $('.cart-product-card').length;
            $('#cart-count').text(count + ' productos');
        }

        // Función para actualizar el subtotal
        function updateSubtotal() {
            let total = 0;
            $('.cart-product-card').each(function() {
                const price = parseFloat($(this).find('.product-price').text().replace(/[Gs.,]/g, ''));
                const quantity = parseInt($(this).find('.quantity').text());
                total += price * quantity;
            });
            
            $('#total-value').text('Gs. ' + total.toLocaleString('es-PY'));
        }

        // Función para verificar si la lista está vacía
        function checkEmptyList() {
            if ($('.cart-product-card').length === 0) {
                $('.cart-container').html(`
                    <div class="cart-header">
                        <h1 class="cart-title">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Mi Carrito
                        </h1>
                        <span class="cart-count">0 productos</span>
                    </div>
                    <div class="empty-list">
                        <div class="empty-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h4>Tu carrito está vacío</h4>
                        <p>Descubre productos increíbles y añádelos a tu carrito</p>
                        <a href="index.php?c=home" class="btn btn-primary mt-3">
                            <i class="fas fa-home me-2"></i>
                            Ir al Inicio
                        </a>
                    </div>
                `);
            }
        }
    });
</script>
