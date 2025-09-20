<?php

require_once "model/categorias.php";

class categoriasController
{

    private $model;
    private $categoria;

    public function __construct()
    {
        $this->model = new categorias();
        $this->categoria = new categorias();
    }

    public function index() {}

    public function crud()
    {
        $categoria = new categorias();

        if (isset($_REQUEST['id_categoria'])) {
            $categoria = $this->model->Obtener($_REQUEST['id_categoria']);
        }

        $categorias = $this->categoria->listar();


        require_once 'view/categorias/categorias-editar.php';
    }

    public function Guardar()
    {
        // Crear una nueva instancia del modelo de categorías
        $categoria = new Categorias();

        // Asignar los datos del formulario al objeto
        $categoria->id_categoria = $_REQUEST['id_categoria'];
        $categoria->nombre_categoria = $_REQUEST['nombre_categoria'];
        $categoria->descripcion = $_REQUEST['descripcion_categoria'];

        // Procesar la imagen de la categoría
        $imagen_path = $_REQUEST['imagen_actual']; // Mantener la imagen actual por defecto

        if (!empty($_FILES['imagen']['name'])) {
            $uploadDir = 'assets/uploads/categorias/'; // Directorio específico para categorías
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileName = basename($_FILES['imagen']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $dest_fileName = uniqid() . '.' . $fileExtension;
                $dest_path = $uploadDir . $dest_fileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagen_path = $dest_fileName;

                    // Opcional: Eliminar la imagen anterior si se está actualizando
                    if (!empty($_REQUEST['imagen_actual']) && file_exists($uploadDir . $_REQUEST['imagen_actual'])) {
                        unlink($uploadDir . $_REQUEST['imagen_actual']);
                    }
                }
            }
        }
        $categoria->imagen = $imagen_path; // Asignar la ruta al objeto

        // Llamar al método del modelo para guardar o actualizar
        $categoria->id_categoria > 0
            ? $this->model->Actualizar($categoria) // Si tiene ID, actualiza
            : $this->model->Registrar($categoria); // Si no, registra uno nuevo

        // Redirigir al listado de categorías después de guardar
        header('Location: ?c=home&a=Index');
    }
}
