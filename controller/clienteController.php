<?php 

require_once 'model/clientes.php';

class clienteController {
    private $model;

    public function __construct() {
        $this->model = new clientes();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
            header('Location: index.php?c=login');
            exit;
        }

        $clientes = $this->model->Listar();
        require_once 'view/header.php';
        require_once 'view/clientes/clientes.php';
        require_once 'view/footer.php';
    }

    public function crud(){
        $id = $_REQUEST['id'];
        if (isset($id)) {
            $cliente = $this->model->obtener($id);
        } else {
            $cliente = new clientes();
        }
        require_once 'view/clientes/clientes-form.php';
    }


    public function guardar() {
        session_start();
        if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
            header('Location: index.php?c=login');
            exit;
        }

        $cliente = new clientes();
        $cliente->id = $_REQUEST['id'];
        $cliente->ci = $_REQUEST['ci'];
        $cliente->nombre_completo = $_REQUEST['nombre_completo'];
        $cliente->correo = $_REQUEST['correo'];
        $cliente->nacionalidad = $_REQUEST['nacionalidad'] ?? "PARAGUAYA"; 
        $cliente->telefono = $_REQUEST['telefono'];
        $cliente->direccion = $_REQUEST['direccion'];
        $cliente->creado_en = date('Y-m-d');

        $cliente->id > 0 
            ? $this->model->Actualizar($cliente) 
            : $this->model->Registrar($cliente);

        
      
        header('Location: index.php?c=cliente');
    }

    public function eliminar() {
        $id = $_REQUEST['id'];
        $this->model->anular($id);
        header('Location: index.php?c=cliente');
    }

    public function BuscarID(){
        $id = $_REQUEST['id'];
        $cliente = $this->model->buscarID($id);
        echo json_encode($cliente);
    }

}

?>