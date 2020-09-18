<?php

  if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'finalizarpedido') {
      FinalizarPedido();
    }elseif ($_POST['acao'] == 'buscarpedidos') {
      BuscarPedidos();
    }elseif($_POST['acao'] == 'buscarprodutospedido'){
      BuscarProdutosPedido($_POST['pedido']);
    }
  }

  //Busca todos os pedidos do Cliente
  function BuscarPedidos(){

    //Inclui o arquivo do banco de dados e inicia a conexão
    require_once "../db/db.php";
    $conn = Connect();

    //Inicia a sessão e prepara a Query.
    session_start();
    $query = "
      SELECT p.ID_PEDIDO, (SELECT COUNT(*) FROM produto_pedido WHERE ID_PEDIDO = p.ID_PEDIDO)
      AS PRODUTOS, p.ANDAMENTO, p.TOTAL, CONCAT_WS(' - ', e.LOGRADOURO, e.BAIRRO, e.NUMERO,
      e.COMPLEMENTO, e.ESTADO, e.CIDADE) AS ENDERECO, t.NOME as TRANSPORTADORA FROM pedido p
      INNER JOIN endereco_usu_bkp e ON (e.ID_ENDERECO = p.ID_ENDERECO) INNER JOIN
      transportadora t ON(p.ID_TRANS = t.ID_TRANS) WHERE
      p.ID_USUARIO = ". $_SESSION['usuario']['id'] ." ORDER BY p.ABERTURA DESC
    ";

    //Verifica se houve sucesso na execução
    if ($sql = mysqli_query($conn, $query)) {

      if(mysqli_num_rows($sql) != 0){
        //Armazena todos os resultados numa variável.
        while($rs = mysqli_fetch_assoc($sql)){

          $pedidos[] = array(
            "id" => $rs['ID_PEDIDO'],
            "qtdprod" => $rs['PRODUTOS'],
            "total" => number_format($rs['TOTAL'], 2, ',', '.'),
            "status" => $rs['ANDAMENTO'],
            "end" => $rs['ENDERECO'],
            "trans" => $rs['TRANSPORTADORA']
          );

        }

        //Retorna os pedidos.
        echo json_encode($pedidos);

      }else{
        echo 0; //Retorna que não foram encontrados registros.
      }
    }
    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Busca todos os Produtos do Pedido.
  function BuscarProdutosPedido($idped){

    //Inclui o arquivo do banco de dados e inicia a conexão
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara a Query e impede SQL Injection.
    $idped = mysqli_real_escape_string($conn, $idped);
    $query = "
      SELECT p.ID_PRODUTO, p.NOME_PRODUTO, p.IMAGEM, pp.QUANTIDADE, p.VALOR
      FROM produto_pedido pp INNER JOIN produto_bkp p ON(p.ID_PRODUTO = pp.ID_PRODUTO)
      WHERE ID_PEDIDO = ".$idped;

    //Verifica se a query foi executada
    if ($sql = mysqli_query($conn, $query)) {

      //Atribui os resultados à variável.
      while($rs = mysqli_fetch_assoc($sql)){

        $produtospedido[] = array(
          "id" => $rs['ID_PRODUTO'],
          "nome" => $rs['NOME_PRODUTO'],
          "img" => $rs['IMAGEM'],
          "qtd" => $rs['QUANTIDADE'],
          "valor" => number_format($rs['VALOR'], 2, ',', '.'),
          "subtotal" => number_format(($rs['QUANTIDADE'] * $rs['VALOR']), 2, ',', '.')
        );

      }

      echo json_encode($produtospedido);

    }
  }

  //Insere o pedido no banco de dados
  function FinalizarPedido(){

    //Inclui o arquivo do banco de dados e inicia a conexão
    require_once "../db/db.php";
    $conn = Connect();

    //Grava o id da transportadora na variável após realizar o método preventivo p/ SQL Injection
    $idtrans = mysqli_real_escape_string($conn, $_POST['transp']);
    $idend = mysqli_real_escape_string($conn, $_POST['idend']);

    //Prepara a query de inserção do pedido
    session_start();
    $query = "
      INSERT INTO pedido(ANDAMENTO, ABERTURA, TOTAL, COD_RASTREIO, ID_USUARIO,
      ID_TRANS, ID_ENDERECO) VALUES('AGUARDANDO PAGAMENTO', NOW(),
      ". $_SESSION['total'] .", '', ". $_SESSION['usuario']['id'] .",
      ". $idtrans .",". $idend .")
    ";

    //Tenta o insert no banco
    if(mysqli_query($conn, $query)){

      /*
        Se o pedido foi inserido, realiza uma consulta para a obtenção do id para a
        inserção dos produtos relacionados ao mesmo.
      */
      $query = "
        SELECT ID_PEDIDO FROM pedido WHERE
        ID_USUARIO = " . $_SESSION['usuario']['id'] . "
        ORDER BY ID_PEDIDO DESC
      ";

      $sql = mysqli_query($conn, $query);

      if ($rs = mysqli_fetch_assoc($sql)) {

        //Salva a id do pedido na variável
        $idpedido = $rs['ID_PEDIDO'];

        //Insere no banco todos os produtos do carrinho
        foreach($_SESSION['carrinho'] as $item => $qtd){

          $query = "
            INSERT INTO produto_pedido(ID_PRODUTO, ID_PEDIDO, QUANTIDADE)
            VALUES(". $item .", ". $idpedido .", ". $qtd .")";

          mysqli_query($conn, $query);

        }

        /*
          Após a inserção de todos os produtos no banco,
          destroi todas as sessões relacionadas
          ao carrinho de compras e redireciona o usuário para a página inicial do site.
        */
        unset($_SESSION['carrinho']);
        unset($_SESSION['itens_carrinho']);
        unset($_SESSION['total']);

        //Retorna Sucesso.
        echo 1;

      }else{
        //Encerra a Conexão com o Banco de Dados
        //Retorna Erro
        mysqli_close($conn);
        echo $query;
      }
    }else{
      //Encerra a Conexão com o Banco de Dados
      //Retorna Erro
      mysqli_close($conn);
      echo $query;
    }
  }

 ?>
