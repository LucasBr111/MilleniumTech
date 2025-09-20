<?php
// Archivo de prueba para el endpoint de verificación de email
require_once "controller/clienteController.php";

echo "<h2>Prueba del endpoint revisarEmail</h2>";

// Simular diferentes tipos de peticiones
$testCases = [
    ['email' => 'test@ejemplo.com'],
    ['email' => 'usuario@test.com'],
    ['email' => ''],
    ['email' => 'invalid-email'],
    ['email' => 'admin@admin.com']
];

foreach ($testCases as $index => $testCase) {
    echo "<h3>Prueba " . ($index + 1) . ": " . ($testCase['email'] ?: 'email vacío') . "</h3>";
    
    // Simular $_REQUEST
    $_REQUEST = $testCase;
    
    try {
        // Capturar la salida
        ob_start();
        
        // Crear instancia del controlador y llamar al método
        $controller = new clienteController();
        $controller->revisarEmail();
        
        // Obtener la salida
        $output = ob_get_clean();
        
        echo "<p><strong>Respuesta:</strong></p>";
        echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
        echo htmlspecialchars($output);
        echo "</pre>";
        
        // Intentar decodificar JSON
        $decoded = json_decode($output, true);
        if ($decoded) {
            echo "<p><strong>JSON decodificado:</strong></p>";
            echo "<pre style='background: #e8f5e8; padding: 10px; border-radius: 5px;'>";
            print_r($decoded);
            echo "</pre>";
        } else {
            echo "<p style='color: red;'>⚠️ No se pudo decodificar como JSON</p>";
        }
        
    } catch (Exception $e) {
        ob_end_clean();
        echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    }
    
    echo "<hr>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
pre { overflow-x: auto; }
hr { margin: 20px 0; }
</style>
