<form id="productoForm" method="post" enctype="multipart/form-data" action="?c=productos&a=Guardar">
    <!-- Input oculto: si existe, editará en lugar de crear -->
    <input type="hidden" name="id_producto" value="<?php echo isset($producto->id_producto) ? $producto->id_producto : ''; ?>">

    <div class="row g-3">
        <!-- Imagen -->
        <div class="col-md-4 text-center">
            <label class="form-label fw-bold">Imagen de Portada</label>
            <div class="mb-3">
                <img id="previewImagen"
                    src="<?php echo !empty($producto->imagen_portada) ? 'assets/uploads/productos/' . $producto->imagen_portada : 'assets/img/no-image.png'; ?>"
                    alt="Imagen de portada"
                    class="img-thumbnail mb-2"
                    style="max-height: 200px;">
            </div>
            <input class="form-control" type="file" name="imagen_portada" id="imagenInput"
                accept="image/*" onchange="mostrarPreview(event)">
            <input type="hidden" name="imagen_portada_actual" value="<?php echo $producto->imagen_portada; ?>">
        </div>

        <div class="col-md-8">
            <label class="form-label fw-bold">Galería de Imágenes</label>
            <div class="mb-3">
                <input class="form-control" type="file" name="imagenes_galeria[]" multiple accept="image/*">
            </div>
            <div class="image-gallery d-flex flex-wrap">
                <?php if (isset($imagenes_galeria) && !empty($imagenes_galeria)): ?>
                    <?php foreach ($imagenes_galeria as $img): ?>
                        <div class="img-container me-2 mb-2">
                            <img src="assets/uploads/productos/<?php echo $img->ruta; ?>" class="img-thumbnail" style="height: 100px;">
                            <input type="hidden" name="imagenes_galeria_actual[]" value="<?php echo $img->ruta; ?>">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- Datos del producto -->
        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h5 class="card-title"><i class="fa-solid fa-box"></i> Datos del producto</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-signature"></i> Nombre</label>
                        <input type="text" class="form-control" name="nombre_producto"
                            value="<?php echo isset($producto->nombre_producto) ? $producto->nombre_producto : ''; ?>"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa-solid fa-industry"></i> Marca</label>
                        <input type="text" class="form-control" name="marca"
                            value="<?php echo isset($producto->marca) ? $producto->marca : ''; ?>">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label"><i class="fa-solid fa-align-left"></i> Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3"><?php echo isset($producto->descripcion) ? $producto->descripcion : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card p-3 shadow-sm mt-3">
                <h5 class="card-title"><i class="fa-solid fa-tags"></i> Información comercial</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label"><i class="fa-solid fa-dollar-sign"></i> Precio</label>
                        <input type="number" step="0.01" class="form-control" name="precio"
                            value="<?php echo isset($producto->precio) ? $producto->precio : ''; ?>"
                            required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="fa-solid fa-boxes-stacked"></i> Stock</label>
                        <input type="number" class="form-control" name="stock"
                            value="<?php echo isset($producto->stock) ? $producto->stock : ''; ?>"
                            required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="fa-solid fa-check-circle"></i> Destacado</label><br>
                        <input type="checkbox" class="form-check-input" name="destacado" value="1"
                            <?php echo (isset($producto->destacado) && $producto->destacado == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>

            <div class="card p-3 shadow-sm mt-3">
                <h5 class="card-title"><i class="fa-solid fa-calendar-days"></i> Promoción</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Desde</label>
                        <input type="date" class="form-control" name="promo_desde"
                            value="<?php echo isset($producto->promo_desde) ? $producto->promo_desde : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hasta</label>
                        <input type="date" class="form-control" name="promo_hasta"
                            value="<?php echo isset($producto->promo_hasta) ? $producto->promo_hasta : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="card p-3 shadow-sm mt-3">
                <h5 class="card-title"><i class="fa-solid fa-layer-group"></i> Categoría</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Categoría</label>
                        <select class="form-select" name="id_categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat->id_categoria; ?>"
                                    <?php echo (isset($producto->id_categoria) && $producto->id_categoria == $cat->id_categoria) ? 'selected' : ''; ?>>
                                    <?php echo $cat->nombre_categoria; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--   <div class="col-md-6">
                        <label class="form-label">Subcategoría</label>
                        <select class="form-select" name="id_subcategoria">
                            <option value="">Seleccione una subcategoría</option>
                            <?php foreach ($subcategorias as $sub): ?>
                                <option value="<?php echo $sub->id_subcategoria; ?>"
                                    <?php echo (isset($producto->id_subcategoria) && $producto->id_subcategoria == $sub->id_subcategoria) ? 'selected' : ''; ?>>
                                    <?php echo $sub->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div> -->
                </div>

            </div>
        </div>

        <div class="modal-footer">
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