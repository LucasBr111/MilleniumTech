<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center">
            <h1>Lista de Cuotas</h1>
            <button id="generarCuotasBtn" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Generar Cuotas para el Cliente
            </button>
        </div>




        <ul class="nav nav-tabs mb-4" id="cuotasTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-filter="todas">Todas</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-filter="dia">Cuotas del día</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-filter="semana">Cuotas de la semana</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-filter="vencidas">Cuotas vencidas</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-filter="vencer">Cuotas a vencer</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-filter="finalizadas">Finalizadas</button>
        </li>
    </ul>

        <div class="table-responsive rounded-3 shadow">
            <table class="table table-striped mb-0">
                <thead class="text-uppercase">
                    <tr>
                        <th scope="col" class="py-3 px-4">Nº</th>
                        <th scope="col" class="py-3 px-4">Cliente</th>
                        <th scope="col" class="py-3 px-4">Contactar</th>
                        <th scope="col" class="py-3 px-4">Monto Gs.</th>
                        <th scope="col" class="py-3 px-4">Pago Gs.</th>
                        <th scope="col" class="py-3 px-4">Saldo Gs.</th>
                        <th scope="col" class="py-3 px-4">Fecha</th>
                        <th scope="col" class="py-3 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody id="cuotasTableBody">
                    <tr>
                        <?php $mensajeWhatsapp = "Buenas tardes. Desde R&F Automotores le recordamos que tiene una cuota pendiente. Por favor, póngase en contacto con nosotros para más detalles."; ?>
                        <td class="py-4 px-4 fw-medium text-white-50">395</td>
                        <td class="py-4 px-4">LUCAS BRITEZ 2</td>
                        <td>
                            <a href="https://api.whatsapp.com/send?phone=595<?php echo "0971513671" ?>&text=<?php echo urlencode($mensajeWhatsapp); ?>" class="btn btn-success" target="_blank">
                                Enviar msj.
                                <img src="assets/img/WhatsApp.png" width="20px">
                            </a>
                        </td>
                        <td class="py-4 px-4">605,000</td>
                        <td class="py-4 px-4">0</td>
                        <td class="py-4 px-4">605,000</td>
                        <td class="py-4 px-4">21/07/2025 15:47</td>
                        <td class="py-4 px-4 d-flex gap-2">
                            <button class="btn btn-success btn-sm">Cobrar</button>
                            <button class="btn btn-primary btn-sm">Cuotas</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Inicializa tu DataTable (reemplaza 'cuotasTable' con el ID de tu tabla)
    const table = $('#cuotasTable').DataTable({
        // Opciones de configuración de tu DataTable, si las tienes
    });

    // Añade un evento de clic a todos los botones dentro de la barra de navegación
    $('#cuotasTabs button').on('click', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto de los botones
        
        // Remueve la clase 'active' de todos los botones y la añade al que se ha hecho clic
        $('#cuotasTabs button').removeClass('active');
        $(this).addClass('active');

        // Obtiene el valor del atributo data-filter
        const filterValue = $(this).data('filter');

        // Lógica de filtrado para el DataTable
        if (filterValue === 'todas') {
            table.search('').draw(); // Muestra todas las filas
        } else {
            // Usa el API de DataTables para filtrar
            // Este es un ejemplo básico. Debes adaptar la lógica de filtrado
            // para que coincida con tus datos (ej. un campo de 'estado', 'fecha', etc.).
            // Por ejemplo, para filtrar por cuotas vencidas, podrías buscar en una columna.
            table.search(filterValue).draw();
        }
    });
});
</script>