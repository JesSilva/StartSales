<?php

  //Verifica a existencia de dados enviados.
  if(isset($_POST['login']) && isset($_POST['pw'])){

    //Inicia a conexão com o banco de dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Previne SQL Injection.
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $pw = mysqli_real_escape_string($conn, $_POST['pw']);

    //Prepara e executa a Query no banco de dados.
    $query = "SELECT * FROM usuario WHERE email = '". $login ."' AND senha = SHA1('". $pw ."') AND TIPOUSUARIO = 2";
    $sql = mysqli_query($conn, $query);

    //Verifica se foram encontrados resultados.
    if($rs = mysqli_fetch_assoc($sql)){

      //Cria a sessão do usuário
      session_start();

      //Atribui os dadps a sessão do usuário
      $_SESSION['usuario'] = array(
        "id" => $rs['ID_USUARIO'],
        "nome" =>  $rs['NOME'],
        "sobrenome" => $rs['SOBRENOME'],
        "email" => $rs['EMAIL'],
        "numdoc" => $rs['CPF_CNPJ']
      );

      echo 1; //Retorna sucesso para o AJAX.

    }else{
      echo 0; //Retorna erro para o AJAX.
    }
  }

 ?>
