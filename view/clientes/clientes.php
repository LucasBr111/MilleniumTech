<!-- Vista: views/cliente/perfil.php -->
<link rel="stylesheet" href="assets/styles/perfil.css">
<div class="container-fluid" style="padding-top: 100px; min-height: 100vh;">
<?php $esAdmin = isset($_SESSION['nivel']) && $_SESSION['nivel'] == 1; ?>
    
    <!-- Hero Profile Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="profile-hero-card">
                <div class="profile-header-content">
                    <div class="profile-avatar-container">
                        <img src="<?php echo !empty($cliente->avatar) ? htmlspecialchars($cliente->avatar) : 'assets/img/pfp.jpg'; ?>"
                            alt="Avatar"
                            class="profile-avatar">
                        <button class="btn-edit-avatar" data-bs-toggle="modal" data-bs-target="#modalCambiarAvatar">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <div class="profile-info">
                        <h1 class="profile-name">Bienvenido, <?php echo htmlspecialchars($cliente->nombre ?? 'Usuario'); ?></h1>
                        <p class="profile-email"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($cliente->email ?? ''); ?></p>
                        <p class="profile-member-since">Miembro desde: <?php echo date('d/m/Y', strtotime($cliente->fecha_registro ?? 'now')); ?></p>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-card">
                            <i class="fas fa-shopping-bag"></i>
                            <div class="stat-info">
                                <h4><?php echo $cliente->total_compras ?? 0; ?></h4>
                                <p>Compras Totales</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-star"></i>
                            <div class="stat-info">
                                <h4><?php echo number_format($puntoss ?? 0); ?></h4>
                                <p>Puntos Acumulados</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-truck"></i>
                            <div class="stat-info">
                                <h4><?php echo $cliente->compras_pendientes ?? 0; ?></h4>
                                <p>Envíos Pendientes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-pills profile-tabs mb-4" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button">
                <i class="fas fa-user"></i> Mis Datos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="compras-tab" data-bs-toggle="tab" data-bs-target="#compras" type="button">
                <i class="fas fa-shopping-cart"></i> Mis Compras
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="puntos-tab" data-bs-toggle="tab" data-bs-target="#puntos" type="button">
                <i class="fas fa-gift"></i> Mis Puntos
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="profileTabsContent">

        <!-- TAB: MIS DATOS -->
        <div class="tab-pane fade show active" id="datos" role="tabpanel">
            <div class="profile-section-card">
                <div class="section-header">
                    <h3><i class="fas fa-user-circle"></i> Información Personal</h3>
                    <a class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#crudModal" data-c="cliente" data-id="<?php echo $cliente->id; ?>">
                        <i class="fas fa-edit"></i> Editar Perfil
                    </a>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label><i class="fas fa-user"></i> Nombre Completo</label>
                            <p><?php echo htmlspecialchars($cliente->nombre ?? 'No especificado'); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label><i class="fas fa-user-shield"></i> Nivel de Usuario</label>
                            <p>
                                <?php
                                if ($cliente->nivel == 1) {
                                    echo "Administrador";
                                } elseif ($cliente->nivel == 2) {
                                    echo "Cliente";
                                } else {
                                    echo "Desconocido";
                                }
                                ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <label><i class="fas fa-envelope"></i> Correo Electrónico</label>
                            <p><?php echo htmlspecialchars($cliente->email ?? 'No especificado'); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label><i class="fas fa-lock"></i> Contraseña</label>
                            <div class="password-field">
                                <p id="passwordDisplay">••••••••</p>
                                <button class="btn-icon" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label><i class="fas fa-phone"></i> Teléfono</label>
                            <p><?php echo htmlspecialchars($cliente->telefono ?? 'No especificado'); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label><i class="fas fa-id-card"></i> Documento de Identidad</label>
                            <p><?php echo htmlspecialchars($cliente->ci ?? 'No especificado'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN TAB: MIS DATOS -->

        <!-- TAB: MIS COMPRAS -->
        <div class="tab-pane fade" id="compras" role="tabpanel">
            <div class="profile-section-card">
                <div class="section-header">
                    <h3><i class="fas fa-shopping-bag"></i> Historial de Compras</h3>
                </div>

                <div class="table-responsive">
                    <table id="tablaCompras" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>N° Pedido</th>
                                <th>Monto Total</th>
                                <th>Estado</th>
                                <th>Dirección de Envío</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($compras)): ?>
                                <?php foreach ($compras as $compra): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($compra->fecha)); ?></td>
                                        <td>#<?php echo $compra->id_venta; ?></td>
                                        <td class="precio-destacado">₲ <?php echo number_format($compra->total, 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="badge-estado estado-<?php echo strtolower($compra->estado); ?>">
                                                <?php echo ucfirst($compra->estado); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($compra->direccion_envio ?? 'No especificado'); ?></td>
                                        <td>
                                            <?php if (isset($esAdmin) && $esAdmin): ?>
                                                <button class="btn-action btn-danger-action" onclick="eliminarCompra(<?php echo $compra->id_venta; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php elseif ($compra->estado === 'pendiente'): ?>
                                                <button class="btn-action btn-warning-action" onclick="confirmarVenta(<?php echo $compra->id_venta; ?>)">
                                                    <i class="fas fa-check"></i> Confirmar
                                                </button>
                                            <?php else: ?>
                                                <button class="btn-action btn-info-action" onclick="verDetalleCompra(<?php echo $compra->id_venta; ?>)">
                                                    <i class="fas fa-eye"></i> Detalles
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No tienes compras registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- FIN TAB: MIS COMPRAS -->

        <!-- TAB: PUNTOS -->
        <div class="tab-pane fade" id="puntos" role="tabpanel">
            <div class="profile-section-card">
                <div class="section-header">
                    <h3><i class="fas fa-gift"></i> Sistema de Puntos</h3>
                </div>

                <div class="puntos-hero">
                    <div class="puntos-display">
                        <i class="fas fa-star"></i>
                        <div>
                            <h2><?php echo number_format($puntoss ?? 0); ?></h2>
                            <p>Puntos Disponibles</p>
                        </div>
                    </div>
                    <div class="puntos-equivalencia">
                        <p><i class="fas fa-info-circle"></i> Equivalencia:</p>
                        <h4>₲ <?php echo number_format(($puntoss ?? 0) * 100, 0, ',', '.'); ?></h4>
                        <small>1 punto = ₲ 100 en descuentos</small>
                    </div>
                    <button class="btn-primary-custom" onclick="canjearPuntos()">
                        <i class="fas fa-gift"></i> Canjear Puntos
                    </button>
                </div>

                <div class="mt-4">
                    <h5 class="mb-3"><i class="fas fa-history"></i> Historial de Puntos</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                    <th>Puntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($puntos)): ?>
                                    <?php foreach ($puntos as $registro): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y', strtotime($registro->fecha_obtencion)); ?></td>
                                            <td><?php echo htmlspecialchars($registro->descripcion); ?></td>
                                            <td><?php echo number_format($registro->puntos); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No hay movimientos de puntos</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN TAB: PUNTOS -->

    </div>
</div>

<!-- MODALES -->

<!-- Modal: Detalle de Compra -->
<div class="modal fade" id="modalDetalleCompra" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content modal-custom">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-receipt"></i> Detalles de la Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="detalle-seccion">
                            <h6><i class="fas fa-info-circle"></i> Información del Pedido</h6>
                            <p><strong>N° Pedido:</strong> <span id="detalle_numero"></span></p>
                            <p><strong>Fecha:</strong> <span id="detalle_fecha"></span></p>
                            <p><strong>Estado:</strong> <span id="detalle_estado"></span></p>
                            <p><strong>Método de Pago:</strong> <span id="detalle_metodo_pago"></span></p>
                            <p><strong>Total:</strong> <span id="detalle_total" class="precio-destacado"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detalle-seccion">
                            <h6><i class="fas fa-map-marker-alt"></i> Dirección de Envío</h6>
                            <p id="detalle_direccion"></p>
                            <p><strong>Tracking:</strong> <span id="detalle_tracking"></span></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detalle-seccion">
                            <h6><i class="fas fa-shopping-bag"></i> Productos</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unit.</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle_productos">
                                        <!-- Se llena dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn-primary-custom" onclick="descargarFactura()">
                    <i class="fas fa-download"></i> Descargar Factura
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal: Confirmar Venta Pendiente -->
<div class="modal fade" id="modalConfirmarVenta" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content modal-custom">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-check-circle"></i> Confirmar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formConfirmarVenta">
                    <input type="hidden" id="id_venta" name="id_venta">
                    <input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $cliente->id; ?>">
                    
                    <div class="row g-4">
                        
                        <!-- SECCIÓN 1: DIRECCIÓN DE ENVÍO -->
                        <div class="col-md-6">
                            <div class="checkout-section">
                                <h6 class="section-title">
                                    <i class="fas fa-map-marker-alt"></i> Dirección de Envío
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label">Dirección Completa <span class="text-danger">*</span></label>
                                    <textarea 
                                        class="form-control" 
                                        name="direccion_envio" 
                                        id="direccion_envio"
                                        rows="3" 
                                        placeholder="Ej: Calle Palma 123, entre Alberdi y Cerro Corá"
                                        required></textarea>
                                    <small class="text-muted">Incluye calle, número, referencias</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Ciudad <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="ciudad" 
                                        id="ciudad"
                                        placeholder="Ej: Asunción"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Departamento <span class="text-danger">*</span></label>
                                    <select class="form-select" name="departamento" id="departamento" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Asunción">Asunción</option>
                                        <option value="Central">Central</option>
                                        <option value="Alto Paraná">Alto Paraná</option>
                                        <option value="Itapúa">Itapúa</option>
                                        <option value="Cordillera">Cordillera</option>
                                        <option value="Guairá">Guairá</option>
                                        <option value="Caaguazú">Caaguazú</option>
                                        <option value="Paraguarí">Paraguarí</option>
                                        <option value="Misiones">Misiones</option>
                                        <option value="Ñeembucú">Ñeembucú</option>
                                        <option value="Amambay">Amambay</option>
                                        <option value="Canindeyú">Canindeyú</option>
                                        <option value="Presidente Hayes">Presidente Hayes</option>
                                        <option value="Concepción">Concepción</option>
                                        <option value="San Pedro">San Pedro</option>
                                        <option value="Caazapá">Caazapá</option>
                                        <option value="Alto Paraguay">Alto Paraguay</option>
                                        <option value="Boquerón">Boquerón</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Teléfono de Contacto <span class="text-danger">*</span></label>
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        name="telefono_contacto" 
                                        id="telefono_contacto"
                                        value="<?php echo htmlspecialchars($cliente->telefono ?? ''); ?>"
                                        placeholder="Ej: 0981 123 456"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Referencias Adicionales</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="referencias" 
                                        id="referencias"
                                        placeholder="Ej: Casa de color blanco, portón negro">
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 2: MÉTODO DE PAGO Y PUNTOS -->
                        <div class="col-md-6">
                            
                            <!-- Método de Pago -->
                            <div class="checkout-section mb-4">
                                <h6 class="section-title">
                                    <i class="fas fa-credit-card"></i> Método de Pago
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label">Seleccionar Método <span class="text-danger">*</span></label>
                                    <select class="form-select" name="id_metodo_pago" id="id_metodo_pago" required>
                                        <option value="">Seleccionar...</option>
                                        <?php 
                                        if (isset($this->metodo_pago)) {
                                            foreach ($this->metodo_pago->listar() as $metodo): 
                                        ?>
                                            <option value="<?php echo $metodo->id; ?>" 
                                                    data-descripcion="<?php echo htmlspecialchars($metodo->descripcion ?? ''); ?>">
                                                <?php echo htmlspecialchars($metodo->nombre); ?>
                                            </option>
                                        <?php 
                                            endforeach;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Información adicional según método -->
                                <div id="info_metodo_pago" class="alert alert-info" style="display: none;">
                                    <small><i class="fas fa-info-circle"></i> <span id="detalle_metodo"></span></small>
                                </div>
                            </div>

                            <!-- Canje de Puntos -->
                            <?php if (isset($puntoss->total) && $puntoss->total > 0): ?>
                            <div class="checkout-section">
                                <h6 class="section-title">
                                    <i class="fas fa-gift"></i> Canje de Puntos
                                </h6>
                                
                                <div class="puntos-disponibles mb-3">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <strong>Puntos Disponibles:</strong>
                                            <span class="text-primary fs-5"><?php echo number_format($puntoss->total); ?></span>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">Equivale a:</small>
                                            <div class="text-success fw-bold">₲ <?php echo number_format($puntoss->total * 100, 0, ',', '.'); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="usar_puntos" 
                                            name="usar_puntos"
                                            value="1"
                                            onchange="togglePuntos()">
                                        <label class="form-check-label" for="usar_puntos">
                                            Quiero usar mis puntos en esta compra
                                        </label>
                                    </div>
                                </div>

                                <div id="seccion_puntos" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Cantidad de Puntos a Usar</label>
                                        <div class="input-group">
                                            <input 
                                                type="number" 
                                                class="form-control" 
                                                name="puntos_usar" 
                                                id="puntos_usar"
                                                min="0"
                                                max="<?php echo $puntoss->total; ?>"
                                                value="0"
                                                onchange="calcularDescuentoModal()">
                                            <button 
                                                class="btn btn-outline-secondary" 
                                                type="button" 
                                                onclick="usarTodosPuntosModal()">
                                                Usar Todos
                                            </button>
                                        </div>
                                        <small class="text-muted">Máximo: <?php echo number_format($puntoss->total); ?> puntos</small>
                                    </div>

                                    <div class="alert alert-success">
                                        <strong>Descuento:</strong> 
                                        <span id="descuento_puntos_modal">₲ 0</span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- SECCIÓN 3: RESUMEN DE PRODUCTOS -->
                        <div class="col-12">
                            <div class="checkout-section">
                                <h6 class="section-title">
                                    <i class="fas fa-shopping-bag"></i> Resumen de Productos
                                </h6>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Precio Unit.</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productos_confirmar">
                                            <!-- Se llena dinámicamente -->
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-light">
                                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                                <td class="text-end">
                                                    <strong id="subtotal_confirmar">₲ 0</strong>
                                                </td>
                                            </tr>
                                            <tr class="table-light" id="fila_descuento_modal" style="display: none;">
                                                <td colspan="3" class="text-end text-success">
                                                    <strong><i class="fas fa-gift"></i> Descuento por Puntos:</strong>
                                                </td>
                                                <td class="text-end text-success">
                                                    <strong id="descuento_total_modal">- ₲ 0</strong>
                                                </td>
                                            </tr>
                                            <tr class="table-primary">
                                                <td colspan="3" class="text-end fs-5">
                                                    <strong>TOTAL A PAGAR:</strong>
                                                </td>
                                                <td class="text-end fs-5">
                                                    <strong id="total_pagar_modal" class="text-primary">₲ 0</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Términos y Condiciones -->
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="acepto_terminos" 
                                            name="acepto_terminos"
                                            required>
                                        <label class="form-check-label" for="acepto_terminos">
                                            Acepto los términos y condiciones de compra
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success btn-lg" onclick="procesarConfirmacionVenta()">
                    <i class="fas fa-check-circle"></i> Confirmar Venta
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.checkout-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.section-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #dee2e6;
}

.puntos-disponibles {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>


<script>
// Variables globales para el modal
let subtotalOriginalModal = 0;
let descuentoPuntosModal = 0;
let maxPuntosDisponibles = <?php echo isset($puntoss->total) ? $puntoss->total : 0; ?>;

// Función que se llama desde el botón "Confirmar" en la tabla
function confirmarVenta(idVenta) {
    // Cargar datos de la venta
    fetch(`index.php?c=venta&a=obtenerDetallesVenta&id=${idVenta}`)
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                
                // Guardar ID de venta
                document.getElementById('id_venta').value = idVenta;
                
                // Cargar productos en la tabla
                cargarProductosVenta(data);
                
                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalConfirmarVenta'));
                modal.show();
                
            } catch(e) {
                console.error('Error parseando JSON:', text);
                alert('Error al procesar los datos de la venta');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los detalles de la venta');
        });
}

// Cargar productos de la venta en el modal
function cargarProductosVenta(productos) {
    const tbody = document.getElementById('productos_confirmar');
    tbody.innerHTML = '';
    
    let totalCalculado = 0;
    
    productos.forEach(item => {
        const subtotalItem = parseFloat(item.total);
        totalCalculado += subtotalItem;
        
        tbody.innerHTML += `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <span>${item.nombre_producto}</span>
                    </div>
                </td>
                <td class="text-center">${item.cantidad}</td>
                <td class="text-end">₲ ${formatearNumero(item.precio_unitario)}</td>
                <td class="text-end">₲ ${formatearNumero(subtotalItem)}</td>
            </tr>
        `;
    });
    
    subtotalOriginalModal = totalCalculado;
    document.getElementById('subtotal_confirmar').textContent = '₲ ' + formatearNumero(subtotalOriginalModal);
    document.getElementById('total_pagar_modal').textContent = '₲ ' + formatearNumero(subtotalOriginalModal);
}

// Toggle para mostrar/ocultar sección de puntos
function togglePuntos() {
    const checkbox = document.getElementById('usar_puntos');
    const seccion = document.getElementById('seccion_puntos');
    
    if (checkbox.checked) {
        seccion.style.display = 'block';
    } else {
        seccion.style.display = 'none';
        document.getElementById('puntos_usar').value = 0;
        calcularDescuentoModal();
    }
}

// Usar todos los puntos disponibles
function usarTodosPuntosModal() {
    const totalVenta = subtotalOriginalModal;
    const maxDescuento = totalVenta / 100; // Máximo de puntos que se pueden usar
    const puntosAUsar = Math.min(maxPuntosDisponibles, Math.floor(maxDescuento));
    
    document.getElementById('puntos_usar').value = puntosAUsar;
    calcularDescuentoModal();
}

// Calcular descuento por puntos
function calcularDescuentoModal() {
    const puntosUsar = parseInt(document.getElementById('puntos_usar').value) || 0;
    
    // Validar que no exceda el total
    const maxDescuento = subtotalOriginalModal / 100;
    const puntosMaximos = Math.min(puntosUsar, Math.floor(maxDescuento), maxPuntosDisponibles);
    
    if (puntosUsar > puntosMaximos) {
        document.getElementById('puntos_usar').value = puntosMaximos;
        alert(`Solo puedes usar máximo ${puntosMaximos} puntos en esta compra`);
        return;
    }
    
    descuentoPuntosModal = puntosUsar * 100; // 1 punto = ₲100
    
    // Actualizar visualización del descuento
    document.getElementById('descuento_puntos_modal').textContent = '₲ ' + formatearNumero(descuentoPuntosModal);
    document.getElementById('descuento_total_modal').textContent = '- ₲ ' + formatearNumero(descuentoPuntosModal);
    
    // Mostrar/ocultar fila de descuento
    const filaDescuento = document.getElementById('fila_descuento_modal');
    if (descuentoPuntosModal > 0) {
        filaDescuento.style.display = 'table-row';
    } else {
        filaDescuento.style.display = 'none';
    }
    
    // Calcular total final
    const totalFinal = Math.max(0, subtotalOriginalModal - descuentoPuntosModal);
    document.getElementById('total_pagar_modal').textContent = '₲ ' + formatearNumero(totalFinal);
}

// Procesar confirmación de venta
function procesarConfirmacionVenta() {
    const form = document.getElementById('formConfirmarVenta');
    
    // Validar formulario
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Recopilar datos del formulario
    const formData = new FormData(form);
    formData.append('total_final', subtotalOriginalModal - descuentoPuntosModal);
    formData.append('descuento_puntos', descuentoPuntosModal);
    
    // Confirmar antes de procesar
    if (confirm('¿Confirmar venta por ₲ ' + formatearNumero(subtotalOriginalModal - descuentoPuntosModal) + '?')) {
        // Enviar datos al servidor
        fetch('index.php?c=venta&a=confirmar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('¡Venta confirmada exitosamente!');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'No se pudo confirmar la venta'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la confirmación');
        });
    }
}

// Función auxiliar para formatear números
function formatearNumero(numero) {
    return Math.round(numero).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
<?php include('view/crudModal.php'); ?>