<div class="container my-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="text-white display-4 fw-bold">✨ Lo Más Nuevo en Tecnología ✨</h1>
            <p class="text-muted lead">Descubre los productos recién llegados a nuestro catálogo.</p>
        </div>
    </div>

    <?php
    // Bucle principal para iterar sobre cada categoría y sus productos
    foreach ($this->categoria->listar() as $categoria):
        // Genera un ID único para el carrusel de esta categoría
        $carousel_id = 'carousel-' . str_replace(' ', '-', strtolower($categoria->nombre_categoria));
    ?>

        <div class="category-section mb-5">

            <div class="banner-categoria mb-4" style="background-image: url('assets/uploads/categorias/<?= htmlspecialchars($categoria->imagen) ?>');">
                <div class="banner-overlay"></div>
                <div class="banner-content">
                    <h2 class="text-white display-5 fw-bold mb-3"><?= htmlspecialchars($categoria->nombre_categoria) ?></h2>
                    <a href="?c=productos&id_categoria=<?= htmlspecialchars($categoria->id_categoria) ?>" class="btn-ver-todo">
                        <span>Ver toda la categoría</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M6 3L11 8L6 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div id="<?= $carousel_id ?>" class="carousel slide position-relative" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php
                    $productos = $this->model->listarPorCategoria($categoria->id_categoria);
                    $chunked_products = array_chunk($productos, 5);
                    $is_first_item = true;

                    foreach ($chunked_products as $chunk_index => $chunk):
                        $active_class = ($is_first_item) ? 'active' : '';
                        $is_first_item = false;
                    ?>

                        <div class="carousel-item <?= $active_class ?>">
                            <div class="row g-3 flex-nowrap">

                                <?php foreach ($chunk as $producto): ?>
                                    <div class="col-6 col-md-4 col-lg-3 col-xl-2dot4">
                                        <div class="product-card">
                                            <?php if ($producto->en_promocion): ?>
                                                <div class="product-badge">¡OFERTA!</div>
                                            <?php endif; ?>
                                            
                                            <div class="product-image-container">
                                                <img src="assets/uploads/productos/<?= htmlspecialchars($producto->imagen) ?>" 
                                                     class="product-image" 
                                                     alt="<?= htmlspecialchars($producto->nombre) ?>"
                                                     loading="lazy">
                                            </div>
                                            
                                            <div class="product-info">
                                                <h5 class="product-title"><?= htmlspecialchars($producto->nombre_producto) ?></h5>

                                                <div class="product-price">
                                                    <?php if ($producto->en_promocion): ?>
                                                        <span class="price-tachado">$<?= number_format($producto->precio_normal, 0, ',', '.') ?></span>
                                                        <span class="price-oferta">$<?= number_format($producto->precio, 0, ',', '.') ?></span>
                                                    <?php else: ?>
                                                        <span class="price-normal">$<?= number_format($producto->precio, 0, ',', '.') ?></span>
                                                    <?php endif; ?>
                                                </div>

                                                <button data-id="<?= htmlspecialchars($producto->id_producto) ?>" class="btn-add-cart">
                                                   <i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

                <?php if (count($chunked_products) > 1): ?>
                    <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#<?= $carousel_id ?>" data-bs-slide="prev">
                        <span class="custom-carousel-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </button>
                    <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#<?= $carousel_id ?>" data-bs-slide="next">
                        <span class="custom-carousel-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        
        <hr class="divider">

    <?php endforeach; ?>

</div>

<style>
:root {
    --primary-gold: #FFD700;
    --dark-bg: #1a1a1a;
    --card-bg: #2a2a2a;
    --text-muted: #A0AEC0;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Banner de Categoría Mejorado */
.banner-categoria {
    height: 200px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 20px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
    position: relative;
    overflow: hidden;
}

.banner-overlay {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
    border-radius: 20px;
    z-index: 1;
}

.banner-content {
    position: relative;
    z-index: 2;
}

.banner-categoria h2 {
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
    margin: 0;
}

/* Botón Ver Todo Mejorado */
.btn-ver-todo {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--primary-gold) 0%, #FFA500 100%);
    color: #000;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    border: none;
}

.btn-ver-todo:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(255, 215, 0, 0.5);
    color: #000;
}

.btn-ver-todo svg {
    transition: var(--transition);
}

.btn-ver-todo:hover svg {
    transform: translateX(4px);
}

/* Carrusel Mejorado */
.carousel-item .row {
    flex-wrap: nowrap;
    transition: transform 0.6s ease-in-out;
}

.col-xl-2dot4 { 
    flex: 0 0 auto;
    width: 20%; 
}

@media (max-width: 1200px) {
    .col-lg-3 { width: 25%; }
}

@media (max-width: 992px) {
    .col-md-4 { width: 33.333%; }
}

@media (max-width: 768px) {
    .col-6 { width: 50%; }
    .banner-categoria { height: 150px; padding: 20px; }
    .banner-categoria h2 { font-size: 1.75rem; }
}

/* Tarjetas de Producto Mejoradas */
.product-card {
    background: var(--card-bg);
    border-radius: 16px;
    overflow: hidden;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
}

.product-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 10;
    box-shadow: 0 4px 10px rgba(255, 65, 108, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.product-image-container {
    width: 100%;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1e1e1e 0%, #2d2d2d 100%);
    padding: 20px;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: var(--transition);
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.product-info {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex-grow: 1;
}

.product-title {
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    margin: 0;
    line-height: 1.4;
    height: 2.8em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin: 8px 0;
}

.price-tachado {
    text-decoration: line-through;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.price-oferta {
    color: var(--primary-gold);
    font-size: 1.4rem;
    font-weight: 700;
}

.price-normal {
    color: #fff;
    font-size: 1.4rem;
    font-weight: 700;
}

/* Botón Agregar al Carrito Mejorado */
.btn-add-cart {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    background: linear-gradient(135deg, var(--primary-gold) 0%, #FFA500 100%);
    color: #000;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    margin-top: auto;
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(255, 215, 0, 0.5);
    background: linear-gradient(135deg, #FFA500 0%, var(--primary-gold) 100%);
}

.btn-add-cart:active {
    transform: translateY(0);
}

.btn-add-cart svg {
    transition: var(--transition);
}

.btn-add-cart:hover svg {
    transform: scale(1.1);
}

/* Controles del Carrusel Personalizados */
.custom-carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    transition: var(--transition);
    opacity: 0.8;
}

.custom-carousel-btn:hover {
    background: rgba(255, 215, 0, 0.2);
    border-color: var(--primary-gold);
    opacity: 1;
    transform: translateY(-50%) scale(1.1);
}

.carousel-control-prev.custom-carousel-btn {
    left: -25px;
}

.carousel-control-next.custom-carousel-btn {
    right: -25px;
}

.custom-carousel-icon {
    color: var(--primary-gold);
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    display: none;
}

/* Divisor Mejorado */
.divider {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, rgba(255, 215, 0, 0.3) 50%, transparent 100%);
    margin: 4rem 0;
}

/* Animaciones de Entrada */
.category-section {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mejoras Responsive */
@media (max-width: 576px) {
    .product-image-container {
        height: 180px;
        padding: 15px;
    }
    
    .product-info {
        padding: 15px;
    }
    
    .product-title {
        font-size: 0.9rem;
    }
    
    .price-oferta, .price-normal {
        font-size: 1.2rem;
    }
    
    .btn-add-cart {
        padding: 10px 16px;
        font-size: 0.85rem;
    }
    
    .custom-carousel-btn {
        width: 40px;
        height: 40px;
    }
    
    .carousel-control-prev.custom-carousel-btn {
        left: -10px;
    }
    
    .carousel-control-next.custom-carousel-btn {
        right: -10px;
    }
}
</style>