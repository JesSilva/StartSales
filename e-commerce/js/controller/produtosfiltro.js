//Executa ao carregar a página
$(document).ready(function(){

  //Requisição de busca para o Controller de Produtos.
  $.ajax({
    url: "control/produtos.php",
    type: "post",
    data: "acao=buscarprodutosaleatorios&qtd=6",
    dataType: "json",
    success: function(resultado){

      //Caso houverem resultados, exibe-os na tela
      if (resultado != 0) {

        for(var i = 0; i < resultado.length; i++){

          //Exibe o endereço na tela
          $("#produtos_container").append(
            "<div class='col-3'>" +
              "<br>" +
                "<img id='imgProduto' src='"+ resultado[i].img +"' class='img'  style='width:100%' class='img-fluid' alt='Responsive image'>" +
                "<blockquote class='blockquote text-left '  style='color: white;'>" +
                  "<p class='mb-1' style='text-align: center; color: black;'>"+ resultado[i].nome +"</p>" +
                  "<footer class='h6'  style='text-align: center; color: black;'>R$ "+ resultado[i].valor +"</footer>" +
                "</blockquote>" +
                "<a href='produtoselecionado.php?p="+ resultado[i].id +"'>" +
                  "<button type='button' class='btn btn-outline-dark' style='margin-left: 10px;'>Saiba Mais sobre o Produto</button>" +
                "</a>" +
              "</div>"
          );
        }
      //Caso não houverem, exibe uma mensagem.
      }else{
        alert("Não foram encontrados Produtos.");
      }
    }
  });
});
