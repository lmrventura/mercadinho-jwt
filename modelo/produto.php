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
                $sql = "SELECT * FROM produto ORDER BY id DESC LIMIT 1;"; //DESC é a abreviação de DESCENDING, cuja tradução é DECRESCENTE. LIMIT 1 resgata 1 valor, no caso apenas o último produto adicionado porque está na ordem decrescente.
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }catch(PDOEXception $e){
                echo("Error: ".$e->getMessage());
            }
        }

        public function getQuantidade($id){
            try {
                $sql = "select quantidade from produto where id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $quantidadeEstoqueProduto = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $quantidadeEstoqueProduto;
            }catch(PDOEXception $e){
                echo("Error: ".$e->getMessage());
            }
        }

        public function setQuantidade($id, $quantidade) {
            try {
                $sql = "UPDATE produto SET 
                        quantidade = :quantidade 
                        WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":quantidade", $quantidade);
                $stmt->execute();
                return $stmt;
            }catch(PDOEXception $e){
                echo("Error: ".$e->getMessage());
            }
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

        public function isProdutoCadastrado($id){
            try{
                $sql = "select id from produto where id = :id";  //validação da EXISTÊNCIA do produto ($id_produto) no banco de dados
                $stmt = $this->conn->prepare($sql);              //eu colocaria esse bloco de código na classe Produto dentro de um método isProdutoCadastrado e utilizaria o método no ctr_venda. Mas foi feito conforme foi pedido na descrição do Problema. Isso não feriria o Princípio da Responsabilidade Única (SRP) do SOLID
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result != null){
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $e){
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