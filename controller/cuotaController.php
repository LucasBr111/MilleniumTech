<?php 

/* require_once 'model/cuota.php';
require_once 'model/cliente.php';
require_once 'model/ingreso.php';
require_once 'model/egreso.php'; */

class cuotaController{

    private $cuota;
    private $cliente;
    private $ingreso;
    private $egreso;
    public function __construct(){
        // Inicializar los constructores de los modelos 
        // $this->cuota = new cuota();
        // $this->cliente = new cliente();
        // $this->ingreso = new ingreso();
        // $this->egreso = new egreso();
    }

    public function index(){
        // Obtener todas las cuotas
       /*  $cuotas = $this->cuota->listar(); */
        // Cargar la vista y pasar las cuotas
        require_once 'view/header.php';
        require_once 'view/cuota/cuota.php';
        require_once 'view/footer.php';
    }
}