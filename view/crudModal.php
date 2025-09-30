<style>
    @media (min-width: 768px) {
        .modal-xl {
            width: 90%;
            max-width: 1500px;
        }
    }
</style>

<div id="crudModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content modal-custom">
            <div class="modal-body" id="edit_form"> 
                </div>
        </div>
    </div>
</div>

<style>
.modal-dialog {
    max-width: 800px;
    margin: 1rem auto; /* reduce espacio superior/inferior */
}

.modal-content {
    padding: 1rem; /* reduce padding interno del modal */
}

/* Eliminar márgenes grandes de títulos */
.card-header h3 {
    margin: 0.5rem 0; /* antes tenías my-4, ahora más compacto */
    font-size: 1.5rem;
}

h5 {
    margin-top: 1rem; /* más ajustado que mt-4 */
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

/* Inputs y labels más pegados */
.form-label {
    margin-bottom: 0.25rem;
}

.form-control {
    margin-bottom: 0.75rem; /* separa inputs ligeramente */
}

/* Ajustes del footer */
.modal-footer {
    padding: 0.75rem 1rem;
}

/* Cerrar modal */
.btn-close {
    top: 0.5rem;
    right: 0.5rem;
}

/* Opcional: quitar backdrop si quieres */
.modal-backdrop {
    display: none;
}

</style>