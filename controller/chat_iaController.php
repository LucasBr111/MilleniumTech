<?php

// archivo que crea la conexion a la base de datos
require_once './config/database/database.php';

class chat_iaController {
    private $pdo;
    private $apiKey = 'AIzaSyABQ7SR-KU-fC5e-vlZmU5WkQifRgNnf7I'; 
    private $db;
    private $esquema_db;

    public function __construct() {
        try {
            $this->pdo = Database::StartUp();
            
            // DEBUG: Verificar que el archivo existe
            $schema_path = './config/database/db.sql';
            if (!file_exists($schema_path)) {
                error_log("ERROR: No se encontró el archivo de esquema en: " . $schema_path);
                $this->esquema_db = "-- Esquema no disponible";
            } else {
                $this->esquema_db = file_get_contents($schema_path);
                error_log("INFO: Esquema cargado correctamente. Tamaño: " . strlen($this->esquema_db) . " bytes");
            }
        } catch (Exception $e) {
            error_log("ERROR FATAL en __construct: " . $e->getMessage());
            die(json_encode(['type' => 'error', 'content' => 'Error de conexión a la base de datos: ' . $e->getMessage()]));
        }
    }
    
    public function consultarGeminiSimple() {
        // DEBUG: Log de inicio
        error_log("=== INICIO consultarGeminiSimple ===");
        error_log("Método HTTP: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST recibido: " . print_r($_POST, true));
        
        // Verificar método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("ERROR: Método no es POST");
            header('Content-Type: application/json');
            echo json_encode(['type' => 'error', 'content' => 'Solo se permiten peticiones POST.']);
            return;
        }
        
        // Verificar que existan los datos
        if (!isset($_POST['pregunta'])) {
            error_log("ERROR: Falta el campo 'pregunta'");
            header('Content-Type: application/json');
            echo json_encode(['type' => 'error', 'content' => 'Falta el campo "pregunta".']);
            return;
        }

        // Obtener y limpiar los datos POST
        $pregunta = trim($_POST['pregunta']);
        error_log("Pregunta recibida: " . $pregunta);
        
        // El historial viene como string JSON
        $historial_raw = $_POST['historial'] ?? '[]';
        error_log("Historial RAW: " . $historial_raw);
        
        $historial = json_decode($historial_raw, true);

        // Verificar si la decodificación JSON falló
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("ERROR: JSON inválido en historial. Error: " . json_last_error_msg());
            $historial = [];
        } else {
            error_log("Historial decodificado correctamente. Elementos: " . count($historial));
        }

        // Si no es un array, inicializar como array vacío
        if (!is_array($historial)) {
            error_log("WARNING: Historial no es un array, inicializando vacío");
            $historial = [];
        }

        try {
            // Llamar a la lógica principal
            error_log("Llamando a procesarPregunta...");
            $respuesta_datos = $this->procesarPregunta($pregunta, $historial);
            error_log("Respuesta generada. Tipo: " . $respuesta_datos['type']);
            
            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($respuesta_datos);
            error_log("=== FIN consultarGeminiSimple (ÉXITO) ===");
            
        } catch (Exception $e) {
            error_log("ERROR CRÍTICO en procesarPregunta: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            header('Content-Type: application/json');
            echo json_encode([
                'type' => 'error', 
                'content' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    public function procesarPregunta(string $pregunta, array $historial): array {
        error_log("--- procesarPregunta iniciado ---");
        error_log("Pregunta: " . $pregunta);
        
        // Validación básica
        if (empty($pregunta)) {
            error_log("ERROR: Pregunta vacía");
            return ['type' => 'error', 'content' => 'La pregunta no puede estar vacía.'];
        }
        
        $prompt_intencion = "Eres un analista de datos experto. El usuario te ha hecho una pregunta sobre su negocio.
        Basado en su pregunta ('{$pregunta}'), decide el mejor método para responder.
        
        Tus únicas respuestas posibles son:
        1. 'SQL:' si la pregunta es sobre datos cuantitativos que requieren una consulta a la base de datos (Ej: 'Ventas del último mes', 'Clientes con más pedidos').
        2. 'GRAPH:' si la pregunta pide una visualización gráfica de datos (Ej: 'Mostrar un gráfico de ventas por mes', 'Distribución de clientes por nivel').
        3. 'TEXT:' si la pregunta es general, de ayuda o no requiere una consulta a la DB (Ej: 'Hola', 'Qué puedes hacer', 'Definición de nivel VIP').
        
        Responde ÚNICAMENTE con la palabra clave y los dos puntos, seguido de un espacio. Ejemplo: 'SQL: ' o 'TEXT: ' o 'GRAPH: '.
        La pregunta del usuario es: {$pregunta}";

        error_log("Consultando intención a Gemini...");
        $intencion = trim($this->consultar($prompt_intencion, $historial));
        error_log("Intención detectada: " . $intencion);
        
        if (str_starts_with($intencion, 'SQL:')) {
            error_log("Procesando como SQL");
            return $this->manejarIntencionSQL($pregunta, $historial);
        } elseif (str_starts_with($intencion, 'GRAPH:')) {
            error_log("Procesando como GRAPH");
            return $this->manejarIntencionSQL($pregunta, $historial, true);
        } elseif (str_starts_with($intencion, 'TEXT:')) {
            error_log("Procesando como TEXT");
            return $this->manejarIntencionTexto($pregunta, $historial);
        } else {
            error_log("WARNING: Intención no reconocida: " . $intencion);
            $default_text = str_starts_with($intencion, 'TEXT: ') ? substr($intencion, 6) : $intencion;
            return ['type' => 'text', 'content' => $default_text];
        }
    }

    private function manejarIntencionSQL(string $pregunta, array $historial, bool $es_grafico = false): array {
        error_log("--- manejarIntencionSQL iniciado (gráfico: " . ($es_grafico ? 'SI' : 'NO') . ") ---");
        
        $limit_clause = $es_grafico ? 'LIMIT 100' : 'LIMIT 50';
        $prompt_sql = "Eres un programador senior. 
        Genera SOLAMENTE una consulta SQL tipo SELECT (sin INSERT, UPDATE ni DELETE),
        usando las tablas del siguiente esquema. 
        El resultado debe ser ÚNICAMENTE la consulta SQL, sin comentarios ni explicación. 
        Agrega siempre {$limit_clause}.
        Si es para un gráfico, asegúrate de que el SELECT contenga DOS columnas: una para la ETIQUETA (Ej: mes, nombre de producto) y otra para el VALOR (Ej: total, conteo).
        
        Mi base de datos:
        {$this->esquema_db}
        
        La Pregunta del usuario es: {$pregunta}
        
        Responde con la consulta sql que nos permita encontrar lo deseado, ademas de recordar cambiar el nombre a los campos (alias) con tal de maximizar el entendimiento del nombre del campo.
        ";

        error_log("Consultando SQL a Gemini...");
        $sql = $this->consultar($prompt_sql, $historial);
        error_log("SQL generado: " . $sql);
        
        // Limpieza para asegurar que solo sea el SQL
        $sql = trim($sql);
        
        // Verificar que sea un SELECT válido
        if (stripos($sql, 'SELECT') !== 0) {
            error_log("ERROR: SQL no comienza con SELECT");
            return ['type' => 'error', 'content' => 'La IA no pudo generar una consulta SQL válida. SQL generado: ' . substr($sql, 0, 200)];
        }

        if (empty($sql)) {
            error_log("ERROR: SQL vacío");
            return ['type' => 'error', 'content' => 'La IA devolvió una consulta vacía.'];
        }
        
        error_log("Ejecutando consulta SQL...");
        $resultados_db = $this->ejecutarConsulta($sql);
        error_log("Resultados obtenidos: " . count($resultados_db) . " filas");
        
        if (isset($resultados_db[0]['error'])) {
            error_log("ERROR en ejecución SQL: " . $resultados_db[0]['error']);
            return ['type' => 'error', 'content' => 'Error al ejecutar la consulta: ' . $resultados_db[0]['error']];
        }

        if ($es_grafico) {
            return ['type' => 'graph', 'content' => $resultados_db];
        } else {
            return ['type' => 'sql_result', 'content' => $resultados_db];
        }
    }

    private function manejarIntencionTexto(string $pregunta, array $historial): array {
        error_log("--- manejarIntencionTexto iniciado ---");
        
        $prompt_texto = "Eres el Asistente de Gestión Empresarial. Responde la pregunta del usuario ('{$pregunta}') de forma amigable y profesional. Utiliza el historial para mantener el contexto.
        
        Si no sabes algo, dilo de forma amable.";
        
        error_log("Consultando respuesta de texto a Gemini...");
        $respuesta = $this->consultar($prompt_texto, $historial);
        error_log("Respuesta de texto recibida. Longitud: " . strlen($respuesta));
        
        return ['type' => 'text', 'content' => $respuesta];
    }

    private function consultar(string $prompt, array $historial): string {
        error_log(">>> consultar() iniciado <<<");
        
        if (empty($this->apiKey)) {
            error_log("ERROR: API Key no configurada");
            return "TEXT: Lo siento, la clave API de Gemini no está configurada correctamente.";
        }
        
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=" . $this->apiKey;
        error_log("URL de API: " . substr($url, 0, 80) . "...");

        // Formatear el historial y añadir el nuevo prompt
        $contents = [];
        foreach ($historial as $msg) {
            $contents[] = ['role' => $msg['role'], 'parts' => [['text' => $msg['text']]]];
        }
        $contents[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];
        
        error_log("Contenido preparado con " . count($contents) . " mensajes");
    
        $data = ["contents" => $contents];
        $json_data = json_encode($data);
        error_log("Tamaño del payload: " . strlen($json_data) . " bytes");
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout de 30 segundos
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Timeout de conexión
        
        error_log("Enviando petición a Gemini API...");
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        error_log("Respuesta HTTP Code: " . $httpCode);
        
        if ($curlError) {
            error_log("ERROR CURL: " . $curlError);
            return "TEXT: Error de conexión con la API de IA: " . $curlError;
        }
    
        if ($httpCode !== 200) {
            error_log("ERROR HTTP " . $httpCode . ": " . substr($response, 0, 500));
            return "TEXT: Error del servidor de IA (Código HTTP: $httpCode). Respuesta: " . substr($response, 0, 200);
        }
    
        error_log("Respuesta recibida correctamente. Tamaño: " . strlen($response) . " bytes");
        
        $json = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("ERROR: No se pudo decodificar JSON de Gemini. Error: " . json_last_error_msg());
            return "TEXT: Error al procesar la respuesta de la IA.";
        }
        
        $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        if (empty($text)) {
            error_log("WARNING: Gemini devolvió texto vacío");
            error_log("JSON completo: " . print_r($json, true));
        }
    
        // Limpieza de código markdown
        $text = trim($text);
        $text = preg_replace('/```(\w+)?\s*|```/i', '', $text);
        $text = trim($text);
        
        error_log("Texto final procesado. Longitud: " . strlen($text));
        error_log("<<< consultar() finalizado >>>");
        
        return $text;
    }

    private function ejecutarConsulta(string $sql): array {
        error_log(">>> ejecutarConsulta() iniciado <<<");
        error_log("SQL a ejecutar: " . $sql);
        
        try {
            // Limpieza básica de la SQL para evitar comandos peligrosos
            if (preg_match('/(INSERT|UPDATE|DELETE|DROP|ALTER|CREATE)/i', $sql)) {
                error_log("ERROR: Comando SQL peligroso detectado");
                throw new PDOException("Comando SQL no permitido detectado.");
            }
            
            if (!$this->pdo) {
                error_log("ERROR: PDO no inicializado");
                throw new PDOException("Conexión a base de datos no disponible.");
            }
                
            $stmt = $this->pdo->prepare($sql); 
            error_log("SQL preparado correctamente");
            
            $stmt->execute();
            error_log("SQL ejecutado correctamente");
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Filas obtenidas: " . count($resultados));

            // Si la consulta es un SELECT válido pero devuelve 0 filas
            if (empty($resultados) && stripos(trim($sql), 'SELECT') === 0) {
                error_log("WARNING: Consulta válida pero sin resultados");
                return [["error" => "Consulta ejecutada, pero no se encontraron datos. Intenta una pregunta diferente."]];
            }
            
            error_log("<<< ejecutarConsulta() finalizado (ÉXITO) >>>");
            return $resultados;

        } catch (PDOException $e) {
            error_log("ERROR PDO: " . $e->getMessage());
            error_log("SQL que causó el error: " . $sql);
            return [["error" => $e->getMessage() . " | SQL: " . substr($sql, 0, 200)]];
        }
    }
}
?>