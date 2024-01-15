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

        public function getAllVendas(){
            $query = "select * from venda";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $vendas;
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

        public function getTotalVenda($id_venda) {
            $sql = "SELECT f_getTotalVenda(:id_venda);";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id_venda", $id_venda);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $string = $result[0]["f_getTotalVenda('$id_venda')"];;
            return $string;
        }
        public function getValorTotalDaVenda($id_venda) {
            try {
                $sql = "CREATE FUNCTION f_getTotalVenda(id_venda INT)
                        RETURNS DECIMAL(10, 2)
                        BEGIN
                            DECLARE total DECIMAL(10, 2);
                            SELECT ve.quantidade * pro.preco INTO total
                            FROM venda ve
                            INNER JOIN produto pro ON pro.id = ve.id_produto
                            WHERE ve.id = id_venda;
                        
                            RETURN total;
                        end";
                $this->conn->exec($sql);//Execução da query que contém a declaração da função
        
                // Agora, você pode chamar a função normalmente em uma nova query
                //$sql = "SELECT f_getTotalVenda(:id_venda) as total";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id_venda", $id_venda, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch(PDOException $e) {
                echo("Error: ".$e->getMessage());
            }
        }
    }
    
?>