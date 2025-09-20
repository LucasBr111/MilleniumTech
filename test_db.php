<?php
// Archivo de prueba para verificar la conexión a la base de datos
require_once "config/database/database.php";

echo "<h2>Prueba de conexión a la base de datos</h2>";

try {
    // Probar conexión
    $pdo = Database::StartUp();
    echo "<p style='color: green;'>✅ Conexión a la base de datos exitosa</p>";
    
    // Verificar si la tabla clientes existe
    $sql = "SHOW TABLES LIKE 'clientes'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tableExists = $stmt->fetchColumn();
    
    if ($tableExists) {
        echo "<p style='color: green;'>✅ La tabla 'clientes' existe</p>";
        
        // Verificar estructura de la tabla
        $sql = "DESCRIBE clientes";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Estructura de la tabla clientes:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Contar registros
        $sql = "SELECT COUNT(*) FROM clientes";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        echo "<p>Total de registros en clientes: <strong>$count</strong></p>";
        
        // Probar la función verificarEmail
        require_once 'model/clientes.php';
        $clienteModel = new clientes();
        
        echo "<h3>Prueba de verificarEmail:</h3>";
        
        // Probar con un email que probablemente no existe
        $testEmail = "test@ejemplo.com";
        $exists = $clienteModel->verificarEmail($testEmail);
        echo "<p>Email '$testEmail' existe: " . ($exists ? "Sí" : "No") . "</p>";
        
        // Probar con un email vacío
        try {
            $exists = $clienteModel->verificarEmail("");
            echo "<p>Email vacío existe: " . ($exists ? "Sí" : "No") . "</p>";
        } catch (Exception $e) {
            echo "<p style='color: orange;'>⚠️ Error con email vacío: " . $e->getMessage() . "</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ La tabla 'clientes' NO existe</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de conexión: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
</style>
