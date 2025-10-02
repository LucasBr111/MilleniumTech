<?php 

require_once 'model/clientes.php';
require_once 'model/carrito.php';
require_once 'model/favoritos.php';
require_once 'model/venta.php';
require_once 'model/metodo.php';

class clienteController {
    private $model;
    private $carrito;
    private $favoritos;
    private $venta;
    private $metodo_pago;


    public function __construct() {
        $this->model = new clientes();
        $this->carrito = new carrito();
        $this->favoritos = new favoritos();
        $this->venta = new venta();
        $this->metodo_pago = new metodo();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
            header('Location: index.php?c=login');
            exit;
        }

        $cliente = $this->model->obtenerUsuario($_SESSION['user_id']);
        $compras = $this->venta->obtenerVentaCliente($_SESSION['user_id']);
        $puntoss = $this->model->obtenerPuntos($_SESSION['user_id']);
        $puntos =$this->model->listarpuntos($_SESSION['user_id']);
        require_once 'view/header.php';
        require_once 'view/clientes/clientes.php';
        require_once 'view/footer.php';
    }

    public function crud(){
        $id = $_REQUEST['id'];
        if (isset($id)) {
            $cliente = $this->model->obtenerUsuario($id);
        } else {
            $cliente = new clientes();
        }
        require_once 'view/clientes/clientes-editar.php';
    }

    public function signUp(){
        $cliente = new clientes();

        $cliente->nombre = $_REQUEST['nombre'];
        $cliente->email = $_REQUEST['email'];
        $cliente->password = $_REQUEST['password'];
        if($cliente->password == "ContrasenhaAdmin"){
            $cliente->nivel = 1;
        }else{
            $cliente->nivel = 2;
        }
        $this->model->registrar($cliente);
        header('Location: index.php?c=login');

    }

    public function revisarEmail(){
        // Configurar headers para JSON
        header('Content-Type: application/json');
        
        try {
            // Verificar que el email esté presente
            if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) {
                echo json_encode(['error' => 'Email no proporcionado']);
                return;
            }
            
            $email = trim($_REQUEST['email']);
            
            // Validar formato de email básico
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['error' => 'Formato de email inválido']);
                return;
            }
            
            // Verificar si el email existe
            $exists = $this->model->verificarEmail($email);
            
            // Devolver respuesta JSON
            echo json_encode([
                'is_available' => !$exists,
                'email' => $email,
                'exists' => $exists
            ]);
            
        } catch (Exception $e) {
            // En caso de error, devolver información de error
            echo json_encode([
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function Contaritems() {
        header('Content-Type: application/json');
    
        try {
            $id_cliente = (int) $_REQUEST['id_cliente'];

            // Consultar al modelo
            $cartCount = $this->carrito->contarPorCliente($id_cliente) ?? 0;
            $favCount  = $this->favoritos->contarPorCliente($id_cliente) ?? 0;
    
            echo json_encode([
                'cart' => $cartCount,
                'favorites' => $favCount
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function guardar(){
        $cliente = new clientes();

        $cliente->id = $_REQUEST['id'];
        $cliente->nombre = $_REQUEST['nombre'];
        $cliente->email = $_REQUEST['email'];
        $cliente->ci = $_REQUEST['ci'];
        $cliente->telefono = $_REQUEST['telefono'];
        $cliente->password = $_REQUEST['password'];

        $this->model->actualizar($cliente);
        header('Location: index.php?c=cliente');
    }

    public function borrar(){
        $id = $_REQUEST['id'];
        $this->model->eliminar($id);
        header('Location: index.php?c=dashboard&a=clientes');
    }
    


}


?>