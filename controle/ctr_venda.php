<?php
    require_once '../modelo/produto.php';
    require_once '../modelo/venda.php';
    $objVenda = new Venda();
    $objProduto = new Produto();

    if(isset($_POST['insert'])){
        $id_produto = $_POST['txtIdProduto'];
        $quantidade = $_POST['txtQuantidade'];

        $quantidadeEstoqueProduto = $objProduto->getQuantidade($id_produto); //resgata a quantidade de produtos do banco
        $quantidadeEstoque = $quantidadeEstoqueProduto[0]["quantidade"]; //transforma em inteiro

        if($objProduto->isProdutoCadastrado($id_produto)){    
            if($quantidadeEstoque >= $quantidade){
                $novaQuantidadeDoEstoque = $quantidadeEstoque - $quantidade;
                $objProduto->setQuantidade($id_produto, $novaQuantidadeDoEstoque);
                if($objVenda->setVenda($id_produto, $quantidade)){
                    $objVenda->redirect('../venda.php');
                }
            }else{
                $objVenda->redirect('../venda.php');
            }
        }else{
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

        if($objVenda->editarVenda($id_produto, $quantidade, $id)){ //if($objVenda->editar($nome, $cpf, $login, $senha, $id)){
            $objVenda->redirect('../venda.php');
        }
    }

?>