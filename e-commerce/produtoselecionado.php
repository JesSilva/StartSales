<?php

  //Inicia a sessão e inclui os arquivos.
  session_start();

  require_once "db/db.php";
  require_once "control/produtos.php";

  //Verifica se o usuário deseja fazer Logoff
  if(isset($_GET['sair'])){
    unset($_SESSION['usuario']);
    header("location:" . basename($_SERVER['PHP_SELF']));
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
      <div class="d-flex justify-content-center" id="detalhesproduto">
        <?php
          require_once "control/produtos.php";
          ProdutoSelecionado($_GET['p']);
        ?>
      </div>
      <div class="container">
        <h2><b>PRODUTOS RELACIONADOS</b></h2><br>
        <div class="row justify-content-xl-center d-flex justify-content-center">
          <div class="col-xl-12">
            <div class="col-xl-12 row" id="listaprodutosrelacionados"></div>
          </div>
        </div>
      <br><br>
    </main>
    <?php
      require_once "includes/footer.php";
    ?>
    <script src="js/popper.min.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/controller/produtoselecionado.js" charset="utf-8"></script>
    <script src="js/visual/modificar_quantidade.js" charset="utf-8"></script>
  </body>
</html>
