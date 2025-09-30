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
}
