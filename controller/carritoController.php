<?php

require_once "model/productos.php";
require_once "model/categorias.php";
require_once "model/carrito.php";
class carritoController
{

    private $model;
    private $categoria;
    private $carrito;
    public function __construct()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->model = new Productos();
        $this->categoria = new categorias();
        $this->carrito = new carrito();
    }

    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $id_cliente = $_SESSION['user_id'];
            $productos = $this->carrito->listarProductoscarrito($id_cliente);
            require_once 'view/header.php';
            require_once './view/productos/productos-carrito.php';
            require_once 'view/footer.php';
        }
        else{
            // describir el error
            $problema = "Acceso no autorizado";
            $subtitulo_error = "Inicia sesión o regístrate para continuar.";
            $cuerpo_problema = "Si ya tienes una cuenta, por favor inicia sesión. Si no, puedes registrarte para crear una nueva cuenta y disfrutar de nuestros servicios.";
            require_once 'view/header.php';
            require_once './view/errror.php';
            require_once 'view/footer.php';
        }

    }

    public function agregar() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401); 
            echo json_encode(['error' => 'Debes iniciar sesión para añadir a carrito.']);
            exit;
        }
    
        if (isset($_REQUEST['id_producto'])) {
            $carrito = new carrito();
            $carrito->id_cliente = $_SESSION['user_id']; 
            $carrito->id_producto = $_REQUEST['id_producto'];
            $carrito->cantidad = $_REQUEST['cantidad'] ?? 1;
    
            try {
                $this->carrito->guardar($carrito);
                echo json_encode(['success' => 'Producto añadido a carrito.']);
            } catch (Exception $e) {
                http_response_code(500); 
                echo json_encode(['error' => 'Error al añadir a carrito: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(400); // Código de 'Bad Request'
            echo json_encode(['error' => 'ID de producto no proporcionado.']);
        }
    }

    public function eliminar() {
        header('Content-Type: application/json');
        
        try {
            // Verificar que el usuario esté logueado
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Debes iniciar sesión para eliminar de carrito.']);
                return;
            }
            
            // Verificar que el id_producto esté presente
            if (!isset($_REQUEST['id_producto'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID de producto no proporcionado.']);
                return;
            }
            
            $id_cliente = $_SESSION['user_id'];
            $id_producto = $_REQUEST['id_producto'];
            
            // Llamar al modelo para eliminar el favorito
            $this->carrito->eliminar($id_cliente, $id_producto);
            
            // Enviar respuesta de éxito
            echo json_encode(['success' => 'Producto eliminado de carrito.']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar de carrito: ' . $e->getMessage()]);
        }
    }

    public function vaciar() {
        header('Content-Type: application/json');
        
        try {
            $id_cliente = $_SESSION['user_id'];
            $this->carrito->limpiar($id_cliente);
    
            echo json_encode(['success' => 'Lista de carrito limpiada correctamente.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al limpiar carrito: ' . $e->getMessage()]);
        }
    }

    public function actualizar() {
        header('Content-Type: application/json');
        
        try {
            // Verificar que el usuario esté logueado
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Debes iniciar sesión para actualizar el carrito.']);
                return;
            }
            
            // Verificar que los datos estén presentes
            if (!isset($_REQUEST['id_producto']) || !isset($_REQUEST['cantidad'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Datos incompletos.']);
                return;
            }
            
            $id_cliente = $_SESSION['user_id'];
            $id_producto = $_REQUEST['id_producto'];
            $cantidad = intval($_REQUEST['cantidad']);
            
            // Validar cantidad
            if ($cantidad < 0) {
                http_response_code(400);
                echo json_encode(['error' => 'La cantidad no puede ser negativa.']);
                return;
            }
            
            // Actualizar cantidad
            $this->carrito->actualizarCantidad($id_cliente, $id_producto, $cantidad);
            
            echo json_encode(['success' => 'Cantidad actualizada correctamente.']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar cantidad: ' . $e->getMessage()]);
        }
    }
    
}
