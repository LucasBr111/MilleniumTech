<?php 
class envio{
    private $pdo; 

    public $id_venta;
    public $direccion_completa;
    public $departamento ;
    public $ciudad ;
    public $contacto;
    public $referencias_adicionales;

    public function __construct(){
        try{
            $this->pdo = Database::StartUp();     
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function guardar($data){
        try{
            $sql = "INSERT INTO envios (id_venta, direccion_completa, departamento, ciudad, contacto, referencias_adicionales) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                $data->id_venta,
                $data->direccion_completa,
                $data->departamento,
                $data->ciudad,
                $data->contacto,
                $data->referencias_adicionales
            ]);
        }catch(Exception $e){
            die($e->getMessage());
        

        }
    }
}