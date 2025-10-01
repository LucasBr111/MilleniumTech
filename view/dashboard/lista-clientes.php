<?php
// =================================================================================
// INICIALIZACIÓN Y CARGA DE DATOS
// $datos_clientes DEBE ser llenada por el controlador (ej: $this->modelo->listarClientes()).
// Se inicializa para evitar warnings.
$datos_clientes = $datos_clientes ?? []; 

// NOTA: Asumo que los objetos de cliente tienen propiedades como: 
// id_cliente, nombre, correo, direccion, nivel (ej: VIP, Estándar), estado (ej: Activo/Inactivo).
// =================================================================================
?>

<div class="container-fluid py-4">
    <h1 class="mb-4 text-info">
        <i class="fas fa-users me-2"></i> Gestión de Clientes
    </h1>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Catálogo de Clientes Registrados</h5>
            
            <button class="btn btn-info text-white admin-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#crudModal" 
                    data-c="cliente" 
                    data-a="crear" 
                    title="Añadir Nuevo Cliente">
                <i class="fas fa-user-plus me-2"></i> Añadir Cliente
            </button>
        </div>
        
        <div class="card-body">
            
            <table id="tablaClientes" class="table table-striped table-hover w-100">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Correo Electrónico</th>
                        <th>Dirección</th>
                        <th>Nivel/Tipo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($datos_clientes as $cliente) {
                        $id_cliente = $cliente->id_cliente ?? $cliente->id;
                        $estado = $cliente->estado ?? 'activo'; // Ejemplo de campo estado
                        $nivel = $cliente->nivel ?? 'Estándar'; // Ejemplo de campo nivel

                        // Badge para el estado
                        $estado_badge_class = ($estado === 'activo' || $estado === 'Activo') ? 'bg-success' : 'bg-secondary';
                        $estado_badge = '<span class="badge ' . $estado_badge_class . '">' . htmlspecialchars(ucfirst($estado)) . '</span>';
                        
                        // Badge para el nivel
                        $nivel_badge_class = ($nivel === 'VIP') ? 'bg-warning text-dark' : 'bg-primary';
                        $nivel_badge = '<span class="badge ' . $nivel_badge_class . '">' . htmlspecialchars($nivel) . '</span>';

                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($id_cliente) . '</td>';
                        echo '<td>' . htmlspecialchars($cliente->nombre ?? 'N/D') . '</td>';
                        echo '<td>' . htmlspecialchars($cliente->correo ?? 'N/D') . '</td>';
                        echo '<td>' . htmlspecialchars($cliente->direccion ?? 'N/D') . '</td>';
                        echo '<td>' . $nivel_badge . '</td>';
                        echo '<td>' . $estado_badge . '</td>';
                        
                        // Columna Acciones
                        echo '<td>';
                        
                        // Botón Editar (Dispara el modal CRUD)
                        echo '<button class="btn btn-warning btn-sm me-2 btn-edit-client" 
                                data-bs-toggle="modal" 
                                data-bs-target="#crudModal" 
                                data-c="cliente"
                                data-a="editar"
                                data-id="' . htmlspecialchars($id_cliente) . '"
                                title="Editar Cliente">';
                        echo '<i class="fas fa-edit"></i>';
                        echo '</button>';
                        
                        // Botón Eliminar (apunta al controlador)
                        echo '<a href="?c=cliente&a=borrar&id=' . htmlspecialchars($id_cliente) . '" 
                                class="btn btn-danger btn-sm btn-delete-client"
                                title="Eliminar Cliente">';
                        echo '<i class="fas fa-user-slash"></i>';
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
        $('#tablaClientes').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" // Idioma español
            },
            "order": [
                [0, "asc"]
            ], // Ordenar por ID ascendente por defecto
            "pagingType": "full_numbers",
            "responsive": true
        });

        // 2. Lógica para el Modal CRUD (Crear/Editar Cliente)
        const crudModal = document.getElementById('crudModal');
        if (crudModal) {
            crudModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const controller = button.getAttribute('data-c'); // cliente
                const action = button.getAttribute('data-a');     // crear o editar
                const idItem = button.getAttribute('data-id'); 
                
                if (controller === 'cliente') {
                    const modalTitle = crudModal.querySelector('.modal-title');
                    const modalBody = crudModal.querySelector('.modal-body');

                    modalTitle.textContent = (action === 'crear') ? 'Añadir Nuevo Cliente' : `Editar Cliente #${idItem}`;
                    
                    // Lógica AJAX para cargar el formulario (debes implementarla en tu controlador)
                    const url = `?c=${controller}&a=formulario&id=${idItem || ''}`; 
                    
                    modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Cargando...</span></div><p class="mt-2">Cargando formulario...</p></div>';

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
                            modalBody.innerHTML = data; 
                        },
                        error: function() {
                            modalBody.innerHTML = '<div class="alert alert-danger">Error al cargar el formulario del cliente. Inténtelo de nuevo.</div>';
                        }
                    });
                }
            });
        }


        // 3. Lógica para el Botón Eliminar Cliente (con confirmación)
        $(document).on('click', '.btn-delete-client', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            if (confirm('¿Estás seguro de que deseas eliminar este cliente? Esto podría afectar a sus ventas históricas.')) {
                window.location.href = url;
            }
        });
    });
</script>