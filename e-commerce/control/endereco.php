<?php
  /*
    Ações de Controle da página
    Acao - Operação realizada (Cadastro, Edição, Exclusão, etc)
  */
  if (isset($_POST['acao'])) {
    if($_POST['acao'] == 'cadastrarendereco'){
      CadastrarEndereco();
    }elseif ($_POST['acao'] == 'excluirendereco') {
      ExcluirEndereco($_POST['idend']);
    }elseif ($_POST['acao'] == 'atualizarendereco') {
      AtualizarEndereco($_POST['idend']);
    }elseif ($_POST['acao'] == 'buscarendereco') {
      BuscarEnderecoCliente($_POST['idend']);
    }elseif ($_POST['acao'] == 'buscarenderecos') {
      BuscarEnderecosCliente();
    }elseif ($_POST['acao'] == 'buscarultimoendereco'){
      BuscarUltimoEndereco();
    }
  }

  //Verifica se o endereço já existe no banco.
  function VerificarDados($cep, $comp, $num){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara a Query e a Executa.
    session_start();
    $query = "SELECT * FROM endereco_usu WHERE CEP = ". $cep ." AND COMPLEMENTO = ". $comp ." AND NUMERO = ". $num . " AND ID_USUARIO = " . $_SESSION['usuario']['id'];

    if(mysqli_query($conn, $query)){

      //Armazena o resultado dentro da variável.
      $sql = mysqli_query($conn, $query);

      //Verifica se foi encontrado algum registro.
      if(mysqli_num_rows($sql) != 0){
        return 2; //Foram encontrados registros.
      }else{
        return 0; //Não foram encontrados registros.
      }
    }else{
      return 3; //Erro
    }
  }

  //Busca todos os endereços do cliente no Banco de Dados.
  function BuscarEnderecosCliente(){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    session_start();

    //Prepara e executa a Query.
    $query = "SELECT * FROM endereco_usu WHERE ID_USUARIO = " . $_SESSION['usuario']['id'] . " ORDER BY ID_ENDERECO DESC";
    if (mysqli_query($conn, $query)) {

      //Atribui o resultado da busca a Variável.
      $sql = mysqli_query($conn, $query);

      //Verifica se existe algum resultado.
      if(mysqli_num_rows($sql) != 0){

        //Enquanto houverem registros, atribui os valores a variável.
        while($rs = mysqli_fetch_assoc($sql)){

          $enderecos[] = array(
            "id" => $rs['ID_ENDERECO'],
            "rua" => $rs['LOGRADOURO'],
            "num" => $rs['NUMERO'],
            "comp" => $rs['COMPLEMENTO'],
            "est" => $rs['ESTADO'],
            "cid" => $rs['CIDADE'],
            "cep" => $rs['CEP']
          );

        }

        //Retorna a lista de Endereços;
        echo json_encode($enderecos);

      }else{
        echo 0; //Erro
      }
    }
    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Função de Busca de um endereço específico para a edição
  function BuscarEnderecoCliente($idendereco){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Previne contra SQL Injection e prepara a Query.
    $idendereco = mysqli_real_escape_string($conn, $idendereco);
    $query = "SELECT * FROM endereco_usu WHERE ID_ENDERECO = " . $idendereco;

    //Verifica se a Query foi bem sucedida
    if(mysqli_query($conn, $query)){

      //Atribui o Resultado a variável.
      $sql = mysqli_query($conn, $query);

      //Coloca os valores obtidos numa variável
      while($rs = mysqli_fetch_assoc($sql)){

        $endereco = array(
          "id_end" => $rs['ID_ENDERECO'],
          "cep" => $rs['CEP'],
          "rua" => $rs['LOGRADOURO'],
          "bairro" => $rs['BAIRRO'],
          "num" => $rs['NUMERO'],
          "com" => $rs['COMPLEMENTO'],
          "uf" => $rs['ESTADO'],
          "cid" => $rs['CIDADE'],
          "id_us" => $rs['ID_USUARIO']
        );

        //Retorna os valores obtidos.
        echo json_encode($endereco);
      }
    }else{
      echo 0; //Erro
    }

    //Encerra a Conexão com o Banco.
    mysqli_close($conn);
  }

  //Função de Busca do último endereço cadastrado
  function BuscarUltimoEndereco(){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Inicia a sessão e prepara a Query.
    session_start();
    $query = "SELECT ID_ENDERECO FROM endereco_usu WHERE ID_USUARIO = ". $_SESSION['usuario']['id'] ." ORDER BY ID_ENDERECO DESC";

    //Verifica se a execução foi bem sucedida.
    if ($sql = mysqli_query($conn, $query)) {

      //Obtém e retorna o resultado da busca.
      if($rs = mysqli_fetch_assoc($sql)){
        echo $rs['ID_ENDERECO'];
      }
    }
  }

  //Função de inserção de Endereços
  function CadastrarEndereco(){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara os dados, prevenindo SQL Injection.
    $cep = mysqli_real_escape_string($conn, $_POST['cep']);
    $num = mysqli_real_escape_string($conn, $_POST['num']);
    $rua = mysqli_real_escape_string($conn, strtoupper($_POST['rua']));
    $bai = mysqli_real_escape_string($conn, strtoupper($_POST['bairro']));
    $cid = mysqli_real_escape_string($conn, strtoupper($_POST['cid']));
    $uf = mysqli_real_escape_string($conn, $_POST['uf']);

    //Verifica se há algum complemento digitado
    if($_POST['com'] == ""){
      $com = "''";
    }else{
      $com = "'" . mysqli_real_escape_string($conn, $_POST['com']) . "'";
    }

    //Verifica se o endereço já existe
    $validacao = VerificarDados($cep, $com, $num);

    if ($validacao == 0) {

      //Verifica se há o campo idcli e prepara a Query.
      $query = "INSERT INTO endereco_usu (CEP, LOGRADOURO, BAIRRO, NUMERO, COMPLEMENTO, ESTADO, CIDADE, ID_USUARIO) VALUES ('". $cep ."', '". $rua ."', '". $bai ."', ". $num .", ". $com .", '". $uf ."', '". $cid ."', ". $_SESSION['usuario']['id'] .")";

      //Verifica se a operação foi realizada com sucesso no banco.
      if(mysqli_query($conn, $query)){

        //Prepara o insert do endereço na tabela secundária.
        $query = "INSERT INTO endereco_usu_bkp (CEP, LOGRADOURO, BAIRRO, NUMERO, COMPLEMENTO, ESTADO, CIDADE, ID_USUARIO) VALUES ('". $cep ."', '". $rua ."', '". $bai ."', ". $num .", ". $com .", '". $uf ."', '". $cid ."', ". $_SESSION['usuario']['id'] .")";

        //Verifica se o segundo insert também foi bem sucedido.
        if (mysqli_query($conn, $query)) {
          echo 1; //Sucesso
        }else{
          echo 0; //Erro
        }
      }else{
        echo 0; //Erro
      }
    }else{
      echo $validacao; //Erro
      exit;
    }

    mysqli_close($conn);
  }

  //Exclui um Endereço
  function ExcluirEndereco($idendereco){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Trata a ID para a Prevenção de SQL Injection.
    $idendereco = mysqli_real_escape_string($conn, $idendereco);

    //Prepara a Query e verifica se sua execução foi bem sucedida.
    $query = "DELETE FROM endereco_usu WHERE ID_ENDERECO = " . $idendereco;
    if(mysqli_query($conn, $query)){
      echo 1; //Sucesso
    }else{
      echo $query; //Erro
    }

    //Encerra a conexão com o banco de dados
    mysqli_close($conn);
  }

  //Atualiza um Endereço
  function AtualizarEndereco($idendereco){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara os dados, prevenindo SQL Injection.
    $idendereco = mysqli_real_escape_string($conn, $idendereco);
    $cep = mysqli_real_escape_string($conn, $_POST['cep']);
    $num = mysqli_real_escape_string($conn, $_POST['num']);
    $rua = mysqli_real_escape_string($conn, strtoupper($_POST['rua']));
    $bai = mysqli_real_escape_string($conn, strtoupper($_POST['bairro']));
    $cid = mysqli_real_escape_string($conn, strtoupper($_POST['cid']));
    $uf = mysqli_real_escape_string($conn, $_POST['uf']);

    //Verifica se há algum complemento digitado
    if($_POST['com'] == ""){
      $com = "''";
    }else{
      $com = "'" . mysqli_real_escape_string($conn, $_POST['com']) . "'";
    }

    //Verifica se o endereço já existe
    $validacao = VerificarDados($cep, $com, $num);
    if ($validacao == 0) {

      //Prepara a Query.
      $query = "UPDATE endereco_usu SET CEP = '". $cep ."', LOGRADOURO = '". $rua ."', BAIRRO = '". $bai ."', NUMERO = ". $num .", COMPLEMENTO = ". $com .", ESTADO = '". $uf ."', CIDADE = '". $cid ."' WHERE ID_ENDERECO = " . $idendereco;

      //Verifica se a operação foi bem sucedida.
      if(mysqli_query($conn, $query)){

        //Prepara a Query para a modificação na tabela secundária.
        $query = "UPDATE endereco_usu_bkp SET CEP = '". $cep ."', LOGRADOURO = '". $rua ."', BAIRRO = '". $bai ."', NUMERO = ". $num .", COMPLEMENTO = ". $com .", ESTADO = '". $uf ."', CIDADE = '". $cid ."' WHERE ID_ENDERECO = " . $idendereco;

        //Verifica se a operação foi bem sucedida.
        if (mysqli_query($conn, $query)) {
          echo 1; //Sucesso
        }else{
          echo 0; //Erro
        }
      }else{
        echo 0; //Erro
      }
    }else{
      echo $validacao; //Erro
      exit;
    }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }
?>
