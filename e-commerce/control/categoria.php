<?php

  //Busca as Categorias do Menu
  function BuscarCategoriasMenu(){

    //Inicia a conexão com o Banco de Dados.
    require_once "db/db.php";
    $conn = Connect();

    //Prepara e executa a query
    $query = "SELECT * FROM categoria ORDER BY NOME";
    if ($sql = mysqli_query($conn, $query)) {
      //Exibe os Resultados no Menu.
      while($rs = mysqli_fetch_assoc($sql)){
        echo "
          <a class='dropdown-item' href='produtosfiltrocategoria.php?c=".$rs['ID_CATEGORIA']."'>
            ".$rs['NOME']."
          </a>
        ";

      }
    }
  }

?>
