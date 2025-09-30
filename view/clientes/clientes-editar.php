<!-- Modal: Editar Perfil -->
<form id="formEditarPerfil" method="POST" action="index.php?c=cliente&a=guardar">
    <h5 class="modal-title"><i class="fas fa-user-edit"></i> Editar Perfil</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    <div class="modal-body">
        <div class="row g-3">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($cliente->id ?? ''); ?>">
            <div class="col-md-6">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control form-control-custom" name="nombre"
                    value="<?php echo htmlspecialchars($cliente->nombre ?? ''); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="tel" class="form-control form-control-custom" name="telefono"
                    value="<?php echo htmlspecialchars($cliente->telefono ?? ''); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control form-control-custom" name="email"
                    value="<?php echo htmlspecialchars($cliente->email ?? ''); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Documento</label>
                <input type="text" class="form-control form-control-custom" name="ci"
                    value="<?php echo htmlspecialchars($cliente->ci ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nueva Contraseña (dejar vacío para mantener)</label>
                <input type="password" class="form-control form-control-custom" name="password" 
                value="<?php echo htmlspecialchars($cliente->password ?? ''); ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn-primary-custom">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </div>
</form>