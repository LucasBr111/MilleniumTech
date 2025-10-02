<div class="container-fluid px-4 py-4">

    <!-- Mensaje de Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-primary shadow-sm border-0" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-hand-wave fa-2x me-3"></i>
                    <div>
                        <h4 class="alert-heading mb-1">¡Bienvenido de nuevo, <span id="userName"><?php echo $_SESSION['user_nombre'] ?? 'Administrador'; ?></span>! 👋</h4>
                        <p class="mb-0">Este es el panel de control de tu e-commerce. Aquí puedes monitorear las métricas clave y gestionar tu negocio.</p>
                        <small class="text-muted">Última actualización: <span id="lastUpdate">--:--</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Principales -->
    <div class="row g-4 mb-4">

        <!-- Ventas Hoy -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs text-success text-uppercase mb-1">
                                Ventas Netas (Hoy)
                            </div>
                            <div class="stat-number" id="ventasHoy">
                                <span class="loading-skeleton" style="display: inline-block; width: 80px; height: 30px;">-</span>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-arrow-up trend-up"></i> 
                                <span id="ventasHoyTrend">--</span>% vs ayer
                            </small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x stat-icon text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pedidos Pendientes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs text-warning text-uppercase mb-1">
                                Pedidos Pendientes
                            </div>
                            <div class="stat-number" id="pedidosPendientes">
                                <span class="loading-skeleton" style="display: inline-block; width: 60px; height: 30px;">-</span>
                            </div>
                            <small class="text-muted">Por procesar</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-basket fa-2x stat-icon text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Clientes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs text-info text-uppercase mb-1">
                                Total Clientes
                            </div>
                            <div class="stat-number" id="totalClientes">
                                <span class="loading-skeleton" style="display: inline-block; width: 60px; height: 30px;">-</span>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-user-plus text-info"></i> 
                                <span id="clientesNuevos">--</span> este mes
                            </small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x stat-icon text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos con Stock Bajo -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs text-danger text-uppercase mb-1">
                                Stock Bajo
                            </div>
                            <div class="stat-number" id="stockBajo">
                                <span class="loading-skeleton" style="display: inline-block; width: 60px; height: 30px;">-</span>
                            </div>
                            <small class="text-muted">Productos críticos</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x stat-icon text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Gráficos y Estadísticas Detalladas -->
    <div class="row g-4 mb-4">

        <!-- Gráfico de Ventas -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-line me-2"></i>Ventas de los Últimos 7 Días
                    </h6>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-light btn-sm active" onclick="cambiarPeriodo('7dias')">7 Días</button>
                        <button type="button" class="btn btn-light btn-sm" onclick="cambiarPeriodo('30dias')">30 Días</button>
                        <button type="button" class="btn btn-light btn-sm" onclick="cambiarPeriodo('año')">Año</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="ventasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actividad Reciente -->
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-clock me-2"></i>Actividad Reciente
                    </h6>
                </div>
                <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                    <div id="actividadReciente">
                        <div class="activity-item loading-skeleton" style="height: 50px;"></div>
                        <div class="activity-item loading-skeleton" style="height: 50px;"></div>
                        <div class="activity-item loading-skeleton" style="height: 50px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Top Productos -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-star me-2"></i>Productos Más Vendidos (Últimos 30 Días)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="topProductosTable">
                            <thead>
                                <tr>
                                    <th width="80">#</th>
                                    <th>Producto</th>
                                    <th width="120">Unidades</th>
                                    <th width="150">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Botón de Debug -->
<button class="btn btn-dark debug-toggle" onclick="toggleDebug()" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; border-radius: 50%; width: 50px; height: 50px;">
    <i class="fas fa-bug"></i>
</button>

<!-- Panel de Debug -->
<div id="debugPanel" class="debug-info" style="position: fixed; bottom: 80px; right: 20px; width: 400px; max-height: 400px; overflow-y: auto; background: rgba(0,0,0,0.9); color: #0f0; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 12px; display: none; z-index: 999;">
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
/* Estilos personalizados */
.stat-number {
    font-size: 1.75rem;
    font-weight: bold;
    color: #2c3e50;
}

.stat-icon {
    opacity: 0.3;
}

.text-xs {
    font-size: 0.75rem;
    font-weight: bold;
    letter-spacing: 0.5px;
}

.border-left-success {
    border-left: 4px solid #28a745 !important;
}

.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}

.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}

.border-left-danger {
    border-left: 4px solid #dc3545 !important;
}

.activity-item {
    padding: 12px;
    border-bottom: 1px solid #e3e6f0;
    transition: background-color 0.2s;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item:hover {
    background-color: #f8f9fc;
}

.loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 4px;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.trend-up {
    color: #28a745;
}

.trend-down {
    color: #dc3545;
}

.debug-info.show {
    display: block !important;
}

.btn-group .btn.active {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.chart-container {
    position: relative;
    margin: auto;
}
</style>

<script>
// Sistema de Debug
let debugPanel = document.getElementById('debugPanel');
let ventasChart = null;
let periodoActual = 7;

function debugLog(message, type = 'info') {
    const timestamp = new Date().toLocaleTimeString();
    const colors = {
        'info': '#0f0',
        'error': '#f00',
        'warning': '#ff0',
        'success': '#0ff'
    };
    
    console.log(`[${timestamp}] ${message}`);
    if (debugPanel) {
        debugPanel.innerHTML += `<div style="color: ${colors[type]}">[${timestamp}] ${message}</div>`;
        debugPanel.scrollTop = debugPanel.scrollHeight;
    }
}

function toggleDebug() {
    if (debugPanel) {
        debugPanel.classList.toggle('show');
    }
}

// Inicialización
debugLog('Dashboard iniciado', 'success');
actualizarHora();

// Actualizar hora cada minuto
setInterval(actualizarHora, 60000);

function actualizarHora() {
    const now = new Date();
    const elem = document.getElementById('lastUpdate');
    if (elem) {
        elem.textContent = now.toLocaleTimeString();
    }
}

/**
 * Cargar todas las estadísticas principales
 */
function cargarEstadisticas() {
    debugLog('Cargando estadísticas...', 'info');
    
    fetch('?c=dashboard&a=getEstadisticas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                debugLog('Estadísticas cargadas correctamente', 'success');
                
                const stats = data.data;
                
                // Actualizar ventas hoy
                const ventasElem = document.getElementById('ventasHoy');
                if (ventasElem) {
                    ventasElem.innerHTML = `$${formatNumber(stats.ventas_hoy)}`;
                }
                
                // Actualizar trend de ventas
                const trendElem = document.getElementById('ventasHoyTrend');
                const trendIcon = trendElem?.previousElementSibling;
                if (trendElem && stats.trend_ventas) {
                    const porcentaje = stats.trend_ventas.porcentaje;
                    const direccion = stats.trend_ventas.direccion;
                    
                    trendElem.textContent = `${Math.abs(porcentaje)}`;
                    
                    if (trendIcon) {
                        trendIcon.className = direccion === 'up' 
                            ? 'fas fa-arrow-up trend-up' 
                            : 'fas fa-arrow-down trend-down';
                    }
                }
                
                // Actualizar pedidos pendientes
                const pedidosElem = document.getElementById('pedidosPendientes');
                if (pedidosElem) {
                    pedidosElem.textContent = stats.pedidos_pendientes;
                }
                
                // Actualizar total clientes
                const clientesElem = document.getElementById('totalClientes');
                if (clientesElem) {
                    clientesElem.textContent = formatNumber(stats.total_clientes);
                }
                
                // Actualizar clientes nuevos
                const clientesNuevosElem = document.getElementById('clientesNuevos');
                if (clientesNuevosElem) {
                    clientesNuevosElem.textContent = stats.clientes_nuevos_mes;
                }
                
                // Actualizar stock bajo
                const stockElem = document.getElementById('stockBajo');
                if (stockElem) {
                    stockElem.textContent = stats.stock_bajo;
                }
                
                debugLog(`Ventas hoy: $${stats.ventas_hoy}`, 'info');
                debugLog(`Pedidos pendientes: ${stats.pedidos_pendientes}`, 'info');
                debugLog(`Total clientes: ${stats.total_clientes}`, 'info');
                debugLog(`Stock bajo: ${stats.stock_bajo}`, 'warning');
                
            } else {
                debugLog('Error al cargar estadísticas: ' + data.message, 'error');
            }
        })
        .catch(error => {
            debugLog('Error en la petición: ' + error.message, 'error');
            console.error('Error:', error);
        });
}

/**
 * Cargar datos del gráfico de ventas
 */
function cargarGrafico(dias = 7) {
    debugLog(`Cargando gráfico para ${dias} días...`, 'info');
    
    fetch(`?c=dashboard&a=getGraficoVentas&dias=${dias}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                debugLog('Datos del gráfico cargados', 'success');
                
                const ctx = document.getElementById('ventasChart');
                if (!ctx) return;
                
                const datos = data.data;
                let labels = [];
                let valores = [];
                
                if (dias == 365) {
                    // Datos mensuales
                    const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 
                                   'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    datos.forEach(item => {
                        labels.push(meses[item.mes - 1]);
                        valores.push(parseFloat(item.total));
                    });
                } else {
                    // Datos diarios
                    datos.forEach(item => {
                        const fecha = new Date(item.fecha + 'T00:00:00');
                        labels.push(formatFecha(fecha, dias));
                        valores.push(parseFloat(item.total));
                    });
                }
                
                // Destruir gráfico anterior si existe
                if (ventasChart) {
                    ventasChart.destroy();
                }
                
                // Crear nuevo gráfico
                ventasChart = new Chart(ctx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Ventas ($)',
                            data: valores,
                            borderColor: 'rgb(78, 115, 223)',
                            backgroundColor: 'rgba(78, 115, 223, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 5,
                            pointBackgroundColor: 'rgb(78, 115, 223)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Ventas: $' + formatNumber(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + formatNumber(value);
                                    }
                                }
                            }
                        }
                    }
                });
                
                debugLog('Gráfico generado exitosamente', 'success');
                
            } else {
                debugLog('Error al cargar gráfico: ' + data.message, 'error');
            }
        })
        .catch(error => {
            debugLog('Error en la petición del gráfico: ' + error.message, 'error');
            console.error('Error:', error);
        });
}

/**
 * Cargar actividad reciente
 */
function cargarActividad() {
    debugLog('Cargando actividad reciente...', 'info');
    
    fetch('?c=dashboard&a=getActividad')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                debugLog('Actividad cargada', 'success');
                
                const container = document.getElementById('actividadReciente');
                if (!container) return;
                
                const actividades = data.data;
                console.log(actividades);
                
                if (actividades.length === 0) {
                    container.innerHTML = '<p class="text-muted text-center">No hay actividad reciente</p>';
                    return;
                }
                
                let html = '';
                actividades.forEach(act => {
                    let icono, color, texto;
                    
                    if (act.tipo === 'venta') {
                        icono = 'fa-shopping-cart';
                        color = act.estado_pago === 'pagado' ? 'success' : 'warning';
                        texto = `Venta #${act.id_venta} - ${act.cliente} ($${formatNumber(act.total)})`;
                    } else if (act.tipo === 'cliente') {
                        icono = 'fa-user-plus';
                        color = 'info';
                        texto = `Nuevo cliente: ${act.cliente}`;
                    }
                    
                    const tiempo = calcularTiempoTranscurrido(act.fecha);
                    
                    html += `
                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas ${icono} fa-lg text-${color}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">${texto}</div>
                                    <small class="text-muted">${tiempo}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                container.innerHTML = html;
                
            } else {
                debugLog('Error al cargar actividad: ' + data.message, 'error');
            }
        })
        .catch(error => {
            debugLog('Error en la petición de actividad: ' + error.message, 'error');
            console.error('Error:', error);
        });
}

/**
 * Cargar top productos
 */
function cargarTopProductos() {
    debugLog('Cargando top productos...', 'info');
    
    fetch('?c=dashboard&a=getTopProductos&limite=5')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                debugLog('Top productos cargado', 'success');
                
                const tbody = document.querySelector('#topProductosTable tbody');
                if (!tbody) return;
                
                const productos = data.data;
                
                if (productos.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No hay datos disponibles</td></tr>';
                    return;
                }
                
                let html = '';
                productos.forEach((prod, idx) => {
                    html += `
                        <tr>
                            <td><span class="badge bg-primary">${idx + 1}</span></td>
                            <td>${prod.nombre_producto}</td>
                            <td><span class="badge bg-success">${prod.unidades_vendidas}</span></td>
                            <td>$${formatNumber(prod.ingresos_totales)}</td>
                        </tr>
                    `;
                });
                
                tbody.innerHTML = html;
                
            } else {
                debugLog('Error al cargar top productos: ' + data.message, 'error');
            }
        })
        .catch(error => {
            debugLog('Error en la petición de top productos: ' + error.message, 'error');
            console.error('Error:', error);
        });
}

/**
 * Cambiar período del gráfico
 */
function cambiarPeriodo(periodo) {
    debugLog(`Cambiando período a: ${periodo}`, 'info');
    
    // Actualizar botones activos
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    let dias;
    switch(periodo) {
        case '7dias':
            dias = 7;
            break;
        case '30dias':
            dias = 30;
            break;
        case 'año':
            dias = 365;
            break;
        default:
            dias = 7;
    }
    
    periodoActual = dias;
    cargarGrafico(dias);
}

/**
 * Funciones auxiliares
 */
function formatNumber(num) {
    return parseFloat(num).toLocaleString('es-PY', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    });
}

function formatFecha(fecha, dias) {
    if (dias <= 7) {
        // Para 7 días, mostrar día de la semana
        const diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        return diasSemana[fecha.getDay()];
    } else {
        // Para 30 días, mostrar día/mes
        const dia = fecha.getDate();
        const mes = fecha.getMonth() + 1;
        return `${dia}/${mes}`;
    }
}

function calcularTiempoTranscurrido(fecha) {
    const ahora = new Date();
    const entonces = new Date(fecha);
    const diff = Math.floor((ahora - entonces) / 1000); // diferencia en segundos
    
    if (diff < 60) return 'Hace unos segundos';
    if (diff < 3600) return `Hace ${Math.floor(diff / 60)} min`;
    if (diff < 86400) return `Hace ${Math.floor(diff / 3600)} hora(s)`;
    return `Hace ${Math.floor(diff / 86400)} día(s)`;
}

/**
 * Cargar todos los datos al inicio
 */
function cargarDatos() {
    cargarEstadisticas();
    cargarGrafico(periodoActual);
    cargarActividad();
    cargarTopProductos();
}

// Cargar datos al cargar la página
window.addEventListener('DOMContentLoaded', function() {
    debugLog('DOM cargado completamente', 'success');
    cargarDatos();
});

// Auto-refresh cada 5 minutos
setInterval(function() {
    debugLog('Auto-refresh de datos...', 'info');
    cargarDatos();
}, 300000);
</script>