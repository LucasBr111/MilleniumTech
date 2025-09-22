<?php

class favoritos
{
    private $pdo;
    public $id_cliente;
    public $id_producto;

    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function registrar($id_cliente, $id_producto)
    {
        try {
            // Primero verificar si ya existe el favorito
            $sql_check = "SELECT COUNT(*) FROM favoritos WHERE id_cliente = ? AND id_producto = ?";
            $stmt_check = $this->pdo->prepare($sql_check);
            $stmt_check->execute(array($id_cliente, $id_producto));
            $exists = $stmt_check->fetchColumn() > 0;

            if ($exists) {
                throw new Exception("Este producto ya está en tus favoritos");
            }

            // Si no existe, insertarlo
            $sql = "INSERT INTO favoritos (id_cliente, id_producto) VALUES (?, ?)";
            $this->pdo->prepare($sql)
                ->execute(array($id_cliente, $id_producto));

            return true;
        } catch (Exception $e) {
            error_log("Error en registrar favorito: " . $e->getMessage());
            throw $e;
        }
    }

    public function eliminar($id_cliente, $id_producto)
    {
        try {
            $sql = "DELETE FROM favoritos WHERE id_cliente = ? AND id_producto = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($id_cliente, $id_producto));
            
            // Verificar si se eliminó algún registro
            if ($stmt->rowCount() === 0) {
                throw new Exception("El producto no estaba en tus favoritos");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error en eliminar favorito: " . $e->getMessage());
            throw $e;
        }
    }

    public function listarProductosFavoritos($id_cliente)
    {
        try {
            $sql = "SELECT p.* FROM favoritos f
                    LEFT JOIN productos p ON p.id_producto = f.id_producto
                    WHERE f.id_cliente = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_cliente]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function contarPorCliente($id_cliente){
        try {
            $sql = "SELECT COUNT(*) as total FROM favoritos WHERE id_cliente = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($id_cliente));
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (Exception $e) {
            error_log("Error en contar favoritos: " . $e->getMessage());
            return 0;
        }
    }

    public function limpiar($id_cliente){
        try{
            $sql = "DELETE FROM favoritos WHERE id_cliente = ?";
            $this->pdo->prepare($sql)
                 ->execute(array($id_cliente));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
