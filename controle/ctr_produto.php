<?php
    require_once '../modelo/produto.php';
    $objProduto = new Produto();
    
    if(isset($_POST['setProduto'])){
        //assiciative array use named keys that you assign to them
        $data = array(
            "nome" => $_POST['txtNome'],
            "quantidade" => $_POST['txtQuantidade'],
            "preco" => $_POST['txtPreco']
        );// Conforme solicitado "A classe Produto deve conter um método setProduto, que terá um parâmetro chamado data, representando um array contendo informações como nome, preço e quantidade." Os dados do POST são provenientes da View
        
        if($objProduto->setProduto($data)){ //
            $objProduto->redirect('../produto.php');
        }
    }

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