<style>
    /* CSS para los campos de solo lectura */
    .form-floating input[readonly],
    .form-floating input[readonly]:focus {
        background-color: #e9ecef;
        color: #495057;
        cursor: default;
        opacity: 0.8;
    }

    /* Ajustes para el placeholder en inputs flotantes */
    .form-floating>label {
        color: #6c757d;
    }

    .form-floating>input:not(:placeholder-shown)~label {
        color: #007bff;
    }

    .card-header-custom {
        background-color: #212529;
        color: white;
        padding: 1.5rem;
    }

    .card-body-custom {
        padding: 1.5rem;
    }

    /* Tu CSS se mantiene igual, está perfecto para el objetivo */
    .form-control[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
            <h2 class="mb-0"><i class="bi bi-file-earmark-check me-2"></i>Finalizar Presupuesto</h2>
            <span class="badge bg-light text-dark">Presupuesto #<?php echo htmlspecialchars($presupuesto->id ?? 'N/A'); ?></span>
        </div>
        <form class="card-body card-body-custom" method="POST" action="?c=presupuesto&a=aprobar" id="finalizarPresupuestoForm">
            <input type="hidden" id="idPresupuesto" name="id_presupuesto" value="<?php echo htmlspecialchars($presupuesto->id ?? ''); ?>">

            <div class="row align-items-end mb-3">
                <div class="col-md-6">
                    <label for="id_cliente" class="form-label">Seleccionar el Cliente</label>
                    <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" title="-- Seleccione o busque un cliente --">
                    <option id="nuevoClienteOption" value="nuevo">-- Nuevo Cliente --</option>
                        <?php foreach ($this->cliente->Listar() as $cliente) : ?>
                            <option
                                data-subtext="CI: <?php echo htmlspecialchars($cliente->ci); ?>"
                                value="<?php echo htmlspecialchars($cliente->id); ?>"
                                <?php if (isset($presupuesto->id_cliente) && $presupuesto->id_cliente == $cliente->id) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cliente->nombre_completo); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-outline-primary w-100" id="btnNuevoCliente">
                        <i class="bi bi-person-plus me-2"></i>Ingresar Nuevo Cliente
                    </button>
                </div>
            </div>

            <div id="camposCliente" class="mt-4" style="display:none;" >
                <h5 class="mb-3">Información del Cliente</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nombreCompleto" name="nombre_cliente" placeholder="Nombre Completo">
                            <label for="nombreCompleto">Nombre Completo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ci" name="ci_cliente" placeholder="Numero de cedula">
                            <label for="ci">CI:</label>
                        </div>
                    </div>
                </div>
             <p>   </p>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad_cliente" placeholder="nacionalidad">
                            <label for="nacionalidad">Nacionalidad</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="direccion" name="direccion_cliente" placeholder="Dirección">
                            <label for="direccion">Dirección</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="telefono" nanme="telefono_cliente" placeholder="Contacto de WhatsApp">
                            <label for="telefono">Nro Telefono:</label>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <h4 class="mb-4"><i class="bi bi-cash me-2"></i>Detalles de la Transacción</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="tipoPago" class="form-label">Tipo de Pago</label>
                    <select class="form-select" id="tipoPago" name="tipo_pago">
                        <option value="contado" <?php if (isset($presupuesto->tipo_pago) && $presupuesto->tipo_pago == 'contado') echo 'selected'; ?>>Contado</option>
                        <option value="credito" <?php if (isset($presupuesto->tipo_pago) && $presupuesto->tipo_pago == 'credito') echo 'selected'; ?>>Crédito</option>
                    </select>
                </div>
            </div>

            <div id="seccionCredito" class="mt-4" style="display:none;">
                <h5 class="mb-3">Condiciones del Crédito</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="monto_credito" class="form-control" id="precioEstipulado" value="<?php echo htmlspecialchars($presupuesto->monto_total ?? '0'); ?>" readonly>
                            <label for="precioEstipulado">Precio Estipulado</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="montoEntregado" name="monto" placeholder="Monto Entregado" value="0">
                            <label for="montoEntregado">Monto Entregado</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="cantidad_cuotas" id="cuotasRegulares" value="<?php echo htmlspecialchars($presupuesto->cantidad_cuotas ?? '1'); ?>" readonly>
                            <label for="cuotasRegulares">Cantidad de Cuotas Regulares</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="monto_cuotas" id="montoCuotas" value="<?php echo htmlspecialchars($presupuesto->monto_cuotas ?? '1'); ?>" readonly>
                            <label for="cuotasRegulares">Monto de Cuotas Regulares</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="cantidad_refuerzos" id="cantidadRefuerzos" value="<?php echo htmlspecialchars($presupuesto->cantidad_refuerzos ?? '1'); ?>" readonly>
                            <label for="cantidadRefuerzos">Cantidad de Refuerzos</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="monto_refuerzo" id="montoRefuerzos" value="<?php echo htmlspecialchars($presupuesto->monto_refuerzo ?? '1'); ?>" readonly>
                            <label for="montoRefuerzos">Monto de Refuerzos</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="button" class="btn btn-outline-info" id="btnCodeudores">
                    <i class="bi bi-people-fill me-2"></i>Agregar Co-deudores
                </button>
            </div>

            <div id="seccionCodeudores" class="mt-4" style="display:none;">
            <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nombreCompleto" name="nombre_codeudor" placeholder="Nombre Completo">
                            <label for="nombreCompleto">Nombre Completo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control"  placeholder="Numero de cedula">
                            <label for="ci">CI:</label>
                        </div>
                    </div>
                </div>
             <p>   </p>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="nacionalidad">
                            <label for="nacionalidad">Nacionalidad</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control"  placeholder="Dirección">
                            <label for="direccion">Dirección</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control"  placeholder="Contacto de WhatsApp">
                            <label for="telefono">Nro Telefono:</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-5">
                <button type="button" class="btn btn-success btn-lg" id="btnFinalizar">
                    <i class="bi bi-check-circle-fill me-2"></i>Finalizar y Guardar Venta
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        // --- MANEJO DE SECCIONES VISIBLES/OCULTAS ---

        function toggleSeccionCredito() {
            if ($('#tipoPago').val() === 'credito') {
                $('#seccionCredito').slideDown(400);
            } else {
                $('#seccionCredito').slideUp(400);
            }
        }

        $('#tipoPago').on('change', function() {
            toggleSeccionCredito();
        });

        toggleSeccionCredito();


        // Botón para mostrar/ocultar campos de nuevo cliente
        $('#btnNuevoCliente').on('click', function() {
            $('#camposCliente').slideToggle(400, function() {
                // Al finalizar la animación, limpia los campos si la sección es visible
                if ($('#camposCliente').is(':visible')) {
                    $('#nombreCompleto, #direccion, #telefono, #ci, #nacionalidad').val('');
                    // Deselecciona el cliente actual si se eligió crear uno nuevo y selecciona la opcion de nuevo por prop
                    $('#id_cliente').val('nuevo')

                }
            });
        });

        // Boton para mostrar y guardar los co deudores
        $('#btnCodeudores').on('click', function() {
            $('#seccionCodeudores').slideToggle(400);
        });

        // --- LÓGICA DE CARGA DE DATOS DEL CLIENTE ---

        function cargarDatosCliente(clienteId) {
            if (!clienteId) {
                $('#camposCliente').slideUp(400);
                return;
            }

            var url = "?c=cliente&a=BuscarID&id=" + clienteId;

            $.ajax({
                url: url,
                method: "POST",
                dataType: 'json',
                success: function(cliente) {
                    $('#nombreCompleto').val(cliente.nombre_completo);
                    $('#direccion').val(cliente.direccion);
                    $('#telefono').val(cliente.telefono);
                    $('#ci').val(cliente.ci);
                    $('#nacionalidad').val(cliente.nacionalidad);
                    $('#camposCliente').slideDown(400);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error al obtener datos del cliente:", textStatus, errorThrown);
                    alert('Error al obtener los datos del cliente.');
                }
            });
        }

        $('#id_cliente').on('change', function() {
            var clienteId = $(this).val();

            if (clienteId === "nuevo") {
                $('#camposCliente').slideDown(400);
                $('#nombreCompleto, #direccion, #telefono, #ci, #nacionalidad').val('');
            } else {
                cargarDatosCliente(clienteId);
            }
        });

        // Lógica inicial para cargar los datos o mostrar el formulario de nuevo cliente
        var clienteInicialId = $('#id_cliente').val();
        console.log(clienteInicialId);
        if (clienteInicialId === "nuevo") {
            console.log("entra aca")
            $('#camposCliente').slideDown(400);
            $('#nombreCompleto, #direccion, #telefono, #ci, #nacionalidad').val('');
        }else if (clienteInicialId) {
            cargarDatosCliente(clienteInicialId);
        }
    });
</script>