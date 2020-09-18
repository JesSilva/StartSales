<header class="header-mobile d-block d-lg-none">
  <div class="header-mobile__bar">
    <div class="container-fluid">
      <div class="header-mobile-inner">
        <a class="logo" href="index.html">
          <img src="images/icon/logo.png" alt="CoolAdmin" />
        </a>
        <button class="hamburger hamburger--slider" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </div>
    </div>
  </div>
  <nav class="navbar-mobile">
    <div class="container-fluid">
      <ul class="navbar-mobile__list list-unstyled">
        <li class="has-sub">
          <a class="js-arrow" href="index.php">
              <i class="fas fa-home"></i>Página Inicial
          </a>
        </li>
        <!-- MENU DE LISTAGENS -->
        <li class="has-sub">
          <a class="js-arrow" href="#">
            <i class="fas fa-clipboard-list"></i>Listagens
          </a>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="listacliente.php">Clientes</a>
            </li>
          </ul>
        </li>
        <!-- MENU DE PEDIDOS -->
        <li class="has-sub">
          <a class="js-arrow" href="#">
              <i class="fa fa-dollar"></i>Pedidos
          </a>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="#">Pedidos Pendentes</a>
            </li>
            <li>
              <a href="#">Pedidos Finalizados</a>
            </li>
          </ul>
        </li>
        <!-- MENU DE PRODUTOS -->
        <li class="has-sub">
          <a class="js-arrow" href="#">
            <i class="fas fa-shopping-cart"></i>Produtos
          </a>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="listaprod.php">Listagem de Produtos</a>
            </li>
          </ul>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="modificarprodutos.php">Cadastro de Produtos</a>
            </li>
          </ul>
        </li>
        <!-- MENU DE CATEGORIAS -->
        <li class="has-sub">
          <a class="js-arrow" href="#">
            <i class="fas fa-tags"></i>Categorias
          </a>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="listacategorias.php">Listagem de Categorias</a>
            </li>
          </ul>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="modificarcategorias.php">Cadastro de Categorias</a>
            </li>
          </ul>
        </li>
        <!-- MENU DE TRANSPORTADORAS -->
        <li class="has-sub">
          <a class="js-arrow" href="#">
            <i class="fas fa-truck"></i>Transportadoras
          </a>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="listatransportadoras.php">Listagem de Transportadoras</a>
            </li>
          </ul>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="modificartransportadoras.php">Cadastro de Transportadoras</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
