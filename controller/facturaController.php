<?php 

require_once 'model/venta.php';
require_once 'model/clientes.php';

class facturaController{
    private $venta;
    private $clientes;
    public function __construct(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        $this->venta = new venta();
        $this->clientes = new clientes();
    }

    public function crud(){
        // Validar que existan los parámetros necesarios
        if(!isset($_REQUEST['id_venta']) || !isset($_REQUEST['id_cliente'])){
            echo "<div class='alert alert-danger'>Error: Faltan parámetros necesarios (id_venta o id_cliente)</div>";
            return;
        }
        
        $id_venta = $_REQUEST['id_venta'];
        $id_cliente = $_REQUEST['id_cliente'];
        
        require_once 'view/facturas/generarFacturas.php'; 
    }


    public function generarfactura(){
        $id_venta = $_POST['id_venta'];
        $id_cliente = $_POST['id_cliente'];
        $tipo_documento = $_POST['facturas'];
        if ($tipo_documento === 'factura') {
            $productos = $this->venta->obtenerDetallesVenta($id_venta);
            $cliente = $this->clientes->obtenerUsuario($id_cliente);
            require_once 'view/facturas/factura.php';
        } elseif ($tipo_documento === 'ticket') {
            // $this->venta->generarTicket($id_venta, $id_cliente);
            require_once 'view/facturas/ticket.php';
        } else {
            echo "<div class='alert alert-danger'>Error: Tipo de documento no válido.</div>";
        }
    }
}