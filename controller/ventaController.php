<?php
require_once 'model/venta.php';
require_once 'model/carrito.php';
require_once 'model/envio.php';
require_once 'model/clientes.php';
require_once 'model/productos.php';

class ventaController
{
    private $model;
    private $carrito;
    private $envio;
    private $cliente;
    private $productos;

    public function __construct()
    {
        $this->model = new venta();
        $this->carrito = new carrito();
        $this->envio = new envio();
        $this->cliente = new clientes();
        $this->productos = new productos();
    }

    // Mostrar listado de Ventas
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

    public function guardar()
    {

        header('Content-Type: application/json');
        try {
            // Validación básica
            if (!isset($_POST['productos']) || !is_array($_POST['productos'])) {
                echo json_encode(['success' => false, 'error' => 'No hay productos para registrar.']);
                return;
            }

            $id_cliente = $_SESSION['user_id'] ?? $_REQUEST['id_cliente'];
            // 1. Obtener el último id_venta y generar el nuevo
            // Asumiendo que tienes un método en tu modelo para esto
            $ultimo_id = $this->model->ultimoId();
            $nuevo_id_venta = (int) $ultimo_id + 1;


            // 2. Iterar sobre los productos y registrarlos en la tabla 'ventas'
            foreach ($_POST['productos'] as $producto) {
                $venta = new venta();
                $venta->id_venta        = $nuevo_id_venta;
                $venta->id_cliente      = $id_cliente; // ID de cliente de la sesión
                $venta->id_producto     = $producto['id_producto'];
                $venta->cantidad        = $producto['cantidad'];
                $venta->precio_unitario = $producto['precio_unitario'];
                $venta->descuento       = 0;
                $venta->impuesto        = 0;
                $venta->total           = $venta->cantidad * $venta->precio_unitario;
                $venta->metodo_pago     = $_POST['metodo_pago'] ?? 'Transferencia';
                $venta->estado_pago     = $_POST['estado_pago'] ?? 'Pendiente';
                $venta->direccion_envio = null;

                $this->model->registrar($venta);
            }

            // VAciar el carrito despues de la compra
            $this->carrito->limpiar($id_cliente);

            // 4. Devolver una respuesta JSON exitosa
            header('Content-Type: application/json');
            echo json_encode(['success' => true,]);
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

    // En tu VentaController.php o ClienteController.php

    public function obtenerDetallesVenta()
    {
        try {
            $id_venta = $_GET['id'] ?? 0;

            // if ($id_venta != 2) {
            //     throw new Exception("ID de venta inválido");
            // }

            // Llamar al método del modelo
            $detalles = $this->model->obtenerDetallesVenta($id_venta);

            // Asegurarse de devolver JSON válido
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($detalles);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }


    public function cerrarVenta()
    {
        $id_venta = $_POST['id_venta'] ?? 0;
        $metodo_pago = $_POST['metodo_pago'] ?? 'Transferencia';
        $direccion_envio = $_POST['direccion_envio'] ?? '';
        $descuento = $_POST['descuento_puntos'] ?? 0;
        $id_cliente = $this->model->obtenerClientePorVenta($id_venta)->id;
        try {

            $this->model->cerrarVenta($id_venta, $direccion_envio, $metodo_pago, $descuento);


            $envio = new envio();
            $envio->id_venta = $id_venta;
            $envio->direccion_completa = $direccion_envio ?? ''; // Usar $_POST
            $envio->departamento = $_POST['departamento'] ?? ''; // Usar $_POST
            $envio->ciudad = $_POST['ciudad'] ?? ''; // Usar $_POST
            $envio->contacto = $_POST['telefono_contacto'] ?? ''; // Usar $_POST
            $envio->referencias_adicionales = $_POST['referencias'] ?? ''; // Usar $_POST
            $this->envio->guardar($envio);

            // Restar puntos en base a descuento
            if ($descuento > 0) {
                $puntos_a_restar = $descuento / 100; // 1 punto equivale a 100Gs
                // Restar puntos
                $this->cliente->restarPuntos($id_cliente, $puntos_a_restar);
            }

            // Restamos el stock de los productos vendidos
            $productos = $this->model->obtenerDetallesVenta($id_venta);
            foreach ($productos as $producto) {
                $this->productos->restarStock($producto->id_producto, $producto->cantidad);
            }

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Venta cerrada exitosamente', 'id_venta' => $id_venta, 'id_cliente' => $id_cliente]);
        } catch (\Exception $e) {

            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al cerrar la venta: ' . $e->getMessage()]);
        }

        // header('Location: index.php?c=cliente');
    }
}
