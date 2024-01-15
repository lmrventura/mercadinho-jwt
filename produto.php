<?php
    require_once 'modelo/produto.php';
    $objProduto = new Produto();

    $returnoProduto = $objProduto->getProduto();
    // var_dump($returnoProduto);
    // $testGetQuantidade = $objProduto->getQuantidade(6);
    // var_dump($testGetQuantidade);
    // // die;
    $products = $objProduto->getAllProducs();
    // var_dump($products);
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
      <h3>Produtos</h3>
      <table class="table table-striped">            
            <thead>  
                <tr>
                    <th colspan="5">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalCadastrar">Novo</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalUltimoProduto">Último Produto Cadastrado</button>
                    </th>
                </tr>              
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Preco</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>                
            </thead>
            <tbody>
                <?php
                   foreach($products as $product) {
                ?>
                        <tr>
                            <td><?php echo($product['id']) ?></td>
                            <td><?php  echo($product['nome']) ?></td>
                            <td><?php echo($product['quantidade']) ?></td>
                            <td><?php echo($product['preco']) ?></td>
                            <td>
                              <button type="button" class="btn btn-info"
                                  data-toggle="modal" data-target="#myModalEditar"
                                  data-id="<?php echo($product['id']) ?>"
                                  data-nome="<?php echo($product['nome']) ?>"
                                  data-quantidade="<?php echo($product['quantidade']) ?>"
                                  data-preco="<?php echo($product['preco']) ?>">
                                  Editar
                              </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger"
                                    data-toggle="modal" data-target="#myModalDeletar"
                                    data-id="<?php echo($product['id']) ?>"
                                    data-nome="<?php echo( $product['nome']) ?>">
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
        <h4 class="modal-title">Cadastrar Produto</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <form action="controle/ctr_produto.php" method="POST">  <!-- Os dados do modal são enviados para o CONTROLE ctr_produto-->
                <input type="hidden" name="setProduto"> <!-- Executa a estrura de dados que tiver no controle com o nome em setProduto -->
                <div class="form-group">
                    <label for="">Nome</label>
                    <input type="text" class="form-control" name="txtNome" required>
                </div>
                <div class="form-group">
                    <label for="">Quantidade</label>
                    <input type="text" class="form-control" name="txtQuantidade" required>
                </div>
                <div class="form-group">
                    <label for="">Preco</label>
                    <input type="text" class="form-control" name="txtPreco" required>
                </div>
                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- The Modal Último Produto-->
<div class="modal" id="myModalUltimoProduto">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: black; color:white">
        <h4 class="modal-title">Último Produto</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>
    
      <!-- Modal body -->
        <div class="modal-body">
            <?php
                foreach($returnoProduto as $p) {
                  echo "id: " . $p["id"]. 
                  "<br> Nome: " . $p["nome"]. 
                  "<br> Preço: " . $p["preco"];
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
        <h4 class="modal-title">Deletar Produto</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <form action="controle/ctr_produto.php" method="POST">
                <input type="hidden" name="delete" id="recipient-id">
                <div class="form-group">
                    <label for="">Nome</label>
                    <input type="text" class="form-control" name="txtNome" id="recipient-nome" readonly>
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
        <h4 class="modal-title">Editar Produto</h4>
        <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <form action="controle/ctr_produto.php" method="POST">
                <input type="hidden" name="editar" id="recipient-id">
                <div class="form-group">
                    <label for="">Nome</label>
                    <input type="text" class="form-control" name="txtNome" id="recipient-nome">
                </div>
                <div class="form-group">
                    <label for="">Quantidade</label>
                    <input type="text" class="form-control" name="txtQuantidade" id="recipient-quantidade">
                </div>
                <div class="form-group">
                    <label for="">Preco</label>
                    <input type="text" class="form-control" name="txtPreco" id="recipient-preco">
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
        var recipientNome = button.data('nome')

        var modal = $(this)
        modal.find('#recipient-id').val(recipientId);
        modal.find('#recipient-nome').val(recipientNome);
    })
</script>

<script>
    $('#myModalEditar').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var recipientId = button.data('id')
        var recipientNome = button.data('nome')
        var recipientQuantidade = button.data('quantidade')
        var recipientPreco = button.data('preco')

        var modal = $(this)
        modal.find('#recipient-id').val(recipientId)
        modal.find('#recipient-nome').val(recipientNome)
        modal.find('#recipient-quantidade').val(recipientQuantidade)
        modal.find('#recipient-preco').val(recipientPreco)
    })
</script>

</body>
</html>