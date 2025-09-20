<?php class clientes {
    private $pdo;
    private $id;
    public $nombre;
    public $email;
    public $password;
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
            $sql = "SELECT * FROM clientes 
                WHERE email = ? 
                AND password = ?";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($data->email, $data->password));
                             
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            throw $e;
        }
    }

    public function obtener($email) {
        try {
            $sql = "SELECT * FROM clientes WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($email));
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error en obtener: " . $e->getMessage());
            throw $e;
        }
    }


    public function verificarEmail($email) {
        try {
            $sql = "SELECT COUNT(*) FROM clientes WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();
            
            // Debug: imprimir información de la consulta
            error_log("Verificando email: $email, Resultado: $count");
            
            return $count > 0; 
        } catch (Exception $e) {
            error_log("Error en verificarEmail: " . $e->getMessage());
            throw $e; // Re-lanzar la excepción para que el controlador la maneje
        }
    }

    public function obtenerUsuario($id) {
        try {
            $sql = "SELECT * FROM clientes WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);    
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function registrar($data) {
        try {
            $sql = "INSERT INTO clientes (nombre, email, password, nivel) 
                    VALUES (?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                 ->execute(
                    array(
                        $data->nombre,
                        $data->email,
                        $data->password,
                        $data->nivel
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}   