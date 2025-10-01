<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">
        <i class="fas fa-shopping-basket me-2"></i> Pedidos Pendientes
    </h1>
    
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0">Listado de Órdenes Pendientes</h5>
        </div>
        <div class="card-body">
            
            <table id="tablaPendientes" class="table table-striped table-hover w-100">
                <thead class="bg-light">
                    <tr>
                        <th>ID Venta</th>
                        <th>Cliente</th>
                        <th>Producto(s)</th>
                        <th>Fecha Venta</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Simulación de la obtención de datos del modelo
                    // ** DEBES llamar a tu controlador/modelo aquí **
                    // $datos_pendientes = $this->modelo->listarpendientes(); 
                    
                    // ** Importante: Para agrupar por id_venta en el frontend, 
                    // la función listarpendientes() debería devolver una lista plana 
                    // y la agruparemos aquí, o idealmente, devolver la lista agrupada desde el SQL. **
                    
                    // Dado que la función actual devuelve una lista plana (una fila por producto por venta),
                    // necesitamos agruparla para mostrar los productos múltiples por ID de Venta.
                    
                    $pedidos_agrupados = [];
                    // Simulación de datos para demostración
                    // Asumo que tu función listarpendientes() devuelve algo como esto:
                    /*
                    $datos_pendientes = [
                        (object)['id_venta' => 1, 'cliente_nombre' => 'Juan Pérez', 'producto_nombre' => 'Laptop', 'fecha_venta' => '2025-10-01', 'total' => 1200.00, 'id_detalle' => 10],
                        (object)['id_venta' => 1, 'cliente_nombre' => 'Juan Pérez', 'producto_nombre' => 'Mouse', 'fecha_venta' => '2025-10-01', 'total' => 1200.00, 'id_detalle' => 11],
                        (object)['id_venta' => 2, 'cliente_nombre' => 'Ana López', 'producto_nombre' => 'Monitor', 'fecha_venta' => '2025-09-30', 'total' => 300.00, 'id_detalle' => 12],
                    ];
                    */

                    // Usaremos la variable `$datos_pendientes` que DEBE ser llenada por tu controlador
                    // con el resultado de `$this->modelo->listarpendientes();`
                    
                    // Ejemplo de cómo agrupar la salida de la función en PHP:
                    foreach ($datos_pendientes as $venta) {
                        $id = $venta->id_venta;
                        if (!isset($pedidos_agrupados[$id])) {
                            $pedidos_agrupados[$id] = [
                                'id_venta' => $id,
                                'cliente_nombre' => $venta->cliente_nombre,
                                'fecha_venta' => $venta->fecha_venta,
                                'total' => $venta->total, // Usar el total de la venta principal
                                'productos' => []
                            ];
                        }
                        // Agregamos cada producto de esa venta
                        $pedidos_agrupados[$id]['productos'][] = $venta->producto_nombre;
                    }

                    // Ahora iteramos sobre la estructura agrupada para pintar la tabla:
                    foreach ($pedidos_agrupados as $venta) {
                        $productos_html = '<ul>';
                        foreach ($venta['productos'] as $producto) {
                            $productos_html .= '<li>' . htmlspecialchars($producto) . '</li>';
                        }
                        $productos_html .= '</ul>';
                        
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($venta['id_venta']) . '</td>';
                        echo '<td>' . htmlspecialchars($venta['cliente_nombre']) . '</td>';
                        echo '<td>' . $productos_html . '</td>';
                        echo '<td>' . date('d/m/Y', strtotime($venta['fecha_venta'])) . '</td>';
                        echo '<td>$' . number_format($venta['total'], 2) . '</td>';
                        echo '<td>';
                        
                        // Botón de Eliminar
                        echo '<button class="btn btn-sm btn-danger btn-eliminar" 
                                      data-id-venta="' . htmlspecialchars($venta['id_venta']) . '" 
                                      title="Eliminar Pedido Completo">';
                        echo '<i class="fas fa-trash-alt"></i> Eliminar';
                        echo '</button>';
                        
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>