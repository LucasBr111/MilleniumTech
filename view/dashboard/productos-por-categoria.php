<?php
// =================================================================================
// INICIALIZACIÓN Y CARGA DE DATOS
// $productos_categoria DEBE ser llenada por el controlador, filtrada por ID de categoría.
$productos_categoria = $productos_categoria ?? []; 
$fecha_actual = date('Y-m-d');
$nombre_categoria = $_GET['nombre'] ?? 'Categoría Desconocida';
$id_categoria = $_GET['id'] ?? 'N/D';

// Función auxiliar para determinar si un producto está en promoción (copia de productos.php)
function estaEnPromocion($promo_desde, $promo_hasta, $fecha_actual) {
    if (!$promo_desde || !$promo_hasta) {
        return false;
    }
    $desde = strtotime($promo_desde);
    $hasta = strtotime($promo_hasta);
    $hoy = strtotime($fecha_actual);
    return ($hoy >= $desde && $hoy <= $hasta);
}
// =================================================================================
?>

<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">
        <i class="fas fa-search me-2"></i> Productos en: "<?php echo htmlspecialchars($nombre_categoria); ?>"
    </h1>
    <p class="text-muted">ID de Categoría: #<?php echo htmlspecialchars($id_categoria); ?></p>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Listado de Productos (Filtrado)</h5>
            
            <button class="btn btn-primary admin-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#crudModal" 
                    data-c="producto" 
                    data-a="crear" 
                    data-categoria-id="<?php echo htmlspecialchars($id_categoria); ?>"
                    title="Añadir Nuevo Producto a esta categoría">
                <i class="fas fa-plus me-2"></i> Añadir Producto
            </button>
        </div>
        
        <div class="card-body">
            
            <table id="tablaProductosCategoria" class="table table-striped table-hover w-100">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>Promoción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($productos_categoria as $producto) {
                        
                        $en_promocion = estaEnPromocion(
                            $producto->promo_desde ?? null, 
                            $producto->promo_hasta ?? null, 
                            $fecha_actual
                        );

                        $promo_badge = $en_promocion ? '<span class="badge bg-danger">¡EN PROMO!</span>' : '<span class="badge bg-secondary">No</span>';
                        $stock_clase = ($producto->stock < 10) ? 'text-danger fw-bold' : 'text-success';
                        $id_prod = $producto->id_producto ?? 'N/D';
                        
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($id_prod) . '</td>';
                        echo '<td>' . htmlspecialchars($producto->nombre_producto ?? 'Sin Nombre') . '</td>';
                        echo '<td>' . htmlspecialchars($producto->marca ?? 'N/D') . '</td>';
                        echo '<td class="' . $stock_clase . '">' . htmlspecialchars($producto->stock ?? 0) . '</td>';
                        echo '<td>' . $promo_badge . '</td>';
                        
                        // Columna Acciones
                        echo '<td>';
                        
                        // Botón Editar (usa data-id para cargar datos en el modal)
                        echo '<button class="btn btn-warning btn-sm me-2 btn-edit-product" 
                                data-bs-toggle="modal" 
                                data-bs-target="#crudModal" 
                                data-c="producto"
                                data-a="editar"
                                data-id="' . htmlspecialchars($id_prod) . '"
                                title="Editar Producto">';
                        echo '<i class="fas fa-edit"></i>';
                        echo '</button>';
                        
                        // Botón Eliminar (apunta al controlador)
                        echo '<a href="?c=producto&a=borrar&id=' . htmlspecialchars($id_prod) . '" 
                                class="btn btn-danger btn-sm btn-delete-product"
                                title="Eliminar Producto">';
                        echo '<i class="fas fa-trash-alt"></i>';
                        echo '</a>';
                        
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicialización de DataTables
        $('#tablaProductosCategoria').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "order": [[0, "asc"]], 
            "responsive": true
        });

        // NOTA: La lógica del modal CRUD (crear/editar) y el botón eliminar
        // debe ser manejada por las funciones ya definidas en tu layout principal.
        // Se añade un atributo 'data-categoria-id' para pre-seleccionar la categoría
        // en el formulario de "Añadir Producto".
    });
</script>