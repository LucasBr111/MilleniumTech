<?php

require_once "model/productos.php";
require_once "model/categorias.php";
require_once "model/favoritos.php";
class favoritosController
{

    private $model;
    private $categoria;
    private $favoritos;
    public function __construct()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->model = new Productos();
        $this->categoria = new categorias();
        $this->favoritos = new favoritos();
    }

    public function index()
    {
        $id_cliente = $_SESSION['user_id'];
        $productos = $this->favoritos->listarProductosFavoritos($id_cliente);
        require_once 'view/header.php';
        require_once './view/productos/productos-favoritos.php';
    }

    public function add() {
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['user_id'])) {
            // Enviar una respuesta de error si el usuario no está logueado
            http_response_code(401); // Código de 'Unauthorized'
            echo json_encode(['error' => 'Debes iniciar sesión para añadir a favoritos.']);
            exit;
        }
    
        // Asegurarse de que el id_producto se reciba correctamente
        if (isset($_REQUEST['id_producto'])) {
            $id_cliente = $_SESSION['user_id']; // Usar la variable correcta de sesión
            $id_producto = $_REQUEST['id_producto'];
    
            try {
                // Llamar al modelo para registrar el favorito
                $this->favoritos->registrar($id_cliente, $id_producto);
    
                // Enviar una respuesta de éxito
                echo json_encode(['success' => 'Producto añadido a favoritos.']);
            } catch (Exception $e) {
                // Manejar errores de la base de datos
                http_response_code(500); // Código de 'Internal Server Error'
                echo json_encode(['error' => 'Error al añadir a favoritos: ' . $e->getMessage()]);
            }
        } else {
            http_response_code(400); // Código de 'Bad Request'
            echo json_encode(['error' => 'ID de producto no proporcionado.']);
        }
    }

    public function remove() {
        header('Content-Type: application/json');
        
        try {
            // Verificar que el usuario esté logueado
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Debes iniciar sesión para eliminar de favoritos.']);
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
            $this->favoritos->eliminar($id_cliente, $id_producto);
            
            // Enviar respuesta de éxito
            echo json_encode(['success' => 'Producto eliminado de favoritos.']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar de favoritos: ' . $e->getMessage()]);
        }
    }

    public function clean() {
        header('Content-Type: application/json');
        
        try {
            $id_cliente = $_SESSION['user_id'];
            $this->favoritos->limpiar($id_cliente);
    
            echo json_encode(['success' => 'Lista de favoritos limpiada correctamente.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al limpiar favoritos: ' . $e->getMessage()]);
        }
    }
    
}
