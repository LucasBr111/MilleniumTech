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

    // Registrar una nueva venta
    public function registrar($data)
    {
        try {
            $sql = "INSERT INTO ventas (
                        id_producto, id_cliente, cantidad, precio_unitario,
                        descuento, impuesto, total, metodo_pago,
                        estado_pago, observaciones
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $this->pdo->prepare($sql)->execute([
                $data->id_producto,
                $data->id_cliente,
                $data->cantidad,
                $data->precio_unitario,
                $data->descuento ?? 0,
                $data->impuesto ?? 0,
                $data->total, // subtotal se calcula solo en BD
                $data->metodo_pago,
                $data->estado_pago ?? 'pendiente',
                $data->observaciones ?? null
            ]);

            return $this->pdo->lastInsertId();
        } catch (Exception $e) {
            die($e->getMessage());
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
            $stm = $this->pdo->prepare("SELECT MAX(id_venta) as max_id FROM ventas");
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return $result->max_id ?? 0;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
