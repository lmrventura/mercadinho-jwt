<?php
    require_once '../modelo/produto.php';
    $objProduto = new Produto();
    
    if(isset($_POST['setProduto'])){
        //assiciative array use named keys that you assign to them
        $data = array(
            "nome" => $_POST['txtNome'],
            "quantidade" => $_POST['txtQuantidade'],
            "preco" => $_POST['txtPreco']
        );
        
        if($objProduto->setProduto($data)){ // if($this->objProduto->setProduto($data)){  ---- Uncaught Error: Using $this when not in object context in C:\xampp\htdocs\mercadinho-jwt\controle\ctr_produto.php:13 Stack trace: #0 {main} thrown in C:\xampp\htdocs\mercadinho-jwt\controle\ctr_produto.php on line 13
            $objProduto->redirect('../produto.php');
        }
    }
/*

    if(isset($GET['getProduto'])){
        $id = $GET['getProduto'];
        $nome = $GET['txtNome'];
        $quantidade = $GET['txtQuantidade'];
        $preco = $GET = ['txtPreco'];
        if($objProduto->getProduto($id, $nome, $quantidade, $preco)){
            $objProduto->redirect('../produto.php');
        }
    }
*/

    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        if($objProduto->deletar($id)){
            $objProduto->redirect('../produto.php');
        }
    }

    if(isset($_POST['editar'])){
        $id = $_POST['editar'];
        $nome = $_POST['txtNome'];
        $quantidade = $_POST['txtQuantidade'];
        $preco = $_POST['txtPreco'];
        if($objProduto->editar($nome, $quantidade, $preco, $id)){
            $objProduto->redirect('../produto.php');
        }
    }
?>