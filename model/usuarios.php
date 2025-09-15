<?php

class usuarios {
    private $pdo;
    private $id;
    public $nombre;
    public $pass;
    public $nivel;
 
    public function __construct() {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function login($data) {
        try {
            $sql = "SELECT * FROM usuarios u 
                WHERE (u.nombre = ?) 
                AND (u.pass = ?)";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($data->nombre, 
                             $data->pass));
                             
        return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtener($pass) {
        try {
            $sql = "SELECT * FROM usuarios WHERE pass = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($pass));
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function verificarPassword($password) {
        try {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE pass = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$password]);
            return $stmt->fetchColumn() > 0; 
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtenerUsuario($id) {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);    
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
