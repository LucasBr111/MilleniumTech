<div id="product-list" class="row">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 product-card-col">
                <div class="product-card">
                    <a href="index.php?c=producto&id=<?= htmlspecialchars($producto->id_producto) ?>">
                        <img src="assets/uploads/productos/<?= htmlspecialchars($producto->imagen) ?>" alt="<?= htmlspecialchars($producto->nombre_producto) ?>" class="product-image">
                    </a>
                    <div class="product-info">
                        <h3 class="product-title"><?= htmlspecialchars($producto->nombre_producto) ?></h3>

                        <?php if ($producto->en_promocion): ?>
                            <p class="product-price">
                                <span style="text-decoration: line-through; color: var(--text-muted); font-size: 0.9em; margin-right: 10px;">
                                    $<?= number_format($producto->precio_normal, 2, ',', '.') ?>
                                </span>
                                <br>
                                <span style="color: var(--primary-gold); font-size: 1.3em; font-weight: bold;">
                                    AHORA $<?= number_format($producto->precio, 2, ',', '.') ?>
                                </span>
                            </p>
                        <?php else: ?>
                            <p class="product-price" style="font-size: 1.3em;">
                                $<?= number_format($producto->precio, 2, ',', '.') ?>
                            </p>
                        <?php endif; ?>

                        <button data-id=<?= htmlspecialchars($producto->id_producto) ?>" class="btn-add-cart">
                            <i class="fas fa-shopping-cart me-2"></i> Añadir
                        </button>
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

<style>
    :root {

        --text-muted: #A0AEC0;
        /* Gris suave, por ejemplo */
        --primary-gold: #FFD700;
        /* Asumiendo que este es tu color destacado */
    }
</style>