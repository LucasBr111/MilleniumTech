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
    public $precio_promo;


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
                        fecha_creacion, 
                        precio_promo
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
                        $data->fecha_creacion,
                        $data->precio_promo
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
                        imagen = ?,
                        precio_promo = ?
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
                        $data->precio_promo,
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
    public function ListarPorCategoria($id_categoria, $filtro = null, $terminoBusqueda = null)
    {

        $sql = "SELECT p.*, c.nombre_categoria
                FROM productos AS p
                LEFT JOIN categorias AS c ON p.id_categoria = c.id_categoria
                WHERE p.id_categoria = :id_categoria AND p.stock > 0";

        $params = [':id_categoria' => $id_categoria];

        // Añadir cláusula de búsqueda si existe
        if ($terminoBusqueda) {
            $sql .= " AND p.nombre_producto LIKE :termino";
            $params[':termino'] = '%' . $terminoBusqueda . '%';
        }

        // Añadir cláusula de ordenamiento
        switch ($filtro) {
            case 'precio_asc':
                $sql .= " ORDER BY p.precio ASC";
                break;
            case 'precio_desc':
                $sql .= " ORDER BY p.precio DESC";
                break;
            case 'nombre_asc':
                $sql .= " ORDER BY p.nombre_producto ASC";
                break;
            case 'nombre_desc':
                $sql .= " ORDER BY p.nombre_producto DESC";
                break;
            default:
                $sql .= " ORDER BY p.id_producto DESC"; // Orden por defecto
                break;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarOfertas($filtro = null, $terminoBusqueda = null)
    {
        $params = [];
        $sql = "SELECT 
                p.*, 
                p.precio as precio_normal,
                CASE
                    WHEN p.promo_desde <= CURDATE() AND p.promo_hasta >= CURDATE()
                    THEN p.precio_promo
                    ELSE p.precio
                END AS precio,
                CASE
                    WHEN p.promo_desde <= CURDATE() AND p.promo_hasta >= CURDATE()
                    THEN TRUE
                    ELSE FALSE
                END AS en_promocion
            FROM productos AS p
            WHERE p.stock > 0";
        $sql .= " AND p.promo_desde <= CURDATE() AND p.promo_hasta >= CURDATE()";

        $sql .= " AND p.promo_desde IS NOT NULL AND p.promo_hasta IS NOT NULL";

        if ($terminoBusqueda) {
            $sql .= " AND p.nombre_producto LIKE :termino";
            $params[':termino'] = '%' . $terminoBusqueda . '%';
        }

        switch ($filtro) {
            case 'precio_asc':

                $sql .= " ORDER BY precio ASC";
                break;
            case 'precio_desc':

                $sql .= " ORDER BY precio DESC";
                break;

            default:
                $sql .= " ORDER BY p.id_producto DESC"; // Orden por defecto
                break;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
