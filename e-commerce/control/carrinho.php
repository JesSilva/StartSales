<?php
  /*
    Ações de controle da página
    Acao - Operação realizada (Cadastro, Edição, Exclusão, etc)
  */
  if (isset($_POST['acao'])) {
    if($_POST['acao'] == "adicionarproduto"){
      AdicionarProduto($_POST['cod'], $_POST['qtd']);
    }elseif ($_POST['acao'] == "modificarquantidade") {
      ModificarQuantidade($_POST['cod'], $_POST['qtd']);
    }elseif ($_POST['acao'] == "removerproduto") {
      RemoverProduto($_POST['cod']);
    }elseif ($_POST['acao'] == 'exibiritens') {
      ExibirProdutos();
    }
  }

  //Adiciona um produto ao carrinho de compras.
  function AdicionarProduto($codproduto, $quantidade){

    //Verifica se o Carrinho de Compras ainda não foi criado.
    session_start();
    if(!isset($_SESSION['carrinho'])){

      //Cria o carrinho
      $_SESSION['carrinho'] = array();
      $_SESSION['carrinho'][$codproduto] = $quantidade; //Adiciona o Produto e sua Quantidade.
      $_SESSION['itens_carrinho'] = 1; //Contador de produtos do carrinho

      //Retorna sucesso.
      echo 1;
      exit;

    }else{

      //Verifica se o produto já existe no carrinho de compras
      if (array_key_exists($codproduto, $_SESSION['carrinho'])) {

        //Caso exista, a quantidade é alterada.
        $_SESSION['carrinho'][$codproduto] == $quantidade;
        echo 2;

      }else{

        //Caso não exista, o mesmo é adicionado e a quantidade de produtos no contador é aumentada.
        $_SESSION['carrinho'][$codproduto] = $quantidade;
        $_SESSION['itens_carrinho'] += 1;

        echo 1;
        exit;

      }
    }
  }

  //Remove um produto do carrinho de compras
  function RemoverProduto($codproduto){

    //Inicia a sessão.
    session_start();

    //Remove o produto do Carrinho
    unset($_SESSION['carrinho'][$codproduto]);

    //Verifica se o Carrinho de Compras ainda possui algum Produto
    if ($_SESSION['itens_carrinho'] > 0) {

      //Se possuir, deduz em 1 a Quantidade de Produtos Existentes.
      $_SESSION['itens_carrinho'] -= 1;

      //Verifica novamente se ainda restam Produtos no Carrinho.
      if ($_SESSION['itens_carrinho'] == 0) {

        //Caso não possuir, destroi a sessão
        unset($_SESSION['carrinho']);
        echo 0;

      }else{
        //Retorna Sucesso
        echo 1;
      }
    }
  }

  //Modifica a quantidade dos produtos no carrinho de compras
  function ModificarQuantidade($codproduto, $quantidade){
    //Modifica a Quantidade e retorna Sucesso.
    session_start();
    $_SESSION['carrinho'][$codproduto] = $quantidade;
    echo 1;
  }

  //Busca no Banco de Dados as Informações de um produto contido no Carrinho
  function BuscarProdutoCarrinho($codproduto){

    $conn = Connect();

    $q = "SELECT * FROM produto where ID_PRODUTO = " . $codproduto;
    $sql = mysqli_query($conn, $q);

    if ($rs = mysqli_fetch_array($sql)) {

      $_SESSION['item_carrinho'] = array(
        "id" => $rs['ID_PRODUTO'],
        "nome" => $rs['NOME_PRODUTO'],
        "descricao" => $rs['DESCRICAO'],
        "valor" => $rs['VALOR'],
        "img" => $rs['IMAGEM']
      );

    }

    mysqli_close($conn);
  }

  //Seleciona os itens do carrinho e exibe-os no modal
  function ExibirProdutosModal(){
    $total = 0;

    echo "
      <div class='modal-body'>
        <h5>Carrinho de compras</h5>
    ";

    foreach ($_SESSION['carrinho'] as $item => $qtd) {
      BuscarProdutoCarrinho($item);
      $subtotal = $qtd * $_SESSION['item_carrinho']['valor'];
      $total = $total + ($qtd * $_SESSION['item_carrinho']['valor']);

      echo "
        <hr>
        <div class='container'>
          <div class='row'>
            <div class='col-sm'>
              <img src='". $_SESSION['item_carrinho']['img'] ."' style='background-repeat: no-repeat;width: 120px;height: 120px;' class='img-fluid rounded' alt='Responsive image'>
            </div>
            <div class='col-sm'>
              <p class='mb-1'><b>". $_SESSION['item_carrinho']['nome'] ."</b></p>
              <footer class='h6'>Tamanho: GG</footer>
              <footer class='h6'>Quantidade: " . $qtd ."</footer>
              <footer class='h6'>Subtotal: R$ ". number_format($subtotal, 2, ',', '.') ." (Valor Original: R$ ". number_format($_SESSION['item_carrinho']['valor'], 2, ',', '.') .")</footer>
              <button onclick= 'VisualizarProduto(". $_SESSION['item_carrinho']['id'] .")'type='button' class='btn btn-info'>Visualizar Produto</button>
              <button onclick='RemoverItemCarrinho(". $_SESSION['item_carrinho']['id'] .")' type='button' class='btn btn-danger'>Remover Produto</button>
            </div>
          </div>
        </div>
        <hr>
      ";
    }
    echo "
        <div class='container'>
          <div class='row'>
              <div class='col-sm'>
                  <p class='mb-1'><b>TOTAL: R$ " . number_format($total, 2, ',', '.') ."</b>
              </div>
              <div class='col-sm'>
                  <a href='finalizar.php'><button type='button' class='btn btn-success'>Finalizar</button></a>
                  <button type='button' data-dismiss='modal' class='btn btn-info'>Continuar comprando</button>
              </div>
            </div>
        </div>
      </div>
    ";
  }

  //Exibe os produtos contidos no Carrinho de Compras
  function ExibirProdutos(){

    //Atribui o valor total como 0
    $total = 0;

    //Realiza um loop para cada produto no Carrinho de Compras.
    foreach ($_SESSION['carrinho'] as $item => $qtd) {

      //Busca os Dados de todos os produtos do Carrinho
      BuscarProdutoCarrinho($item);
      $total = $total + ($qtd * $_SESSION['item_carrinho']['valor']);

      echo "
        <tr style='text-align: center;'>
          <td><img src='". $_SESSION['item_carrinho']['img'] ."' style='background-repeat: no-repeat;width: 120px;height: 120px;' class='img-fluid rounded' alt='Responsive image'></td>
          <td>". $_SESSION['item_carrinho']['nome'] ."</td>
          <td>R$ ". $_SESSION['item_carrinho']['valor'] ."</td>
          <td>R$ ". $_SESSION['item_carrinho']['valor'] * $qtd ."</td>
          <td>". $qtd ."</td>
          <td>
            <button onclick= 'VisualizarProduto(". $_SESSION['item_carrinho']['id'] .")'type='button' class='btn btn-info'>Visualizar</button><br><br>
            <button type='button' class='btn btn-danger' onclick='RemoverItemCarrinho(". $_SESSION['item_carrinho']['id'] .")'>Remover</button>
          </td>
        </tr>
      ";
    }

    $_SESSION['total'] = $total;
  }

?>
