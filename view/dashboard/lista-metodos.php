<?php
// =================================================================================
// INICIALIZACIÓN Y CARGA DE DATOS
// $metodos_con_ingresos DEBE ser llenada por el controlador.
// Inicializamos para evitar warnings.
$metodos_con_ingresos = $metodos_con_ingresos ?? []; 

// Para calcular el total general de todos los ingresos:
$gran_total_ingresos = 0.00;
foreach ($metodos_con_ingresos as $metodo) {
    $gran_total_ingresos += (float)($metodo->ingresos_totales ?? 0);
}

// Mapeo simple de iconos (si no vienen del modelo) para mejor estética
$iconos_default = [
    'Tarjeta' => 'fas fa-credit-card',
    'Transferencia' => 'fas fa-university',
    'QR' => 'fab fa-paypal',

];
// =================================================================================
?>

<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">
        <i class="fas fa-hand-holding-dollar me-2"></i> Ingresos por Métodos de Pago
    </h1>

    <div class="card bg-success text-white mb-5 shadow-lg">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">TOTAL DE INGRESOS REGISTRADOS:</h4>
            <span class="fs-2 fw-bold">=GS <?php echo number_format($gran_total_ingresos, 2); ?></span>
        </div>
    </div>

    <div class="row g-4">
        
        <?php if (empty($metodos_con_ingresos)): ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i> No hay datos de ingresos registrados aún.
                </div>
            </div>
        <?php endif; ?>

        <?php foreach ($metodos_con_ingresos as $metodo): 
            $nombre = $metodo->nombre ?? 'Método Desconocido';
            $ingreso = $metodo->ingresos_totales ?? 0.00;
            
            // Asignar el icono
            $icono = $metodo->icono ?? $iconos_default[$nombre] ?? $iconos_default['Otro'];
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm h-100 border-start border-5 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3 text-primary">
                            <i class="<?php echo htmlspecialchars($icono); ?> fa-3x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title text-muted text-uppercase mb-1">
                                <?php echo htmlspecialchars($nombre); ?>
                            </h5>
                            <p class="card-text fs-4 fw-bold mb-0 text-dark">
                            GS. <?php echo number_format($ingreso); ?>
                            </p>
                            <?php 
                                $porcentaje = ($gran_total_ingresos > 0) ? ($ingreso / $gran_total_ingresos) * 100 : 0;
                            ?>
                            <small class="text-secondary"><?php echo number_format($porcentaje, 1); ?>% del total</small>
                            <div class="progress mt-1" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: <?php echo number_format($porcentaje, 1); ?>%" 
                                     aria-valuenow="<?php echo number_format($porcentaje, 1); ?>" 
                                     aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card-footer bg-light border-0 text-end">
                    <a href="?c=metodopago&a=configurar&nombre=<?php echo urlencode($nombre); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-cog"></i> Configurar
                    </a>
                </div> -->
            </div>
        </div>
        <?php endforeach; ?>
        
    </div>
</div>
