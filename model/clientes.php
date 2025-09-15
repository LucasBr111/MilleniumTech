<?php 

class clientes{
    private $pdo;

    public $id;
    public $ci;
    public $nombre_completo;
    public $correo;
    public $telefono;
    public $direccion;
    public $nacionalidad; 
    public $creado_en;

    public function __construct(){
        try{
            $this->pdo = Database::StartUp();     
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Listar(){
        try{
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM clientes WHERE anulado IS NULL");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }



    public function Registrar(clientes $data){
        try{
            $sql = "INSERT INTO clientes (ci, nombre_completo, nacionalidad, correo, telefono, direccion, creado_en) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $this->pdo->prepare($sql)
                 ->execute(
                    array(
                        $data->ci,
                        $data->nombre_completo,
                        $data->nacionalidad,
                        $data->correo,
                        $data->telefono,
                        $data->direccion,
                        $data->creado_en
                    )
                );
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Actualizar(clientes $data){
        try{
            $sql = "UPDATE clientes SET 
                        ci = ?, 
                        nombre_completo = ?, 
                        nacionalidad = ?, 
                        correo = ?, 
                        telefono = ?, 
                        direccion = ?
                    WHERE id = ?";

            $this->pdo->prepare($sql)
                 ->execute(
                    array(
                        $data->ci,
                        $data->nombre_completo,
                        $data->nacionalidad,
                        $data->correo,
                        $data->telefono,
                        $data->direccion,
                        $data->id
                    )
                );
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtener($id){
        try{
            $stm = $this->pdo
                      ->prepare("SELECT * FROM clientes WHERE id = ?");
                      

            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function anular($id){
        try{
            $stm = $this->pdo
                      ->prepare("UPDATE clientes SET anulado = 1 WHERE id = ?");                      

            $stm->execute(array($id));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function buscarID($id){
        try{
            $sql = "SELECT * FROM clientes WHERE id = ?";
            $stm = $this->pdo->prepare($sql);
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}