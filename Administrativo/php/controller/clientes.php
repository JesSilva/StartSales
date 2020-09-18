<?php

  //Realiza uma busca no banco de dados e exibe os clientes cadastrados no sistema.
  function BuscarClientes(){

    //Inicia a conexão com o banco de dados.
    require_once "db/conexao.php";
    $conn = Connect();

    //Prepara a Query e executa a consulta no banco de dados.
    $query = "SELECT * from usuario WHERE TIPOUSUARIO = 2";
    if ($sql = mysqli_query($conn, $query)) {

      //Exibe os dados na tabela do site
      while($rs = mysqli_fetch_assoc($sql)){

        echo "
          <tr class='tr-shadow'>
            <td>". $rs['NOME'] ."</td>
            <td>". $rs['SOBRENOME'] ."</td>
            <td class='desc'>". $rs['CPF_CNPJ'] ."</td>
            <td>". $rs['EMAIL'] ."</td>
          </tr>
        ";
      }
      echo "Clientes Cadastrados: " . mysqli_num_rows($sql);
    }

    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);
  }

  function BuscarCliente($dados){

    //Inicia a conexão com o banco de dados.
    require_once "db/conexao.php";
    $conn = Connect();

    //Previne SQL Injection
    $dados = mysqli_real_escape_string($conn, $dados);

    //Prepara a Query e executa a consulta no banco de dados.
    $query = "
      SELECT * from usuario WHERE (NOME LIKE '%". $dados ."%' OR SOBRENOME
      LIKE '%". $dados ."%' OR CPF_CNPJ = '". $dados ."') AND TIPOUSUARIO = 2";

    if ($sql = mysqli_query($conn, $query)) {

      //Exibe os dados na tabela do site
      while($rs = mysqli_fetch_assoc($sql)){

        echo "
          <tr class='tr-shadow'>
            <td>". $rs['NOME'] ."</td>
            <td>". $rs['SOBRENOME'] ."</td>
            <td class='desc'>". $rs['CPF_CNPJ'] ."</td>
            <td>". $rs['EMAIL'] ."</td>
          </tr>
        ";
      }
      echo "Clientes Encontrados: " . mysqli_num_rows($sql);
    }

    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);

  }

?>
