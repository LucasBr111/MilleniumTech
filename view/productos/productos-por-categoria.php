<div class="product-container container my-5">
    
    <div class="row mb-4 align-items-center title-section">
        <div class="col-md-6 mb-3 mb-md-0">
            <h1 class="text-white"><?php echo ($nombre_categoria) ?></h1>
            <p class="text-muted">Explora la selección de productos disponibles en esta categoría.</p>
        </div>
        
        <div class="col-md-6">
            <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center">
                <div class="input-group search-bar mb-2 mb-md-0 me-md-3">
                    <input type="text" class="form-control" id="search-input" placeholder="Buscar productos...">
                    <span class="input-group-text"><i class="fas fa-search text-white"></i></span>
                </div>
                
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle filter-dropdown" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter me-2"></i>Filtros
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="filterDropdown">
                        <li><h6 class="dropdown-header">Ordenar por:</h6></li>
                        <li><a class="dropdown-item <?= ($filtro === 'precio_asc') ? 'active' : '' ?>" href="index.php?c=productos&id_categoria=<?= htmlspecialchars($id_categoria) ?>&filtro=precio_asc">Precio (menor a mayor)</a></li>
                        <li><a class="dropdown-item <?= ($filtro === 'precio_desc') ? 'active' : '' ?>" href="index.php?c=productos&id_categoria=<?= htmlspecialchars($id_categoria) ?>&filtro=precio_desc">Precio (mayor a menor)</a></li>
                        <li><a class="dropdown-item <?= ($filtro === 'nombre_asc') ? 'active' : '' ?>" href="index.php?c=productos&id_categoria=<?= htmlspecialchars($id_categoria) ?>&filtro=nombre_asc">Nombre (A-Z)</a></li>
                        <li><a class="dropdown-item <?= ($filtro === 'nombre_desc') ? 'active' : '' ?>" href="index.php?c=productos&id_categoria=<?= htmlspecialchars($id_categoria) ?>&filtro=nombre_desc">Nombre (Z-A)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <hr class="divider">

   <?php include 'view/productos/listado-productos.php'; ?>
</div>

<script>
$(document).ready(function() {
    
    // Función para realizar la búsqueda por AJAX
    function searchProducts(query) {
    // Obtenemos el ID de la categoría y el filtro actual del contexto PHP
    const categoriaId = <?= htmlspecialchars($id_categoria) ?>;
    // Se corrige: se obtiene el filtro de la URL actual si no se pasa, o se usa el valor predeterminado si es la primera carga.
    // Aunque en este caso, es mejor obtenerlo del contexto PHP como ya lo haces.
    const filtro = '<?= htmlspecialchars($filtro) ?>'; 

    $.ajax({
        // La URL debe apuntar al controlador y acción correctos.
        // Los parámetros se enviarán en la propiedad 'data'.
        url: 'index.php?c=productos&a=listar', // URL base del controlador/acción
        method: 'GET',
        data: {
            // Se envían los datos como un objeto para que jQuery los formatee correctamente en la URL
            query: query,
            id_categoria: categoriaId,
            filtro: filtro
        },
        success: function(response) {
            // Actualizar el div de la lista de productos con la respuesta
            $('#product-list').html(response);
        },
        error: function(xhr, status, error) {
            // Manejo de errores más detallado
            console.error("Error en la búsqueda AJAX:", status, error, xhr.responseText);
            $('#product-list').html('<div class="col-12 text-center"><div class="alert-info-custom"><i class="fas fa-exclamation-triangle me-2"></i>Ocurrió un error al buscar los productos.</div></div>');
        }
    });
}

    // Escuchar el evento 'input' en el campo de búsqueda
    $('#search-input').on('input', function() {
        const query = $(this).val();
        if (query.length > 2 || query.length === 0) { 
            searchProducts(query);
        }
    });

    $('head').append(`
    <style>
        .search-bar .form-control {
            background-color: var(--card-bg);
            border: 1px solid var(--accent-blue);
            color: var(--text-primary);
        }
        .search-bar .form-control:focus {
            box-shadow: 0 0 5px var(--border-glow);
            border-color: var(--border-glow);
        }
        .search-bar .input-group-text {
            background-color: var(--card-bg);
            border: 1px solid var(--accent-blue);
            border-left: none;
            color: var(--text-primary);
        }
        .filter-dropdown {
            background: var(--gradient-secondary);
            border: none;
            color: var(--text-secondary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .filter-dropdown:hover {
            box-shadow: 0 0 10px var(--border-glow);
            transform: translateY(-2px);
        }
        .dropdown-menu.dropdown-menu-dark {
            background-color: var(--dark-bg);
            border: 1px solid var(--accent-blue);
        }
        .dropdown-menu.dropdown-menu-dark .dropdown-item {
            color: var(--text-secondary);
        }
        .dropdown-menu.dropdown-menu-dark .dropdown-item:hover {
            background-color: var(--card-hover);
            color: var(--primary-gold);
        }
        .dropdown-menu.dropdown-menu-dark .dropdown-item.active {
            background-color: var(--accent-blue);
            color: var(--primary-gold);
        }
        .product-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--navbar-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 30px rgba(255, 215, 0, 0.2);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid var(--accent-blue);
        }
        .product-info {
            padding: 1rem;
            text-align: center;
        }
        .product-title {
            color: var(--text-primary);
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 3px rgba(255, 255, 255, 0.1);
        }
        .product-price {
            color: var(--primary-gold);
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .btn-add-cart {
            display: inline-block;
            background: var(--gradient-primary);
            color: var(--dark-bg);
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-add-cart:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px var(--border-glow);
        }
        .alert-info-custom {
            background: var(--card-bg);
            border: 1px solid var(--accent-blue);
            color: var(--text-primary);
            padding: 1.5rem;
            border-radius: 10px;
        }
        .divider {
            border-top: 1px solid var(--navbar-border);
            opacity: 0.5;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
    </style>
    `);
});
</script>