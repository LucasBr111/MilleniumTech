<?php

class carrito
{
    private $pdo;
    public $id_cliente;
    public $id_producto;
    public $cantidad;

    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function guardar($data){
        try {
            $sql = "INSERT INTO carrito (id_cliente, id_producto, cantidad) VALUES (?, ?, ?)";
            $this->pdo->prepare($sql)
                ->execute(array($data->id_cliente, $data->id_producto, $data->cantidad));
            return true;
        } catch (Exception $e) {
            error_log("Error en guardar carrito: " . $e->getMessage());
            throw $e;
        }
    }

    public function contarPorCliente($id_cliente){
        try {
            $sql = "SELECT COUNT(*) as total FROM carrito WHERE id_cliente = ?";
            $this->pdo->prepare($sql)->execute(array($id_cliente));
            $result = $this->pdo->prepare($sql)->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (Exception $e) {
            error_log("Error en contar carrito: " . $e->getMessage());
            return 0;
        }
    }
}