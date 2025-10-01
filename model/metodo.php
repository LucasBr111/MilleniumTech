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

    public function lisarConIngresos(){
        try{
            $result = array();

            $stm = $this->pdo->prepare("SELECT m.nombre, COUNT(v.metodo_pago) AS total_ventas, SUM(v.total) AS ingresos_totales
            FROM metodos_pago m
            LEFT JOIN ventas v ON m.id = v.metodo_pago
            GROUP BY m.id");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
}
}