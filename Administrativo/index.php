<?php
  //Início da sessão e include do arquivo auxiliar
  session_start();
  require_once "php/controller/indexcontroller.php";

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
    <title>Painel de controle</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
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
          <!-- MAIN CONTENT-->
          <div class="main-content">
            <div class="section__content section__content--p30">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <div class="overview-wrap">
                      <h2 class="title-1">Informações sobre seu estabelecimento</h2>
                    </div>
                  </div>
                </div>
                  <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                      <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                          <div class="overview-box clearfix">
                            <div class="icon">
                              <i class="zmdi zmdi-account-o"></i>
                            </div>
                            <div class="text">
                              <h2>
                                <?php
                                  BuscarNumeroFuncionarios();
                                ?>
                              </h2>
                              <span>Funcionarios Cadastrados</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                          <div class="overview__inner">
                            <div class="overview-box clearfix">
                              <div class="icon">
                                <i class="zmdi zmdi-shopping-cart"></i>
                              </div>
                              <div class="text">
                                <h2>
                                  <?php
                                    BuscarPedidosDiarios();
                                   ?>
                                </h2>
                                <span>Pedidos do Dia</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                          <div class="overview__inner">
                            <div class="overview-box clearfix">
                              <div class="icon">
                                <i class="zmdi zmdi-calendar-note"></i>
                              </div>
                              <div class="text">
                                <h2>
                                  <?php
                                    BuscarFaturamentoDiario();
                                   ?>
                                </h2>
                                <span>Faturamento Diário</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                          <div class="overview__inner">
                            <div class="overview-box clearfix">
                              <div class="icon">
                                <i class="zmdi zmdi-money"></i>
                              </div>
                              <div class="text">
                                <h2>
                                  <?php
                                    BuscarFaturamentoMensal();
                                   ?>
                                </h2>
                                <span>Faturamento Mensal</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="au-card recent-report">
                        <div class="au-card-inner">
                          <h3 class="title-2">Gráfico Anual de Vendas</h3>
                          <div class="vendasanual" style="margin-top: 40px;">
                            <canvas id="vendasanual"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="au-card chart-percent-card">
                        <div class="au-card-inner">
                          <h3 class="title-2 tm-b-5">Produtos Mais Vendidos da Semana</h3>
                          <div class="row no-gutters">
                            <div class="col-xl-6" style="margin-left: auto; margin-right: auto;">
                              <div class="maisvendidossemana">
                                <canvas id="maisvendidossemana"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="copyright">
                    <p>Copyright © 2019 Todos os direito reservados por <a href="#">RR Outlet</a>.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="js/view/graficosindex.js"></script>
    <script src="js/graficosmain.js"></script>
  </body>
</html>
