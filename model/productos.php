<?php
class Productos
{
    private $pdo;
    public $id_producto;
    public $nombre_producto;
    public $descripcion;
    public $precio;
    public $stock;
    public $id_categoria;
    public $marca;
    public $destacado;
    public $imagen;
    public $promo_desde;
    public $promo_hasta;
    public $fecha_creacion;


    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    // ======================
    // Registrar
    // ======================
    public function Registrar(Productos $data)
    {
        try {
            $sql = "INSERT INTO productos (
                        nombre_producto,
                        marca,
                        descripcion,
                        precio,
                        stock,
                        destacado,
                        promo_desde,
                        promo_hasta,
                        id_categoria,
                        imagen,
                        fecha_creacion
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->nombre_producto,
                        $data->marca,
                        $data->descripcion,
                        $data->precio,
                        $data->stock,
                        $data->destacado,
                        $data->promo_desde,
                        $data->promo_hasta,
                        $data->id_categoria,
                        $data->imagen,
                        $data->fecha_creacion
                    )
                );

            return $this->pdo->lastInsertId();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // ======================
    // Actualizar
    // ======================
    public function Actualizar(Productos $data)
    {
        try {
            $sql = "UPDATE productos SET 
                        nombre_producto = ?, 
                        marca = ?, 
                        descripcion = ?, 
                        precio = ?, 
                        stock = ?, 
                        destacado = ?, 
                        promo_desde = ?, 
                        promo_hasta = ?, 
                        id_categoria = ?, 
                        imagen = ?
                    WHERE id_producto = ?";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->nombre_producto,
                        $data->marca,
                        $data->descripcion,
                        $data->precio,
                        $data->stock,
                        $data->destacado,
                        $data->promo_desde,
                        $data->promo_hasta,
                        $data->id_categoria,
                        $data->imagen,
                        $data->id_producto
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // ======================
    // Obtener por ID
    // ======================
    public function Obtener($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // ======================
    // Listar todos colocarle like por cliente
    // ======================
    public function Listar($id_cliente = null)
    {
        try {
            if ($id_cliente !== null) {
                // Si hay cliente → traer favoritos de ese cliente
                $sql = "SELECT p.*, f.id AS es_favorito
                        FROM productos p
                        LEFT JOIN favoritos f 
                            ON f.id_producto = p.id_producto 
                           AND f.id_cliente = ?";
                $stm = $this->pdo->prepare($sql);
                $stm->execute([$id_cliente]);
            } else {
                // Si no hay cliente logueado → no traer favoritos
                $sql = "SELECT p.* 
                        FROM productos p";
                $stm = $this->pdo->prepare($sql);
                $stm->execute();
            }

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    // ======================
    // Eliminar
    // ======================
    public function Eliminar($id)
    {
        try {
            $stm = $this->pdo->prepare("DELETE FROM productos WHERE id_producto = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ProductosDestacados($id_cliente = null)
    {
        try {
            if ($id_cliente !== null) {
                // Si hay un cliente, une las tablas de favoritos y carrito.
                $sql = "SELECT 
                            p.*,
                            CASE WHEN f.id IS NOT NULL THEN TRUE ELSE FALSE END AS es_favorito,
                            CASE WHEN c.id_producto IS NOT NULL THEN TRUE ELSE FALSE END AS en_carrito
                        FROM productos p
                        LEFT JOIN favoritos f 
                            ON f.id_producto = p.id_producto AND f.id_cliente = :id_cliente
                        LEFT JOIN carrito c
                            ON c.id_producto = p.id_producto AND c.id_cliente = :id_cliente
                        WHERE p.destacado = 1";

                $stm = $this->pdo->prepare($sql);
                $stm->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
                $stm->execute();
            } else {
                // Si no hay cliente, simplemente trae los productos destacados sin información de favoritos o carrito.
                $sql = "SELECT p.*,
                               FALSE AS es_favorito,
                               FALSE AS en_carrito
                        FROM productos p
                        WHERE p.destacado = 1";

                $stm = $this->pdo->prepare($sql);
                $stm->execute();
            }

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage()); 
        }
    }
    public function RegistrarImagenGaleria($id_producto, $ruta_imagen)
    {
        try {
            $sql = "INSERT INTO producto_imagenes (id_producto, ruta_imagen) VALUES (?, ?)";
            $this->pdo->prepare($sql)
                ->execute(array($id_producto, $ruta_imagen));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
