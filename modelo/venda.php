<?php
    require_once 'conexao.php';
    require_once 'produto.php';

    class Venda extends Produto {
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

        public function getVenda() {
            try {
                $sql = "SELECT * FROM venda ORDER BY id DESC LIMIT 1;";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }catch(PDOEXception $e){
                echo("Error: ".$e->getMessage());
            }
        }
        
        public function setVenda( $id_produto, $quantidade){ 
            try{
                $sql = "insert into venda(id_produto, quantidade)
                values(:id_produto, :quantidade)";  //registro da venda no banco de dados após validação.
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

        public function editarVenda($id_produto, $quantidade, $id){
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