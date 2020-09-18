<?php
  /*
    Ações de controle da página
    Acao - Operação realizada (Cadastro, Edição, Exclusão, etc)
  */
  if(isset($_POST['acao'])){
    if ($_POST['acao'] == "buscarprodutosaleatorios") {
      //Verifica se alguma categoria foi requisitada.
      if (!isset($_POST['ctg'])) {
        BuscarProdutosAleatorios($_POST['qtd'], "");
      }else{
        BuscarProdutosAleatorios($_POST['qtd'], $_POST['ctg']);
      }
    }elseif ($_POST['acao'] == "buscarproduto") {
      ProdutoSelecionado($_POST['cod']);
    }elseif ($_POST['acao'] == "buscarprodutosrelacionados") {
      BuscarProdutosRelacionados($_POST['cod']);
    }
  }

  //Seleciona e retorna uma quantidade específica de produtos aleatórios
  function BuscarProdutosAleatorios($quantidade, $categoria){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara a Query
    if ($categoria == "") {
      $query = "SELECT * FROM produto ORDER BY RAND() LIMIT ". $quantidade;
    }else{

      //Verifica se há a sessão indicando algum produto a ser evitado
      if (isset($_SESSION['produtoatual'])) {
        $query = "SELECT * FROM produto WHERE ID_CATEGORIA_PROD = ". $categoria ." AND ID_PRODUTO <> ". $_SESSION['produtoatual'] ." ORDER BY RAND() LIMIT ". $quantidade;
      }else{
        $query = "SELECT * FROM produto WHERE ID_CATEGORIA_PROD = ". $categoria ." ORDER BY RAND() LIMIT ". $quantidade;
      }
    }

    //Verifica se a consulta foi bem sucedida.
    if (mysqli_query($conn, $query)) {

      //Armazena o resultado
      $sql = mysqli_query($conn, $query);

      //Atribui os resultados a uma variável
      while($rs = mysqli_fetch_assoc($sql)){

        //Cria uma lista de produtos
        $produtos[] = array(
          "id" => $rs['ID_PRODUTO'],
          "nome" => $rs['NOME_PRODUTO'],
          "desc" => $rs['DESCRICAO'],
          "valor" => $rs['VALOR'],
          "img" => $rs['IMAGEM'],
          "cat" => $rs['ID_CATEGORIA_PROD']
        );

      }

      //Retorna a lista de produtos.
      echo json_encode($produtos);

    }else{
      echo 0; //Erro
    }
  }

  //Exibe o produto da Página - Produto Selecionado
  function ProdutoSelecionado($codproduto){

    //Inicia a conexão com o Banco de Dados.
    require_once "db/db.php";
    $conn = Connect();

    //Prepara a Query contra SQL Injection.
    $codproduto = mysqli_real_escape_string($conn, $codproduto);
    $query = "SELECT * FROM produto WHERE ID_PRODUTO = " . $codproduto;

    //Verifica se a Execução foi bem sucedida.
    if ($sql = mysqli_query($conn, $query)) {

      //Obtém o resultado da Busca.
      if ($rs = mysqli_fetch_array($sql)) {

        //Verifica se a variável de sessão do Carrinho de Compras existe.
        if (isset($_SESSION['carrinho'])) {

          /*
            Verifica se o Produto já existe no Carrinho de Compras.
            Modifica as informações exibidas de acordo com o Resultado.
          */
          if (array_key_exists($codproduto, $_SESSION['carrinho'])){

            $buttontext = "Modificar Quantidade"; //Texto do Botão
            $qtd = $_SESSION['carrinho'][$codproduto]; //Quantidade já adicionada.
            $clickevent = "ModificarQuantidade"; //Evento de Click do Botão
            //Formatação e Exibição do Valor Total
            $valortotal = "Total: R$ <span id='vlr_produto_container'>". number_format(($rs['VALOR'] * $qtd), 2, ',', '.') ."</span>";

          }else{
            $buttontext = "Adicionar ao Carrinho"; //Texto do Botão
            $qtd = 1; //Quantidade
            $clickevent = "AddItemCarrinho"; //Evento do Botão.
            $valortotal = ""; //Valor exibido quando o produto é adicionado.
          }

        //Caso o Produto não tenha sido Adicionado.
        }else{
          $buttontext = "Adicionar ao Carrinho"; //Texto do Botão.
          $qtd = 1; //Quantidade
          $clickevent = "AddItemCarrinho"; //Evento de Click
          $valortotal = ""; //Valor exibido quando o produto é adicionado.
        }
      }

        //Exibe detalhes do produto na Página.

        echo "
          <blockquote class='blockquote text-left' style='color: black;'><br>
            <img src='". $rs['IMAGEM'] ."' class='img-fluid' alt='Responsive image'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </blockquote>
          <blockquote class='blockquote text-left' style='color: black;'>
            <br><br><br><br><br><br>
            <p class='mb-3 h4'><b>". $rs['NOME_PRODUTO'] ."</b></p>
            <footer class='h6'>– ". $rs['DESCRICAO'] ."</footer><br>
            <input type='hidden' id='txtvlrproduto' value='". $rs['VALOR'] ."'>
        ";

        //Verifica se o Produto já Foi adicionado ao Carrinho
        if (isset($_SESSION['carrinho'])) {
          //Caso exista, exibe o valor total correspondente a quantidade adicionada.
          if (array_key_exists($codproduto, $_SESSION['carrinho'])){
            echo "
              <footer class='h4'>R$ ". number_format($rs['VALOR'], 2, ',', '.') ."</footer>
              <footer class='h4'>".  $valortotal ."</footer>
            ";
          }else{
            echo "
              <footer class='h4'>R$ <span id='vlr_produto_container'>". number_format($rs['VALOR'], 2, ',', '.') ."</span></footer>
            ";
          }
        }else{
          echo "
            <footer class='h4'>R$ <span id='vlr_produto_container'>". number_format($rs['VALOR'], 2, ',', '.') ."</span></footer>
          ";
        }

        //Exibe os Campos e Botões relacionados ao produto.
        echo "
          <div class='input-group mb-3'>
            <input type='number' id='txtqtd_produto' class='form-control' min='1' max='50' placeholder='Quantidade de produtos' aria-label='Quantidade de produtos' aria-describedby='button-addon2' value='". $qtd ."'>
            <div class='input-group-append'>
              <button class='btn btn-outline-dark' type='button' id='btnadd_produto'>+</button>
            </div>
            <div class='input-group-append'>
              <button class='btn btn-outline-dark' type='button' id='btnremover_produto'>-</button>
            </div>
            </div>
            <button onclick='". $clickevent ."(". $rs['ID_PRODUTO'] .")' type='button' class='btn btn-outline-dark'>". $buttontext ."</button>
          </blockquote>
        ";
      }

    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

  //Busca os Produtos da mesma Categoria do Exibido.
  function BuscarProdutosRelacionados($idproduto){

    //Inicia a conexão com o Banco de Dados.
    require_once "../db/db.php";
    $conn = Connect();

    //Prepara a Query e Previne contra SQL Injection.
    $idproduto = mysqli_real_escape_string($conn, $idproduto);
    $query = "SELECT ID_CATEGORIA_PROD FROM produto WHERE ID_PRODUTO = " . $idproduto;

    //Executa a Query e armazena seu resultado na variável.
    if ($sql = mysqli_query($conn, $query)) {

      //Verifica se foram encontrados Resultados.
      if ($rs = mysqli_fetch_assoc($sql)) {

        //Cria uma variável de sessão para buscar todos os produtos exceto o já exibido.
        $_SESSION['produtoatual'] = $idproduto;

        //Envia os Dados para a função responsável por pesquisar os Produtos.
        BuscarProdutosAleatorios(4, $rs['ID_CATEGORIA_PROD']);
      }
    }else{
      echo 0;
    }
  }

  //Busca produtos por nome
  function BuscarProdutosNome($pesquisa){

    //Inicia a conexão com o Banco de Dados.
    require_once "db/db.php";
    $conn = Connect();

    //Prepara a query e previne contra SQL Injection.
    $pesquisa = mysqli_real_escape_string($conn, strtoupper($pesquisa));
    $query = "SELECT * FROM produto WHERE NOME_PRODUTO LIKE '%". $pesquisa ."%'";

    //Verifica se a execução foi bem sucedida
    if ($sql = mysqli_query($conn, $query)) {

      //Verifica se a quantidade de resultados é maior que 0.
      if(mysqli_num_rows($sql) > 0){

        //Exibe os resultados.
        while($rs = mysqli_fetch_array($sql)){

          echo "
            <div class='col-3'><br>
              <img id='imgProduto' src='". $rs['IMAGEM'] ."' class='img'  style='width:100%' class='img-fluid' alt='Responsive image'>
              <blockquote class='blockquote text-left '  style='color: white;'>
                <p class='mb-1' style='color: black'>". $rs['NOME_PRODUTO'] ."</p>
                <footer class='h6'  style='color: black'>R$ ". $rs['VALOR'] ."</footer>
              </blockquote>
              <a href='produtoselecionado.php?p=". $rs['ID_PRODUTO'] ."'>
              <button type='button' class='btn btn-outline-dark'>Saiba Mais sobre o Produto</button>
              </a>
            </div>
          ";
        }

      }else{
        echo "<p style='text-align: center'>Nenhum Resultado Encontrado !</p>";
      }
    }
    //Encerra a conexão com o Banco de Dados.
    mysqli_close($conn);
  }

 ?>
