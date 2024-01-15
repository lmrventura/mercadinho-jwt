<?php
    require_once '../modelo/produto.php';
    require_once '../modelo/venda.php';
    $objVenda = new Venda();
    $objProduto = new Produto();

    if(isset($_POST['insert'])){
        
        $id_produto = $_POST['txtIdProduto'];
        $quantidade = $_POST['txtQuantidade'];

        $quantidadeEstoqueProduto = $objProduto->getQuantidade($id_produto); //resgata a quantidade de produtos do banco com o parâmetro $id_produto que foi obtido $_POST['txtIdProduto']; presente no input do modal cadastrar.
        $quantidadeEstoque = $quantidadeEstoqueProduto[0]["quantidade"]; //transforma em inteiro, resgatando apenas o valor inteiro da quantidade presente no array array(1) { [0]=> array(1) {  ["quantidade"]=>int(0)}}

        if($objProduto->isProdutoCadastrado($id_produto)){ //verifica se existe algum produto cadastrado com o $id_produto
            if($quantidadeEstoque >= $quantidade){  //verifica se a quantidade de produtos da venda emitida pela view é maior ou igual a quantidade presente no estoque
                $novaQuantidadeDoEstoque = $quantidadeEstoque - $quantidade; // atualizando o valor do estoque após a venda, subtraindo o valor do banco obtido com o$quantidade vindo da VIEW
                $objProduto->setQuantidade($id_produto, $novaQuantidadeDoEstoque);  //UPDATE na entidade de PRODUTOS do banco 
                if($objVenda->setVenda($id_produto, $quantidade)){ // INSERT/   ******setVenda******  da tupla
                    $objVenda->redirect('../venda.php');
                }
            }else{
                $objVenda->redirect('../venda.php'); //se o if retornar falso ele redireciona para a página sem executar a instrução dentro do if
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

        if($objVenda->editarVenda($id_produto, $quantidade, $id)){
            $objVenda->redirect('../venda.php');
        }
    }

?>