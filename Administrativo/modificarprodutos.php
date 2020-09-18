<?php
  //Início da sessão e include dos arquivos auxiliares
  session_start();
  require_once "php/controller/indexcontroller.php";
  require_once "php/controller/categorias.php";
  require_once "php/controller/produtos.php";

  //Verifica se o usuário deseja fazer logoff
  if (isset($_GET['sair'])) {
    session_destroy();
    header("location: login.php");
  }

  /*
    Verifica se o usuário está autênticado
    Caso não esteja, o redireciona para a página de login.
  */
  if (!isset($_SESSION['usuario'])) {
    header("location: login.php");
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Titulo da Pagina -->
    <title>Painel de Controle - Produtos</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
  </head>
  <body class="animsition">
    <div class="page-wrapper">
      <?php
        //Menu Lateral Mobile
        require_once 'view/sidebarmobile.php';
      ?>
      <?php
        //Menu Lateral Desktop
        require_once 'view/sidebar.php';
      ?>
      <div class="page-container">
        <?php
          //Header Desktop
          require_once 'view/headerdesktop.php';
        ?>
        <div class="main-content">
          <?php
            if (!isset($_GET['p'])) {
          ?>
              <div class="section__content section__content--p30">
                <div class="container-fluid">
                  <div style="float:left;width:900px;height:100px;">
                    <div class="card">
                      <div class="card-header">
                        <strong>Cadastro de Produtos</strong>
                      </div>
                      <form enctype="multipart/form-data" id="cadastrarproduto" action="" method="post">
                        <div class="card-body card-block">
                          <div class="form-group">
                            <label for="company" class=" form-control-label">Nome</label>
                            <input type="text" id="txtNomeProduto" name="txtNomeProduto" placeholder="Informe o nome do Produto" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="company" class=" form-control-label">Descrição</label>
                            <input type="text" id="txtDescricaoProduto" name="txtDescricaoProduto" placeholder="Informe a descrição do Produto" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="street" class=" form-control-label">Valor</label>
                            <input type="number" id="txtValorProduto" name="txtValorProduto" placeholder="0,00" step="any" min="1" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="street" class=" form-control-label">Quantidade</label>
                            <input type="number" id="txtQuantidadeProduto" name="txtQuantidadeProduto" placeholder="0" min="1" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="street" class=" form-control-label">Imagem</label>
                            <input type="file" id="ImgProduto" name="ImgProduto" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="slctCategoria" class=" form-control-label">Categoria</label>
                            <select name="slctCategoria" id="slctCategoria" class="form-control-sm form-control">
                              <option value="0">Selecione uma Categoria...</option>
                              <?php
                                //Busca as Categorias
                                BuscarCategoriasSelect();
                               ?>
                            </select>
                          </div>
                        </div>
                        <div class="card-footer">
                          <button class="btn btn-outline-success">Cadastrar</button>
                          <button class="btn btn-outline-danger">
                            <a href="listaprod.php">Cancelar</a>
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }else{
              BuscarProduto($_GET['p']);
            }
           ?>
       </div>
     </div>
    </div>
    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js"></script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <!-- Graficos -->
    <script src="js/graficosmain.js"></script>
    <!-- Controller -->
    <script src="js/controller/produtos.js" charset="utf-8"></script>
  </body>
</html>
