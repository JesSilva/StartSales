<?php

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
        <script src="js/jquery_source.js"></script>
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
                          <blockquote class="blockquote text-left" style="color: black;"><br>
                                <p class="mb-3"><b>FAÇA A SUA CONTA AGORA MESMO</b></p>
                         </blockquote>
                          <form>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Nome</label>
                                    <input type="text" class="form-control" id="txtNomeCadastro" aria-describedby="emailHelp" placeholder="Insira o seu primeiro nome">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sobrenome</label>
                                    <input type="text" class="form-control" id="txtSobrenomeCadastro" placeholder="Insira seu sobrenome">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">CPF/CNPJ</label>
                                    <input type="text" class="form-control" id="txtNumDocCadastro" placeholder="Insira seu CPF ou CNPJ">
                                </div>
                            </form>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      </div>
                      <div class="col-12">
                            <form>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Endereço de E-mail</label>
                                    <input type="email" class="form-control" id="txtEmailCadastro" aria-describedby="emailHelp" placeholder="Insira o seu e-mail">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Senha</label>
                                    <input type="password" class="form-control" id="txtSenhaCadastro" placeholder="Insira sua senha">
                                </div><br>
                                <button id="btncriarconta" type="button" class="btn btn-outline-dark">Cadastrar</button>
                                <a href="login.php"><button type="button" class="btn btn-outline-dark">Voltar</button></a>
                            </form>

                      </div>
                    </div>
                  </div>
              </div>
              <br>
        </main><br>

        <?php
            require_once "includes/footer.php";
        ?>

        <script src="js/jquery_source.js" charset="utf-8"></script>
        <script src="js/popper.min.js" charset="utf-8"></script>
        <script src="js/bootstrap.min.js" charset="utf-8"></script>
        <script src="js/controller/cliente.js"></script>
        <script src="js/controller/carrinho.js" charset="utf-8"></script>

    </body>
</html>
