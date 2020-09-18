<?php

//Inicia a sessão e inclui os arquivos.
session_start();

require_once "db/db.php";
require_once "control/produtos.php";

//Verifica se o usuário deseja fazer Logoff.
if (isset($_GET['sair'])) {
  unset($_SESSION['usuario']);
  header("location: index.php");
}

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
</head>

<body>
  <?php
  require_once "includes/nav.php";
  ?>
  <main>
    <div class="container">
      <br>
      <div class="alert alert-success" role="alert">
        Olá, <strong><?php echo $_SESSION['usuario']['nome'] . " " . $_SESSION['usuario']['sobrenome'] ?></strong>,
        essa é sua página administrativa. Nós da <strong>RR Outlet</strong> recomendamos que mantenha seus dados sempre atualizados.
      </div>
      <div class="container">
        <div class="row justify-content-xl-center d-flex justify-content-center">
          <div class="col-xl-12">
            <div class="col-xl-12 row">
              <div class="col-12">
                <div id="accordion">
                  <div class="card">
                    <div class="col card-header" id="headingOne">
                      <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Dados Pessoais
                      </button>
                      <button class="btn btn-primary collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Endereços
                      </button>
                      <button class="btn btn-primary collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Meus Pedidos
                      </button>
                      <button class="btn btn-primary collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Alterar Senha
                      </button>
                    </div>
                    <div class="card">
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                          <form action="updatedadoscliente.php" method="POST">
                            <div class="collapse multi-collapse collapse show" id="multiCollapseExample1">
                              <h6><b>AQUI VOCÊ PODE GERENCIAR SUAS INFORMAÇÕES PESSOAIS</b></h6>
                              <div class="card card-body">
                                <div class="row">
                                  <div class="col">
                                    <label for="txtfirstname"><strong>Nome</strong></label>
                                    <input type="text" id="txtfirstname" class="form-control" placeholder="Nome" value="<?php echo $_SESSION['usuario']['nome']; ?>">
                                  </div>
                                  <div class="col">
                                    <label for="txtlastname"><strong>Sobrenome</strong></label>
                                    <input type="text" id="txtlastname" class="form-control" placeholder="Sobrenome" value="<?php echo $_SESSION['usuario']['sobrenome']; ?>">
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div class="card card-body">
                                <div class="row">
                                  <div class="col">
                                    <label for="txtmail"><strong>Email</strong></label>
                                    <input type="text" id="txtmail" class="form-control" placeholder="E-mail" value="<?php echo $_SESSION['usuario']['email']; ?>">
                                  </div>
                                  <div class="col">
                                    <label for="txtnumdoc"><strong>CPF/CNPJ</strong></label>
                                    <input type="text" id="txtnumdoc" class="form-control" placeholder="CPF/CNPJ" value="<?php echo $_SESSION['usuario']['numdoc']; ?>">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <br>
                          <button id="btninfopessoais" type="button" class="btn btn-outline-success btn-lg btn-block" value="<?php echo $_SESSION['usuario']['id']; ?>">Alterar Dados Pessoais</button>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                          <h6><b>AQUI VOCÊ PODE GERENCIAR SEUS ENDEREÇOS</b></h6>
                          <iframe style="width: 100%; height: 230px; border: 0px;" src="includes/listaenderecos.php"></iframe>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                          <h6><b>AQUI VOCÊ PODE VERIFICAR OS SEUS PEDIDOS</b></h6>
                          <iframe style="width: 100%; height: 230px; border: 0px;" src="includes/listapedidos.php"></iframe>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                        <div class="card-body">
                          <form action="updatedadoscliente.php" method="POST">
                            <div class="collapse multi-collapse collapse" id="collapseSix">
                              <h6><b>AQUI VOCÊ PODE ALTERAR SUA SENHA</b></h6>
                              <div class="card card-body">
                                <div class="row">
                                  <div class="col">
                                    <label for="txtsenhaantiga"><strong>Senha Antiga:</strong></label>
                                    <input type="password" id="txtsenhaantiga" class="form-control" placeholder="Senha Atual">
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div class="card card-body">
                                <div class="row">
                                  <div class="col">
                                    <label for="txtnovasenha"><strong>Nova Senha:</strong></label>
                                    <input type="password" id="txtnovasenha" class="form-control" placeholder="Nova Senha">
                                  </div>
                                  <div class="col">
                                    <label for="txtnovasenha2"><strong>Confirmar Senha:</strong></label>
                                    <input type="password" id="txtrepetirsenha" class="form-control" placeholder="Confirmar Senha">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <br>
                          <button type="button" id="btnalterarsenha" class="btn btn-outline-success btn-lg btn-block" value="<?php echo $_SESSION['usuario']['id']; ?>">Alterar Senha</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
  <br><br>
  <?php
  require_once "includes/footer.php";
  ?>
  <script src="js/popper.min.js" charset="utf-8"></script>
  <script src="js/bootstrap.min.js" charset="utf-8"></script>
  <script src="js/controller/cliente.js" charset="utf-8"></script>
</body>

</html>