<?php 

require_once 'model/clientes.php';
require_once 'model/presupuesto.php';
require_once 'model/cuotas.php';
/* require_once 'model/ventas.php';
require_once 'model/codeudores.php'; */



class presupuestoController{
    private $model;
    private $presupuesto;
    private $cuotas;
    private $cliente;
    private $venta;
    private $codeudor;



    public function __CONSTRUCT(){
    
        $this->model = new presupuesto();
        $this->presupuesto = new presupuesto();
        $this->cuotas = new cuotas();
        $this->cliente = new clientes();
       /*  $this->venta = new venta();
        $this->codeudor = new codeudores(); */
    }

    public function index() {
        require_once 'view/header.php';
        require_once 'view/presupuesto/presupuesto.php';
        require_once 'view/footer.php';
    }

    public function guardar(){
        // Validar y obtener los datos del formulario de manera segura
        $id_cliente = $_REQUEST['id_cliente'] ?? 0;
        $id_vendedor = $_SESSION['user_id'] ?? 1;
        $id_vehiculo = $_REQUEST['id_vehiculo'] ?? 0;
        $precio_total = (float)($_REQUEST['precioTotal'] ?? 0);
        $entrega_inicial = (float)($_REQUEST['entregaInicial'] ?? 0);
        $monto_cuota_regular = (float)($_REQUEST['montoCuota'] ?? 0);
        $total_cuotas = (int)($_REQUEST['totalCuotas'] ?? 0);
        $cantidad_refuerzos = (int)($_REQUEST['cantidadRefuerzos'] ?? 0);
        $monto_refuerzo = (float)($_REQUEST['montoRefuerzo'] ?? 0);
        $pago = $_REQUEST['pago'] ?? '';
        $de = $_REQUEST['de'] ?? '';
    
        
        $presupuesto = new presupuesto();
        $presupuesto->id_cliente = $id_cliente;
        $presupuesto->id_vendedor = $id_vendedor;
        $presupuesto->id_vehiculo = $id_vehiculo;
        $presupuesto->precio_total = $precio_total;
        $presupuesto->monto_entrega = $entrega_inicial;
        $presupuesto->fecha_presupuesto = date('Y-m-d');
        $presupuesto->estado = 'Pendiente';
        $presupuesto->cantidad_cuotas = $total_cuotas;
        $presupuesto->monto_cuotas = $monto_cuota_regular;
        $presupuesto->cantidad_refuerzos = $cantidad_refuerzos;
        $presupuesto->monto_refuerzo = $monto_refuerzo;

        $presupuesto->pago = $pago;
    
        // Llama al modelo para registrar el presupuesto y obtener su ID
        $this->model->registrar($presupuesto);
        $id_presupuesto = $this->model->obtenerUltimoIdPres();
    
        // 2. Registrar cada cuota individualmente
        $fecha_actual = new DateTime();
        $fecha_actual->modify('+1 month');
    
        for ($i = 0; $i < $total_cuotas; $i++) {
            $cuota = new cuotas();
            $cuota->id_presupuesto = $id_presupuesto;
            $cuota->id_usuario = $id_vendedor;
            $cuota->id_cliente = $id_cliente;
    
            // Determinar si es una cuota regular o un refuerzo
            if ($fecha_actual->format('n') == 12 && $cantidad_refuerzos > 0) {
                $cuota->monto = $monto_refuerzo;
                $cuota->tipo_pago = 'Refuerzo';
                // Decrementa la cantidad de refuerzos para no exceder el total
                $cantidad_refuerzos--;
            } else {
                $cuota->monto = $monto_cuota_regular;
                $cuota->tipo_pago = 'Cuota Regular';
            }
            
            $cuota->fecha_pago = $fecha_actual->format('Y-m-d');
            $cuota->monto_pagado = 0;
    
            // Llama al modelo para registrar la cuota
            $this->cuotas->Registrar($cuota);
    
            // Avanzar al siguiente mes para la próxima cuota
            $fecha_actual->modify('+1 month');
        

        }
        // Redirigir a una página de éxito o mostrar un mensaje
        header('Location: index.php?c=presupuesto');
    
       
    }

    public function financiar(){
        die("hasbn");
        require_once 'view/header.php';
        require_once 'view/presupuesto/nuevo-pres.php';
        require_once 'view/footer.php';

    }

    public function AprobarVista(){
        $id = $_REQUEST['id'];
        if (isset($id)) {
            $presupuesto = $this->model->obtener($id);
        }
        require_once 'view/header.php';
        require_once 'view/presupuesto/finalizar-pres.php';
        require_once 'view/footer.php';
    }

    public function aprobar(){
        // Obtener datos del formulario de manera segura
        $id_presupuesto = $_REQUEST['id_presupuesto'] ?? 0;
        $id_cliente = $_REQUEST['id_cliente'] ?? 0;
        $id_vendedor = $_SESSION['user_id'] ?? 1;
        $tipo_pago = $_REQUEST['tipo_pago'] ?? '';
        
        // Cargar el presupuesto existente para obtener los datos no enviados en el formulario
        $presupuesto = $this->model->Obtener($id_presupuesto);

        // Lógica para registrar un nuevo cliente si se seleccionó la opción "nuevo"
        if ($id_cliente === 'nuevo' && !empty($_REQUEST['nombre_cliente']) && !empty($_REQUEST['ci_cliente'])) {
            $nuevoCliente = new Clientes();
            $nuevoCliente->nombre_completo = $_REQUEST['nombre_cliente'];
            $nuevoCliente->ci = $_REQUEST['ci_cliente'];
            $nuevoCliente->nacionalidad = $_REQUEST['nacionalidad_cliente'] ?? '';
            $nuevoCliente->direccion = $_REQUEST['direccion_cliente'] ?? '';
            $nuevoCliente->telefono = $_REQUEST['telefono_cliente'] ?? '';
            
         
            $this->cliente ->registrar($nuevoCliente);
        }

        // Actualizar el estado del presupuesto
        $presupuesto->id_cliente = $id_cliente;
        $presupuesto->id_vendedor = $id_vendedor;
        $presupuesto->estado = 'Aprobado';
        $presupuesto->tipo_pago = $tipo_pago;

        // Lógica condicional para actualizar los datos de pago
        if ($tipo_pago === 'contado') {
            $presupuesto->precio_total = (float)($_REQUEST['monto_credito'] ?? 0);
            $presupuesto->monto_entrega = 0;
            $presupuesto->cantidad_cuotas = NULL;
            $presupuesto->monto_cuotas = NULL;
            $presupuesto->cantidad_refuerzos = NULL;
            $presupuesto->monto_refuerzo = NULL;
        } else { // Pago a crédito
            $presupuesto->precio_total = (float)($_REQUEST['monto_credito'] ?? 0);
            $presupuesto->monto_entrega = (float)($_REQUEST['monto'] ?? 0);
            $presupuesto->cantidad_cuotas = (int)($_REQUEST['cantidad_cuotas'] ?? 0);
            $presupuesto->monto_cuotas = (float)($_REQUEST['monto_cuotas'] ?? 0);
            $presupuesto->cantidad_refuerzos = (int)($_REQUEST['cantidad_refuerzos'] ?? 0);
            $presupuesto->monto_refuerzo = (float)($_REQUEST['monto_refuerzo'] ?? 0);
        }
        
        $this->model->aprobar($presupuesto);

        // Crear una nueva venta con los datos actualizados
        $venta = new Venta();
        $venta->id_presupuesto = $presupuesto->id;
        $venta->id_cliente = $presupuesto->id_cliente;
        $venta->id_vendedor = $presupuesto->id_vendedor;
        $venta->id_vehiculo = $presupuesto->id_vehiculo;
        $venta->fecha_venta = date('Y-m-d');
        $venta->metodo_pago = $presupuesto->tipo_pago;
        $venta->total = $presupuesto->precio_total;

       $venta_id = $this->venta->registrar($venta);

        // Registrar co-deudores si se proporcionaron sus datos
        if (!empty($_REQUEST['nombre_codeudor']) && !empty($_REQUEST['ci_codeudor'])) {
            $clientes = new clientes();
            $clientes->nombre_completo = $_REQUEST['nombre_codeudor'];
            $clientes->ci = $_REQUEST['ci_codeudor'];
            $clientes->nacionalidad = $_REQUEST['nacionalidad_codeudor'] ?? '';
            $clientes->direccion = $_REQUEST['direccion_codeudor'] ?? '';
            $clientes->telefono = $_REQUEST['telefono_codeudor'] ?? '';

           $this->cliente->registrar($clientes);

        //    Registrar Codeudor
            $codeudor = new codeudores();
            $codeudor->id_cliente = $clientes->id;
            $codeudor->id_venta = $venta_id;
            $codeudor->id_cliente_codeudor = $presupuesto->id_cliente;

            $this->codeudor->registrar($codeudor);
        }

        // Redireccionar a la vista de ventas
        header('Location: index.php?c=venta&a=index');
        exit;
    }
}