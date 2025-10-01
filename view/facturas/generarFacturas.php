<div class="form-container">
    <h2>Seleccionar Tipo de Documento</h2>

    <form id="generationForm" method="POST" action="?c=factura&a=generarFactura">
        <input type="hidden" name="id_venta" value="<?php echo $_REQUEST['id_venta']; ?>">
        <input type="hidden" name="id_cliente" value="<?php echo $_REQUEST['id_cliente']; ?>">
        
        <label for="document-type">Acción Requerida:</label>
        <select id="document-type" class="form-select" name="facturas">
            <option value="factura">Generar Factura</option>
            <option value="ticket">Generar Ticket</option>
        </select>
        
        <div class="button-center-container">
            <button type="submit" class="btn-primary-custom" >
                Generar
            </button>
        </div>
        
    </form>

    <div id="modal-message">
    </div>
</div>
<style>
    
.btn-primary-custom {
    background: var(--gradient-primary);
    border: none;
    color: var(--darker-bg);
    padding: 12px 24px;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    flex: 1;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>