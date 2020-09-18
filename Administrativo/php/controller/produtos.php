<?php

  //Verifica se há alguma operação a ser realizada
  if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'excluirproduto') {
      ExcluirProduto($_POST['id']);
    }
  }elseif (isset($_GET['cadastro'])){
    CadastrarProduto();
  }elseif (isset($_GET['alterar'])){
    AlterarProduto();
  }

  //Seleciona os produtos e os exibe na tela
  function BuscarProdutos(){

    //Inicia a conexão com o banco de dados.
		require_once "db/conexao.php";
		$conn = Connect();

    //Prepara a Query
    $query = "
      SELECT p.ID_PRODUTO, p.NOME_PRODUTO, p.DESCRICAO, p.VALOR, p.IMAGEM,
      c.NOME AS CATEGORIA, e.QUANTIDADE FROM produto p INNER JOIN categoria c
      ON(c.ID_CATEGORIA = p.ID_CATEGORIA_PROD) INNER JOIN estoque e
      ON(p.ID_PRODUTO = e.ID_PRODUTO) ORDER BY p.NOME_PRODUTO
    ";

    //Verifica se a busca foi bem sucedida
    if ($sql = mysqli_query($conn, $query)) {

      //Verifica se há resultados
      if (mysqli_num_rows($sql) > 0) {

        //Exibe os produtos encontrados
        while ($rs = mysqli_fetch_assoc($sql)) {

          echo "
            <tr class='tr-shadow'>
              <td>
                <img src='../e-commerce/". $rs['IMAGEM'] ."' style='background-repeat: no-repeat;width: 80px;height: 100px;' class='img-fluid rounded' alt='Responsive image'>
              </td>
              <td>". $rs['NOME_PRODUTO'] ."</td>
              <td class='desc'>". $rs['DESCRICAO'] ."</td>
              <td> R$ ". number_format($rs['VALOR'], 2, ',', '.') ."</td>
              <td>". $rs['CATEGORIA'] ."</td>
              <td>". $rs['QUANTIDADE'] ."</td>
              <td>
                <div class='table-data-feature'>
                  <a class='item' href='modificarprodutos.php?p=". $rs['ID_PRODUTO'] ."' data-toggle='tooltip' data-placement='top' title='Edit'>
                    <i class='zmdi zmdi-edit'></i>
                  </a>
                  <a class='item' href='#' onclick='RemoverProduto(". $rs['ID_PRODUTO'] .")' data-toggle='tooltip' data-placement='top' title='Edit'>
                    <i class='zmdi zmdi-delete'></i>
                  </a>
                </div>
              </td>
            </tr>
          ";

        }

      }else{
        echo "
          <tr>
            <td colspan='6' style='text-align: center;'>
              Nenhum Produto Encontrado.
            </td>
          </tr>
        ";
      }

    }else{
      echo "
        <tr>
          <td colspan='6' style='text-align: center;'>
            Nenhum Produto Encontrado.
          </td>
        </tr>
      ";
    }
  }

  //Busca um Produto específico e exibe na tela
  function BuscarProduto($id){

      //Inicia a conexão com o banco de dados.
  		require_once "db/conexao.php";
  		$conn = Connect();

      //Previne contra SQL Injection e Prepara a Query de busca.
      $id = mysqli_real_escape_string($conn, $id);
      $query = "
        SELECT p.ID_PRODUTO, p.NOME_PRODUTO, p.DESCRICAO, p.VALOR, p.IMAGEM,
        c.ID_CATEGORIA, c.NOME AS CATEGORIA, e.QUANTIDADE FROM produto p INNER JOIN categoria c
        ON(c.ID_CATEGORIA = p.ID_CATEGORIA_PROD) INNER JOIN estoque e
        ON(p.ID_PRODUTO = e.ID_PRODUTO) WHERE p.ID_PRODUTO =
      " . $id;

      //Verifica se a Query foi executada com sucesso
      if ($sql = mysqli_query($conn, $query)) {

        //Exibe o resultado da busca na tela
        if ($rs = mysqli_fetch_assoc($sql)) {

          echo "
            <div class='section__content section__content--p30'>
              <div class='container-fluid'>
                <div style='float:left;width:900px;height:100px;'>
                  <div class='card'>
                    <div class='card-header'>
                      <strong>Alteração de Produtos</strong>
                    </div>
                    <form enctype='multipart/form-data' id='modificarproduto' action='' method='post'>
                      <div class='card-body card-block'>
                        <div class='form-group'>
                          <label for='company' class=' form-control-label'>Nome</label>
                          <input type='text' id='txtNomeProduto' name='txtNomeProduto' placeholder='Informe o nome do Produto' class='form-control' value='". $rs['NOME_PRODUTO'] ."'>
                        </div>
                        <div class='form-group'>
                          <label for='company' class=' form-control-label'>Descrição</label>
                          <input type='text' id='txtDescricaoProduto' name='txtDescricaoProduto' placeholder='Informe a descrição do Produto' class='form-control' value='". $rs['DESCRICAO'] ."'>
                        </div>
                        <div class='form-group'>
                          <label for='street' class=' form-control-label'>Valor</label>
                          <input type='number' id='txtValorProduto' name='txtValorProduto' placeholder='0,00' step='any' min='1' class='form-control' value='". $rs['VALOR'] ."'>
                        </div>
                        <div class='form-group'>
                          <label for='street' class=' form-control-label'>Quantidade</label>
                          <input type='number' id='txtQuantidadeProduto' name='txtQuantidadeProduto' placeholder='0' min='1' class='form-control' value='". $rs['QUANTIDADE'] ."'>
                        </div>
                        <div class='form-group'>
                          <label for='street' class=' form-control-label'>Imagem</label>
                          <input type='file' id='ImgProduto' name='ImgProduto' class='form-control'>
                        </div>
                        <div class='form-group'>
                          <label for='slctCategoria' class=' form-control-label'>Categoria</label>
                          <select name='slctCategoria' id='slctCategoria' class='form-control-sm form-control'>
                            <option value='". $rs['ID_CATEGORIA'] ."'>". $rs['CATEGORIA'] ."</option>
          ";

          //Busca as Categorias
          BuscarCategoriasSelectExceto($rs['ID_CATEGORIA']);

          echo "
                          </select>
                        </div>
                      </div>
                      <div class='card-footer'>
                        <input type='hidden' name='txtIdProduto' value='". $rs['ID_PRODUTO'] ."'>
                        <button class='btn btn-outline-success'>Alterar</button>
                        <button class='btn btn-outline-danger'>
                          <a href='listaprod.php'>Cancelar</a>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          ";

        }
      }

      //Encerra a Conexão com o Banco de Dados
      mysqli_close($conn);
  }

  //Insere um produto na base de dados
  function CadastrarProduto(){

    //Inicia a conexão com o banco de dados.
		require_once "../../db/conexao.php";
		$conn = Connect();

    //Verifica se o arquivo de imagem é do tipo correto
    if (isset($_FILES['ImgProduto']['type'])) {

      $extensoes = array("jpeg", "jpg", "png");
      $temp = explode(".", $_FILES['ImgProduto']['name']);
      $extensaoimg = end($temp);

      //Verifica se o arquivo possui a extensão correta
      if (in_array($extensaoimg, $extensoes)) {

        //Verifica se o arquivo já existe na pasta
        if (!file_exists("../../../e-commerce/imagens/produtos/". $_FILES['ImgProduto']['name'])) {

          //Salva os dados para a transferência da imagem de local
          $caminhoorigem = $_FILES['ImgProduto']['tmp_name'];
          $nomearquivo = uniqid() . "." . $extensaoimg;
          $caminhodestino = "../../../e-commerce/imagens/produtos/". $nomearquivo;

          //Tenta mover a imagem para a pasta.
          if (move_uploaded_file($caminhoorigem, $caminhodestino)) {

            //Previne SQL Injection
            $nome = mysqli_real_escape_string($conn, $_POST['txtNomeProduto']);
            $desc = mysqli_real_escape_string($conn, $_POST['txtDescricaoProduto']);
            $vlr = mysqli_real_escape_string($conn, str_replace(',', '.', $_POST['txtValorProduto']));
            $qtd = mysqli_real_escape_string($conn, $_POST['txtQuantidadeProduto']);
            $ctg = mysqli_real_escape_string($conn, $_POST['slctCategoria']);

            //Prepara a Query
            $query = "
              INSERT INTO produto(NOME_PRODUTO, DESCRICAO, VALOR, IMAGEM,
              ID_CATEGORIA_PROD) VALUES('". $nome ."', '". $desc ."', ". $vlr .",
              'imagens/produtos/". $nomearquivo ."', ". $ctg .")
            ";

            //Verifica se a execução foi bem Sucedida
            if (mysqli_query($conn, $query)) {

              //Prepara a query para obter o ID do produto recém cadastrado
              $query = "SELECT ID_PRODUTO from produto ORDER BY ID_PRODUTO DESC LIMIT 1";

              //Verifica se a query foi bem sucedida
              if ($sql = mysqli_query($conn, $query)) {

                //Obtém a ID do produto recém cadastrado
                if ($rs = mysqli_fetch_assoc($sql)) {
                  $idprod = $rs['ID_PRODUTO'];

                  //Prepara a Query para a Inserção no Estoque
                  $query = "INSERT INTO estoque VALUES(". $qtd .", ". $idprod .")";

                  //Verifica se a Query foi executada com sucesso
                  if (mysqli_query($conn, $query)) {

                    //Prepara a query para inserção na tabela de backup
                    $query = "
                      INSERT INTO produto_bkp(NOME_PRODUTO, DESCRICAO, VALOR, IMAGEM,
                      ID_CATEGORIA_PROD) VALUES('". $nome ."', '". $desc ."', ". $vlr .",
                      'imagens/produtos/". $nomearquivo ."', ". $ctg .")
                    ";

                    //Verifica se o query foi executada com sucesso
                    if (mysqli_query($conn, $query)) {
                      ///Retorna a mensagem de erro para o usuário
                      echo 1;
                    }else{
                      //Retorna a mensagem de erro para o usuário
                      echo 6;
                    }

                  }else{
                    //Retorna a mensagem de erro para o usuário
                    echo 5;
                  }
                }

              }else{
                //Retorna a mensagem de erro para o usuário
                echo 5;
              }
            }else{
              //Retorna a mensagem de erro para o usuário
              echo 5;
            }
          }else{
            //Retorna a mensagem de erro para o usuário
            echo 4;
          }
        }else{
          //Retorna a mensagem de erro para o usuário
          echo 3;
        }
      }else{
        //Retorna a mensagem de erro para o usuário
        echo 2;
      }
    }
    //Encerra a conexão com a base de dados.
    mysqli_close($conn);
  }

  //Excluir o produto da base de dados.
  function ExcluirProduto($id){

    //Inicia a conexão com o banco de dados.
    require_once "../../db/conexao.php";
    $conn = Connect();

    //Previne SQL Injection e Prepara a query
    $id = mysqli_real_escape_string($conn, $id);
    $query = "DELETE FROM produto WHERE ID_PRODUTO = ". $id;

    //Verifica se a operação foi bem sucedida e retorna o resultado
    if (mysqli_query($conn, $query)) {
      echo 1;
    }else{
      echo 0;
    }
    //Encerra a conexão com o banco de dados.
    mysqli_close($conn);
  }

  //Atualiza um produto na base de Dados
  function AlterarProduto(){

    //Inicia a conexão com o banco de dados.
		require_once "../../db/conexao.php";
		$conn = Connect();

    //Verifica se o usuário Fez Upload de Imagem
    if ($_FILES['ImgProduto']['size'] != 0 && $_FILES['ImgProduto']['error'] != 0){

      //Verifica se o arquivo de imagem é do tipo correto
      if (isset($_FILES['ImgProduto']['type'])) {

        $extensoes = array("jpeg", "jpg", "png");
        $temp = explode(".", $_FILES['ImgProduto']['name']);
        $extensaoimg = end($temp);

        //Verifica se o arquivo possui a extensão correta
        if (in_array($extensaoimg, $extensoes)) {

          //Verifica se o arquivo já existe na pasta
          if (!file_exists("../../../e-commerce/imagens/produtos/". $_FILES['ImgProduto']['name'])) {

            //Salva os dados para a transferência da imagem de local
            $caminhoorigem = $_FILES['ImgProduto']['tmp_name'];
            $nomearquivo = uniqid() . "." . $extensaoimg;
            $caminhodestino = "../../../e-commerce/imagens/produtos/". $nomearquivo;

            //Tenta mover a imagem para a pasta.
            if (move_uploaded_file($caminhoorigem, $caminhodestino)) {

              //Previne SQL Injection
              $idprod = mysqli_real_escape_string($conn, $_POST['txtIdProduto']);
              $nome = mysqli_real_escape_string($conn, $_POST['txtNomeProduto']);
              $desc = mysqli_real_escape_string($conn, $_POST['txtDescricaoProduto']);
              $vlr = mysqli_real_escape_string($conn, str_replace(',', '.', $_POST['txtValorProduto']));
              $qtd = mysqli_real_escape_string($conn, $_POST['txtQuantidadeProduto']);
              $ctg = mysqli_real_escape_string($conn, $_POST['slctCategoria']);

              //Prepara a Query
              $query = "
                UPDATE produto SET NOME_PRODUTO = '". $nome ."', DESCRICAO = '". $desc ."',
                VALOR = ". $vlr .", IMAGEM = 'imagens/produtos/". $nomearquivo ."',
                ID_CATEGORIA_PROD = ". $ctg ." WHERE ID_PRODUTO = " . $idprod;

              //Verifica se a execução foi bem Sucedida
              if (mysqli_query($conn, $query)) {

                //Prepara a Query para a Inserção no Estoque
                $query = "UPDATE estoque SET QUANTIDADE = ". $qtd ." WHERE ID_PRODUTO = ". $idprod;

                //Verifica se a Query foi executada com sucesso
                if (mysqli_query($conn, $query)) {

                  //Prepara a Query
                  $query = "
                    UPDATE produto_bkp SET NOME_PRODUTO = '". $nome ."', DESCRICAO = '". $desc ."',
                    VALOR = ". $vlr .", IMAGEM = 'imagens/produtos/". $nomearquivo ."',
                    ID_CATEGORIA_PROD = ". $ctg ." WHERE ID_PRODUTO = " . $idprod;

                  //Verifica se o query foi executada com sucesso
                  if (mysqli_query($conn, $query)) {
                    ///Retorna a mensagem de erro para o usuário
                    echo 1;
                  }else{
                    //Retorna a mensagem de erro para o usuário
                    echo 6;
                  }
                }
              }
            }else{
              //Retorna a mensagem de erro para o usuário
              echo 4;
            }
          }else{
            //Retorna a mensagem de erro para o usuário
            echo 3;
          }
        }else{
          //Retorna a mensagem de erro para o usuário
          echo 2;
        }

      }

    }else{

      //Previne SQL Injection
      $idprod = mysqli_real_escape_string($conn, $_POST['txtIdProduto']);
      $nome = mysqli_real_escape_string($conn, $_POST['txtNomeProduto']);
      $desc = mysqli_real_escape_string($conn, $_POST['txtDescricaoProduto']);
      $vlr = mysqli_real_escape_string($conn, str_replace(',', '.', $_POST['txtValorProduto']));
      $qtd = mysqli_real_escape_string($conn, $_POST['txtQuantidadeProduto']);
      $ctg = mysqli_real_escape_string($conn, $_POST['slctCategoria']);

      //Prepara a Query
      $query = "
        UPDATE produto SET NOME_PRODUTO = '". $nome ."', DESCRICAO = '". $desc ."',
        VALOR = ". $vlr .", ID_CATEGORIA_PROD = ". $ctg ." WHERE ID_PRODUTO = " . $idprod;

      //Verifica se a execução foi bem Sucedida
      if (mysqli_query($conn, $query)) {

        //Prepara a Query para a Inserção no Estoque
        $query = "UPDATE estoque SET QUANTIDADE = ". $qtd ." WHERE ID_PRODUTO = ". $idprod;

        //Verifica se a Query foi executada com sucesso
        if (mysqli_query($conn, $query)) {

          //Prepara a Query
          $query = "
            UPDATE produto_bkp SET NOME_PRODUTO = '". $nome ."', DESCRICAO = '". $desc ."',
            VALOR = ". $vlr .", ID_CATEGORIA_PROD = ". $ctg ." WHERE ID_PRODUTO = " . $idprod;

          //Verifica se o query foi executada com sucesso
          if (mysqli_query($conn, $query)) {
            ///Retorna a mensagem de erro para o usuário
            echo 1;
          }else{
            //Retorna a mensagem de erro para o usuário
            echo 6;
          }
        }
      }
    }
    //Encerra a conexão com a base de dados.
    mysqli_close($conn);
  }

 ?>
