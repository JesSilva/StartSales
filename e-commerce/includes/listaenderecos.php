<?php
  session_start();
  require_once "../control/cliente.php";
 ?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title> RR Outlet Oficial </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" media="screen" />
    <link rel="shortcut icon" href="../Imagens/favicon.png" />
    <script src="../js/jquery_source.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="listaenderecos">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col" style="position: sticky; top: 0;">Logradouro</th>
            <th scope="col" style="position: sticky; top: 0;">Número</th>
            <th scope="col" style="position: sticky; top: 0;">Complemento</th>
            <th scope="col" style="position: sticky; top: 0;">Estado</th>
            <th scope="col" style="position: sticky; top: 0;">Cidade</th>
            <th scope="col" style="position: sticky; top: 0;">CEP</th>
            <th scope="col" style="position: sticky; top: 0;"></th>
            <th scope="col" style="position: sticky; top: 0;">
              <button id="btnincluirendereco" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Incluir
              </button>
            </th>
          </tr>
        </thead>
        <tbody id="tbodylistaenderecos"></tbody>
      </table>
    </div>
    <div class="gerenciarenderecos" style="display: none;">
      <form name="enderecoform" method="post">
        <div class="card card-body">
          <div class="row">
            <div class="col">
              <input name="cep" type="text" id="cep" class="form-control" placeholder="CEP" required autofocus>
            </div>
            <div class="col">
              <input type="text" id="num" class="form-control"  placeholder="Número">
            </div>
            <div class="col">
              <input type="text" id="comp" class="form-control" placeholder="Complemento">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <input name="rua" type="text" id="rua" value="" class="form-control" placeholder="Logradouro" disabled>
            </div>
            <div class="col">
              <input name="bairro" type="text" id="bairro" class="form-control" placeholder="Bairro" disabled>
            </div>
            <div class="col">
              <input name="cidade" type="text" id="cidade" class="form-control" placeholder="Cidade" disabled>
            </div>
            <div class="col">
              <input name="uf" type="text" id="uf" class="form-control" placeholder="Estado" disabled>
            </div>
          </div>
        </div>
        <br>
      </form>
      <button type="button" id="btnsalvarendereco" onclick="SalvarEndereco()" class="btn btn-outline-success" value="<?php echo $_SESSION['usuario']['id']; ?>">Cadastrar</button>
      <button type="button" id="btnvoltarendereco" class="btn btn-outline-danger">Cancelar</button>
      <button type="button" onclick="limpar_campos_endereco()" class="btn btn-outline-warning">Limpar</button>
    </div>
    <script src="../js/popper.min.js" charset="utf-8"></script>
    <script src="../js/bootstrap.min.js" charset="utf-8"></script>
    <script src="../js/visual/admincli.js" charset="utf-8"></script>
    <script src="../js/controller/cliente.js" charset="utf-8"></script>
    <script src="../js/controller/endereco.js" charset="utf-8"></script>
    <script src="../js/controller/apicep.js" charset="utf-8"></script>
  </body>
</html>
