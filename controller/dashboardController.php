<?php

require_once "model/productos.php";
require_once "model/categorias.php";
require_once "model/clientes.php";
require_once "model/venta.php";
require_once "model/metodo.php";
require_once "model/dashboard.php";




class dashboardController
{
    private $productos;
    private $categorias;
    private $clientes;
    private $ventas;
    private $metodos;
    private $model;

    public function __construct()
    {
        $this->productos = new Productos();
        $this->categorias = new categorias();
        $this->clientes = new clientes();
        $this->ventas = new venta();
        $this->metodos = new metodo();
        $this->model = new dashboard();
    }


    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener ID del cliente si está logueado
        $ID_CLIENTE = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        $productos = $this->productos->Listar($ID_CLIENTE);
        $categorias = $this->categorias->listar();

        // Por si acaso verificar si es admin nuevamente 
        $es_admin = ($_SESSION['nivel'] == 1);
        if ($es_admin) {
            require_once 'view/header.php';
            require_once 'view/dashboard/home_prueba.php';
            require_once 'view/footer.php';
        } else {
           header("Location: ?c=home");
        }
    }

    public function pedidos_pendientes()
    {
        $datos_pendientes = $this->ventas->listarPendientes();

        require_once 'view/header.php';
        require_once 'view/dashboard/listar-pendientes.php';
        require_once 'view/footer.php';
    }

    public function listado_ventas()
    {
        $datos_pagados = $this->ventas->listarPagados();

        require_once 'view/header.php';
        require_once 'view/dashboard/lista-ventas.php';
        require_once 'view/footer.php';
    }

    public function productos()
    {
        $datos_productos = $this->productos->Listar();

        require_once 'view/header.php';
        require_once 'view/dashboard/lista-productos.php';
        require_once 'view/footer.php';
    }

    public function categorias()
    {
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

    public function metodos_pago()
    {
        $metodos_con_ingresos = $this->metodos->lisarConIngresos();
        require_once 'view/header.php';
        require_once 'view/dashboard/lista-metodos.php';
        require_once 'view/footer.php';
    }

    public function clientes()
    {
        $datos_clientes = $this->clientes->listar();

        require_once 'view/header.php';
        require_once 'view/dashboard/lista-clientes.php';
        require_once 'view/footer.php';
    }

    public function chat_ia()
    {
        require_once 'view/header.php';
        require_once 'view/dashboard/chat_ia.php';
        require_once 'view/footer.php';
    }

    public function getEstadisticas()
    {
        header('Content-Type: application/json');
        
        try {
            $estadisticas = $this->model->getEstadisticasGenerales();
            
            echo json_encode([
                'success' => true,
                'data' => $estadisticas
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Obtiene datos para el gráfico de ventas
     */
    public function getGraficoVentas()
    {
        header('Content-Type: application/json');
        
        try {
            $dias = isset($_GET['dias']) ? intval($_GET['dias']) : 7;
            
            // Validar días
            if (!in_array($dias, [7, 30, 365])) {
                $dias = 7;
            }
            
            if ($dias == 365) {
                // Si es un año, usar datos mensuales
                $datos = $this->model->getVentasMensuales();
            } else {
                // Para 7 o 30 días, usar datos diarios
                $datos = $this->model->getVentasGrafico($dias);
            }
            
            echo json_encode([
                'success' => true,
                'data' => $datos,
                'periodo' => $dias
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Obtiene actividad reciente
     */
    public function getActividad()
    {
        header('Content-Type: application/json');
        
        try {
            $limite = 10;
            $actividades = $this->model->getActividadReciente();
            
            echo json_encode([
                'success' => true,
                'data' => $actividades
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Obtiene top productos
     */
    public function getTopProductos()
    {
        header('Content-Type: application/json');
        
        try {
            $limite = isset($_GET['limite']) ? intval($_GET['limite']) : 5;
            $productos = $this->model->getTopProductos($limite);
            
            echo json_encode([
                'success' => true,
                'data' => $productos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
