<?php
require_once "model/clientes.php";

class loginController {

    private $user;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->user = new clientes();
    }

    public function index() {
        require_once "view/login.php";
    }

    public function login() {
        // Configurar headers para JSON
        header('Content-Type: application/json');
        
        try {
            // Verificar que los datos estén presentes
            if (!isset($_POST['email']) || !isset($_POST['password'])) {
                echo json_encode(['status' => 'error', 'message' => 'Email y contraseña son requeridos']);
                return;
            }
            
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            // Validar formato de email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status' => 'error', 'message' => 'Formato de email inválido']);
                return;
            }
            
            // Crear objeto cliente para el login
            $cliente = new clientes();
            $cliente->email = $email;
            $cliente->password = $password;
            
            // Intentar hacer login
            $result = $this->user->login($cliente);
            
            if ($result) {
                // Iniciar sesión si no está iniciada
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Obtener datos del usuario
                $user = $this->user->obtener($cliente->email);
                
                if ($user) {
                    // Guardar datos en sesión
                    $_SESSION['nombre'] = $user->nombre;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['nivel'] = $user->nivel;
                    $_SESSION['user_id'] = $user->id;
                    
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Login exitoso',
                        'success' => '¡Bienvenido ' . $user->nombre . '!',
                        'user' => [
                            'nombre' => $user->nombre,
                            'email' => $user->email,
                            'nivel' => $user->nivel
                        ]
                    ]);
                    
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al obtener datos del usuario']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Email o contraseña incorrectos']);
            }
            
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error interno del servidor: ' . $e->getMessage()]);
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

            header('Location: index.php?c=home');
        
    }
}