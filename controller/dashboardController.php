<?php 

require_once "model/productos.php"; 
require_once "model/categorias.php";
require_once "model/clientes.php";
require_once "model/venta.php";
require_once "model/metodo.php";




class dashboardController{
    private $productos;
    private $categorias;
    private $clientes;
    private $ventas;
    private $metodos;

    public function __construct(){
        $this->productos = new Productos();
        $this->categorias = new categorias();
        $this->clientes = new clientes();
        $this->ventas = new venta();
        $this->metodos = new metodo();
        
        
    }


    public function index(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Obtener ID del cliente si está logueado
        $ID_CLIENTE = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        $productos = $this->productos->Listar($ID_CLIENTE);
        $categorias = $this->categorias->listar();

        require_once 'view/header.php';
        require_once 'view/dashboard/home.php';
        require_once 'view/footer.php';
    
    }

    public function pedidos_pendientes(){
        $datos_pendientes = $this->ventas->listarPendientes();

        require_once 'view/header.php';
        require_once 'view/dashboard/listar-pendientes.php';
        require_once 'view/footer.php';

    }

    public function listado_ventas(){
        $datos_pagados = $this->ventas->listarPagados();

        require_once 'view/header.php';
        require_once 'view/dashboard/lista-ventas.php';
        require_once 'view/footer.php';
    }

    public function productos(){
        $datos_productos = $this->productos->Listar();

        require_once 'view/header.php';
        require_once 'view/dashboard/lista-productos.php';
        require_once 'view/footer.php';
    }

    public function categorias(){
        $datos_categorias = $this->categorias->listar();

        require_once 'view/header.php';
        require_once 'view/dashboard/lista-categorias.php';
        require_once 'view/footer.php';
    }

    public function productos_por_categoria()
    {
        $id_categoria = $_GET['id'] ?? null;
        if ($id_categoria) {
            $productos_categoria = $this->productos->ListarPorCategoria($id_categoria);
            require_once 'view/header.php';
            require_once 'view/dashboard/productos-por-categoria.php';
            require_once 'view/footer.php';
        } else {
            // Manejar el caso cuando no se proporciona una categoría válida
            header("Location: ?c=dashboard&a=categorias");
            exit();
        }
    }

    public function metodos_pago(){
        $metodos_con_ingresos = $this->metodos->lisarConIngresos();
        require_once 'view/header.php';
        require_once 'view/dashboard/lista-metodos.php';
        require_once 'view/footer.php';
    }

    public function clientes(){
        $datos_clientes = $this->clientes->listar();

        require_once 'view/header.php';
        require_once 'view/dashboard/lista-clientes.php';
        require_once 'view/footer.php';
    }
}   