<?php
    require_once 'modelo/venda.php'; 
    $objVenda = new Venda(); //criei um objeto do PRODUTO, chamando a classe modelo do PRODUTO que tem validar, editar, runQueery etc PRESENTE EM MODELO
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>HBV</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="header">
<nav>
    <div class="before"></div>
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
        &#9776;
    </label>
    <ul id="menu">
        <li>
            <a href="produto.php" target="_blank">Produto</a>
        </li>
        <li>
            <a href="venda.php">Venda</a>
        </li>
    </ul>
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
                    </th>
                </tr>              
                <tr>
                    <th>Id Venda</th>
                    <th>Id Produto</th>
                    <th>Quantidade</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>                
            </thead>
            <tbody>
                <?php
                    $query = "select * from venda";
                    $stmt = $objVenda->runQuery($query);
                    $stmt->execute();
                    while($objVenda = $stmt->fetch(PDO::FETCH_ASSOC)){ 
                ?>
                        <tr>
                            <td><?php echo($objVenda['id']) ?></td>
                            <td><?php echo($objVenda['id_produto']) ?></td>
                            <td><?php echo($objVenda['quantidade']) ?></td>
                            <td> 
                              <button type="button" class="btn btn-info"
                                  data-toggle="modal" data-target="#myModalEditar"
                                  data-id="<?php echo($objVenda['id']) ?>"
                                  data-id_produto="<?php echo($objVenda['id_produto']) ?>"
                                  data-quantidade="<?php echo($objVenda['quantidade']) ?>">
                                  Editar
                              </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger"
                                    data-toggle="modal" data-target="#myModalDeletar"
                                    data-id="<?php echo($objVenda['id']) ?>"
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