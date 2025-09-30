<div id="product-list" class="row">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 product-card-col">
                    <div class="product-card">
                        <a href="index.php?c=producto&id=<?= htmlspecialchars($producto->id_producto) ?>">
                            <img src="assets/uploads/productos/<?= htmlspecialchars($producto->imagen) ?>" alt="<?= htmlspecialchars($producto->nombre_producto) ?>" class="product-image">
                        </a>
                        <div class="product-info">
                            <h5 class="product-title"><?= htmlspecialchars($producto->nombre_producto) ?></h5>
                            <p class="product-price">$<?= number_format($producto->precio, 2, ',', '.') ?></p>
                            <button data-id = "<?php echo $producto->id_producto; ?>" class="btn-add-cart"><i class="fas fa-cart-plus me-2"></i> Añadir</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert-info-custom">
                    <i class="fas fa-info-circle me-2"></i>
                    No hay productos disponibles en esta categoría.
                </div>
            </div>
        <?php endif; ?>
    </div>