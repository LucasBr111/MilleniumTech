<!-- Vista: views/cliente/perfil.php -->
<!-- Asume que $cliente, $compras, $direcciones, $metodosPago y $puntos vienen del controlador como objetos -->
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
                                <h4><?php echo number_format($cliente->puntos ?? 0); ?></h4>
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
                                            <td>#<?php echo ($compra->id); ?></td>
                                            <td class="precio-destacado">₲ <?php echo number_format($compra->total, 0, ',', '.'); ?></td>
                                            <td>
                                                <span class="badge-estado estado-<?php echo strtolower($compra->estado); ?>">
                                                    <?php echo ucfirst($compra->estado); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($compra->direccion_envio) ?? 'No especificado'; ?></td>
                                            <td>
                                                <?php if (isset($esAdmin) && $esAdmin): ?>
                                                    <button class="btn-action btn-danger-action" onclick="eliminarCompra(<?php echo $compra->id_venta; ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php elseif ($compra->estado === 'pendiente'): ?>
                                                    <button class="btn-action btn-warning-action" onclick="confirmarVenta(<?php echo $compra->id; ?>)">
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
        </div>

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
                            <h2><?php echo number_format($puntos->total ?? 0); ?></h2>
                            <p>Puntos Disponibles</p>
                        </div>
                    </div>
                    <div class="puntos-equivalencia">
                        <p><i class="fas fa-info-circle"></i> Equivalencia:</p>
                        <h4>₲ <?php echo number_format(($puntos->total ?? 0) * 100, 0, ',', '.'); ?></h4>
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
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($puntos->historial)): ?>
                                    <?php foreach ($puntos->historial as $registro): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y', strtotime($registro->fecha)); ?></td>
                                            <td><?php echo htmlspecialchars($registro->concepto); ?></td>
                                            <td class="<?php echo $registro->tipo === 'ingreso' ? 'text-success' : 'text-danger'; ?>">
                                                <?php echo $registro->tipo === 'ingreso' ? '+' : '-'; ?><?php echo number_format($registro->puntos); ?>
                                            </td>
                                            <td><?php echo number_format($registro->saldo); ?></td>
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
                    <!-- Información del pedido -->
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

                    <!-- Dirección de envío -->
                    <div class="col-md-6">
                        <div class="detalle-seccion">
                            <h6><i class="fas fa-map-marker-alt"></i> Dirección de Envío</h6>
                            <p id="detalle_direccion"></p>
                            <p><strong>Tracking:</strong> <span id="detalle_tracking"></span></p>
                        </div>
                    </div>

                    <!-- Productos -->
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

<!-- Modal: Confirmar Venta -->
<div class="modal fade" id="modalConfirmarVenta" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modal-custom">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-check-circle"></i> Confirmar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas confirmar esta venta?</p>
                <p class="text-muted">Esta acción procesará el pedido y no se puede deshacer.</p>
                <input type="hidden" id="confirmar_venta_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-primary-custom" onclick="confirmarVentaAjax()">
                    <i class="fas fa-check"></i> Sí, Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<?php include('view/crudModal.php'); ?>