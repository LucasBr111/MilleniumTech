<?php class clientes
{
    private $pdo;
    public $id;
    public $nombre;
    public $email;
    public $ci;
    public $telefono;
    public $password;
    public $nivel;

    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function login($data)
    {
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

    public function obtener($email)
    {
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


    public function verificarEmail($email)
    {
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

    public function obtenerUsuario($id)
    {
        try {
            $sql = "SELECT 
        c.*,
        v.direccion_envio as direccion,
        COALESCE(p.puntos, 0) as puntos,
        COUNT(DISTINCT v.id_venta) AS total_compras,
        COUNT(DISTINCT CASE WHEN v.estado_pago = 'pendiente' THEN v.id_venta END) AS compras_pendientes
        FROM clientes c
        LEFT JOIN puntos p ON p.id_cliente = c.id
        LEFT JOIN ventas v ON v.id_cliente = c.id
        WHERE c.id = ?
        GROUP BY c.id, c.nombre;
        ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function registrar($data)
    {
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
    public function actualizar($data)
    {
        try {
            $sql = "UPDATE clientes SET 
                    nombre = ?, 
                    email = ?, 
                    ci = ?, 
                    telefono = ?, 
                    password = ?
                    WHERE id = ?";
            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->nombre,
                        $data->email,
                        $data->ci,
                        $data->telefono,
                        $data->password,
                        $data->id
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // obtener puntos del cliente 
    public function obtenerPuntos($id_cliente)
    {
        try {
            $sql = "SELECT sum(puntos) as total FROM puntos WHERE id_cliente = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_cliente]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? (int)$result->total : 0;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function listarpuntos($id_cliente)
    {
        try {
            $sql = "SELECT * FROM puntos WHERE id_cliente = ? ORDER BY fecha_obtencion DESC LIMIT 10";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_cliente]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function restarPuntos($id_cliente, $puntos_a_restar)
{
    try {
        // El valor de los puntos debe ser NEGATIVO para descontar
        $puntos_descontados = -$puntos_a_restar; 
        
        $sql = "INSERT INTO puntos (id_cliente, puntos, fecha_obtencion, descripcion) 
                VALUES (?, ?, NOW(), 'Redencion de puntos')";
        $stmt = $this->pdo->prepare($sql);
        // Orden de parámetros: 1. id_cliente, 2. puntos_descontados
        $stmt->execute([$id_cliente, $puntos_descontados]); 
    } catch (Exception $e) {
        // Usar manejo de errores seguro, no die()
        error_log("Error al restar puntos: " . $e->getMessage());
        throw $e;
    }
}
public function contarClientes(){
    try {
        $sql = "SELECT COUNT(*) as total FROM clientes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? (int)$result->total : 0;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

public function listar()
{
    try {
        $result = array();

        $stm = $this->pdo->prepare("SELECT * FROM clientes");
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
}
