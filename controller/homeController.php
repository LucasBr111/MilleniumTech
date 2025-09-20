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
        $productos = $this->model->Listar();
        $categorias = $this->categorias->listar();
        $productos_destacados = $this->model->ProductosDestacados();

        require_once 'view/header.php';
        // require_once 'view/sidebar.php';
        require_once 'view/home/home.php';
        require_once 'view/footer.php';
    
    }
}   