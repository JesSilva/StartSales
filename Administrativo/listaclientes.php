<?php
  //Início da sessão e include dos arquivos auxiliares
  session_start();
  require_once "php/controller/indexcontroller.php";
  require_once "php/controller/clientes.php";

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
    <title>Painel de Controle - Clientes</title>

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
        <form id="pesquisarcliente" action="" method="get">
          <div class="main-content">
            <div class="section__content section__content--p30">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="title-5 m-b-35">Lista de Clientes Cadastrados</h3>
                    <div class="table-data__tool">
                      <div class="table-data__tool">
                        <label for="txtNumPedido" class=" form-control-label">Nome ou Documento do Cliente:</label>
                        <input type="text" id="txtDadosCliente" name="cliente" placeholder="Nome ou Documento do Cliente" class="form-control">
                        <input type="submit" name="" class="btn btn-outline-success" value="Pesquisar">
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                      <thead>
                        <tr>
                          <th>Nome</th>
                          <th>Sobrenome</th>
                          <th>CPF/CNPJ</th>
                          <th>E-mail</th>
                        </tr>
                      </thead>
                      <tbody>
                        <div>
                          <?php
                            if (isset($_GET['cliente'])) {
                              //Busca os dados de um Cliente
                              BuscarCliente($_GET['cliente']);
                            }else{
                              //Busca todos os clientes
                              BuscarClientes();
                            }
                          ?>
                        </div>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
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
    <script src="js/graficosmain.js"></script>
    <script src="js/controller/clientes.js"></script>
  </body>
</html>
