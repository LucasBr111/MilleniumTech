<style>
    /* Estilos Específicos para la Vista de Favoritos */
    :root {
        --blanco-marmol: #F8F9FA;
        --dorado-elegante: #D4AF37;
        --bordo-profundo: #520017;
        --verde-jade: #006B54;
        --negro-futurista: #121212;
        --gris-claro: #EFEFEF;
        --gris-texto: #6c757d;
    }

    .fav-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 25px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(212, 175, 55, 0.1);
    }

    .fav-header {
        background: linear-gradient(135deg, var(--bordo-profundo), #6d001d);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .fav-header::before {
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

    .fav-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
        position: relative;
        z-index: 1;
        color: var(--blanco-marmol);
    }

    .fav-count {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 300;
        display: block;
        margin-top: 5px;
    }

    .fav-clear-btn {
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

    .fav-clear-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateY(-2px);
    }

    /* Tarjeta de producto mejorada */
    .fav-product-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .fav-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .fav-product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-details h5 {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--negro-futurista);
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .product-code {
        background: var(--gris-claro);
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--gris-texto);
    }

    .product-brand {
        color: var(--dorado-elegante);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .product-price {
        font-weight: 700;
        font-size: 1.3rem;
        color: var(--bordo-profundo);
        margin: 0;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        background: var(--gris-claro);
        border-radius: 25px;
        overflow: hidden;
        width: fit-content;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .quantity-control button {
        background: transparent;
        border: none;
        color: var(--negro-futurista);
        font-size: 1.1rem;
        font-weight: 600;
        width: 35px;
        height: 35px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-control button:hover {
        background: var(--dorado-elegante);
        color: white;
    }

    .quantity-control button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .quantity-control .quantity {
        padding: 0 15px;
        font-weight: 600;
        font-size: 1rem;
        min-width: 40px;
        text-align: center;
        background: white;
        line-height: 35px;
    }

    .stock-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stock-badge.no-stock {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .stock-badge.low-stock {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }

    .stock-badge.in-stock {
        background: linear-gradient(135deg, var(--verde-jade), #008f71);
        color: white;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: stretch;
    }

    .remove-item-btn {
        background: linear-gradient(135deg, var(--bordo-profundo), #6d001d);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .remove-item-btn:hover {
        background: linear-gradient(135deg, #dc3545, #c82333);
        transform: translateY(-2px);
    }

    .add-to-cart-btn {
        background: linear-gradient(135deg, var(--verde-jade), #008f71);
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 25px;
        padding: 10px 16px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .add-to-cart-btn:hover:not(:disabled) {
        background: linear-gradient(135deg, #008f71, #00b894);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 107, 84, 0.3);
    }

    .add-to-cart-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }

    /* Resumen mejorado */
    .fav-summary {
        background: linear-gradient(135deg, var(--negro-futurista), #2c2c2c);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-top: 30px;
        text-align: center;
    }

    .subtotal-label {
        font-weight: 400;
        font-size: 1.1rem;
        opacity: 0.9;
        display: block;
    }

    .subtotal-value {
        font-weight: 700;
        font-size: 2rem;
        color: var(--dorado-elegante);
        margin-top: 5px;
        display: block;
    }

    /* Mensaje de favoritos vacíos mejorado */
    .empty-list {
        text-align: center;
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        border: 2px dashed #dee2e6;
    }

    .empty-list .empty-icon {
        font-size: 4rem;
        color: var(--gris-texto);
        margin-bottom: 20px;
        opacity: 0.6;
    }

    .empty-list h4 {
        font-size: 1.5rem;
        color: var(--negro-futurista);
        font-weight: 600;
        margin-bottom: 10px;
    }

    .empty-list p {
        color: var(--gris-texto);
        font-size: 1rem;
    }

    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fav-product-card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsividad mejorada */
    @media (max-width: 768px) {
        .fav-container {
            margin: 20px 15px;
            padding: 20px;
        }

        .fav-header {
            padding: 20px;
        }

        .fav-title {
            font-size: 1.5rem;
        }

        .fav-product-card {
            padding: 15px;
        }

        .action-buttons {
            flex-direction: row;
            justify-content: space-between;
        }

        .product-price {
            font-size: 1.1rem;
        }

        .subtotal-value {
            font-size: 1.6rem;
        }
    }
</style>

<div class="fav-container">
    <div class="fav-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fav-title">Mi Lista de Deseos</h3>
                <span class="fav-count" id="products-count">(<?= count($productos ?? []) ?> productos guardados)</span>
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
        // Función mejorada para manejar la eliminación de un producto
        $('.remove-item-btn').on('click', function() {
            const $btn = $(this);
            const productId = $btn.data('id');
            const $itemElement = $btn.closest('.fav-product-card');

            // Confirmación elegante con SweetAlert2
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
                    // Deshabilitar botón durante la operación
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

        // Función mejorada para limpiar toda la lista
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


        // Manejo mejorado de cantidad con validación de stock
        $('.btn-quantity-plus').on('click', function() {
            const $btn = $(this);
            const $parent = $btn.closest('.quantity-control');
            const $quantityElem = $parent.find('.quantity');
            const stock = parseInt($parent.data('stock'));
            const currentQuantity = parseInt($quantityElem.text());
            const productId = $parent.data('id');

            if (stock <= 0) {
                showStockMessage('Este producto no tiene stock disponible');
                return;
            }

            if (currentQuantity < stock) {
                const newQuantity = currentQuantity + 1;
                $quantityElem.text(newQuantity);

                // Deshabilitar botón si alcanzamos el límite
                if (newQuantity >= stock) {
                    $btn.prop('disabled', true);
                    showStockMessage(`Stock máximo alcanzado (${stock} unidades)`);
                }

                // Habilitar botón de menos
                $parent.find('.btn-quantity-minus').prop('disabled', false);

                updateSubtotal();
            }
        });

        $('.btn-quantity-minus').on('click', function() {
            const $btn = $(this);
            const $parent = $btn.closest('.quantity-control');
            const $quantityElem = $parent.find('.quantity');
            const currentQuantity = parseInt($quantityElem.text());

            if (currentQuantity > 1) {
                const newQuantity = currentQuantity - 1;
                $quantityElem.text(newQuantity);

                // Habilitar botón de más
                $parent.find('.btn-quantity-plus').prop('disabled', false);

                // Deshabilitar botón de menos si llegamos al mínimo
                if (newQuantity <= 1) {
                    $btn.prop('disabled', true);
                }

                updateSubtotal();
                hideStockMessage();
            }
        });

        // Función mejorada para añadir al carrito
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
                    // Animación de éxito
                    $btn.removeClass('btn-primary').addClass('btn-success')
                        .html('<i class="fas fa-check"></i> ¡Añadido!');

                    // Mostrar notificación
                    showSuccessMessage('Producto añadido al carrito correctamente');

                    // Restaurar botón después de 2 segundos
                    setTimeout(() => {
                        $btn.prop('disabled', false)
                            .removeClass('btn-success').addClass('btn-primary')
                            .html('<i class="fas fa-cart-plus me-1"></i> Al carrito');
                    }, 2000);

                    // Actualizar contador del carrito si existe
                    updateCartCounter();
                },
                error: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-cart-plus me-1"></i> Al carrito');
                    showErrorMessage('Error al añadir el producto. Intenta nuevamente.');
                }
            });
        });

        // Funciones auxiliares mejoradas
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

        function showStockMessage(message) {
            // Crear o actualizar mensaje de stock
            let $message = $('.stock-message');
            if ($message.length === 0) {
                $message = $('<div class="alert alert-warning stock-message mt-2" style="font-size: 0.85rem;"></div>');
                $('.fav-container').prepend($message);
            }
            $message.html(`<i class="fas fa-exclamation-triangle me-1"></i> ${message}`).slideDown();

            // Auto-ocultar después de 5 segundos
            setTimeout(hideStockMessage, 5000);
        }

        function hideStockMessage() {
            $('.stock-message').slideUp(function() {
                $(this).remove();
            });
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

        function updateCartCounter() {
            // Aquí puedes añadir lógica para actualizar el contador del carrito
            // si tienes uno en tu navbar o header
        }

        // Inicializar estado de botones según stock
        $('.fav-product-card').each(function() {
            const $card = $(this);
            const stock = parseInt($card.find('.quantity-control').data('stock'));
            const $minusBtn = $card.find('.btn-quantity-minus');

            // Deshabilitar botón de menos por defecto (cantidad inicial = 1)
            $minusBtn.prop('disabled', true);

            // Si no hay stock, deshabilitar todos los controles
            if (stock <= 0) {
                $card.find('.quantity-control button').prop('disabled', true);
            }
        });
    });
</script>