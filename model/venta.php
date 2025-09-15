<?php
class venta
{
    private $pdo;
    

    public $id;
    public $id_venta;              // si lo usás como correlativo interno
    public $id_cliente;
    public $id_vendedor;
    public $id_vehiculo;

    public $precio_costo;
    public $precio_venta_subtotal;
    public $total;

    public $tipo_comprobante;
    public $numero_comprobante;

    public $margen_ganancia;

    public $fecha_venta;
    public $metodo_pago;           // en tu idea de registro usaste tipo_pago
    public $anulado;

    public $id_presupuesto;


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
    public function obtener($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM ventas WHERE id = ?");
            $stm->execute([$id]);
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
                        id_presupuesto, id_cliente, id_vendedor, id_vehiculo,
                        fecha_venta, metodo_pago, total, precio_costo,
                        precio_venta_subtotal, cantidad_vendida, 
                        margen_ganancia, tipo_comprobante, numero_comprobante,
                        anulado
                    ) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

            $this->pdo->prepare($sql)->execute([
                $data->id_presupuesto,
                $data->id_cliente,
                $data->id_vendedor,
                $data->id_vehiculo,
                $data->fecha_venta,
                $data->tipo_pago,              // en tu idea de registro usas tipo_pago
                $data->precio_total,           // total de la venta
                $data->precio_costo ?? 0,
                $data->precio_venta_subtotal ?? 0,
                $data->cantidad_vendida ?? 1,
                $data->margen_ganancia ?? 0,
                $data->tipo_comprobante ?? 'Factura',
                $data->numero_comprobante ?? null
            ]);

            return $this->pdo->lastInsertId(); // devuelve el id_venta generado
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Actualizar una venta
    public function actualizar($data)
    {
        try {
            $sql = "UPDATE ventas SET
                        id_presupuesto = ?,
                        id_cliente = ?,
                        id_vendedor = ?,
                        id_vehiculo = ?,
                        fecha_venta = ?,
                        metodo_pago = ?,
                        total = ?,
                        precio_costo = ?,
                        precio_venta_subtotal = ?,
                        cantidad_vendida = ?,
                        margen_ganancia = ?,
                        tipo_comprobante = ?,
                        numero_comprobante = ?
                    WHERE id = ?";

            $this->pdo->prepare($sql)->execute([
                $data->id_presupuesto,
                $data->id_cliente,
                $data->id_vendedor,
                $data->id_vehiculo,
                $data->fecha_venta,
                $data->tipo_pago,
                $data->precio_total,
                $data->precio_costo ?? 0,
                $data->precio_venta_subtotal ?? 0,
                $data->cantidad_vendida ?? 1,
                $data->margen_ganancia ?? 0,
                $data->tipo_comprobante,
                $data->numero_comprobante,
                $data->id
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Anular una venta (cambia flag anulado = 1)
    public function anular($id)
    {
        try {
            $sql = "UPDATE ventas SET anulado = 1 WHERE id = ?";
            $this->pdo->prepare($sql)->execute([$id]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
