<?php 


class categorias{
    private $pdo; 

    public $id_categoria; 
    public $nombre_categoria;
    public $imagen;
    public $descripcion;
    public $icono;

    public function __construct()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function listar(){
        try{
            $stm = $this->pdo->prepare("SELECT * FROM categorias");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Registrar(Categorias $data)
    {
        try {
            $sql = "INSERT INTO categorias (nombre_categoria, descripcion, imagen) VALUES (?, ?, ?)";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->nombre_categoria,
                        $data->descripcion,
                        $data->imagen
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function Actualizar(Categorias $data)
    {
        try {
            $sql = "UPDATE categorias SET
                        nombre_categoria        = ?,
                        descripcion  = ?,
                        imagen                  = ?
                    WHERE id_categoria = ?";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->nombre_categoria,
                        $data->descripcion,
                        $data->imagen,
                        $data->id_categoria
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function obtener($id){
        try{
            $stm = $this->pdo->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
    

    public function contarProductosPorCategoria($id_categoria){
        try{
            $stm = $this->pdo->prepare("SELECT COUNT(*) as total FROM productos WHERE id_categoria = ?");
            $stm->execute(array($id_categoria));
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return $result ? $result->total : 0;
          
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}