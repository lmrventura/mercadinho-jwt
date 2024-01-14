<?php
    require_once '../modelo/venda.php';
    $objVenda = new Venda();

    if(isset($_POST['insert'])){
        $id_produto = $_POST['txtIdProduto'];
        $quantidade = $_POST['txtQuantidade'];
        if($objVenda->insert($id_produto, $quantidade)){
            $objVenda->redirect('../venda.php');
        }
    }

    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        if($objVenda->deletar($id)){
            $objVenda->redirect('../venda.php');
        }
    }

    if(isset($_POST['editar'])){
        $id = $_POST['editar'];
        $id_produto = $_POST['txtIdProduto'];
        $quantidade = $_POST['txtQuantidade'];

        if($objVenda->editar($id_produto, $quantidade, $id)){ //if($objVenda->editar($nome, $cpf, $login, $senha, $id)){
            $objVenda->redirect('../venda.php');
        }
    }

?>