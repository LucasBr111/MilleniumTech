<?php
require_once 'model/usuarios.php';
class loginController {

    private $user;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->user = new usuarios();
    }

    public function index() {
        // Si ya está logueado, redirigir al inicio
        // if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
        //     header('Location: index.php?c=home');
        //     exit;
        // }
        require_once "view/login.php";
    }

    public function login() {
        $usuario = new usuarios();
        $usuario->nombre = $_POST['nombre'];
        $usuario->pass = $_POST['pass'];
    
        $result = $this->user->login($usuario);
    
        header('Content-Type: application/json');
    
        if ($result) {
            if (session_status() == PHP_SESSION_NONE) session_start();
    
            $user = $this->user->obtener($usuario->pass);
    
            $_SESSION['nombre'] = $user->nombre;
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['nivel'] = $user->nivel;
            $_SESSION['user_id'] = $user->id;
    
            echo json_encode(['status' => 'success', 'message' => 'Login exitoso']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuario o contraseña incorrectos']);
        }
        exit;
    }
    
    
    public function logout() {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Limpiar todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la sesión
        session_destroy();
        
        // Redireccionar al inicio con mensaje de sesión cerrada
        header('Location: index.php?c=login');
    }
}