<?php
class venta
{
    private $pdo;

    // Atributos públicos de la tabla ventas
    public $id_venta;
    public $id_producto;
    public $id_cliente;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;        // generado automáticamente por la BD
    public $descuento;
    public $impuesto;
    public $total;
    public $metodo_pago;
    public $estado_pago;
    public $fecha_venta;
    public $direccion_envio;

    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Listar todas las ventas
    public function listar()
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM ventas ORDER BY fecha_venta DESC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Obtener una venta por ID
    public function obtener($id_venta)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM ventas WHERE id_venta = ?");
            $stm->execute([$id_venta]);
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    // Registrar una nueva venta (y puntos)
    public function registrar($data)
    {
        // Asegúrate de que $this->pdo sea una instancia de PDO
        try {
            // 1. INICIAR TRANSACCIÓN: Asegura atomicidad (ambas o ninguna)
            $this->pdo->beginTransaction();

            // --- SENTENCIA 1: REGISTRAR VENTA ---
            $sqlVenta = "INSERT INTO ventas (
                         id_producto, id_cliente, id_venta,
                         cantidad, precio_unitario,
                         descuento, impuesto, total, metodo_pago,
                         estado_pago, direccion_envio
                     ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtVenta = $this->pdo->prepare($sqlVenta);
            $stmtVenta->execute([
                $data->id_producto,
                $data->id_cliente,
                $data->id_venta,
                $data->cantidad,
                $data->precio_unitario,
                $data->descuento ?? 0,
                $data->impuesto ?? 0,
                $data->total,
                $data->metodo_pago,
                $data->estado_pago ?? 'pendiente',
                $data->direccion_envio ?? null
            ]);

            $idVentaRegistrada = $this->pdo->lastInsertId();

            // --- SENTENCIA 2: REGISTRAR PUNTOS ---
            $sqlPuntos = "INSERT INTO puntos (id_cliente, puntos, fecha_obtencion, descripcion)
                      VALUES (?, 10, NOW(), 'Compra realizada')";

            $stmtPuntos = $this->pdo->prepare($sqlPuntos);
            // Solo necesita el id_cliente
            $stmtPuntos->execute([$data->id_cliente]);

            // 2. CONFIRMAR TRANSACCIÓN: Si todo salió bien
            $this->pdo->commit();

            return $idVentaRegistrada;
        } catch (Exception $e) {
            // 3. REVERTIR TRANSACCIÓN: Si algo falla
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            // Es mejor lanzar la excepción para que el controlador superior la maneje (ej. en el try/catch de guardar())
            // En tu caso, si quieres mantener la estructura, úsala para devolver un error:
            throw new Exception("Error al registrar la venta y/o puntos: " . $e->getMessage());

            // Si no lanzas la excepción, necesitarás que la función superior
            // (el controlador 'guardar') capture el die() o el mensaje de error.
            // die($e->getMessage());
        }
    }

    // Actualizar una venta
    public function actualizar($data)
    {
        try {
            $sql = "UPDATE ventas SET
                        id_producto = ?,
                        id_cliente = ?,
                        cantidad = ?,
                        precio_unitario = ?,
                        descuento = ?,
                        impuesto = ?,
                        total = ?,
                        metodo_pago = ?,
                        estado_pago = ?,
                        direccion_envio = ?
                    WHERE id_venta = ?";

            $this->pdo->prepare($sql)->execute([
                $data->id_producto,
                $data->id_cliente,
                $data->cantidad,
                $data->precio_unitario,
                $data->descuento ?? 0,
                $data->impuesto ?? 0,
                $data->total,
                $data->metodo_pago,
                $data->estado_pago,
                $data->direccion_envio,
                $data->id_venta
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Cambiar estado de pago (ej: marcar como pagado o cancelado)
    public function cambiarEstado($id_venta, $estado)
    {
        try {
            $sql = "UPDATE ventas SET estado_pago = ? WHERE id_venta = ?";
            $this->pdo->prepare($sql)->execute([$estado, $id_venta]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Eliminar una venta (si lo necesitás)
    public function eliminar($id_venta)
    {
        try {
            $sql = "DELETE FROM ventas WHERE id_venta = ?";
            $this->pdo->prepare($sql)->execute([$id_venta]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function ultimoId()
    {
        try {
            $stm = $this->pdo->query("SELECT COALESCE(MAX(id_venta), 0) as max_id FROM ventas");
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return (int)$result->max_id;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtenerVentaCliente($id_cliente)
    {
        try {
            $sql = "SELECT 
                v.id_venta AS id_venta,
                v.id,
                sum(v.total) as total,                      
                v.estado_pago AS estado,       
                v.fecha_venta AS fecha,       
                v.direccion_envio AS direccion_envio 
                FROM ventas v                /* Aquí faltaba el FROM */
                WHERE 
                v.id_cliente = ?
                GROUP BY 
                v.id_venta
                ORDER BY 
                v.fecha_venta DESC";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_cliente]);
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtenerDetallesVenta($id_venta)
    {
        try {
            $sql = "SELECT 
                v.id_venta,
                v.id_producto,
                p.nombre_producto AS nombre_producto,
                v.cantidad,
                v.precio_unitario,
                v.descuento,
                v.impuesto,
                v.total
                FROM ventas v
                JOIN productos p ON v.id_producto = p.id_producto
                WHERE v.id_venta = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_venta]);
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function cerrarVenta($id_venta, $direccion_envio, $metodo_pago, $descuento)
    {
        try {
            $sql = "UPDATE ventas SET 
                        direccion_envio = ?, 
                        metodo_pago = ?, 
                        estado_pago = 'pagado',
                        descuento = ?,
                        total = (total - ?)  /* Corregido: 'toal' debe ser 'total' */
                    WHERE id_venta = ?";

            $this->pdo->prepare($sql)->execute([
                $direccion_envio,
                $metodo_pago,
                $descuento,
                $descuento, // Se repite para la resta en la columna 'total'
                $id_venta
            ]);
        } catch (Exception $e) {
            // MEJORA: Manejo de errores seguro
            error_log("Error en cerrarVenta para ID {$id_venta}: " . $e->getMessage());
            // Lanza una excepción que el controlador puede capturar para devolver un JSON de error
            throw new Exception("Error interno al procesar la venta.");
        }
    }

    public function obtenerClientePorVenta($id_venta)
    {
        try {
            $sql = "SELECT c.* 
                    FROM clientes c
                    JOIN ventas v ON c.id = v.id_cliente
                    WHERE v.id_venta = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_venta]);
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function contarhoy()
    {
        try {
            $stm = $this->pdo->query("SELECT COUNT(*) as total_hoy FROM ventas WHERE DATE(fecha_venta) = CURDATE()");
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return (int)$result->total_hoy;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function listarpendientes(){
        try {
            $sql = "SELECT v.*, 
                           c.nombre AS cliente_nombre,
                           p.nombre_producto AS producto_nombre
                    FROM ventas v
                    LEFT JOIN clientes c ON v.id_cliente = c.id
                    LEFT JOIN productos p ON v.id_producto = p.id_producto
                    WHERE v.estado_pago = 'pendiente'
                    ORDER BY v.fecha_venta DESC";
            
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function listarPagados()
{
    try {
        $sql = "SELECT v.*, 
                       c.nombre AS cliente_nombre, 
                       p.nombre_producto AS producto_nombre
                FROM ventas v
                LEFT JOIN clientes c ON v.id_cliente = c.id
                LEFT JOIN productos p ON v.id_producto = p.id_producto
                WHERE v.estado_pago = 'pagado'
                ORDER BY v.fecha_venta DESC";
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

public function contarPendientes()
{
    try {
        $stm = $this->pdo->query("SELECT COUNT(*) as total_pendientes FROM ventas WHERE estado_pago = 'pendiente'");
        $result = $stm->fetch(PDO::FETCH_OBJ);
        return (int)$result->total_pendientes;
    } catch (Exception $e) {
        die($e->getMessage());
    }

    
}

   
}
