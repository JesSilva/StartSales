<?php

  if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'atualizar') {
      AtualizarPedido($_POST['id'], $_POST['stts'], $_POST['codr']);
    }
  }

  //Busca todos os pedidos e exibe-os na tabela
  function BuscarPedidos($tipo){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Previne SQL Injection
    $tipo = mysqli_real_escape_string($conn, $tipo);

    //Verifica quais os pedidos que o usuário deseja trazer
    if ($tipo == 'PENDENTES') {

      $query = "
        SELECT p.ID_PEDIDO, CONCAT(u.NOME, ' ', u.SOBRENOME) AS CLIENTE,
        p.ANDAMENTO, p.COD_RASTREIO FROM pedido p INNER JOIN usuario u ON
        (p.ID_USUARIO = u.ID_USUARIO) WHERE p.ANDAMENTO <> 'FINALIZADO'
        ORDER BY p.ID_PEDIDO DESC
      ";

    }elseif ($tipo == 'FINALIZADOS') {

      $query = "
        SELECT p.ID_PEDIDO, CONCAT(u.NOME, ' ', u.SOBRENOME) AS CLIENTE,
        p.ANDAMENTO, p.COD_RASTREIO FROM pedido p INNER JOIN usuario u ON
        (p.ID_USUARIO = u.ID_USUARIO) WHERE p.ANDAMENTO = 'FINALIZADO'
        ORDER BY p.ID_PEDIDO DESC
      ";

    }else{

      $query = "
        SELECT p.ID_PEDIDO, CONCAT(u.NOME, ' ', u.SOBRENOME) AS CLIENTE,
        p.ANDAMENTO, p.COD_RASTREIO FROM pedido p INNER JOIN usuario u ON
        (p.ID_USUARIO = u.ID_USUARIO) ORDER BY p.ID_PEDIDO DESC
      ";

    }

    //Verifica se a Query foi executada com sucesso.
    if ($sql = mysqli_query($conn, $query)) {

      //Exibe os resultados da busca
      while ($rs = mysqli_fetch_assoc($sql)) {

        echo "
          <tr class='tr-shadow'>
            <td>
              <span>". $rs['ID_PEDIDO'] ."</span>
            </td>
            <td>
              <span>". $rs['CLIENTE'] ."</span>
            </td>
            <td>
              <span>". $rs['ANDAMENTO'] ."</span>
            </td>
            <td>
              <span>". $rs['COD_RASTREIO'] ."</span>
            </td>
          ";

        //Exibe um resultado diferente se o pedido já foi finalizado
        if ($rs['ANDAMENTO'] == 'FINALIZADO') {

          echo "<td></td>";

        }else{

          echo "
            <td>
              <div class='table-data-feature'>
                <a class='item' href='modificarpedidos.php?p=". $rs['ID_PEDIDO'] ."' data-toggle='tooltip' data-placement='top' title='Editar'>
                  <i class='zmdi zmdi-edit'></i>
                </a>
              </div>
            </td>
          </tr>
        ";

        }
      }
    }

    //Encerra a Conexão com o Banco de Dados
    mysqli_close($conn);

  }

  //Busca um pedido específico para a edição
  function BuscarPedido($id){

    //Inicia a conexão com o banco de dados.
    require_once "db/conexao.php";
    $conn = Connect();

    //Previne SQL Injection
    $id = mysqli_real_escape_string($conn, $id);

    //Prepara a query de busca
    $query = "SELECT ID_PEDIDO, COD_RASTREIO FROM pedido WHERE ID_PEDIDO =" . $id;

    //Verifica se a busca foi bem sucedida
    if ($sql = mysqli_query($conn, $query)) {

      //Exibe os dados do pedido
      if ($rs = mysqli_fetch_assoc($sql)) {

        echo "
          <div class='main-content'>
            <div class='section__content section__content--p30'>
              <div class='container-fluid'>
                <div style='float:left;width:900px;height:100px;'>
                  <div class='card'>
                    <div class='card-header'>
                      <strong>Atualização do Pedido - Nº ". $id ."</strong>
                    </div>
                    <div class='card-body card-block'>
                      <div class='form-group'>
                        <form name='formpedido' action='#' method='POST'>
                          <label for='slctStatus' class=' form-control-label'>Andamento do Pedido:</label>
                          <select class='form-control' id='slctStatus' name='slctStatus'>
                            <option value='1'>AGUARDANDO PAGAMENTO</option>
                            <option value='2'>EM PREPARAÇÃO</option>
                            <option value='3'>ENVIADO</option>
                            <option value='4'>FINALIZADO</option>
                          </select><br>
                          <label for='txtCodRastreio' class=' form-control-label'>Código de Rastreio:</label>
                          <input type='text' id='txtCodRastreio' name='txtCodRastreio' placeholder='Digite o Código de Rastreio' class='form-control'>
                        </form>
                      </div>
                    </div>
                    <div class='card-footer'>
                      <button id='salvar' onclick='AtualizarPedido(". $id .")' class='btn btn-outline-success'>
                        Atualizar
                      </button>
                      <button id='cancelar' class='btn btn-outline-danger'>
                        <a href='listapedidos.php'>Cancelar</a>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";

      }
    }

    //Encerra a Conexão com o Banco de Dados
    mysqli_close($conn);
  }

  //Busca um pedido específico e o exibe na tabela
  function BuscarPedidoLista($id){

    //Inicia a conexão com o banco de dados.
    require_once "db/conexao.php";
    $conn = Connect();

    //Previne SQL Injection
    $id = mysqli_real_escape_string($conn, $id);

    //Prepara a query de busca
    $query = "
      SELECT p.ID_PEDIDO, CONCAT(u.NOME, ' ', u.SOBRENOME) AS CLIENTE,
      p.ANDAMENTO, p.COD_RASTREIO FROM pedido p INNER JOIN usuario u ON
      (p.ID_USUARIO = u.ID_USUARIO) WHERE p.ID_PEDIDO =
    " . $id;

    //Verifica se a busca foi bem sucedida
    if ($sql = mysqli_query($conn, $query)) {

      //Verifica se o pedido foi encontrado
      if (mysqli_num_rows($sql) > 0) {

        //Exibe o resultado para o usuário
        if ($rs = mysqli_fetch_assoc($sql)) {

          echo "
            <tr class='tr-shadow'>
              <td>
                <span>". $rs['ID_PEDIDO'] ."</span>
              </td>
              <td>
                <span>". $rs['CLIENTE'] ."</span>
              </td>
              <td>
                <span>". $rs['ANDAMENTO'] ."</span>
              </td>
              <td>
                <span>". $rs['COD_RASTREIO'] ."</span>
              </td>
            ";

          //Exibe um resultado diferente se o pedido já foi finalizado
          if ($rs['ANDAMENTO'] == 'FINALIZADO') {

            echo "<td></td>";

          }else{

            echo "
              <td>
                <div class='table-data-feature'>
                  <a class='item' href='modificarpedidos.php?p=". $rs['ID_PEDIDO'] ."' data-toggle='tooltip' data-placement='top' title='Editar'>
                    <i class='zmdi zmdi-edit'></i>
                  </a>
                </div>
              </td>
            </tr>
          ";

          }
        }

      }else{
        echo "<td colspan='5' style='text-align: center;'>Pedido não Encontrado.</td>";
      }
    }


    //Encerra a Conexão com o Banco de Dados
    mysqli_close($conn);
  }

  //Atualiza um Pedido
  function AtualizarPedido($id, $status, $rastreio){

    //Inicia a conexão com o banco de dados.
    require_once "../../db/conexao.php";
    $conn = Connect();

    //Previne contra SQL Injection
    $id = mysqli_real_escape_string($conn, $id);
    $status = mysqli_real_escape_string($conn, $status);
    $rastreio = mysqli_real_escape_string($conn, $rastreio);

    //Verifica qual o andamento do pedido
    switch($status){
      case 1:
        $status = 'AGUARDANDO PAGAMENTO';
        break;
      case 2:
        $status = 'EM PREPARACAO';
        break;
      case 3:
        $status = 'ENVIADO';
        break;
      case 4:
        $status = 'FINALIZADO';
        break;
    }

    //Prepara a query
    $query = "
      UPDATE pedido SET ANDAMENTO = '". $status ."', COD_RASTREIO = '". $rastreio ."'
      WHERE ID_PEDIDO = ". $id;

    //Verifica se a operação foi realizada com sucesso
    if (mysqli_query($conn, $query)) {
      echo 1;
    }else{
      echo 0;
    }

    //Encerra a conexão com o banco de dados
    mysqli_close($conn);
  }
?>
