<?php

// archivo que crea la conexion a la base de datos
require_once './config/database/database.php';

class chat_iaController {
    private $pdo;
    private $apiKey = 'AIzaSyABQ7SR-KU-fC5e-vlZmU5WkQifRgNnf7I'; 
    private $db;
    private $esquema_db;
    
    // Contexto empresarial
    private $contexto_empresa = "
    Eres el Asistente Virtual de MilleniumTech, una empresa líder en la venta de productos tecnológicos 
    de línea gaming de alta calidad. Nuestra especialidad incluye:
    
    - PCs Gaming de alto rendimiento
    - Laptops Gaming para profesionales y entusiastas
    - Periféricos Gaming: Mouse, Teclados mecánicos, Auriculares
    - Monitores Gaming de alta frecuencia
    - Accesorios y componentes: RAM, SSD, Tarjetas gráficas
    
    Nuestra misión es proporcionar a los gamers y profesionales del sector tecnológico 
    los mejores equipos con excelente servicio al cliente y asesoría especializada.
    
    IMPORTANTE: Si el usuario hace preguntas fuera del ámbito de MilleniumTech, 
    su tecnología gaming, ventas, clientes o datos de negocio, debes responder amablemente 
    que como asistente de MilleniumTech solo puedes ayudar con temas relacionados a:
    - Información sobre productos gaming
    - Análisis de ventas y reportes
    - Datos de clientes y pedidos
    - Estadísticas del negocio
    - Consultas sobre inventario y productos
    ";

    public function __construct() {
        try {
            $this->pdo = Database::StartUp();
            
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
        error_log("=== INICIO consultarGeminiSimple ===");
        error_log("Método HTTP: " . $_SERVER['REQUEST_METHOD']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("ERROR: Método no es POST");
            header('Content-Type: application/json');
            echo json_encode(['type' => 'error', 'content' => 'Solo se permiten peticiones POST.']);
            return;
        }
        
        if (!isset($_POST['pregunta'])) {
            error_log("ERROR: Falta el campo 'pregunta'");
            header('Content-Type: application/json');
            echo json_encode(['type' => 'error', 'content' => 'Falta el campo "pregunta".']);
            return;
        }

        $pregunta = trim($_POST['pregunta']);
        error_log("Pregunta recibida: " . $pregunta);
        
        $historial_raw = $_POST['historial'] ?? '[]';
        $historial = json_decode($historial_raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("ERROR: JSON inválido en historial. Error: " . json_last_error_msg());
            $historial = [];
        }

        if (!is_array($historial)) {
            error_log("WARNING: Historial no es un array, inicializando vacío");
            $historial = [];
        }

        try {
            error_log("Llamando a procesarPregunta...");
            $respuesta_datos = $this->procesarPregunta($pregunta, $historial);
            error_log("Respuesta generada. Tipo: " . $respuesta_datos['type']);
            
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
        
        if (empty($pregunta)) {
            error_log("ERROR: Pregunta vacía");
            return ['type' => 'error', 'content' => 'La pregunta no puede estar vacía.'];
        }
        
        // Prompt mejorado para detectar intenciones
        $prompt_intencion = "Eres un analista de datos experto de MilleniumTech, empresa de productos gaming.
        
CONTEXTO EMPRESARIAL:
{$this->contexto_empresa}

Analiza la siguiente pregunta del usuario y determina QUÉ ACCIONES se necesitan para responderla adecuadamente.

REGLAS DE CLASIFICACIÓN:

1. **SQL:** Para consultas sobre datos cuantitativos específicos de la base de datos
   - Ventas, ingresos, totales, promedios, conteos
   - Información de clientes, productos, pedidos
   - Genera SELECT con alias descriptivos (AS)
   - Usa JOINs para contexto completo
   - Evita duplicados con DISTINCT cuando sea necesario
   Ejemplo: '¿Cuántas ventas tuvimos el mes pasado?', '¿Top 5 productos más vendidos?'

2. **GRAPH:** Para visualizaciones de datos que requieren gráficos
   - SIEMPRE especifica el tipo de gráfico: BAR, LINE, PIE, AREA, DOUGHNUT
   - BAR: Comparaciones entre categorías
   - LINE: Tendencias temporales
   - PIE/DOUGHNUT: Distribuciones y proporciones
   - AREA: Tendencias acumulativas
   - La consulta SQL debe tener 2 columnas: ETIQUETA y VALOR
   Ejemplo: '¿Gráfico de ventas mensuales?' → 'GRAPH:LINE'
            '¿Distribución de clientes por nivel?' → 'GRAPH:PIE'

3. **TEXT:** Para respuestas conversacionales y contextuales
   - Saludos, presentaciones, explicaciones generales
   - Información sobre la empresa MilleniumTech
   - Preguntas sobre capacidades del asistente
   - Si la pregunta está FUERA del ámbito de MilleniumTech, responde amablemente que solo puedes ayudar con temas gaming/tecnología/ventas
   Ejemplo: '¿Qué productos venden?', 'Hola', '¿Cómo funciona el nivel VIP?'

4. **COMBINACIONES (Múltiples intenciones):**
   - **SQL+TEXT:** Cuando se necesita datos Y explicación contextual
     Ejemplo: '¿Cuáles son nuestros mejores clientes y por qué?'
   - **GRAPH+TEXT:** Cuando se necesita gráfico Y análisis interpretativo
     Ejemplo: '¿Muestra las ventas mensuales y analiza la tendencia?'

FORMATO DE RESPUESTA:
- Una sola intención: 'SQL:' o 'TEXT:' o 'GRAPH:TIPO' (donde TIPO = BAR, LINE, PIE, AREA, DOUGHNUT)
- Múltiples intenciones: 'SQL+TEXT:' o 'GRAPH:TIPO+TEXT:'

EJEMPLOS:
- 'Ventas totales del año' → 'SQL:'
- 'Gráfico de pastel de productos más vendidos' → 'GRAPH:PIE'
- 'Muestra gráfico de ventas mensuales y explica la tendencia' → 'GRAPH:LINE+TEXT:'
- 'Top clientes y análisis de su comportamiento' → 'SQL+TEXT:'
- 'Hola, ¿qué puedes hacer?' → 'TEXT:'

PREGUNTA DEL USUARIO: {$pregunta}

Responde SOLO con la clasificación (SQL:, TEXT:, GRAPH:TIPO, SQL+TEXT:, GRAPH:TIPO+TEXT:)";

        error_log("Consultando intención a Gemini...");
        $intencion = trim($this->consultar($prompt_intencion, $historial));
        error_log("Intención detectada: " . $intencion);
        
        // Procesar intenciones múltiples o simples
        return $this->procesarIntencion($intencion, $pregunta, $historial);
    }

    private function procesarIntencion(string $intencion, string $pregunta, array $historial): array {
        error_log("--- procesarIntencion: " . $intencion . " ---");
        
        // Detectar intenciones combinadas
        if (strpos($intencion, '+') !== false) {
            return $this->procesarIntencionCombinada($intencion, $pregunta, $historial);
        }
        
        // Intenciones simples
        if (str_starts_with($intencion, 'GRAPH:')) {
            preg_match('/GRAPH:(BAR|LINE|PIE|AREA|DOUGHNUT)/i', $intencion, $matches);
            $tipo_grafico = $matches[1] ?? 'BAR';
            error_log("Procesando GRAPH tipo: " . $tipo_grafico);
            return $this->manejarIntencionGrafico($pregunta, $historial, $tipo_grafico);
            
        } elseif (str_starts_with($intencion, 'SQL:')) {
            error_log("Procesando SQL simple");
            return $this->manejarIntencionSQL($pregunta, $historial);
            
        } elseif (str_starts_with($intencion, 'TEXT:')) {
            error_log("Procesando TEXT simple");
            return $this->manejarIntencionTexto($pregunta, $historial);
            
        } else {
            error_log("WARNING: Intención no reconocida: " . $intencion);
            return $this->manejarIntencionTexto($pregunta, $historial);
        }
    }

    private function procesarIntencionCombinada(string $intencion, string $pregunta, array $historial): array {
        error_log("--- procesarIntencionCombinada: " . $intencion . " ---");
        
        $resultados = ['type' => 'combined', 'components' => []];
        
        // SQL+TEXT
        if (stripos($intencion, 'SQL') !== false && stripos($intencion, 'TEXT') !== false) {
            $sql_result = $this->manejarIntencionSQL($pregunta, $historial);
            $resultados['components'][] = $sql_result;
            
            if ($sql_result['type'] !== 'error') {
                $texto_contexto = $this->generarTextoConContexto($pregunta, $sql_result['content'], $historial);
                $resultados['components'][] = ['type' => 'text', 'content' => $texto_contexto];
            }
        }
        
        // GRAPH+TEXT
        elseif (stripos($intencion, 'GRAPH') !== false && stripos($intencion, 'TEXT') !== false) {
            preg_match('/GRAPH:(BAR|LINE|PIE|AREA|DOUGHNUT)/i', $intencion, $matches);
            $tipo_grafico = $matches[1] ?? 'BAR';
            
            $graph_result = $this->manejarIntencionGrafico($pregunta, $historial, $tipo_grafico);
            $resultados['components'][] = $graph_result;
            
            if ($graph_result['type'] !== 'error') {
                $texto_analisis = $this->generarAnalisisGrafico($pregunta, $graph_result['content'], $historial);
                $resultados['components'][] = ['type' => 'text', 'content' => $texto_analisis];
            }
        }
        
        return $resultados;
    }

    private function manejarIntencionSQL(string $pregunta, array $historial): array {
        error_log("--- manejarIntencionSQL iniciado ---");
        
        $prompt_sql = "Eres un programador SQL experto de MilleniumTech.

ESQUEMA DE BASE DE DATOS:
{$this->esquema_db}

REGLAS ESTRICTAS:
1. Genera SOLO consultas SELECT (prohibido: INSERT, UPDATE, DELETE, DROP, ALTER, CREATE)
2. Usa alias descriptivos con AS para todas las columnas
3. Usa JOINs apropiados para obtener contexto completo
4. Usa DISTINCT si es necesario para evitar duplicados
5. Agrega LIMIT 50 al final
6. La consulta debe ser ejecutable directamente
7. NO incluyas comentarios, explicaciones ni markdown
8. Si necesitas fechas recientes, usa DATE_SUB(CURDATE(), INTERVAL X DAY/MONTH/YEAR)

PREGUNTA: {$pregunta}

Responde ÚNICAMENTE con la consulta SQL lista para ejecutar:";

        error_log("Consultando SQL a Gemini...");
        $sql = $this->consultar($prompt_sql, $historial);
        $sql = $this->limpiarSQL($sql);
        error_log("SQL generado: " . $sql);
        
        if (!$this->esSelectValido($sql)) {
            error_log("ERROR: SQL no válido");
            return ['type' => 'error', 'content' => 'No se pudo generar una consulta SQL válida. Intenta reformular tu pregunta.'];
        }
        
        error_log("Ejecutando consulta SQL...");
        $resultados_db = $this->ejecutarConsulta($sql);
        
        if (isset($resultados_db[0]['error'])) {
            error_log("ERROR en ejecución SQL: " . $resultados_db[0]['error']);
            return ['type' => 'error', 'content' => 'Error al ejecutar la consulta: ' . $resultados_db[0]['error']];
        }

        return ['type' => 'sql_result', 'content' => $resultados_db, 'sql' => $sql];
    }

    private function manejarIntencionGrafico(string $pregunta, array $historial, string $tipo_grafico): array {
        error_log("--- manejarIntencionGrafico tipo: " . $tipo_grafico . " ---");
        
        $prompt_sql = "Eres un programador SQL experto para visualizaciones de datos de MilleniumTech.

ESQUEMA DE BASE DE DATOS:
{$this->esquema_db}

TIPO DE GRÁFICO SOLICITADO: {$tipo_grafico}

REGLAS PARA GRÁFICOS:
1. El SELECT debe tener EXACTAMENTE 2 columnas:
   - Primera columna: ETIQUETA (nombre, categoría, fecha) con alias 'label'
   - Segunda columna: VALOR numérico (total, cantidad, promedio) con alias 'value'
2. Para gráficos de tiempo (LINE, AREA): ordena por fecha ASC
3. Para rankings (BAR, PIE): ordena por valor DESC
4. Usa LIMIT 100 para no sobrecargar el gráfico
5. Usa JOINs para obtener nombres descriptivos, no IDs
6. Formatea fechas legibles (DATE_FORMAT)
7. NO incluyas comentarios ni markdown

PREGUNTA: {$pregunta}

Genera la consulta SQL con formato:
SELECT nombre_descriptivo AS label, valor_numerico AS value
FROM ...";

        error_log("Consultando SQL para gráfico...");
        $sql = $this->consultar($prompt_sql, $historial);
        $sql = $this->limpiarSQL($sql);
        error_log("SQL gráfico generado: " . $sql);
        
        if (!$this->esSelectValido($sql)) {
            error_log("ERROR: SQL no válido para gráfico");
            return ['type' => 'error', 'content' => 'No se pudo generar una consulta SQL válida para el gráfico.'];
        }
        
        $resultados_db = $this->ejecutarConsulta($sql);
        
        if (isset($resultados_db[0]['error'])) {
            return ['type' => 'error', 'content' => 'Error al ejecutar la consulta del gráfico: ' . $resultados_db[0]['error']];
        }

        // Validar formato para gráficos
        if (!$this->validarFormatoGrafico($resultados_db)) {
            error_log("WARNING: Formato de datos no óptimo para gráfico");
        }

        return [
            'type' => 'graph', 
            'content' => $resultados_db, 
            'graph_type' => strtolower($tipo_grafico),
            'sql' => $sql
        ];
    }

    private function manejarIntencionTexto(string $pregunta, array $historial): array {
        error_log("--- manejarIntencionTexto iniciado ---");
        
        $prompt_texto = "{$this->contexto_empresa}

Eres el Asistente Virtual de MilleniumTech. Responde a la siguiente pregunta del usuario de manera:
- Amigable y profesional
- Clara y concisa
- Enfocada en tecnología gaming y productos MilleniumTech

Si la pregunta está FUERA del ámbito de MilleniumTech (política, religión, temas personales no relacionados, etc.):
Responde amablemente: 'Como asistente de MilleniumTech, puedo ayudarte con temas relacionados a nuestros productos gaming, análisis de ventas, datos de clientes y consultas sobre tecnología. ¿En qué puedo ayudarte dentro de estas áreas?'

Si preguntan qué puedes hacer, menciona:
- Análisis de ventas y reportes
- Información sobre productos gaming
- Estadísticas de clientes y pedidos
- Visualizaciones de datos (gráficos)
- Consultas sobre inventario

PREGUNTA: {$pregunta}

Responde de forma natural y útil:";
        
        error_log("Consultando respuesta de texto a Gemini...");
        $respuesta = $this->consultar($prompt_texto, $historial);
        error_log("Respuesta de texto recibida. Longitud: " . strlen($respuesta));
        
        return ['type' => 'text', 'content' => $respuesta];
    }

    private function generarTextoConContexto(string $pregunta, array $datos_sql, array $historial): string {
        $resumen_datos = $this->resumirDatos($datos_sql);
        
        $prompt = "{$this->contexto_empresa}

El usuario preguntó: '{$pregunta}'

Se obtuvieron los siguientes datos de la base de datos:
{$resumen_datos}

Genera una respuesta que:
1. Interprete los datos de forma clara
2. Destaque los puntos más importantes
3. Ofrezca insights valiosos para el negocio
4. Sea concisa (máximo 200 palabras)

Responde como el asistente de MilleniumTech:";

        return $this->consultar($prompt, $historial);
    }

    private function generarAnalisisGrafico(string $pregunta, array $datos_grafico, array $historial): string {
        $resumen_datos = $this->resumirDatos($datos_grafico);
        
        $prompt = "{$this->contexto_empresa}

El usuario solicitó: '{$pregunta}'

Los datos del gráfico muestran:
{$resumen_datos}

Proporciona un análisis breve que:
1. Identifique tendencias principales
2. Destaque valores máximos/mínimos relevantes
3. Ofrezca conclusiones accionables
4. Sea conciso (máximo 150 palabras)

Análisis:";

        return $this->consultar($prompt, $historial);
    }

    private function resumirDatos(array $datos): string {
        if (empty($datos)) {
            return "No se encontraron datos.";
        }
        
        $total_filas = count($datos);
        $muestra = array_slice($datos, 0, 5);
        
        $resumen = "Total de registros: {$total_filas}\n\n";
        $resumen .= "Muestra de datos:\n";
        
        foreach ($muestra as $index => $fila) {
            $resumen .= ($index + 1) . ". ";
            $valores = [];
            foreach ($fila as $key => $value) {
                $valores[] = "{$key}: {$value}";
            }
            $resumen .= implode(", ", $valores) . "\n";
        }
        
        return $resumen;
    }

    private function validarFormatoGrafico(array $datos): bool {
        if (empty($datos)) {
            return false;
        }
        
        $primera_fila = $datos[0];
        $columnas = array_keys($primera_fila);
        
        // Idealmente debe tener 'label' y 'value'
        return count($columnas) >= 2;
    }

    private function limpiarSQL(string $sql): string {
        $sql = trim($sql);
        // Remover bloques de código markdown
        $sql = preg_replace('/```(\w+)?\s*|```/i', '', $sql);
        // Remover comentarios SQL
        $sql = preg_replace('/--[^\n]*/', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
        return trim($sql);
    }

    private function esSelectValido(string $sql): bool {
        $sql = strtoupper(trim($sql));
        
        if (stripos($sql, 'SELECT') !== 0) {
            return false;
        }
        
        $comandos_prohibidos = ['INSERT', 'UPDATE', 'DELETE', 'DROP', 'ALTER', 'CREATE', 'TRUNCATE'];
        foreach ($comandos_prohibidos as $cmd) {
            if (stripos($sql, $cmd) !== false) {
                return false;
            }
        }
        
        return true;
    }

    private function consultar(string $prompt, array $historial): string {
        error_log(">>> consultar() iniciado <<<");
        
        if (empty($this->apiKey)) {
            error_log("ERROR: API Key no configurada");
            return "Lo siento, la clave API de Gemini no está configurada correctamente.";
        }
        
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=" . $this->apiKey;

        $contents = [];
        foreach ($historial as $msg) {
            $contents[] = ['role' => $msg['role'], 'parts' => [['text' => $msg['text']]]];
        }
        $contents[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];
        
        error_log("Contenido preparado con " . count($contents) . " mensajes");
    
        $data = ["contents" => $contents];
        $json_data = json_encode($data);
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        
        error_log("Enviando petición a Gemini API...");
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        error_log("Respuesta HTTP Code: " . $httpCode);
        
        if ($curlError) {
            error_log("ERROR CURL: " . $curlError);
            return "Error de conexión con la API de IA: " . $curlError;
        }
    
        if ($httpCode !== 200) {
            error_log("ERROR HTTP " . $httpCode . ": " . substr($response, 0, 500));
            return "Error del servidor de IA (Código HTTP: $httpCode).";
        }
    
        $json = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("ERROR: No se pudo decodificar JSON de Gemini");
            return "Error al procesar la respuesta de la IA.";
        }
        
        $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        if (empty($text)) {
            error_log("WARNING: Gemini devolvió texto vacío");
        }
    
        $text = $this->limpiarSQL($text);
        
        error_log("Texto final procesado. Longitud: " . strlen($text));
        error_log("<<< consultar() finalizado >>>");
        
        return $text;
    }

    private function ejecutarConsulta(string $sql): array {
        error_log(">>> ejecutarConsulta() iniciado <<<");
        error_log("SQL a ejecutar: " . $sql);
        
        try {
            if (!$this->esSelectValido($sql)) {
                throw new PDOException("Comando SQL no permitido detectado.");
            }
            
            if (!$this->pdo) {
                throw new PDOException("Conexión a base de datos no disponible.");
            }
                
            $stmt = $this->pdo->prepare($sql); 
            $stmt->execute();
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Filas obtenidas: " . count($resultados));

            if (empty($resultados) && stripos(trim($sql), 'SELECT') === 0) {
                error_log("WARNING: Consulta válida pero sin resultados");
                return [["error" => "Consulta ejecutada, pero no se encontraron datos. Intenta una pregunta diferente."]];
            }
            
            error_log("<<< ejecutarConsulta() finalizado (ÉXITO) >>>");
            return $resultados;

        } catch (PDOException $e) {
            error_log("ERROR PDO: " . $e->getMessage());
            return [["error" => $e->getMessage()]];
        }
    }
}
?>