<?php
class dashboard
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Obtiene las ventas del día actual
     */
    public function getVentasHoy()
    {
        try {
            $sql = "SELECT COALESCE(SUM(total), 0) as total 
                    FROM ventas 
                    WHERE DATE(fecha_venta) = CURDATE() 
                    AND estado_pago != 'cancelado'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return floatval($resultado['total']);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Obtiene el porcentaje de cambio vs ayer
     */
    public function getTrendVentasHoy()
    {
        try {
            $sqlHoy = "SELECT COALESCE(SUM(total), 0) as total 
                       FROM ventas 
                       WHERE DATE(fecha_venta) = CURDATE() 
                       AND estado_pago != 'cancelado'";
            
            $sqlAyer = "SELECT COALESCE(SUM(total), 0) as total 
                        FROM ventas 
                        WHERE DATE(fecha_venta) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
                        AND estado_pago != 'cancelado'";
            
            $stmtHoy = $this->pdo->prepare($sqlHoy);
            $stmtHoy->execute();
            $hoy = $stmtHoy->fetch(PDO::FETCH_ASSOC);
            
            $stmtAyer = $this->pdo->prepare($sqlAyer);
            $stmtAyer->execute();
            $ayer = $stmtAyer->fetch(PDO::FETCH_ASSOC);
            
            $totalHoy = floatval($hoy['total']);
            $totalAyer = floatval($ayer['total']);
            
            if ($totalAyer > 0) {
                $porcentaje = (($totalHoy - $totalAyer) / $totalAyer) * 100;
            } else {
                $porcentaje = $totalHoy > 0 ? 100 : 0;
            }
            
            return [
                'porcentaje' => round($porcentaje, 1),
                'direccion' => $porcentaje >= 0 ? 'up' : 'down'
            ];
        } catch (Exception $e) {
            return ['porcentaje' => 0, 'direccion' => 'up'];
        }
    }

    /**
     * Obtiene el número de pedidos pendientes de pago
     */
    public function getPedidosPendientes()
    {
        try {
            $sql = "SELECT COUNT(DISTINCT id_venta) as total 
                    FROM ventas 
                    WHERE estado_pago = 'pendiente'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return intval($resultado['total']);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Obtiene el total de clientes registrados
     */
    public function getTotalClientes()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM clientes";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return intval($resultado['total']);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Obtiene el número de clientes nuevos este mes
     */
    public function getClientesNuevosMes()
    {
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM clientes 
                    WHERE MONTH(fecha_registro) = MONTH(CURDATE()) 
                    AND YEAR(fecha_registro) = YEAR(CURDATE())";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return intval($resultado['total']);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Obtiene productos con stock bajo (menos de 10 unidades)
     */
    public function getProductosStockBajo()
    {
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM productos 
                    WHERE stock < 5 AND stock >= 0";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return intval($resultado['total']);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Obtiene datos de ventas para el gráfico (últimos N días)
     */
    public function getVentasGrafico($dias = 7)
    {
        try {
            $sql = "SELECT 
                        DATE(fecha_venta) as fecha,
                        COALESCE(SUM(total), 0) as total,
                        COUNT(DISTINCT id_venta) as num_pedidos
                    FROM ventas 
                    WHERE fecha_venta >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                    AND estado_pago != 'cancelado'
                    GROUP BY DATE(fecha_venta)
                    ORDER BY fecha ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$dias]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Crear array con todos los días (incluso los que no tienen ventas)
            $datos = [];
            for ($i = $dias - 1; $i >= 0; $i--) {
                $fecha = date('Y-m-d', strtotime("-$i days"));
                $datos[$fecha] = [
                    'fecha' => $fecha,
                    'total' => 0,
                    'num_pedidos' => 0
                ];
            }
            
            // Rellenar con los datos reales
            foreach ($resultados as $row) {
                $datos[$row['fecha']] = [
                    'fecha' => $row['fecha'],
                    'total' => floatval($row['total']),
                    'num_pedidos' => intval($row['num_pedidos'])
                ];
            }
            
            return array_values($datos);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Obtiene la actividad reciente del sistema
     */
    public function getActividadReciente($limite = 10)
    {
        try {
            $sql = "SELECT 
                        'venta' as tipo,
                        v.id_venta,
                        v.total,
                        c.nombre as cliente,
                        v.fecha_venta as fecha,
                        v.estado_pago
                    FROM ventas v
                    INNER JOIN clientes c ON v.id_cliente = c.id
                    WHERE v.fecha_venta >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
                     GROUP BY v.id_venta    
                    
                    UNION ALL
                    
                    SELECT 
                        'cliente' as tipo,
                        c.id as id_venta,
                        0 as total,
                        c.nombre as cliente,
                        c.fecha_registro as fecha,
                        'registrado' as estado_pago
                    FROM clientes c
                    WHERE c.fecha_registro >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
                    
                    ORDER BY fecha DESC
                    LIMIT 10";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Obtiene los productos más vendidos
     */
    public function getTopProductos()
    {
        try {
            $sql = "SELECT 
                        p.id_producto,
                        p.nombre_producto,
                        p.imagen,
                        COUNT(DISTINCT v.id_venta) as num_ventas,
                        SUM(v.cantidad) as unidades_vendidas,
                        SUM(v.subtotal) as ingresos_totales
                    FROM ventas v
                    INNER JOIN productos p ON v.id_producto = p.id_producto
                    WHERE v.estado_pago != 'cancelado'
                    AND v.fecha_venta >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    GROUP BY p.id_producto, p.nombre_producto, p.imagen
                    ORDER BY ingresos_totales DESC
                    LIMIT 5";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Obtiene resumen de ventas por mes (para gráfico anual)
     */
    public function getVentasMensuales()
    {
        try {
            $sql = "SELECT 
                        MONTH(fecha_venta) as mes,
                        YEAR(fecha_venta) as anio,
                        COALESCE(SUM(total), 0) as total
                    FROM ventas 
                    WHERE fecha_venta >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                    AND estado_pago != 'cancelado'
                    GROUP BY YEAR(fecha_venta), MONTH(fecha_venta)
                    ORDER BY anio ASC, mes ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Obtiene estadísticas generales del dashboard
     */
    public function getEstadisticasGenerales()
    {
        try {
            return [
                'ventas_hoy' => $this->getVentasHoy(),
                'trend_ventas' => $this->getTrendVentasHoy(),
                'pedidos_pendientes' => $this->getPedidosPendientes(),
                'total_clientes' => $this->getTotalClientes(),
                'clientes_nuevos_mes' => $this->getClientesNuevosMes(),
                'stock_bajo' => $this->getProductosStockBajo()
            ];
        } catch (Exception $e) {
            return [
                'ventas_hoy' => 0,
                'trend_ventas' => ['porcentaje' => 0, 'direccion' => 'up'],
                'pedidos_pendientes' => 0,
                'total_clientes' => 0,
                'clientes_nuevos_mes' => 0,
                'stock_bajo' => 0
            ];
        }
    }
}
?>