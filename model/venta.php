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
    public $observaciones;

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
                         estado_pago, observaciones
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
            $data->observaciones ?? null
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
                        observaciones = ?
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
                $data->observaciones,
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
                v.total,                      
                v.estado_pago AS estado,       
                v.fecha_venta AS fecha,       
                v.observaciones AS direccion_envio 
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


}
