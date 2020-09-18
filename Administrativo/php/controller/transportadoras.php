<?php

  if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'cadastrartransportadora') {
      CadastrarTransportadora($_POST['nome'], $_POST['desc']);
    }elseif ($_POST['acao'] == 'excluirtransportadora') {
      ExcluirTransportadora($_POST['id']);
    }elseif ($_POST['acao'] == 'alterartransportadora') {
      AlterarTransportadora($_POST['id'], $_POST['nome'], $_POST['desc']);
    }
  }

  //Seleciona todas as Transportadoras da base de dados.
  function BuscarTransportadoras(){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Prepara a Query e executa a pesquisa no Banco de dados
    $query = "SELECT * FROM transportadora ORDER BY NOME";
    if ($sql = mysqli_query($conn, $query)) {

      //Armazena e exibe os dados encontrados
      while ($rs = mysqli_fetch_assoc($sql)) {
        echo "
          <tr class='tr-shadow'>
            <td>
              <span>". $rs['NOME'] ."</span>
            </td>
            <td>
              <span>". $rs['DESCRICAO'] ."</span>
            </td>
            <td>
              <div class='table-data-feature'>
                <a class='item' href='modificartransportadoras.php?t=". $rs['ID_TRANS'] ."' data-toggle='tooltip' data-placement='top' title='Editar'>
                  <i class='zmdi zmdi-edit'></i>
                </a>
                <a class='item' href='#' onclick='ExcluirTransportadora(". $rs['ID_TRANS'] .")' data-toggle='tooltip' data-placement='top' title='Excluir'>
                  <i class='zmdi zmdi-delete'></i>
                </a>
              </div>
            </td>
          </tr>
        ";

      }

      //Exibe o número de Registros encontrados
      echo "<strong>Transportadoras Registradas: ". mysqli_num_rows($sql) ,"</strong>";
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);

  }

  function BuscarTransportadora($id){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Previne contra SQL Injection e prepara a Query
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM transportadora WHERE ID_TRANS = ". $id;

    //Verifica se a operação foi realizada com Sucesso
    if ($sql = mysqli_query($conn, $query)) {

      //Obtém os dados e exibe-os para o usuário
      if ($rs = mysqli_fetch_assoc($sql)) {

        echo "
          <div class='main-content'>
            <div class='section__content section__content--p30'>
              <div class='container-fluid'>
                <div style='float:left;width:900px;height:100px;'>
                  <div class='card'>
                    <div class='card-header'>
                      <strong>Edição de Transportadoras</strong>
                    </div>
                    <div class='card-body card-block'>
                      <div class='form-group'>
                      <form name='formcategoria' action='#' method='POST'>
                        <label for='txtNomeTransportadora' class=' form-control-label'>Nome</label>
                        <input type='text' id='txtNomeTransportadora' name='txtNomeTransportadora' placeholder='Nome da Transportadora' class='form-control' value='". $rs['NOME'] ."'>
                        <br>
                        <label for='txtDescricaoTransportadora' class=' form-control-label'>Descrição</label>
                        <input type='text' id='txtDescricaoTransportadora' name='txtDescricaoTransportadora' placeholder='Descrição da Transportadora' class='form-control' value='". $rs['DESCRICAO'] ."'>
                      </form>
                      </div>
                    </div>
                    <div class='card-footer'>
                      <button id='salvar' onclick='AlterarTransportadora(". $rs['ID_TRANS'] .")' class='btn btn-outline-success'>
                        Alterar
                      </button>
                      <button id='cancelar' class='btn btn-outline-danger'>
                        <a href='listatransportadoras.php'>Cancelar</a>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";

      }else{
        //Erro - Usuário Redirecionado
        header("location: listacategorias.php");
      }
    }else{
      //Erro - Usuário Redirecionado
      header("location: listacategorias.php");
    }

    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);
  }

  //Cadastra uma Transportadora na base de dados.
  function CadastrarTransportadora($nome, $desc){

    //Inicia a conexão com o banco de dados.
		require_once "../../db/conexao.php";
		$conn = Connect();

    //Previne conta SQL Injection e prepara a Query
    $nome = mysqli_real_escape_string($conn, $nome);
    $desc = mysqli_real_escape_string($conn, $desc);
    $query = "INSERT INTO transportadora(NOME, DESCRICAO) VALUES('". $nome ."', '". $desc ."')";

    //Verifica se a operação foi realizada com Sucesso
    if (mysqli_query($conn, $query)) {

      //Realiza o insert na tabela de apoio
      $query = "INSERT INTO transportadora_bkp(NOME, DESCRICAO) VALUES('". $nome ."', '". $desc ."')";

      if (mysqli_query($conn, $query)) {
        //Retorna sucesso na inserção
        echo 1;
      }else{
        //Retorna falha na inserção
        echo 0;
      }
    }else{
      //Retorna falha na inserção
      echo 0;
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);
  }

  //Exclui a Transportadora selecionada da base de dados.
  function ExcluirTransportadora($id){

    //Inicia a conexão com o banco de dados.
		require_once "../../db/conexao.php";
		$conn = Connect();

    //Previne conta SQL Injection e prepara a Query
    $id = mysqli_real_escape_string($conn, $id);
    $query = "DELETE FROM transportadora WHERE ID_TRANS = ". $id;

    //Verifica se a operação foi realizada com Sucesso
    if (mysqli_query($conn, $query)) {
      //Retorna sucesso na exclusão
      echo 1;
    }else{
      //Retorna falha na exclusão
      echo 0;
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);
  }

  //Altera os dados de uma Transportadora na base de dados.
  function AlterarTransportadora($id, $nome, $desc){

    //Inicia a conexão com o banco de dados.
    require_once "../../db/conexao.php";
    $conn = Connect();

    //Previne conta SQL Injection e prepara a Query
    $id = mysqli_real_escape_string($conn, $id);
    $nome = mysqli_real_escape_string($conn, $nome);
    $desc = mysqli_real_escape_string($conn, $desc);
    $query = "UPDATE transportadora SET NOME = '". $nome ."', DESCRICAO = '". $desc ."' WHERE ID_TRANS = ". $id;

    //Verifica se a operação foi realizada com Sucesso
    if (mysqli_query($conn, $query)) {
      //Retorna sucesso na inserção
      echo 1;
    }else{
      //Retorna falha na inserção
      echo 0;
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);

  }

?>
