<?php 
class metodo{
    private $pdo; 

    public $metodo;

    public function __construct(){
        try{
            $this->pdo = Database::StartUp();     
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
    public function listar(){
        try{
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM metodos_pago");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}