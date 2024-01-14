<?php
    require_once 'conexao.php';

    class Produto{
        public $nome;
        public $preco;
        public $quantidade;
        
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
        
        public function getProduto() {
            try {
                $sql = "SELECT * FROM produto ORDER BY id DESC LIMIT 1;";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }catch(PDOEXception $e){
                echo("Error: ".$e->getMessage());
            }
        }

        public function updateProduto($quantidadeVendida, $id){
            $sql = "update";
        }
        
        public function visualizarProtudos() {
            try {
                $sql = "SELECT * FROM produto ORDER BY id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }catch(PDOEXception $e){
                echo("Error: ".$e->getMessage());
            }
        }
        
        public function setProduto($data){ //$nome, $quantidade, $preco - Create
            try{
                $this->nome = $data["nome"];
                $this->preco = $data["preco"];
                $this->quantidade = $data["quantidade"];

                $sql = "insert into produto(nome, quantidade, preco)
                        values(:nome, :quantidade, :preco)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":nome", $this->nome);
                $stmt->bindParam(":quantidade", $this->quantidade);
                $stmt->bindParam(":preco", $this->preco);
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
                $sql = "delete from produto where id = :id";
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

        public function editar($nome, $quantidade, $preco, $id){ 
            try{
                $sql = "UPDATE produto SET
                        nome = :nome,
                        quantidade = :quantidade,
                        preco = :preco
                        WHERE id = :id";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":nome", $nome);
                $stmt->bindParam(":quantidade", $quantidade);
                $stmt->bindParam(":preco", $preco);
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