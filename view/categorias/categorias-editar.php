<form id="categoriaForm" method="post" enctype="multipart/form-data" action="?c=categorias&a=Guardar">
    <input type="hidden" name="id_categoria" value="<?php echo isset($categoria->id_categoria) ? $categoria->id_categoria : ''; ?>">

    <div class="row g-3">
        <div class="col-md-6 text-center">
            <label class="form-label fw-bold">Imagen de Categoría</label>
            <div class="mb-3">
                <img id="previewImagen"
                    src="<?php echo !empty($categoria->imagen) ? 'assets/uploads/categorias/' . $categoria->imagen : 'assets/img/no-image.png'; ?>"
                    alt="Imagen de categoría"
                    class="img-thumbnail mb-2"
                    style="max-height: 200px;">
            </div>
            <input class="form-control" type="file" name="imagen" id="imagenInput" accept="image/*" onchange="mostrarPreview(event)">
            <input type="hidden" name="imagen_actual" value="<?php echo isset($categoria->imagen) ? $categoria->imagen : ''; ?>">
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h5 class="card-title"><i class="fa-solid fa-list-ul"></i> Datos de la Categoría</h5>
                <div class="mb-3">
                    <label class="form-label">Nombre de Categoría</label>
                    <input type="text" class="form-control" name="nombre_categoria"
                        value="<?php echo isset($categoria->nombre_categoria) ? $categoria->nombre_categoria : ''; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion_categoria" rows="3"><?php echo isset($categoria->descripcion_categoria) ? $categoria->descripcion_categoria : ''; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer mt-4">
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    // Preview de imagen antes de subir
    function mostrarPreview(event) {
        const output = document.getElementById('previewImagen');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
</script>