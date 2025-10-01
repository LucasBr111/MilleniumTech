<?php
$datos_categorias = $datos_categorias ?? []; 

?>

<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">
        <i class="fas fa-tags me-2"></i> Gestión de Categorías
    </h1>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Listado de Categorías</h5>
            
            <button class="btn btn-primary admin-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#crudModal" 
                    data-c="categorias" 
                    title="Añadir Nueva Categoría">
                <i class="fas fa-plus me-2"></i> Añadir Categoría
            </button>
        </div>
        
        <div class="card-body">
            
            <table id="tablaCategorias" class="table table-striped table-hover w-100">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-center">Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($datos_categorias as $categoria) {
                        $id_cat = $categoria->id_categoria ?? $categoria->id;


                        $conteo = $this->categorias->contarProductosPorCategoria($id_cat) ?? 'N/A'; // Reemplaza 'N/A' por la llamada real
                        $conteo_badge = '<span class="badge bg-info text-dark">' . $conteo . '</span>';


                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($id_cat) . '</td>';
                        echo '<td>' . htmlspecialchars($categoria->nombre_categoria ?? 'N/D') . '</td>';
                        echo '<td>' . htmlspecialchars($categoria->descripcion ?? 'N/D') . '</td>';
                        echo '<td class="text-center">' . $conteo_badge . '</td>';
                        
                        // Columna Acciones
                        echo '<td>';

                        // Botón Ver Productos de la Categoría
                        echo '<a href="?c=dashboard&a=productos_por_categoria&id=' . htmlspecialchars($id_cat) . '&nombre=' . urlencode($categoria->nombre_categoria ?? 'Categoria') . '" 
                                class="btn btn-success btn-sm me-2"
                                title="Ver productos en esta categoría">';
                        echo '<i class="fas fa-search"></i> Ver Productos';
                        echo '</a>';
                        
                        // Botón Editar (usa data-id para cargar datos en el modal)
                        echo '<button class="btn btn-warning btn-sm me-2 btn-edit-category" 
                                data-bs-toggle="modal" 
                                data-bs-target="#crudModal" 
                                data-c="categorias"
                                data-id="' . htmlspecialchars($id_cat) . '"
                                title="Editar Categoría">';
                        echo '<i class="fas fa-edit"></i>';
                        echo '</button>';
                        
                        // Botón Eliminar (apunta al controlador)
                        echo '<a href="?c=categoria&a=borrar&id=' . htmlspecialchars($id_cat) . '" 
                                class="btn btn-danger btn-sm btn-delete-category"
                                title="Eliminar Categoría">';
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
        $('#tablaCategorias').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "order": [[0, "asc"]], 
            "responsive": true
        });
        
        // Lógica de confirmación para el borrado de Categoría
        $(document).on('click', '.btn-delete-category', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (confirm('ADVERTENCIA: ¿Está seguro de eliminar esta categoría? Esto podría afectar a los productos asociados.')) {
                window.location.href = url;
            }
        });
    });
</script>

<?php include ('view/crudModal.php'); ?>