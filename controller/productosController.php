<?php

require_once "model/productos.php";
require_once "model/categorias.php";
require_once "model/favoritos.php";
require_once "model/venta.php";
class productosController
{

    private $model;
    private $categoria;
    private $favoritos;
    private $venta;

    public function __construct()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->model = new Productos();
        $this->categoria = new categorias();
        $this->favoritos = new favoritos();
        $this->venta = new venta();
    }

    public function index()
    {
        $id_categoria = $_REQUEST['id_categoria'];
        $nombre_categoria = $this->categoria->Obtener($id_categoria)->nombre_categoria;
        $filtro = $_REQUEST['filtro'] ?? null;
        $productos = $this->model->ListarPorCategoria($id_categoria, $filtro);

        require_once 'view/header.php';
        require_once 'view/productos/productos-por-categoria.php';
        require_once 'view/footer.php';
    }

    public function listar(){
        $id_categoria = $_REQUEST['id_categoria'];
        $filtro = $_REQUEST['filtro'];
        $terminoBusqueda = $_REQUEST['query'] ;

        $productos = $this->model->ListarPorCategoria($id_categoria, $filtro, $terminoBusqueda);

        include './view/productos/listado-productos.php';
       
    }


    public function crud()
    {
        $producto = new Productos();

        if (isset($_REQUEST['id'])) {
            $producto = $this->model->Obtener($_REQUEST['id']);
        }

        $categorias = $this->categoria->listar();


        require_once './view/productos/productos-editar.php';
    }
    public function favoritos()
    {
        $id_cliente = $_SESSION['user_id'];
        $productos = $this->favoritos->listarProductosFavoritos($id_cliente);
        require_once 'view/header.php';
        require_once './view/productos/productos-favoritos.php';
    }

    public function guardar()
    {
        $producto = new Productos();

        $producto->id_producto = $_REQUEST['id_producto'];
        $producto->nombre_producto = $_REQUEST['nombre_producto'];
        $producto->descripcion = $_REQUEST['descripcion'];
        $producto->precio = $_REQUEST['precio'];
        $producto->stock = $_REQUEST['stock'];
        $producto->id_categoria = $_REQUEST['id_categoria'];
        $producto->marca = $_REQUEST['marca'];
        $producto->destacado = isset($_REQUEST['destacado']) ? 1 : 0;
        $producto->promo_desde = $_REQUEST['promo_desde'];
        $producto->promo_hasta = $_REQUEST['promo_hasta'];



        // Paso 1: Procesar la Imagen de Portada (única)
        $imagen_portada_path = $_REQUEST['imagen_portada_actual']; // Por defecto, mantener la imagen actual

        if (!empty($_FILES['imagen_portada']['name'])) {
            $uploadDir = 'assets/uploads/productos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileTmpPath = $_FILES['imagen_portada']['tmp_name'];
            $fileName = basename($_FILES['imagen_portada']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedExtensions)) {
                // Generar un nombre único para evitar conflictos
                $dest_fileName = uniqid() . '.' . $fileExtension;
                $dest_path = $uploadDir . $dest_fileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagen_portada_path = $dest_fileName;
                }
            }
        }
        $producto->imagen = $imagen_portada_path; // Asignar la ruta al objeto producto

        $producto_id = $producto->id_producto;
        if ($producto_id > 0) {
            // Si es una actualización, ya tenemos el ID
            $this->model->Actualizar($producto);
        } else {
            // Si es un nuevo producto, el método Registrar debe devolver el ID insertado
            $producto_id = $this->model->Registrar($producto);
        }

        // Paso 3: Procesar la Galería de Imágenes (Múltiples)
        // Esto se hace siempre después de tener un ID de producto
        if ($producto_id > 0 && !empty($_FILES['imagenes_galeria']['name'][0])) {
            $uploadDir = 'assets/uploads/productos/';
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            foreach ($_FILES['imagenes_galeria']['tmp_name'] as $key => $tmp_name) {
                $fileName = $_FILES['imagenes_galeria']['name'][$key];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($fileExtension, $allowedExtensions)) {
                    $dest_fileName = uniqid('galeria_') . '.' . $fileExtension;
                    $dest_path = $uploadDir . $dest_fileName;

                    if (move_uploaded_file($tmp_name, $dest_path)) {
                        // Guardar la ruta y el ID del producto en la tabla secundaria
                        $this->model->RegistrarImagenGaleria($producto_id, $dest_fileName);
                    }
                }
            }
            // redirigir al index
           
        }  
        header('Location: index.php?c=home');         
    }

    public function addfavorito() {
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

    public function removefavorito() {
        // Configurar headers para JSON
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
}
