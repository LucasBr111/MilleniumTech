
<head>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        .chat-container {
            max-width: 900px;
            margin: 40px auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .chat-messages {
            height: 60vh;
            overflow-y: auto;
            padding: 20px;
            background-color: #fafafa;
        }
        .message {
            max-width: 80%;
            padding: 12px 18px;
            border-radius: 18px;
            margin-bottom: 15px;
            word-wrap: break-word;
            display: block;
        }
        .user {
            background-color: #007bff;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }
        .gemini {
            background-color: #e9ecef;
            color: #333;
            margin-right: auto;
            border-bottom-left-radius: 4px;
        }
        .gemini i {
            color: #007bff;
            margin-right: 5px;
        }
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            margin-top: 15px;
        }
        .table {
            font-size: 0.85rem;
            margin-bottom: 0;
        }
        .loader {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 3px solid #ccc;
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        #chartContainer {
            margin-top: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .debug-panel {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0,0,0,0.9);
            color: #0f0;
            padding: 10px;
            border-radius: 8px;
            max-width: 300px;
            max-height: 200px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            z-index: 9999;
        }
        .debug-panel.hidden {
            display: none;
        }
        .debug-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 10000;
        }
    </style>
</head>

<div class="container">
    <div class="card-header bg-primary text-white text-center py-3">
        <h4 class="mb-0"><i class="fas fa-brain me-2"></i> Asistente de Gestión</h4>
        <small>Pregunta lo que necesites sobre tus datos de ventas, clientes o inventario.</small>
    </div>
    
    <div id="chatMessages" class="chat-messages">
        <div class="message gemini">
            <i class="fas fa-robot"></i> ¡Hola! Soy tu asistente de gestión. Pregúntame sobre tus <strong>ventas</strong>, <strong>clientes</strong> o <strong>inventario</strong>. Por ejemplo:
            <ul>
                <li>"¿Cuál fue la ganancia total del último mes?"</li>
                <li>"Muéstrame un gráfico de productos vendidos por categoría."</li>
                <li>"¿Qué clientes han comprado más?"</li>
            </ul>
        </div>
    </div>
    
    <div class="card-footer p-3">
        <form id="chatForm" class="d-flex">
            <input type="text" id="pregunta" name="pregunta" class="form-control form-control-lg me-2 rounded-pill" 
                   placeholder="Escribe tu consulta aquí..." required autocomplete="off">
            <button type="submit" id="sendButton" class="btn btn-primary rounded-pill px-4" title="Enviar consulta">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<!-- Panel de Debug -->
<button class="btn btn-dark debug-toggle" onclick="toggleDebug()">
    <i class="fas fa-bug"></i> Debug
</button>
<div id="debugPanel" class="debug-panel hidden"></div>

<script>
    // Variables globales
    let chatHistory = [];
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const sendButton = document.getElementById('sendButton');
    const debugPanel = document.getElementById('debugPanel');

    // =========================================================================
    // DEBUG LOGIC
    // =========================================================================
    function debugLog(message, type = 'info') {
        const timestamp = new Date().toLocaleTimeString();
        const color = {
            'info': '#0f0',
            'error': '#f00',
            'warning': '#ff0',
            'success': '#0ff'
        }[type] || '#0f0';
        
        console.log(`[${timestamp}] ${message}`);
        debugPanel.innerHTML += `<div style="color: ${color}">[${timestamp}] ${message}</div>`;
        debugPanel.scrollTop = debugPanel.scrollHeight;
    }

    function toggleDebug() {
        debugPanel.classList.toggle('hidden');
    }

    // =========================================================================
    // CHAT MESSAGE RENDERING
    // =========================================================================
    function addMessage(role, content) {
        debugLog(`Añadiendo mensaje: ${role}`, 'info');
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${role}`;
        
        // El contenido puede ser HTML (tablas/gráficos) o texto simple
        if (role === 'gemini') {
            msgDiv.innerHTML = `<i class="fas fa-robot"></i> ${content}`;
        } else {
            msgDiv.textContent = content;
        }
        
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        debugLog(`Mensaje añadido correctamente`, 'success');
    }

    // =========================================================================
    // TABLE RENDERING
    // =========================================================================
    function generateTableHtml(data) {
        debugLog('Generando tabla HTML', 'info');
        
        if (!data || data.length === 0 || data[0].error) {
            const errorMsg = data[0]?.error || 'No se encontraron resultados válidos.';
            debugLog(`Error en datos de tabla: ${errorMsg}`, 'error');
            return `<div class="alert alert-warning mt-2"><i class="fas fa-exclamation-triangle"></i> ${errorMsg}</div>`;
        }

        const headers = Object.keys(data[0]);
        debugLog(`Tabla con ${headers.length} columnas y ${data.length} filas`, 'info');
        
        let html = '<div class="table-responsive"><table class="table table-bordered table-striped table-sm">';
        
        // Encabezados
        html += '<thead class="table-primary"><tr>';
        headers.forEach(h => {
            // Convierte 'nombre_columna' a 'Nombre Columna'
            const formattedHeader = h.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            html += `<th>${formattedHeader}</th>`;
        });
        html += '</tr></thead><tbody>';

        // Filas
        data.forEach(row => {
            html += '<tr>';
            headers.forEach(h => {
                html += `<td>${row[h] !== null ? row[h] : 'N/A'}</td>`;
            });
            html += '</tr>';
        });

        html += '</tbody></table></div>';
        debugLog('Tabla HTML generada', 'success');
        return html;
    }
    
    // =========================================================================
    // CHART RENDERING (UPDATED)
    // =========================================================================
    function generateChartHtml(data, type = 'bar') {
        debugLog(`Generando gráfico tipo: ${type}`, 'info');

        if (!data || data.length === 0 || data[0].error) {
            const errorMsg = data[0]?.error || 'No hay suficientes datos para generar el gráfico.';
            debugLog(`Error en datos de gráfico: ${errorMsg}`, 'error');
            // Devolvemos el error en un div para que pueda ser incrustado en el mensaje
            return `<div class="alert alert-warning mt-2"><i class="fas fa-exclamation-triangle"></i> ${errorMsg}</div>`; 
        }
        
        const keys = Object.keys(data[0]);
        
        if (keys.length < 2) {
             debugLog('ERROR: La consulta de gráfico debe devolver al menos 2 columnas.', 'error');
             return `<div class="alert alert-warning mt-2"><i class="fas fa-exclamation-triangle"></i> El formato de datos del gráfico es incorrecto (Se esperaban 'label' y 'value').</div>`;
        }

        const labels = data.map(row => row[keys[0]]);
        const values = data.map(row => parseFloat(row[keys[1]]) || 0);
        const datasetLabel = keys[1].replace(/_/g, ' ');

        const chartId = 'chartCanvas_' + Date.now();
        const icon = (type.toLowerCase() === 'line' || type.toLowerCase() === 'area') ? 'fas fa-chart-line' : (type.toLowerCase() === 'pie' || type.toLowerCase() === 'doughnut' ? 'fas fa-chart-pie' : 'fas fa-chart-bar');
        
        const html = `
            <div id="chartContainer" class="card p-3 shadow-sm">
                <h6><i class="${icon}"></i> Visualización de Datos: ${datasetLabel} por ${keys[0].replace(/_/g, ' ')}</h6>
                <canvas id="${chartId}"></canvas>
            </div>
        `;

        // Agregamos el mensaje que contendrá el canvas al chat
        // NOTA: Para gráficos, NO devolvemos el HTML, sino que lo agregamos directamente al chat 
        addMessage('gemini', html); 
        
        // Pequeño timeout para asegurar que el canvas se ha renderizado en el DOM
        setTimeout(() => {
            debugLog(`Dibujando gráfico de ${type} con Chart.js`, 'info');
            const ctx = document.getElementById(chartId);
            
            if (!ctx) {
                debugLog('ERROR: No se encontró el canvas para dibujar', 'error');
                return;
            }
            
            // Lógica para manejar colores y tipos de gráfico
            const chartType = type.toLowerCase();
            const isPieOrDoughnut = ['pie', 'doughnut'].includes(chartType);
            const primaryColor = 'rgba(0, 123, 255, 0.8)';
            const colors = isPieOrDoughnut 
                ? labels.map((_, i) => `hsl(${(i * 360 / labels.length) % 360}, 70%, 50%)`) 
                : primaryColor;

            const chartConfig = {
                type: isPieOrDoughnut ? chartType : (chartType === 'area' ? 'line' : chartType),
                data: {
                    labels: labels,
                    datasets: [{
                        label: datasetLabel,
                        data: values,
                        backgroundColor: colors,
                        borderColor: isPieOrDoughnut ? 'white' : 'rgba(0, 123, 255, 1)',
                        borderWidth: isPieOrDoughnut ? 2 : 1,
                        fill: chartType === 'area' ? 'origin' : false, // Usar 'origin' para gráficos de área
                        tension: ['line', 'area'].includes(chartType) ? 0.3 : 0 // Para gráficos de línea/área
                    }]
                },
                options: {
                    responsive: true,
                    // Deshabilitar ejes para Pie/Doughnut
                    scales: isPieOrDoughnut ? { x: { display: false }, y: { display: false } } : {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: !isPieOrDoughnut, // Mostrar leyenda en Pie/Doughnut
                            position: 'top',
                        }
                    }
                }
            };

            new Chart(ctx.getContext('2d'), chartConfig);
            debugLog('Gráfico dibujado exitosamente', 'success');
        }, 100);
        
        return null; // Devuelve null porque el mensaje ya se añadió
    }

    // =========================================================================
    // FORM SUBMISSION AND AJAX LOGIC (UPDATED)
    // =========================================================================
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        debugLog('=== NUEVA CONSULTA ===', 'info');
        
        const pregunta = document.getElementById('pregunta').value.trim();
        if (!pregunta) {
            debugLog('ERROR: Pregunta vacía', 'error');
            return;
        }

        debugLog(`Pregunta: ${pregunta}`, 'info');
        addMessage('user', pregunta);

        const loaderHtml = '<div class="loader"></div> Analizando...';
        addMessage('gemini', loaderHtml);
        const loaderElement = chatMessages.lastElementChild;
        
        document.getElementById('pregunta').value = '';
        document.getElementById('pregunta').disabled = true;
        sendButton.disabled = true;

        const tempHistory = [...chatHistory, { role: 'user', text: pregunta }];
        const historyToSend = JSON.stringify(tempHistory);
        debugLog(`Historial: ${tempHistory.length} mensajes`, 'info');

        debugLog('Enviando petición AJAX...', 'info');
        
        $.ajax({
            url: "?c=chat_ia&a=consultarGeminiSimple",
            method: 'POST',
            data: {
                pregunta: pregunta,
                historial: historyToSend
            },
            dataType: 'json',
            timeout: 60000, // 60 segundos de timeout
            success: function(response) {
                debugLog('Respuesta recibida del servidor', 'success');
                debugLog(`Tipo de respuesta: ${response.type}`, 'info');
                
                loaderElement.remove();

                // Función auxiliar para procesar un solo componente (SQL, TEXT, GRAPH)
                function processComponent(component) {
                    let componentHtml = '';
                    const rawContent = component.content;

                    if (component.type === 'sql_result') {
                        debugLog('Procesando componente SQL', 'info');
                        componentHtml += `<h6 class="mt-3 mb-2 text-primary"><i class="fas fa-database"></i> Resultados de Consulta</h6>`;
                        componentHtml += generateTableHtml(rawContent);
                        return componentHtml;

                    } else if (component.type === 'graph') {
                        debugLog('Procesando componente Gráfico', 'info');
                        // La función de gráfico añade el mensaje directamente
                        const errorContent = generateChartHtml(rawContent, component.graph_type); 
                        return errorContent || ''; // Retorna error si falla el formato, si no, vacío

                    } else if (component.type === 'text') {
                        debugLog('Procesando componente Texto', 'info');
                        // Incluye un encabezado si es parte de una respuesta combinada
                        const isCombined = response.type === 'combined';
                        let textContent = isCombined ? `<div class="mt-3 pt-3 border-top"><i class="fas fa-comments text-primary"></i> <strong>Análisis:</strong> ${rawContent.replace(/\n/g, '<br>')}</div>` : rawContent.replace(/\n/g, '<br>');
                        return textContent;
                    }
                    return '';
                }

                if (response.type === 'error') {
                    const rawContent = response.content;
                    debugLog(`Error recibido: ${rawContent}`, 'error');
                    const errorHtml = `<div class="alert alert-danger mt-2"><i class="fas fa-exclamation-triangle"></i> ${rawContent}</div>`;
                    addMessage('gemini', errorHtml);
                } else if (response.type === 'combined') {
                    debugLog('Procesando respuesta COMBINADA', 'info');
                    let combinedHtml = '';
                    
                    response.components.forEach(component => {
                        const htmlPart = processComponent(component);
                        if (htmlPart) {
                            combinedHtml += htmlPart;
                        }
                    });
                    
                    // Si generó HTML (tablas/texto), lo mostramos. Los gráficos se añaden solos.
                    if (combinedHtml) {
                        // Si hay solo un componente de texto, no lo encerramos en otro div
                        const textOnly = response.components.every(c => c.type === 'text');
                        addMessage('gemini', combinedHtml);
                    }
                } else { // type: 'sql_result', 'graph', 'text' (simples)
                    let simpleHtml = '';
                    if (response.type === 'sql_result') {
                        simpleHtml += '¡Consulta exitosa! Aquí están los resultados de la base de datos:';
                    }
                    
                    simpleHtml += processComponent(response);
                    
                    if (simpleHtml) {
                       addMessage('gemini', simpleHtml);
                    }
                }

                // Actualizar historial
                if (response.type !== 'error') {
                    chatHistory.push({ role: 'user', text: pregunta });
                    
                    let modelContent;
                    if (response.type === 'text') {
                        modelContent = response.content;
                    } else if (response.type === 'combined') {
                        modelContent = `[Respuesta combinada: ${response.components.map(c => c.type).join(' + ')}]`;
                    } else {
                        // Para SQL y GRAPH, solo guardamos el tipo
                        modelContent = `[Respuesta: ${response.type}]`;
                    }
                    chatHistory.push({ role: 'model', text: modelContent });
                    debugLog(`Historial actualizado: ${chatHistory.length} mensajes`, 'info');
                }
            },
            error: function(xhr, status, error) {
                debugLog(`ERROR AJAX: ${status} - ${error}`, 'error');
                debugLog(`Estado HTTP: ${xhr.status}`, 'error');
                debugLog(`Respuesta del servidor: ${xhr.responseText}`, 'error');
                
                loaderElement.remove();
                
                let errorMessage = `<div class="alert alert-danger mt-2">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Error de comunicación con el servidor</strong><br>
                    Estado: ${status}<br>
                    Código HTTP: ${xhr.status}<br>
                    <small>Revisa la consola (F12) y los logs PHP.</small>
                </div>`;
                
                addMessage('gemini', errorMessage);
            },
            complete: function() {
                debugLog('Petición AJAX completada', 'info');
                document.getElementById('pregunta').disabled = false;
                document.getElementById('pregunta').focus();
                sendButton.disabled = false;
            }
        });
    });

    // Inicialización
    debugLog('Chat listo para usar', 'success');
</script>

