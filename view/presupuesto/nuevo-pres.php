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
</style>

<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center">
            <h2 class="mb-0"><i class="bi bi-calculator me-2"></i>Generador de Presupuestos</h2>
        </div>
        <div class="card-body p-4">
            <form id="formularioPresupuesto">
                <!-- Secciones del formulario -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="selectorVehiculo" class="form-label">
                            <i class="bi bi-car-front-fill me-2"></i>Seleccionar Vehículo Existente
                        </label>
                        <select class="form-select" id="selectorVehiculo">
                            <option value="">Seleccione un vehículo...</option>
                            <!-- Esto es PHP, no se ejecutará aquí. Asumimos que la data está presente. -->
                            <option value="150000000">Toyota Hilux (2022) - Gs. 150.000.000</option>
                            <option value="120000000">Chevrolet Onix (2021) - Gs. 120.000.000</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-primary w-100" id="btnNuevoVehiculo">
                            <i class="bi bi-plus-circle me-2"></i>Ingresar Nuevo Vehículo
                        </button>
                    </div>
                </div>

                <div id="camposNuevoVehiculo" class="mt-4" style="display:none;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombreNuevoVehiculo" class="form-label">Nombre del Vehículo</label>
                            <input type="text" class="form-control" id="nombreNuevoVehiculo" placeholder="Ej: Toyota Hilux">
                        </div>
                        <div class="col-md-6">
                            <label for="precioNuevoVehiculo" class="form-label">
                                Precio Total del Vehículo
                            </label>
                            <input type="text" class="form-control input-precio" id="precioNuevoVehiculo" placeholder="Monto total del vehículo">
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <h4 class="mb-4">
                    <i class="bi bi-coin me-2"></i>Detalles del Plan de Pagos
                </h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control input-precio" id="precioTotal" placeholder="Monto total del vehículo" required>
                            <label for="precioTotal">Precio Total del Vehículo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control input-precio" id="entregaInicial" placeholder="Monto de la entrega inicial" required>
                            <label for="entregaInicial">Entrega Inicial</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control input-precio" id="montoCuota" placeholder="Monto de la cuota regular" required>
                            <label for="montoCuota">Monto de la Cuota</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="saldoFinanciar" readonly>
                            <label for="saldoFinanciar">Saldo a Financiar</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="totalCuotas" readonly>
                            <label for="totalCuotas">Cantidad de Cuotas</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="cantidadRefuerzos" readonly>
                            <label for="cantidadRefuerzos">Cantidad de Refuerzos</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="montoRefuerzo" readonly>
                            <label for="montoRefuerzo">Monto del Refuerzo</label>
                        </div>
                    </div>
                </div>

                <!-- Campos ocultos para el envío de datos -->
                <input type="hidden" id="precioTotalHidden" name="precioTotal">
                <input type="hidden" id="entregaInicialHidden" name="entregaInicial">
                <input type="hidden" id="montoCuotaHidden" name="montoCuota">
                <input type="hidden" id="saldoFinanciarHidden" name="saldoFinanciar">
                <input type="hidden" id="totalCuotasHidden" name="totalCuotas">
                <input type="hidden" id="cantidadRefuerzosHidden" name="cantidadRefuerzos">
                <input type="hidden" id="montoRefuerzoHidden" name="montoRefuerzo">

            </form>

            <div class="d-grid gap-2 mt-4">
                <button type="button" class="btn btn-success" id="btnGenerarPresupuesto">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>Generar Plan de Pagos
                </button>
            </div>
        </div>
    </div>

    <div id="vistaPreviaPlanPagos" style="display:none;">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-secondary text-white p-4">
                <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Vista Previa del Plan de Pagos</h4>
            </div>
            <div class="card-body p-4">
                <div id="contenedorTablaPlanPagos">
                </div>
            </div>
        </div>
    </div>

    <!-- Boton para enviar el formulario. Se agrega la clase `d-none` para ocultarlo por defecto -->
    <div class="d-grid gap-2 mt-4" id="botonGuardarPresupuesto">
        <button type="button" class="btn btn-primary" id="btn-guardar" disabled>
            <i class="bi bi-save me-2"></i>Guardar Presupuesto
        </button>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#btn-guardar').prop('disabled', true);

        /**
         * @name redondearAGuaranies
         * @description Redondea un número al millar más cercano,
         * respetando la denominación de 500 Gs.
         * @param {number} n - El número a redondear.
         * @returns {number} El número redondeado.
         */
        function redondearAGuaranies(n) {
            if (n === 0) return 0;
            const resto = n % 1000;
            if (resto === 500) {
                return n;
            } else {
                return Math.ceil(n / 1000) * 1000;
            }
        }

        /**
         * @name formatearNumero
         * @description Formatea un número con separadores de miles (punto).
         * @param {number} n - El número a formatear.
         * @returns {string} El número formateado como cadena de texto.
         */
        function formatearNumero(n) {
            return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        /**
         * @name limpiarNumero
         * @description Limpia un número formateado para convertirlo a un valor flotante.
         * @param {string} n - La cadena de texto a limpiar.
         * @returns {number} El número flotante.
         */
        function limpiarNumero(n) {
            return parseFloat(String(n).replace(/\./g, '')) || 0;
        }

        // Evento de entrada para formatear los campos de precio
        $('.input-precio').on('input', function() {
            let valor = $(this).val();
            if (valor !== '') {
                $(this).val(formatearNumero(limpiarNumero(valor)));
            }
        });

        /**
         * @name calcularPresupuesto
         * @description Función principal para calcular el presupuesto del plan de pagos.
         * Obtiene los valores de los campos de entrada y llama a la función de generación de tabla.
         */
        function calcularPresupuesto() {
            const precioTotal = limpiarNumero($('#precioTotal').val());
            const entregaInicial = limpiarNumero($('#entregaInicial').val());
            const montoCuota = limpiarNumero($('#montoCuota').val());

            if (precioTotal <= 0 || montoCuota <= 0 || precioTotal < entregaInicial) {
                $('#saldoFinanciar').val('');
                $('#totalCuotas').val('');
                $('#cantidadRefuerzos').val('');
                $('#montoRefuerzo').val('');
                $('#vistaPreviaPlanPagos').hide();
                return false; // Retornar falso si hay error de validación
            }

            const saldoFinanciar = precioTotal - entregaInicial;
            $('#saldoFinanciar').val(formatearNumero(saldoFinanciar));

            generarTablaPlanPagos(saldoFinanciar, montoCuota);
            return true; // Retornar verdadero si la validación es exitosa
        }

        /**
         * @name generarTablaPlanPagos
         * @description Genera la tabla del plan de pagos, ajustando el monto de los refuerzos
         * para que las cuotas regulares sean siempre iguales y el saldo quede en 0.
         * @param {number} saldoFinanciar - El saldo restante a financiar.
         * @param {number} montoCuota - El monto de la cuota mensual regular.
         */
        function generarTablaPlanPagos(saldoFinanciar, montoCuota) {
            const contenedorTabla = $('#contenedorTablaPlanPagos');
            contenedorTabla.empty();

            let saldoTemporal = saldoFinanciar;
            let totalCuotas = 0;
            let cantidadRefuerzos = 0;
            let fechaTemporal = new Date();
            let anios = {};

            // Primera pasada para calcular total de cuotas y refuerzos
            while (saldoTemporal > 0) {
                fechaTemporal.setMonth(fechaTemporal.getMonth() + 1);
                totalCuotas++;
                if (fechaTemporal.getMonth() === 11) {
                    cantidadRefuerzos++;
                }
                saldoTemporal -= montoCuota;
                // Prevenir loop infinito
                if (totalCuotas > 300 && saldoTemporal > 0) {
                    console.error("Presupuesto demasiado largo. Verifique los montos.");
                    $('#vistaPreviaPlanPagos').hide();
                    return;
                }
            }

            const saldoRestante = saldoFinanciar - ((totalCuotas - cantidadRefuerzos) * montoCuota);
            let montoRefuerzoFinal = 0;

            if (cantidadRefuerzos > 0) {
                montoRefuerzoFinal = redondearAGuaranies(saldoRestante / cantidadRefuerzos) + montoCuota;
            }

            // Segunda pasada para generar la tabla con los valores finales
            let saldoActual = saldoFinanciar;
            let fechaActual = new Date();
            let cuotaCount = 0;

            while (saldoActual > 0) {
                fechaActual.setMonth(fechaActual.getMonth() + 1);
                cuotaCount++;

                let tipoPago = 'Cuota Regular';
                let monto = montoCuota;

                if (fechaActual.getMonth() === 11) { // Diciembre
                    tipoPago = 'Refuerzo';
                    monto = montoRefuerzoFinal;
                }

                if (saldoActual < monto) {
                    monto = saldoActual;
                    tipoPago = 'Cuota Final';
                }

                saldoActual -= monto;

                const anio = fechaActual.getFullYear();
                if (!anios[anio]) {
                    anios[anio] = [];
                }
                anios[anio].push({
                    fecha: new Date(fechaActual),
                    monto: monto,
                    tipo: tipoPago
                });
            }

            for (const anio in anios) {
                const tablaAnio = `
                        <h5 class="mt-4 mb-2">Año ${anio}</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Tipo de Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${anios[anio].map(p => `
                                        <tr>
                                            <td>${p.fecha.toLocaleDateString('es-ES')}</td>
                                            <td>Gs. ${formatearNumero(p.monto)}</td>
                                            <td>${p.tipo}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                contenedorTabla.append(tablaAnio);
            }

            $('#totalCuotas').val(cuotaCount);
            $('#cantidadRefuerzos').val(cantidadRefuerzos);
            $('#montoRefuerzo').val(formatearNumero(montoRefuerzoFinal));
        }


        // --- Lógica de eventos del formulario ---

        $('#selectorVehiculo').on('change', function() {
            const precioSeleccionado = limpiarNumero($(this).val());
            if (!isNaN(precioSeleccionado) && precioSeleccionado > 0) {
                $('#precioTotal').val(formatearNumero(precioSeleccionado));
                $('#camposNuevoVehiculo').slideUp();
            } else {
                $('#precioTotal').val('');
            }
            calcularPresupuesto();
        });

        $('#btnNuevoVehiculo').on('click', function() {
            $('#camposNuevoVehiculo').slideToggle(() => {
                if ($('#camposNuevoVehiculo').is(':visible')) {
                    $('#precioNuevoVehiculo').focus();
                    $('#selectorVehiculo').val('');
                }
                calcularPresupuesto();
            });
        });

        $('#precioNuevoVehiculo').on('input', function() {
            $('#precioTotal').val($(this).val());
            calcularPresupuesto();
        });

        $('#btnGenerarPresupuesto').on('click', function(e) {
            e.preventDefault();

            // 1. Obtener y validar los valores
            const esValido = calcularPresupuesto();

            // 2. Si es válido, preparar y mostrar los campos
            if (esValido) {
                // Actualizar los campos ocultos
                $('#precioTotalHidden').val(limpiarNumero($('#precioTotal').val()));
                $('#entregaInicialHidden').val(limpiarNumero($('#entregaInicial').val()));
                $('#montoCuotaHidden').val(limpiarNumero($('#montoCuota').val()));
                $('#saldoFinanciarHidden').val(limpiarNumero($('#saldoFinanciar').val()));
                $('#totalCuotasHidden').val(limpiarNumero($('#totalCuotas').val()));
                $('#cantidadRefuerzosHidden').val(limpiarNumero($('#cantidadRefuerzos').val()));
                $('#montoRefuerzoHidden').val(limpiarNumero($('#montoRefuerzo').val()));

                // 3. Mostrar la vista previa y el botón de guardar
                $('#vistaPreviaPlanPagos').show();
                $('#btn-guardar').prop('disabled', false);

                // Notificación de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Presupuesto Creado',
                    text: 'El presupuesto ha sido generado correctamente. Ahora puede guardarlo.'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, complete los campos de precio para generar el presupuesto.'
                });
                $('#vistaPreviaPlanPagos').hide();
                $('#btn-guardar').prop('disabled', true);
            }
        });

        // Enviar el formulario al backend para guardar los detalles
        $('#btn-guardar').on('click', function(e) {
            e.preventDefault(); // Evitar la recarga de página

            // Deshabilitar el botón para evitar múltiples envíos
            $(this).prop('disabled', true);

            // Mover los valores de los inputs de solo lectura a los campos ocultos
            $('#saldoFinanciarHidden').val(limpiarNumero($('#saldoFinanciar').val()));
            $('#totalCuotasHidden').val(limpiarNumero($('#totalCuotas').val()));
            $('#cantidadRefuerzosHidden').val(limpiarNumero($('#cantidadRefuerzos').val()));
            $('#montoRefuerzoHidden').val(limpiarNumero($('#montoRefuerzo').val()));

            // Envio normal sin ajax, agregando el metodo y la action
            $('#formularioPresupuesto').attr('method', 'POST');
            $('#formularioPresupuesto').attr('action', 'index.php?c=presupuesto&a=guardar');
            $('#formularioPresupuesto').submit();
        });
    });
</script>