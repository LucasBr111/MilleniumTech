<?php
require_once 'model/venta.php';
require_once 'model/carrito.php';

class ventaController
{
    private $model;
    private $carrito;

    public function __construct()
    {
        $this->model = new venta();
        $this->carrito = new carrito();
    }

    // Mostrar listado de ventas
    public function index()
    {
        try {
            $ventas = $this->model->listar();
            require_once 'view/header.php';
            require_once 'view/ventas/ventas.php';   // vista principal de listado
            require_once 'view/footer.php';
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Mostrar formulario para nueva o edición
    public function crud()
    {
        try {
            $venta = new venta();

            if (isset($_REQUEST['id_venta']) && !empty($_REQUEST['id_venta'])) {
                $venta = $this->model->obtener($_REQUEST['id_venta']);
            }

            require_once 'view/header.php';
            require_once 'view/ventas/ventas-form.php'; // formulario
            require_once 'view/footer.php';
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // En tu controlador de ventas (VentaController.php)

// En tu controlador de ventas (VentaController.php)

public function guardar() {
    try {
        // Validación básica
        if (!isset($_POST['productos']) || !is_array($_POST['productos'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'No hay productos para registrar.']);
            return;
        }

        // 1. Obtener el último id_venta y generar el nuevo
        // Asumiendo que tienes un método en tu modelo para esto
        $ultimo_id = $this->model->ultimoId();
        $nuevo_id_venta = $ultimo_id + 1;
        

        // 2. Iterar sobre los productos y registrarlos en la tabla 'ventas'
        foreach ($_POST['productos'] as $producto) {
            $venta = new venta();
            $venta->id_venta        = $nuevo_id_venta;
            $venta->id_producto     = $producto['id_producto'];
            $venta->id_cliente      = $_SESSION['id_cliente'] ?? 1; // ID de cliente de la sesión
            $venta->cantidad        = $producto['cantidad'];
            $venta->precio_unitario = $producto['precio_unitario'];
            $venta->descuento       = 0;
            $venta->impuesto        = 0;
            $venta->total           = $venta->cantidad * $venta->precio_unitario;
            $venta->metodo_pago     = $_POST['metodo_pago'] ?? 'Pendiente';
            $venta->estado_pago     = $_POST['estado_pago'] ?? 'Pendiente';
            $venta->observaciones   = null;

            $this->model->registrar($venta);
        }


        // VAciar el carrito despues de la compra
        $this->carrito->limpiar($_SESSION['id_cliente']);

        // 4. Devolver una respuesta JSON exitosa
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'redirect_url' => 'index.php?c=documentos&id_venta=' . $nuevo_id_venta]);

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
    // Cambiar estado de pago (ej: AJAX)
    public function cambiarEstado()
    {
        header('Content-Type: application/json');
        try {
            if (!isset($_REQUEST['id_venta'], $_REQUEST['estado'])) {
                echo json_encode(['error' => 'Parámetros faltantes']);
                return;
            }

            $this->model->cambiarEstado($_REQUEST['id_venta'], $_REQUEST['estado']);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Eliminar venta
    public function eliminar()
    {
        try {
            if (isset($_REQUEST['id_venta'])) {
                $this->model->eliminar($_REQUEST['id_venta']);
            }
            header('Location: index.php?c=venta');
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
