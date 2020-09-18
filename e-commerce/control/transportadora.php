<?php
  /*
    Ações de Controle da página
    Acao - Operação realizada (Cadastro, Edição, Exclusão, etc)
  */
  if(isset($_POST['acao'])){
    if($_POST['acao'] == "buscartransportadoras"){
      BuscarTransportadorasFinalizarPedido();
    }
  }

  //Seleciona 5 transportadoras aleatórias apenas para a exibição
  function BuscarTransportadorasFinalizarPedido(){

    //Inclui o arquivo do banco de dados e inicia a conexão
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara e Executa a Query;
    $query = "SELECT ID_TRANS, NOME FROM transportadora ORDER BY RAND() LIMIT 5";
    if($sql = mysqli_query($conn, $query)){

      //Aloca o resultado encontrado na variável
      while($rs = mysqli_fetch_assoc($sql)){

        $transportadoras[] = array(
          "cod" => $rs['ID_TRANS'],
          "nome"	=> $rs['NOME'],
          "custo" => "R$ " . rand(15, 99) . "," . rand(0, 99)
        );
      }

      //Retorna o resultado da busca.
      echo json_encode($transportadoras);

    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

 ?>
