<?php
  session_start();
  require_once "../control/cliente.php";
  require_once "../control/pedido.php";
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
    <table class="table" id="listapedidos">
      <thead class="thead-dark">
        <tr style="text-align: center;">
          <th scope="col" style="width: 14.2%; position: sticky; top: 0;">Número do Pedido</th>
          <th scope="col" style="width: 14.2%; position: sticky; top: 0;">Produtos</th>
          <th scope="col" style="width: 14.2%; position: sticky; top: 0;">Total</th>
          <th scope="col" style="width: 14.2%; position: sticky; top: 0;">Andamento</th>
          <th scope="col" style="width: 14.2%; position: sticky; top: 0;">Endereço</th>
          <th scope="col" style="width: 14.2%; position: sticky; top: 0;">Transportadora</th>
          <!-- Opções -->
          <th scope="col" style="width: 14.2%; position: sticky; top: 0;"></th>
        </tr>
      </thead>
      <tbody id="tbodylistapedidos"></tbody>
    </table>
    <table class="table" id="listaprodutos" style="display: none;">
      <thead class="thead-dark">
        <tr style="text-align: center;">
          <th scope="col" style="width: 16.6%; position: sticky; top: 0;"></th>
          <th scope="col" style="width: 16.6%; position: sticky; top: 0;">Produto</th>
          <th scope="col" style="width: 16.6%; position: sticky; top: 0;">Quantidade</th>
          <th scope="col" style="width: 16.6%; position: sticky; top: 0;">Valor</th>
          <th scope="col" style="width: 16.6%; position: sticky; top: 0;">Subtotal</th>
          <th scope="col" style="width: 16.6%; position: sticky; top: 0;">
            <button id="btnvoltarpedidos" class="btn btn-danger collapsed">
              Voltar
            </button>
          </th>
        </tr>
      </thead>
      <tbody id="tbodylistaprodutos"></tbody>
    </table>
    <script src="../js/popper.min.js" charset="utf-8"></script>
    <script src="../js/bootstrap.min.js" charset="utf-8"></script>
    <script src="../js/visual/admincli.js" charset="utf-8"></script>
    <script src="../js/controller/cliente.js" charset="utf-8"></script>
    <script src="../js/controller/listapedidos.js" charset="utf-8"></script>
  </body>
</html>
