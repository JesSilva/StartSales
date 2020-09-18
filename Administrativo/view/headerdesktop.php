<header class="header-desktop">
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="header-wrap">
        <div class="header-button">
          <div class="account-wrap">
            <div class="account-item clearfix js-item-menu">
              <div class="image">
                <img src="images/icon/avatar.png" alt="" />
              </div>
              <div class="content">
                <a class="js-acc-btn" href="#">
                  <?php echo $_SESSION["usuario"]['nome'] . " " .$_SESSION["usuario"]['sobrenome']; ?>
                </a>
              </div>
              <div class="account-dropdown js-dropdown">
                <div class="info clearfix">
                  <div class="image">
                    <a href="#">
                      <img src="images/icon/avatar.png" alt="" />
                    </a>
                  </div>
                  <div class="content">
                    <h5 class="name">
                      <p>Nome do usuário: </p>
                      <a href="#"><?php echo $_SESSION["usuario"]['email']; ?></a>
                    </h5>
                  </div>
                </div>
                <div class="account-dropdown__footer">
                  <a href="?sair">
                    <i class="zmdi zmdi-power"></i>Sair
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
