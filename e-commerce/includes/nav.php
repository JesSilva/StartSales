<?php
  require_once "control/carrinho.php";
?>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: black;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="produtosfiltro.php">Outlet</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Categorias
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <?php
              //Inclui o Controller e Busca as Categorias Existentes
              require_once "control/categoria.php";
              BuscarCategoriasMenu();
             ?>
          </div>
        </li>
        <?php
          //Verifica se o usuário está logado e modifica o menu de acordo com o resultado.
          echo "
            <li class='nav-item'>
          ";

          if(!isset($_SESSION['usuario'])){
            echo "
              <a class='nav-link' href='login.php'>Login</a>
            ";
            echo "</li>";
          }else{
            echo "
              <a class='nav-link' href='admincli.php'>Minha Conta</a>
            ";
            echo "</li>";

            echo "
              <li class='nav-item'>
            ";

            echo "<a class='nav-link' href='?sair'>Sair</a>";
            echo "</li>";
          }
       ?>
      </ul>
    </div>
    <a class="navbar-brand" href="index.php">
      <img src="Imagens/logo-footer.png" id="logo-footer" class="d-inline-block align-top img-fluid" alt="Responsive image">
    </a>
    <div class="position-relative collapse navbar-collapse float-md-left" id="navbarNav"></div>
    <a class="navbar-brand" data-toggle="modal" data-target=".bd-example-modal-lg" href="#">
      <img src="Imagens/icones/carrinho.png" class="img-fluid" alt="Responsive image">
      <span id="carrinho_itens" class="badge badge-danger">
        <?php
          //Exibe a Quantidade de Produtos no Carrinho.
          if(isset($_SESSION['itens_carrinho'])){
            echo $_SESSION['itens_carrinho'];
          }else{
            echo 0;
          }
         ?>
      </span>
    </a>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <?php
            //Verifica se Há um carrinho de Compras.
            if (isset($_SESSION['carrinho'])) {
              ExibirProdutosModal();
            }else{
              echo "Seu carrinho de compras está vazio";
            }
           ?>
        </div>
      </div>
    </div>
    <form class="form-inline" method="post" action="produtospesquisa.php">
      <input class="form-control mr-sm-2" type="search" name="txtPesquisa" placeholder="Pesquise o produto" aria-label="Search">
      <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Buscar</button>
    </form>
  </nav>
</header>
<script src="js/controller/carrinho.js" charset="utf-8"></script>
