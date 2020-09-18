<aside class="menu-sidebar d-none d-lg-block">
  <div class="logo">
      <a href="#">
          <img src="images/icon/logo.png" alt="Cool Admin" />
      </a>
  </div>
  <div class="menu-sidebar__content js-scrollbar1">
    <nav class="navbar-sidebar">
      <ul class="list-unstyled navbar__list">
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
              <a href="listaclientes.php">Clientes</a>
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
              <a href="listapedidos.php">Listagem de Pedidos</a>
            </li>
            <li>
              <a href="listapedidos.php?pendentes">Pedidos Pendentes</a>
            </li>
            <li>
              <a href="listapedidos.php?finalizados">Pedidos Finalizados</a>
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
    </nav>
  </div>
</aside>
