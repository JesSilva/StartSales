<?php

  if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'cadastrarcategoria') {
      CadastrarCategoria($_POST['nome']);
    }elseif ($_POST['acao'] == 'excluircategoria') {
      ExcluirCategoria($_POST['c']);
    }elseif ($_POST['acao'] == 'alterarcategoria') {
      AlterarCategoria($_POST['id'], $_POST['nome']);
    }
  }

  //Busca todas as categorias e as exibe na tela para o usuário
  function BuscarCategorias(){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Prepara a Query e executa a pesquisa no Banco de dados
    $query = "SELECT * FROM categoria ORDER BY NOME";
    if ($sql = mysqli_query($conn, $query)) {

      //Armazena e exibe os dados encontrados
      while ($rs = mysqli_fetch_assoc($sql)) {
        echo "
          <tr class='tr-shadow'>
            <td>
              <span>". $rs['NOME'] ."</span>
            </td>
            <td>
              <div class='table-data-feature'>
                <a class='item' href='modificarcategorias.php?c=". $rs['ID_CATEGORIA'] ."' data-toggle='tooltip' data-placement='top' title='Editar'>
                  <i class='zmdi zmdi-edit'></i>
                </a>
                <a class='item' href='#' onclick='ExcluirCategoria(". $rs['ID_CATEGORIA'] .")' data-toggle='tooltip' data-placement='top' title='Excluir'>
                  <i class='zmdi zmdi-delete'></i>
                </a>
              </div>
            </td>
          </tr>
        ";
      }

      //Exibe o número de Registros encontrados
      echo "<strong>Categorias Registradas: ". mysqli_num_rows($sql) ,"</strong>";
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);
  }

  //Busca todas as categorias e as exibe na Caixa de Seleção
  function BuscarCategoriasSelect(){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Prepara a Query e executa a pesquisa no Banco de dados
    $query = "SELECT * FROM categoria ORDER BY NOME";
    if ($sql = mysqli_query($conn, $query)) {

      //Armazena e exibe os dados encontrados
      while ($rs = mysqli_fetch_assoc($sql)) {

        echo "
          <option value='". $rs['ID_CATEGORIA'] ."'>". $rs['NOME'] ."</option>
        ";

      }
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);

  }

  //Busca todas as categorias com exceção da escolhida e as exibe na Caixa de Seleção
  function BuscarCategoriasSelectExceto($id){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Previne SQL Injection
    $id = mysqli_real_escape_string($conn, $id);

    //Prepara a Query e executa a pesquisa no Banco de dados
    $query = "SELECT * FROM categoria WHERE ID_CATEGORIA <> ". $id ." ORDER BY NOME";
    if ($sql = mysqli_query($conn, $query)) {

      //Armazena e exibe os dados encontrados
      while ($rs = mysqli_fetch_assoc($sql)) {

        echo "
          <option value='". $rs['ID_CATEGORIA'] ."'>". $rs['NOME'] ."</option>
        ";

      }
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);

  }

  //Busca uma categoria específica e a exibe para o usuário
  function BuscarCategoria($id){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Previne contra SQL Injection e prepara a Query
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM categoria WHERE ID_CATEGORIA = ". $id;

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
                      <strong>Edição de Categorias</strong>
                    </div>
                    <div class='card-body card-block'>
                      <div class='form-group'>
                        <form name='formcategoria' action='#' method='POST'>
                          <label for='company' class=' form-control-label'>Descrição</label>
                          <input type='text' id='txtNomeCategoria' name='txtNomeCategoria' placeholder='Nome da Categoria' class='form-control' value='". $rs['NOME'] ."'>
                        </form>
                      </div>
                    </div>
                    <div class='card-footer'>
                      <button id='salvar' onclick='AlterarCategoria(". $rs['ID_CATEGORIA'] .")' class='btn btn-outline-success'>
                        Alterar
                      </button>
                      <button id='cancelar' class='btn btn-outline-danger'>
                        <a href='listacategorias.php'>Cancelar</a>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";

      }else{
        //Retorna erro
        echo 0;
      }
    }else{
      //Retorna falha na pesquisa
      echo 0;
    }
  }

  //Cadastra uma Categoria na base de dados.
  function CadastrarCategoria($nome){

    //Inicia a conexão com o banco de dados.
		require_once "../../db/conexao.php";
		$conn = Connect();

    //Previne conta SQL Injection e prepara a Query
    $categoria = mysqli_real_escape_string($conn, $nome);
    $query = "INSERT INTO categoria(NOME) VALUES('". $categoria ."')";

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

  //Exclui a categoria selecionada da base de dados.
  function ExcluirCategoria($cat){

    //Inicia a conexão com o banco de dados.
		require_once "../../db/conexao.php";
		$conn = Connect();

    //Previne conta SQL Injection e prepara a Query
    $cat = mysqli_real_escape_string($conn, $cat);
    $query = "DELETE FROM categoria WHERE ID_CATEGORIA = ". $cat;

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

  //Altera os dados de uma categoria na base de dados.
  function AlterarCategoria($id, $nome){

    //Inicia a conexão com o banco de dados.
    require_once "../../db/conexao.php";
    $conn = Connect();

    //Previne conta SQL Injection e prepara a Query
    $id = mysqli_real_escape_string($conn, $id);
    $nome = mysqli_real_escape_string($conn, $nome);
    $query = "UPDATE categoria SET NOME = '". $nome ."' WHERE ID_CATEGORIA = ". $id;

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
