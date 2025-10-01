<div class="container-fluid">

<div class="row">
    <div class="col-12 mb-4">
        <div class="alert alert-primary shadow-sm" role="alert">
            <h4 class="alert-heading">¡Bienvenido de nuevo, <?php echo $_SESSION['user_nombre'] ?? 'Administrador'; ?>! 👋</h4>
            <p>Este es el panel de control de tu e-commerce. Aquí puedes monitorear las métricas clave y gestionar tu catálogo, pedidos y clientes.</p>
        </div>
    </div>
</div>

<div class="row">
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Ventas Netas (Hoy)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo ($this->ventas->contarHoy()); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pedidos Pendientes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $this->ventas->contarPedidos() ?? 0; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Clientes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $this->clientes->contarClientes() ?? 0; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</div>

</div>