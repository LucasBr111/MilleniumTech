<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Lista de Clientes</h2>
            <button data-bs-toggle="modal" data-bs-target="#crudModal" data-c="cliente" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Agregar
            </button>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="clienteTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="todos-tab" data-bs-toggle="tab" href="#todos" role="tab" aria-controls="todos" aria-selected="true">
                        Todos
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="deudores-tab" data-bs-toggle="tab" href="#deudores" role="tab" aria-controls="deudores" aria-selected="false">
                        Deudores
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="finalizados-tab" data-bs-toggle="tab" href="#finalizados" role="tab" aria-controls="finalizados" aria-selected="false">
                        Finalizados
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="clienteTabsContent">
                <div class="tab-pane fade show active" id="todos" role="tabpanel" aria-labelledby="todos-tab">
                    <div class="table-responsive">
                        <table id="clienteTable" class="table datatable table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">C.I.</th>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Fecha de Registro</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $r) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($r->ci); ?></td>
                                        <td><?php echo htmlspecialchars($r->nombre_completo); ?></td>
                                        <td><?php echo htmlspecialchars($r->correo); ?></td>
                                        <td><?php echo htmlspecialchars($r->telefono); ?></td>
                                        <td><?php echo htmlspecialchars($r->direccion); ?></td>
                                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($r->creado_en))); ?></td>
                                        <td class="d-flex gap-2">
                                            <a data-id="<?php echo $r->id; ?>"  data-c="cliente"  data-bs-toggle="modal" data-bs-target="#crudModal" class="btn btn-warning btn-sm" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="?c=cliente&a=eliminar&id=<?php echo $r->id; ?>" class="btn btn-danger btn-sm text-white delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'view/crudModal.php'; ?>