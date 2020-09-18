<?php

  if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'graficoanualvendas') {
      BuscarGraficoAnualVendas();
    }elseif($_POST['acao'] == 'graficovendidossemana'){
      BuscarMaisVendidosSemana();
    }
  }

  //Seleciona o número de funcionários existentes
  function BuscarNumeroFuncionarios(){

    //Inicia a conexão com o banco de dados
    require_once "db/conexao.php";
    $conn = Connect();

    //Prepara e executa a query
    $query = "SELECT count(*) as funcionarios FROM usuario WHERE TIPOUSUARIO = 1";
    if ($sql = mysqli_query($conn, $query)){

      //Exibe os resultados
      if ($rs = mysqli_fetch_assoc($sql)) {
        echo $rs['funcionarios'];
      }else{
        echo 0;
      }
    }else{
      echo 0;
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Seleciona e exibe a quantidade de produtos vendidos hoje
  function BuscarPedidosDiarios(){

    //Inicia a conexão com o banco de dados
    require_once "db/conexao.php";
    $conn = Connect();

    //Prepara e executa a query
    $query = "SELECT count(*) as pedidos FROM pedido WHERE DAY(ABERTURA) = DAY(CURDATE())";
    if ($sql = mysqli_query($conn, $query)){

      //Exibe os resultados
      if ($rs = mysqli_fetch_assoc($sql)) {
        echo $rs['pedidos'];
      }else{
        echo 0;
      }
    }else{
      echo 0;
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Seleciona e Exibe o faturamento diário
  function BuscarFaturamentoDiario(){

    //Inicia a conexão com o banco de dados
    require_once "db/conexao.php";
    $conn = Connect();

    //Prepara e executa a query
    $query = "SELECT SUM(pro.valor * pp.quantidade) as faturamento FROM produto_pedido
    pp INNER JOIN pedido p ON(pp.ID_PEDIDO = p.ID_PEDIDO) INNER JOIN produto pro ON
    (pro.ID_PRODUTO = pp.ID_PRODUTO) WHERE DAY(p.ABERTURA) = DAY(CURDATE())";
    if ($sql = mysqli_query($conn, $query)){

      //Exibe os resultados
      if ($rs = mysqli_fetch_assoc($sql)) {
        echo number_format($rs['faturamento'], 2, ',', '.');;
      }else{
        echo 0;
      }
    }else{
      echo 0;
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Seleciona e Exibe o faturamento mensal
  function BuscarFaturamentoMensal(){

    //Inicia a conexão com o banco de dados
    require_once "db/conexao.php";
    $conn = Connect();

    //Prepara e executa a query
    $query = "SELECT SUM(pro.valor * pp.quantidade) as faturamento FROM produto_pedido
    pp INNER JOIN pedido p ON(pp.ID_PEDIDO = p.ID_PEDIDO) INNER JOIN produto pro ON
    (pro.ID_PRODUTO = pp.ID_PRODUTO) WHERE MONTH(p.ABERTURA) = MONTH(CURDATE())";
    if ($sql = mysqli_query($conn, $query)){

      //Exibe os resultados
      if ($rs = mysqli_fetch_assoc($sql)) {
        echo number_format($rs['faturamento'], 2, ',', '.');;
      }else{
        echo 0;
      }
    }else{
      echo 0;
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Seleciona as vendas do ano para o gráfico
  function BuscarGraficoAnualVendas(){

    //Inicia a conexão com o banco de dados
    require_once "../../db/conexao.php";
    $conn = Connect();

    //Prepara e executa a query
    $query = "SELECT count(*) as pedidos FROM pedido WHERE
              year(ABERTURA) = year(curdate()) GROUP BY MONTH(ABERTURA)";

    if ($sql = mysqli_query($conn, $query)){
      //Retorna os resultados
      while($rs = mysqli_fetch_assoc($sql)) {

        $vendas[] = array($rs['pedidos']);

      }

      echo json_encode($vendas);
    }else{
      echo 0;
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);

  }

  //Seleciona os produtos mais vendidos da semana
  function BuscarMaisVendidosSemana(){

    //Inicia a conexão com o banco de dados
    require_once "../../db/conexao.php";
    $conn = Connect();

    //Prepara a query;
    $query = "
      SELECT c.NOME as cat, count(*) as vendas from produto_pedido pp INNER JOIN produto_bkp p ON
      (p.ID_PRODUTO = pp.ID_PRODUTO) INNER JOIN categoria c ON
      (p.ID_CATEGORIA_PROD = c.ID_CATEGORIA) INNER JOIN pedido pe ON
      (pp.ID_PEDIDO = pe.ID_PEDIDO) WHERE WEEK(pe.ABERTURA) = WEEK(CURDATE())
      GROUP BY p.ID_CATEGORIA_PROD
    ";

    //Executa a consulta e retorna os valores.
    if ($sql = mysqli_query($conn, $query)) {
      while ($rs = mysqli_fetch_assoc($sql)) {

        $produtos[] = array(
          "cat" => $rs['cat'],
          "qtd" => $rs['vendas']
        );

      }

      //Retorna o resultado
      echo json_encode($produtos);
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);

  }

?>
