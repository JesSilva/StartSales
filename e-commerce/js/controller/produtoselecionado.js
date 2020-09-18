//Executa ao Carregar a página.
$(document).ready(function(){

  //Obtem a ID do produto da URL
  var url = window.location.href;
  var args = url.split('?').pop().split('=').pop();
  var id = args;

  //Obtém o valor original do produto.
  vlr_original = $("#txtvlrproduto").val();

  //Requisição de busca para o Controller de Produtos.
  //Produtos Relacionados.
  $.ajax({
    url: "control/produtos.php",
    type: "post",
    data: "acao=buscarprodutosrelacionados&qtd=4&cod=" + id,
    dataType: "json",
    success: function(resultado){
      //Caso houverem resultados, exibe-os na tela
      if (resultado != 0) {
        for(var i = 0; i < resultado.length; i++){

          //Exibe os valores na tela
          $("#listaprodutosrelacionados").append(
            "<div class='col-3'>"+
              "<img id='imgProduto' src='"+ resultado[i].img +"' class='img'  style='width:100%' class='img-fluid' alt='Responsive image'>" +
              "<blockquote class='blockquote text-left'  style='color: white;'>" +
              "<p class='mb-1' style='text-align: center; color: black;'>"+ resultado[i].nome +"</p>" +
                "<footer class='h6'  style='text-align: center; color: black'>R$ "+ resultado[i].valor +"</footer>" +
              "</blockquote>" +
              "<a href=produtoselecionado.php?p="+ resultado[i].id +">" +
                "<button type='button' class='btn btn-outline-dark' style='margin-left: 10px;'>Saiba Mais sobre o Produto</button>" +
              "</a>"+
            "</div>"
          );
        }
      //Caso não houverem, exibe uma mensagem.
      }else{
        alert("Não foi possível localizar o produto Produtos.");
      }
    }
  });

});
