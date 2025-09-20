<?php

require_once "model/productos.php";
require_once "model/categorias.php";

class productosController
{

    private $model;
    private $categoria;

    public function __construct()
    {
        $this->model = new Productos();
        $this->categoria = new categorias();
    }

    public function index()
    {
        $productos = $this->model->Listar();
        $categorias = $this->categoria->listar();
        require_once 'view/header.php';
        require_once 'view/sidebar.php';
        require_once 'view/productos/productos.php';
        require_once 'view/footer.php';
    }

    public function crud()
    {
        $producto = new Productos();

        if (isset($_REQUEST['id_producto'])) {
            $producto = $this->model->Obtener($_REQUEST['id_producto']);
        }

        $categorias = $this->categoria->listar();


        require_once './view/productos/productos-editar.php';
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
        }
        // redirigir al index
        header('Location: index.php?c=home');
    }
}
