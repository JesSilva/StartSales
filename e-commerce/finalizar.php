<?php

//Inicia a sessão e inclui os arquivos.
session_start();

require_once "db/db.php";
require_once "control/produtos.php";
require_once "control/carrinho.php";

//Verifica operações de Logoff ou se existem variáveis cruciais
if (isset($_GET['sair'])) {
  unset($_SESSION['usuario']);
  header("location: index.php");
}

if (!isset($_SESSION['usuario'])) {
  header("location: login.php");
}

if (!isset($_SESSION['carrinho'])) {
  header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title> RR Outlet Oficial </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
  <link rel="shortcut icon" href="../Imagens/favicon.png" />
  <script src="js/jquery_source.js" charset="utf-8"></script>

  <head>

  <body>
    <?php
    require_once "includes/nav.php";
    ?>
    <main>
      <br>
      <div class="container">
        <div class="row">
          <div class="col-8 shadow p-3 mb-5 bg-white rounded">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Produto</th>
                  <th scope="col">Preço</th>
                  <th scope="col">Subtotal</th>
                  <th scope="col">Quantidade</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody id="listaprodutoscarrinho">
                <?php
                ExibirProdutos();
                ?>
              </tbody>
            </table>
            <hr>
          </div>
          <div class="col rounded border" style="background-color: #F8F8FF; text-align: justify;">
            <div class="col">
              <form name="finalizarpedido_form">
                <br>
                <span><b>Escolha seu Endereço</b></span><br><br>
                <select id="slctendereco" class="form-control">
                  <option value="0" selected>Escolha um Endereço</option>
                </select>
                <br>
                <span><b>Ou digite um CEP</b></span><br><br>
                <input type="number" id="txtcepfinalizar" class="form-control" placeholder="Insira seu CEP para calcular o frete" aria-label="Recipient's username" aria-describedby="basic-addon2"><br>
                <div id="cep_insert_fields" style="display: none;">
                  <b><span id="cep_text"></span></b><br><br>
                  <span><b>Número</b></span><br>
                  <input type="number" id="txtnum" class="form-control" placeholder="Número da Residência" aria-label="Recipient's username" aria-describedby="basic-addon2" value="" required><br>
                  <span><b>Complemento</b></span><br>
                  <input type="text" id="txtcomplemento" class="form-control" placeholder="Complemento (Opcional)" aria-label="Recipient's username" aria-describedby="basic-addon2">
                </div><br><br>
                <div id="transp_list_wrapper" style="display: none;"></div><br><br>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8"></div>
          <div class="col rounded border" style="background-color: #F8F8FF">
            <br>
            <span><b>Total do Carrinho</b></span><br><br>
            <hr>
            <span>Total: <b>R$</b><b id="total"> <?php echo number_format($_SESSION['total'], 2, ',', '.'); ?></b></span><br><br>
            <button name="btnfinalizarpedido" onclick="FinalizarPedido(<?php echo $_SESSION['usuario']['id']; ?>)" class="btn btn-success btn-lg btn-block">Finalizar</button><br>
          </div>
        </div>
      </div>
      <br>
    </main>
    <br>
    <?php
    require_once "includes/footer.php";
    ?>
    <script src="js/popper.min.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/controller/carrinho.js" charset="utf-8"></script>
    <script src="js/controller/apicep.js" charset="utf-8"></script>
    <script src="js/controller/pedido.js" charset="utf-8"></script>
  </body>

</html>