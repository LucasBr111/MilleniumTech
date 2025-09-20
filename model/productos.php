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


    public function __construct(){
        try{
            $this->pdo = Database::StartUp();     
        }catch(Exception $e){
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
    // Listar todos
    // ======================
    public function Listar()
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM productos");
            $stm->execute();
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
    
    public function ProductosDestacados() {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM productos WHERE destacado = 1");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
        
    }
    public function RegistrarImagenGaleria($id_producto, $ruta_imagen) {
        try {
            $sql = "INSERT INTO producto_imagenes (id_producto, ruta_imagen) VALUES (?, ?)";
            $this->pdo->prepare($sql)
                ->execute(array($id_producto, $ruta_imagen));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
