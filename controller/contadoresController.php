<?php
require_once 'model/favoritos.php';
require_once 'model/carrito.php';

class contadoresController {
    private $favoritos;
    private $carrito;

    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->favoritos = new favoritos();
        $this->carrito = new carrito();
    }

    public function obtenerContadores() {
        // Configurar headers para JSON
        header('Content-Type: application/json');
        
        try {
            $contadores = [
                'favoritos' => 0,
                'carrito' => 0
            ];
            
            // Si el usuario está logueado, obtener contadores reales
            if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                $contadores['favoritos'] = $this->favoritos->contarPorCliente($_SESSION['user_id']);
                
                
                $contadores['carrito'] = $this->carrito->contarPorCliente($_SESSION['user_id']);
            }
            
            echo json_encode([
                'success' => true,
                'contadores' => $contadores
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => 'Error al obtener contadores: ' . $e->getMessage()
            ]);
        }
    }
}
