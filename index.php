<?php
require_once "config/database/database.php";

// error_reporting(0);
$controller = isset($_GET['c']) ? $_GET['c'] : 'login'; 
$action = isset($_GET['a']) ? $_GET['a'] : 'index'; 

$controllerFile = "controller/" . $controller . "Controller.php"; 

if (file_exists($controllerFile)) { 
    require_once $controllerFile;
    
    $controllerClass = ucfirst($controller) . "Controller";

    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass(); 
        
        if (method_exists($controllerInstance, $action)) { 
            $controllerInstance->$action();
        } else {
            die("Error: Método no encontrado."); 
        }
    } else {
        die("Error: Clase no encontrada."); 
    }
} else {
    die("Error: Controlador no encontrado."); 
}
?>
