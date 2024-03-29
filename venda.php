<?php
    require_once 'modelo/venda.php'; 
    require_once 'modelo/produto.php';

    $objVenda = new Venda(); //criei um objeto do PRODUTO, chamando a classe modelo do PRODUTO que tem validar, editar, runQueery etc PRESENTE EM MODELO
    $objProduto = new Produto();

    $retornoProduto = $objProduto->visualizarProtudos(); //visualizarProtudos
    $retornoUltimaVenda = $objVenda->getVenda(); //implementação do método solicitado.
    $vendas = $objVenda->getAllVendas();
    // var_dump($retornoProduto);
    //var_dump($retornoUltimaVenda);
    //$validacaoProduto = $objVenda->isProdutoCadastrado(9);
    // die;
    // $calcVenda = $objVenda->getTotalVenda(3);
    // $valorString = $calcVenda[0]["f_getTotalVenda('3')"];
    // var_dump($valorString);
    // die;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>HBV</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="css/nav.css"> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="header">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="before"></div>
    <input type="checkbox" id="check" class="d-none">
    <label for="check" class="navbar-toggler checkbtn" data-toggle="collapse" data-target="#menu">
        &#9776;
    </label>

    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="produto.php" target="">Produto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="venda.php">Venda</a>
            </li>
        </ul>
    </div>
</nav>
</div>
<div class="container">
    <br>
    <br>
    <br>
  <div class="row">
      <h3>Venda</h3>
      <table class="table table-striped">            
            <thead>  
                <tr>
                    <th colspan="5">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalCadastrar">Novo</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalUltimaVenda">Última Venda Cadastrada</button>
                    </th>
                </tr>              
                <tr>
                    <th>Id Venda</th>
                    <th>Id Produto</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>                
            </thead>
            <tbody>
                <?php
                    foreach($vendas as $venda){
                ?>
                        <tr>
                            <td><?php echo($venda['id']) ?></td>
                            <td><?php echo($venda['id_produto']) ?></td>
                            <td><?php echo($venda['quantidade']) ?></td>
                            <td><?php 
                                    echo($objVenda->getTotalVenda($venda['quantidade'])); 
                                ?>
                            </td><!-- $objVenda->getTotalVenda($venda['id_produto'])[0]["f_getTotalVenda('2')"] -->
                            <td> 
                              <button type="button" class="btn btn-info"
                                  data-toggle="modal" data-target="#myModalEditar"
                                  data-id="<?php echo($venda['id']) ?>"
                                  data-id_produto="<?php echo($venda['id_produto']) ?>"
                                  data-quantidade="<?php echo($venda['quantidade']) ?>">
                                  Editar
                              </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger"
                                    data-toggle="modal" data-target="#myModalDeletar"
                                    data-id="<?php echo($venda['id']) ?>"
                                >
                                        Deletar
                                </button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
            </tbody>
      </table>
  </div>
</div>

<!-- The Modal Cadastrar-->
<div class="modal" id="myModalCadastrar">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: black; color:white">
        <h4 class="modal-title">Cadastrar Venda</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <form action="controle/ctr_venda.php" method="POST">
                <input type="hidden" name="insert">
                <div class="form-group">
                    <label for="">Produto</label>
                    <input type="text" class="form-control" name="txtIdProduto" required>
                </div>
                <div class="form-group">
                    <label for="">Quantidade</label>
                    <input type="text" class="form-control" name="txtQuantidade" required>
                </div>
                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- The Modal Última Venda-->
<div class="modal" id="myModalUltimaVenda">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: black; color:white">
        <h4 class="modal-title">Última Venda</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>
    
      <!-- Modal body -->
        <div class="modal-body">
            <?php
                foreach($retornoUltimaVenda as $v) {
                  echo "idVenda: " . $v["id"]. 
                  " <br> IdProduto: " . $v["id_produto"]. 
                  " <br> Quantidade: " . $v["quantidade"]. 
                  "<br>";//. " - Preço " . $v["preco"]. "<br>";
              }
            ?>
        </div>
    </div>
  </div>
</div>

<!-- The Modal Deletar-->
<div class="modal" id="myModalDeletar">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: black; color:white">
        <h4 class="modal-title">Deletar Venda</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <form action="controle/ctr_venda.php" method="POST">
                <input type="hidden" name="delete" id="recipient-id"> 
                <div class="form-group">
                    <label for="">ID</label>
                    <input type="text" class="form-control" name="txtIdVenda" id="recipient-idvenda" readonly>
                </div>
                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
      </div>
    </div>
  </div>
</div>


<!-- The Modal Editar-->
<div class="modal" id="myModalEditar">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: black; color:white">
        <h4 class="modal-title">Editar Venda</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <form action="controle/ctr_venda.php" method="POST">
                <input type="hidden" name="editar" id="recipient-id">
                <div class="form-group">
                    <label for="">ID Produto</label>
                    <input type="text" class="form-control" name="txtIdProduto" id="recipient-idproduto">
                </div>
                <div class="form-group">
                    <label for="">Quantidade</label>
                    <input type="text" class="form-control" name="txtQuantidade" id="recipient-quantidade">
                </div>
                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
      </div>
    </div>
  </div>
</div>


</div>
</div>

<script>
    $('#myModalDeletar').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var recipientId = button.data('id');

        var modal = $(this) 
        modal.find('#recipient-id').val(recipientId);
    })
</script>

<script>
    $('#myModalEditar').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var recipientId = button.data('id')
        var recipientIdProduto = button.data('id_produto')
        var recipientQuantidade = button.data('quantidade')
        
        var modal = $(this)
        modal.find('#recipient-id').val(recipientId)
        modal.find('#recipient-idproduto').val(recipientIdProduto)
        modal.find('#recipient-quantidade').val(recipientQuantidade)
    })
</script>

</body>
</html>