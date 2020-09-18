<?php

  /*
    Ações de controle da página
    Acao - Operação realizada (Cadastro, Edição, Exclusão, etc)

  */
  if(isset($_POST['acao'])){
    if($_POST['acao'] == 'novaconta'){
      CadastrarCliente();
    }elseif($_POST['acao'] == 'atualizardadospessoais'){
      AtualizarDadosPessoais();
    }elseif($_POST['acao'] == 'atualizarsenha'){
      AtualizarSenha();
    }
  }

  //Verifica se o cliente já existe no sistema.
  function VerificarDados($email, $numdoc){

    //Inicia a conexão com o banco de dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara e executa a query
    $query = "SELECT * FROM usuario WHERE EMAIL = '" . $email . "'";
    $sql = mysqli_query($conn, $query);

    //Verifica se há registros no banco
    if(mysqli_num_rows($sql) != 0){
      return 2;
    }else{

      //Novamente Prepara e executa a query
      $query = "SELECT * FROM usuario WHERE CPF_CNPJ =" . $numdoc;
      $sql = mysqli_query($conn, $query);

      //Novamente verifica se foram encontrados registros no banco.
      if(mysqli_num_rows($sql) != 0){
        return 3;
      }else{
        return 0;
      }
    }
  }

  //Cadastro de um novo cliente no Sistema.
  function CadastrarCliente(){

    //Inicia a conexão com o banco de dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Trata as entradas de dados p/ a prevenção de SQL Injection.
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conn, $_POST['sobrenome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $numdoc = mysqli_real_escape_string($conn, $_POST['doc']);
    $pw = mysqli_real_escape_string($conn, $_POST['pw']);

    $validacao = VerificarDados($email, $numdoc);

    if($validacao == 0){
      //Prepara a Query
      $query = "INSERT INTO usuario(NOME, SOBRENOME, EMAIL, SENHA, CPF_CNPJ, TIPOUSUARIO)
                VALUES('". $nome ."', '". $sobrenome ."', '". $email ."', SHA1('". $pw ."'), ". $numdoc .", 2)";

      //Verifica se a execução foi bem sucedida e retorna a resposta para o AJAX.
      if(mysqli_query($conn, $query)){
        echo 1; //Sucesso
      }else{
        echo 0; //Erro de banco
      }
    }else{
      echo $validacao; //Erros diferentes
    }
  }

  //Função de Atualização de Dados Pessoais
  function AtualizarDadosPessoais(){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Obtém os dados e realiza a prevenção p/ SQL Injection.
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conn, $_POST['sobrenome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $numdoc = mysqli_real_escape_string($conn, $_POST['numdoc']);

    //Verifica se os valores são diferentes dos originais
    session_start();
    if ($email != $_SESSION['usuario']['email']){
      $validacao = VerificarDados($email, 0);

      //Caso existam, retorna erro.
      if ($validacao != 0) {
        echo $validacao;
        exit;
      }
    }elseif($numdoc != $_SESSION['usuario']['numdoc']) {
      $validacao = VerificarDados('ignore', $numdoc);

      //Caso existam, retorna erro.
      if ($validacao != 0) {
        echo $validacao;
        exit;
      }
    }

    //Prepara a Query.
    $query = "UPDATE usuario SET NOME = '". $nome ."', SOBRENOME = '". $sobrenome ."', EMAIL = '". $email ."', CPF_CNPJ = ". $numdoc ." WHERE ID_USUARIO = " . $id;

    //Verifica se a query foi bem sucedida.
    if(mysqli_query($conn, $query)){

      //Destroi a variável de sessão, realizando logoff
      unset($_SESSION['usuario']);
      echo 1; //Sucesso

    }else{
      echo 0; //Erro
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Função de Atualização da senha do cliente
  function AtualizarSenha(){

    //Inicia a conexão com o banco de dados.
    require_once "../db/db.php";
    $conn = Connect();

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $newpw = mysqli_real_escape_string($conn, $_POST['newpw']);

    $query = "
      UPDATE usuario SET SENHA = SHA1('". $newpw ."')
      WHERE ID_USUARIO = " . $id;

    if(mysqli_query($conn, $query)){
      session_start();
      unset($_SESSION['usuario']);
      echo 1;
    }else{
      echo 0;
    }
    mysqli_close($conn);
  }
 ?>
