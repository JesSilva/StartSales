<?php

  //Inicia a sessão e inclui os arquivos.
  session_start();

  require_once "db/db.php";
  require_once "control/produtos.php";
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
      <div class="container shadow p-3 mb-5 bg-white rounded">
        <div class="row justify-content-xl-center d-flex justify-content-center">
          <div class="col-xl-12">
            <div class="col-xl-12 row">
              <div class="col-12">
                <br>
                <blockquote class="blockquote text-left" style="color: black;"><br>
                  <p class="mb-3">
                    <b>PRIMEIRA COMPRA ?</b>
                  </p>
                  <footer class="h6">
                    Ao criar uma conta em nossa loja, você passará pelo processo de check-out mais rapidamente. Poderá cadastrar múltiplos endereços; Visualizar e rastrear seus pedidos e muito mais.
                  </footer>
                  <br>
                  <a href="register.php">
                    <button type="button" class="btn btn-outline-dark">Cadastre-se</button>
                  </a>
                  <br><br>
                  <footer class="h6">
                    Ao clicar em "Cadastrar-se", você comprova que leu e concorda com nossos <a href="#">Termos de Uso</a>
                  </footer><br><br>
                </blockquote>
              </div>
              <div class="col-12">
                <blockquote class="blockquote text-left" style="color: black;"><br>
                  <p class="mb-3"><b>JÁ POSSUI CADASTRO ?</b></p>
                </blockquote>
                <form name = "loginform">
                  <div class="form-group ">
                    <label for="txtEmail">Endereço de E-mail</label>
                    <input type="email" class="form-control" id="txtEmail" aria-describedby="emailHelp" placeholder="Insira o seu e-mail">
                  </div>
                  <div class="form-group">
                    <label for="txtSenha">Senha</label>
                    <input type="password" class="form-control" id="txtSenha" placeholder="Insira sua senha">
                  </div>
                  <button id="btnlogin" type="button" class="btn btn-outline-dark">Entrar</button>
                </form>
              </div>
            </div>
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
    <script src="js/controller/login.js" charset="utf-8"></script>
    <script src="js/controller/carrinho.js" charset="utf-8"></script>
  </body>
</html>
