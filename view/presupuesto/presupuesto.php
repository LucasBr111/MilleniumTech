<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center">
            <h1>Lista de Presupuestos</h1>
            <a href="?c=presupuesto&a=nuevo" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Presupuesto
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive rounded-3 shadow">
                <table id="presupuestosTable" class="table table-striped mb-0">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col" class="py-3 px-4">ID</th>
                            <th scope="col" class="py-3 px-4">Cliente</th>
                            <th scope="col" class="py-3 px-4">Vehículo</th>
                            <th scope="col" class="py-3 px-4">Vendedor</th>
                            <th scope="col" class="py-3 px-4">Fecha</th>
                            <th scope="col" class="py-3 px-4">Monto Total</th>
                            <th scope="col" class="py-3 px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($this->model->Listar() as $r): ?>
                        <tr>
                            <td class="py-4 px-4 fw-medium"><?= htmlspecialchars($r->id) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($r->nombre_completo) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($r->auto_nombre) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($r->vendedor) ?></td>
                            <td class="py-4 px-4"><?= htmlspecialchars($r->fecha_creacion) ?></td>
                            <td class="py-4 px-4"><?= 'Gs. ' . number_format($r->monto_total, 0, ',', '.') ?></td>
                            <td class="py-4 px-4 d-flex gap-2">
                                <?php if ($r->estado == 'pendiente'): ?>
                                    <a href="?presupuesto&a=aprobar&id=<?= htmlspecialchars($r->id) ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Aprobar
                                    </a>
                                <?php else: ?>

                                <a href="?c=presupuesto&a=ver&id=<?= htmlspecialchars($r->id) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="?c=presupuesto&a=eliminar&id=<?= htmlspecialchars($r->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este presupuesto?');">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>