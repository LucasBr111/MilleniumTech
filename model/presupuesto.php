<?php

class presupuesto
{

    private $pdo;

    public $id_cliente;
    public $id_vendedor;
    public $id_vehiculo;
    public $precio_total;
    public $monto_entrega;
    public $fecha_presupuesto;
    public $estado;
    public $cantidad_cuotas;
    public $monto_cuotas;
    public $cantidad_refuerzos;
    public $monto_refuerzo;
    public $pago;
    public $de;


    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function registrar(presupuesto $data)
    {
        try {
            $sql = "INSERT INTO presupuesto ( id_cliente, id_vendedor, id_vehiculo, precio_total, monto_entrega, fecha_presupuesto, estado, cantidad_cuotas, monto_cuotas, cantidad_refuerzos, monto_refuerzo, pago, de) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->id_cliente,
                        $data->id_vendedor,
                        $data->id_vehiculo,
                        $data->precio_total,
                        $data->monto_entrega,
                        $data->fecha_presupuesto,
                        $data->estado,
                        $data->cantidad_cuotas,
                        $data->monto_cuotas,
                        $data->cantidad_refuerzos,
                        $data->monto_refuerzo,
                        $data->pago,
                        $data->de
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtenerUltimoIdPres()
    {
        try {
            $sql = "SELECT max(id) FROM presupuesto";
    
            // 1. Prepare the statement
            $stm = $this->pdo->prepare($sql);
    
            // 2. Execute the statement
            $stm->execute();
    
            // 3. Fetch the result
            return $stm->fetchColumn();
    
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Listar(){
        try{
            $sql ="SELECT p.*, c.nombre_completo, v.nombre as 'auto_nombre', u.nombre as 'vendedor'
                    FROM presupuesto p
                    LEFT JOIN clientes c ON c.id = p.id_cliente
                    LEFT JOIN vehiculos v ON v.id = p.id_vehiculo
                    LEFT JOIN usuarios u ON u.id = p.id_vendedor

                    WHERE p.anulado IS NULL AND p.de = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);

        }catch(Exception $e){
            die($e->getMessage());
        }
    }
    public function obtener($id){
        try{
            $sql = "SELECT * FROM presupuesto WHERE id = ?";
            $stm = $this->pdo
                      ->prepare($sql);
                      

            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
    

    public function aprobar($data){
        try{
            $sql = "UPDATE presupuesto SET id_Cliente, id_vendedor, id_vehiculo, precio_total, monto_entrega, monto_entrega, fecha_presupuesto, estado, cantidad_cuotas, monto_cuotas, cantidad_refuerzos, monto_refuerzo, pago, de WHERE id = ?";
            $stm = $this->pdo
            ->prepare($sql);
            $stm->execute(array(
                $data->id_cliente,
                $data->id_vendedor,
                $data->id_vehiculo,
                $data->precio_total,
                $data->monto_entrega,
                $data->fecha_presupuesto,
                $data->estado, 
                $data->cantidad_cuotas,
                $data->monto_cuotas,
                $data->cantidad_refuerzos, 
                $data->monto_refuerzo,
                $data->pago,
                $data->de,
            ));
            return $stm->fetch(PDO::FETCH_OBJ);

        }catch(Exception $e){
            die($e->getMessage());
        }

    }
}
