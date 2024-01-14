<?php
    require_once 'conexao.php';

    class Venda {
        public $quantidade;
        public $desconto;
        
        private $conn;

        public function __construct()
        {
            $dataBase = new dataBase();
            $db = $dataBase->dbConnection();
            $this->conn = $db;
        }

        public function runQuery($sql){
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }
        
        public function getVenda(){
            
        }

        public function insert( $id_produto, $quantidade){ 
            try{
                $sql = "insert into venda(id_produto, quantidade)
                        values(:id_produto, :quantidade)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id_produto", $id_produto);
                $stmt->bindParam(":quantidade", $quantidade);
                $stmt->execute();
                return $stmt;
            }catch(PDOException $e){
                echo("Error: ".$e->getMessage());
            }finally{
                $this->conn = null;
            }
        }

        public function deletar($id){
            try{
                $sql = "delete from venda where id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                return $stmt;
            }catch(PDOException $e){
                echo("Error: ".$e->getMessage());
            }finally{
                $this->conn = null;
            }
        }

        public function editar($id_produto, $quantidade, $id){
            //15 minutos
            try{
                $sql = "UPDATE venda SET
                        id_produto = :id_produto,
                        quantidade = :quantidade
                        WHERE id = :id";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id_produto", $id_produto);
                $stmt->bindParam(":quantidade", $quantidade);
                $stmt->bindParam(":id", $id);

                $stmt->execute();
                return $stmt;

            }catch(PDOException $e){
                echo("Error: ".$e->getMessage());
            }finally{
                $this->conn = null;
            }
        }
    
        public function redirect($url){
            header("Location: $url");
        }

    }
    
?>