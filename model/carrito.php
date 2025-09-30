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
            // Primero verificar si el producto ya existe en el carrito
            $sql_check = "SELECT cantidad FROM carrito WHERE id_cliente = ? AND id_producto = ?";
            $stmt_check = $this->pdo->prepare($sql_check);
            $stmt_check->execute(array($data->id_cliente, $data->id_producto));
            $existing = $stmt_check->fetch(PDO::FETCH_OBJ);
            
            if ($existing) {
                // Si ya existe, actualizar la cantidad
                $new_quantity = $existing->cantidad + $data->cantidad;
                $sql_update = "UPDATE carrito SET cantidad = ? WHERE id_cliente = ? AND id_producto = ?";
                $this->pdo->prepare($sql_update)
                    ->execute(array($new_quantity, $data->id_cliente, $data->id_producto));
            } else {
                // Si no existe, insertarlo
                $sql = "INSERT INTO carrito (id_cliente, id_producto, cantidad) VALUES (?, ?, ?)";
                $this->pdo->prepare($sql)
                    ->execute(array($data->id_cliente, $data->id_producto, $data->cantidad));
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error en guardar carrito: " . $e->getMessage());
            throw $e;
        }
    }

    public function contarPorCliente($id_cliente){
        try {
            $sql = "SELECT COUNT(*) as total FROM carrito WHERE id_cliente = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($id_cliente));
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (Exception $e) {
            error_log("Error en contar carrito: " . $e->getMessage());
            return 0;
        }
    }
    public function eliminar($id_cliente, $id_producto)
    {
        try {
            $sql = "DELETE FROM carrito WHERE id_cliente = ? AND id_producto = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($id_cliente, $id_producto));
            
            // Verificar si se eliminó algún registro
            if ($stmt->rowCount() === 0) {
                throw new Exception("El producto no estaba en tus carrito");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error en eliminar favorito: " . $e->getMessage());
            throw $e;
        }
    }
    public function limpiar($id_cliente){
        try{
            $sql = "DELETE FROM carrito WHERE id_cliente = ?";
            $this->pdo->prepare($sql)
                 ->execute(array($id_cliente));
        } catch (Exception $e) {
            error_log("Error en limpiar carrito: " . $e->getMessage());
            throw $e;
        }
    }

    public function actualizarCantidad($id_cliente, $id_producto, $cantidad){
        try {
            if ($cantidad <= 0) {
                // Si la cantidad es 0 o menor, eliminar el producto
                return $this->eliminar($id_cliente, $id_producto);
            }
            
            $sql = "UPDATE carrito SET cantidad = ? WHERE id_cliente = ? AND id_producto = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($cantidad, $id_cliente, $id_producto));
            
            if ($stmt->rowCount() === 0) {
                throw new Exception("El producto no estaba en tu carrito");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error en actualizar cantidad: " . $e->getMessage());
            throw $e;
        }
    }
    public function listarProductoscarrito($id_cliente)
    {
        try {
            $sql = "SELECT 
                        p.*, 
                        c.cantidad,
                        CASE
                            WHEN p.promo_desde IS NOT NULL 
                                 AND p.promo_hasta IS NOT NULL
                                 AND NOW() >= p.promo_desde 
                                 AND NOW() <= p.promo_hasta
                            THEN p.precio_promo -- Aplicar el precio de promoción
                            -- Si no hay promoción activa, usar el precio normal
                            ELSE p.precio 
                        END AS precio_final 
                    FROM productos p
                    LEFT JOIN carrito c ON p.id_producto = c.id_producto
                    WHERE c.id_cliente = ?";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($id_cliente));
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error en listar productos del carrito: " . $e->getMessage());
            return [];
        }
    }
}