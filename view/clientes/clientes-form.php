<?php
$ci = $nombre_completo = $nacionalidad = $correo = $telefono = $direccion = '';
$id_cliente = 0;

if (isset($cliente) && $cliente != null) {
    $id_cliente = htmlspecialchars($cliente->id);
    $ci = htmlspecialchars($cliente->ci);
    $nombre_completo = htmlspecialchars($cliente->nombre_completo);
    $nacionalidad = htmlspecialchars($cliente->nacionalidad);
    $correo = htmlspecialchars($cliente->correo);
    $telefono = htmlspecialchars($cliente->telefono);
    $direccion = htmlspecialchars($cliente->direccion);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center rounded-top">
                <h3 class="text-center">
                    <i class="fas fa-user-edit text-danger me-2"></i>
                    <?php echo ($id_cliente > 0) ? 'Editar Cliente' : 'Nuevo Cliente'; ?>
                </h3>
            </div>
            
            <form id="clienteForm" method="post" action="?c=cliente&a=guardar" class="p-4">
                <input type="hidden" name="id" value="<?php echo $id_cliente; ?>">

                <h5 class="text-black"><i class="fas fa-id-card text-danger me-2"></i>Datos Personales</h5>
                <hr class="border-2 border-danger opacity-50">
                
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $nombre_completo; ?>" placeholder="Nombre y Apellido" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input type="text" class="form-control" id="ci" name="ci" value="<?php echo $ci; ?>" placeholder="Cédula de Identidad" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-flag"></i></span>
                            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="<?php echo $nacionalidad ?? "PARAGUAYA" ?>" placeholder="Ej: PARAGUAYA">
                        </div>
                    </div>
                </div>

                <h5 class="text-black mt-4"><i class="fas fa-address-book text-danger me-2"></i>Datos de Contacto</h5>
                <hr class="border-2 border-danger opacity-50">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" placeholder="Ej: 09xx xxxxxxx" maxlength="10" required>
                            <div class="invalid-feedback">Debe contener exactamente 10 dígitos.</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>" placeholder="ejemplo@correo.com">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                             <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>" placeholder="Dirección completa" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-save-fill me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('clienteForm').addEventListener('submit', function (e) {
        const telefono = document.getElementById('telefono');
        const valor = telefono.value.trim();

        // Validar que tenga exactamente 10 dígitos numéricos
        if (!/^\d{10}$/.test(valor)) {
            telefono.classList.add('is-invalid');
            telefono.focus();
            e.preventDefault();
        } else {
            telefono.classList.remove('is-invalid');
        }
    });
</script>