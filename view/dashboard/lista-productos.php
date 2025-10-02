<?php
// =================================================================================
// INICIALIZACIÓN DE VARIABLES
// Asegúrate de que $datos_productos se llene con el resultado de tu modelo/controlador.
$datos_productos = $datos_productos ?? []; 
$fecha_actual = date('Y-m-d');
// =================================================================================

// Función auxiliar para determinar si un producto está en promoción
function estaEnPromocion($promo_desde, $promo_hasta, $fecha_actual) {
    if (!$promo_desde || !$promo_hasta) {
        return false;
    }
    // Convertir a timestamps para comparación
    $desde = strtotime($promo_desde);
    $hasta = strtotime($promo_hasta);
    $hoy = strtotime($fecha_actual);
    
    // Condición: hoy >= promo_desde Y hoy <= promo_hasta
    return ($hoy >= $desde && $hoy <= $hasta);
}
?>

<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">
        <i class="fas fa-box-open me-2"></i> Gestión de Productos
    </h1>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Catálogo General</h5>
            
            <button class="btn btn-primary admin-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#crudModal" 
                    data-c="productos" 
                    title="Añadir Nuevo Producto">
                <i class="fas fa-plus me-2"></i> Añadir Producto
            </button>
        </div>
        
        <div class="card-body">
            
            <table id="tablaProductos" class="table table-striped table-hover w-100">
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
                    foreach ($datos_productos as $producto) {
                        
                        // Determinar el estado de la promoción
                        $en_promocion = estaEnPromocion(
                            $producto->promo_desde ?? null, 
                            $producto->promo_hasta ?? null, 
                            $fecha_actual
                        );

                        // Etiquetas y clases para la columna Promoción
                        if ($en_promocion) {
                            $promo_badge = '<span class="badge bg-danger">¡EN PROMO!</span>';
                        } else {
                            $promo_badge = '<span class="badge bg-secondary">No</span>';
                        }
                        
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($producto->id_producto ?? 'N/D') . '</td>';
                        echo '<td>' . htmlspecialchars($producto->nombre_producto ?? 'Sin Nombre') . '</td>';
                        echo '<td>' . htmlspecialchars($producto->marca ?? 'N/D') . '</td>';
                        
                        // Columna Stock con color según nivel (ejemplo)
                        $stock_clase = ($producto->stock < 10) ? 'text-danger fw-bold' : 'text-success';
                        echo '<td class="' . $stock_clase . '">' . htmlspecialchars($producto->stock ?? 0) . '</td>';
                        
                        echo '<td>' . $promo_badge . '</td>';
                        
                        // Columna Acciones
                        echo '<td>';
                        
                        // Botón Editar (usa data-id para cargar datos en el modal)
                        echo '<button class="btn btn-warning btn-sm me-2 btn-edit-product" 
                                data-bs-toggle="modal" 
                                data-bs-target="#crudModal" 
                                data-c="productos"
                                data-id="' . htmlspecialchars($producto->id_producto ?? '') . '"
                                title="Editar Producto">';
                        echo '<i class="fas fa-edit"></i>';
                        echo '</button>';
                        
                        // Botón Eliminar (usa SweetAlert/Confirmación)
                        echo '<a href="?c=producto&a=borrar&id=' . htmlspecialchars($producto->id_producto ?? '') . '" 
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
        // 1. Inicialización de DataTables
        $('#tablaProductos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" // Idioma español
            },
            "order": [
                [0, "asc"]
            ], // Ordenar por ID ascendente por defecto
            "pagingType": "full_numbers",
            "responsive": true
        });
    

        // 3. Lógica para el Botón Eliminar (Usando confirmación)
        $(document).on('click', '.btn-delete-product', function(e) {
            e.preventDefault();
            const url = $(this).attr('href'); // Obtiene ?c=producto&a=borrar&id=...

            if (confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
                // ** Opcional: Reemplazar con SweetAlert2 para una mejor UX **
                // Si el usuario confirma, redirigimos a la URL de eliminación
                window.location.href = url;
            }
        });
    });
</script>

<?php include ('view/crudModal.php'); ?>