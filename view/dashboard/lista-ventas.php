<?php
$datos_pagados = $datos_pagados ?? []; 
$ventas_agrupadas = [];
$total_ventas_contadas = 0;
$total_ganancia_acumulada = 0.00;
foreach ($datos_pagados as $venta) {
  
    $id = $venta->id_venta; 
    
    if (empty($id)) continue; 

    if (!isset($ventas_agrupadas[$id])) {
        $ventas_agrupadas[$id] = [
            'id_venta' => $id,
            'cliente_nombre' => $venta->cliente_nombre ?? 'N/D',
            'fecha_venta' => $venta->fecha_venta ?? date('Y-m-d'),
            'total' => $venta->total ?? 0.00, 
            'estado_pago' => $venta->estado_pago ?? 'pagado',
            'productos' => []
        ];
        $total_ventas_contadas++;
        $total_ganancia_acumulada += (float)($venta->total ?? 0.00);
    }
  
    $ventas_agrupadas[$id]['productos'][] = $venta->producto_nombre ?? 'Producto Desconocido';
}
?>

<div class="container-fluid py-4">
    <h1 class="mb-4 text-success">
        <i class="fas fa-file-invoice-dollar me-2"></i> Listado de Ventas
    </h1>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0">Órdenes Pagadas y Completadas</h5>
        </div>
        <div class="card-body">

            <table id="tablaVentas" class="table table-striped table-hover w-100">
                <thead class="bg-light">
                    <tr>
                        <th>ID Venta</th>
                        <th>Cliente</th>
                        <th>Producto(s)</th>
                        <th>Fecha Venta</th>
                        <th>Total Ganado</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Iteramos sobre la estructura agrupada. Si está vacía, DataTables lo maneja.
                    foreach ($ventas_agrupadas as $venta) {
                        // Codificamos los nombres de los productos a JSON para pasarlos al botón
                        $productos_json = htmlspecialchars(json_encode($venta['productos']), ENT_QUOTES, 'UTF-8');
                        
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($venta['id_venta']) . '</td>';
                        echo '<td>' . htmlspecialchars($venta['cliente_nombre']) . '</td>';
                        
                        // Columna de Productos con el Botón Modal
                        echo '<td>';
                        echo '<button class="btn btn-sm btn-info btn-ver-productos" 
                            data-bs-toggle="modal" 
                            data-bs-target="#productosModal"
                            data-id-venta="' . htmlspecialchars($venta['id_venta']) . '"
                            data-productos="' . $productos_json . '">'; // Pasamos los productos como JSON
                        echo '<i class="fas fa-eye me-1"></i> Ver ' . count($venta['productos']) . ' Producto(s)';
                        echo '</button>';
                        echo '</td>';

                        echo '<td>' . date('d/m/Y', strtotime($venta['fecha_venta'])) . '</td>';
                        echo '<td>$' . number_format($venta['total'], 2) . '</td>';
                        echo '<td><span class="badge bg-success">' . ucfirst(htmlspecialchars($venta['estado_pago'])) . '</span></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Resumen de Ventas:</th>
                        <th id="gananciaTotal">$<?php echo number_format($total_ganancia_acumulada, 2); ?></th>
                        <th></th>
                    </tr>
                </tfoot>

            </table>

        </div>

        <div class="card-footer bg-light border-top d-flex justify-content-between align-items-center">
            <span class="fw-bold">
                Total de Ventas Contadas:
                <span class="badge bg-primary fs-6"><?php echo $total_ventas_contadas; ?></span>
            </span>
            <span class="fw-bold text-success">
                Ganancia Total Acumulada:
                <span class="fs-5">$<?php echo number_format($total_ganancia_acumulada, 2); ?></span>
            </span>
        </div>
    </div>
</div>

<div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="productosModalLabel">Detalle de Productos - Venta #<span id="modalVentaId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="modalProductosLista">
                    </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // 1. Inicialización de DataTables
        $('#tablaVentas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" // Idioma español
            },
            "order": [
                [3, "desc"]
            ], // Ordenar por Fecha Venta descendente por defecto
            "pagingType": "full_numbers",
            "responsive": true,
            "footerCallback": function(row, data, start, end, display) {
                // Función vacía para evitar que DataTables recalcule o mueva el tfoot
            }
        });

        // 2. Lógica para llenar el Modal de Productos
        const productosModal = document.getElementById('productosModal');
        productosModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const idVenta = button.getAttribute('data-id-venta');
            const productosJson = button.getAttribute('data-productos');

            let productos;
            try {
                productos = JSON.parse(productosJson);
            } catch (e) {
                console.error("Error al parsear JSON de productos:", e);
                productos = ["Error al cargar productos."];
            }

            const modalTitleSpan = productosModal.querySelector('#modalVentaId');
            modalTitleSpan.textContent = idVenta;

            const productosLista = productosModal.querySelector('#modalProductosLista');
            productosLista.innerHTML = ''; // Limpiar lista anterior

            if (Array.isArray(productos) && productos.length > 0) {
                productos.forEach(nombreProducto => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = nombreProducto;
                    productosLista.appendChild(li);
                });
            } else {
                 const li = document.createElement('li');
                 li.className = 'list-group-item text-muted';
                 li.textContent = 'No se encontraron detalles de productos.';
                 productosLista.appendChild(li);
            }
        });
    });
</script>