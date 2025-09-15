<?php 
class cuotas{
    private $pdo;

    public $id;
    public $id_presupuesto;
    public $id_usuario;
    public $id_cliente;
    public $monto;
    public $monto_pagado;
    public $fecha_pago;
    public $tipo_pago;

    public function __construct(){
        try{
            $this->pdo = Database::StartUp();     
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Registrar(cuotas $data){
        try{
            $sql = "INSERT INTO cuotas (id_presupuesto, id_usuario, id_cliente, monto, monto_pagado, fecha_pago, tipo_pago) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                 ->execute(
                    array(
                        $data->id_presupuesto,
                        $data->id_usuario,
                        $data->id_cliente,
                        $data->monto,
                        $data->monto_pagado,
                        $data->fecha_pago,
                        $data->tipo_pago
                    )
                );
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}