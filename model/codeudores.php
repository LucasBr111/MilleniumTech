<?php

class codeudores
{
    private $pdo;

    public $id_venta;
    public $id_cliente;
    public $id_cliente_codeudor;

    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function registrar($data)
    {
        try {
            $sql = "INSERT INTO codeudores(id_cliente, id_cliente_codeudor, id_venta) VALUES(?, ?, ?)";
            $this->pdo->prepare($sql);
            $this->pdo->prepare($sql)
            ->execute(array($data->id_cliente, $data->id_cliente_codeudor, $data->id_venta));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
