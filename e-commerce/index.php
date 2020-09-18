<?php
//Inicia a sessão e inclui os arquivos.
session_start();

require_once "db/db.php";
require_once "control/produtos.php";

//Verifica se o usuário deseja fazer Logoff.
if (isset($_GET['sair'])) {
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
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" media="screen" />
  <link rel="shortcut icon" href="Imagens/favicon.png" />
  <script src="js/jquery_source.js" charset="utf-8"></script>

  <head>

  <body>
    <?php
    require_once "includes/nav.php";
    ?>
    <main>

      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="Imagens/Slide/1.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="Imagens/Slide/2.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="Imagens/Slide/3.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <div class="container">
        <div class="row justify-content-md-center">
          <div class="col-xl-4 py-3 px-md-5 rounded">
            <img src="Imagens/Categorias/1.jpg" class="img-fluid rounded" alt="Responsive image">
          </div>
          <div class="col-xl-4 py-3 px-md-5 rounded">
            <img src="Imagens/Categorias/1.jpg" class="img-fluid rounded" alt="Responsive image">
          </div>
          <div class="col-xl-4 py-3 px-md-5 rounded">
            <img src="Imagens/Categorias/1.jpg" class="img-fluid rounded" alt="Responsive image">
          </div>
        </div>
        <div class="row justify-content-md-center">
          <div class="col-xl-4 py-3 px-md-5 rounded">
            <img src="Imagens/Categorias/1.jpg" class="img-fluid rounded" alt="Responsive image">
          </div>
          <div class="col-xl-4 py-3 px-md-5 rounded">
            <img src="Imagens/Categorias/1.jpg" class="img-fluid rounded" alt="Responsive image">
          </div>
          <div class="col-xl-4 py-3 px-md-5 rounded">
            <img src="Imagens/Categorias/1.jpg" class="img-fluid rounded" alt="Responsive image">
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col">
            <img src="https://img.icons8.com/ios-filled/50/000000/free-shipping.png" class="img-fluid" alt="Responsive image"><b> FRETE GRÁTIS ACIMA DE R$300,00</b>
          </div>
          <div class="col">
            <img src="https://img.icons8.com/ios-filled/50/000000/insert-card.png" class="img-fluid" alt="Responsive image"><b> ATÉ 10X SEM JUROS NO CARTÃO</b>
          </div>
          <div class="col">
            <img src="https://img.icons8.com/ios-filled/50/000000/shopping-basket.png" class="img-fluid" alt="Responsive image"><b> 30 DIAS PARA A TROCA DO PRODUTO</b>
          </div>
        </div>
      </div>

    </main>

    <?php
    require_once "includes/footer.php";
    ?>

    <script src="js/popper.min.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/controller/carrinho.js" charset="utf-8"></script>
  </body>

</html>