<?php 

require_once "model/productos.php"; 
require_once "model/categorias.php";


class homeController{
    private $model;
    private $productos;
    private $categorias;

    public function __construct(){
        $this->model = new Productos();
        $this->productos = new productos();
        $this->categorias = new categorias();
        
    }


    public function index(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Obtener ID del cliente si está logueado
        $ID_CLIENTE = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        $productos = $this->model->Listar($ID_CLIENTE);
        $categorias = $this->categorias->listar();
        $productos_destacados = $this->model->ProductosDestacados($ID_CLIENTE);

        require_once 'view/header.php';
        // require_once 'view/sidebar.php';
        require_once 'view/home/home.php';
        require_once 'view/footer.php';
    
    }
}   