//Ao carregar a página, realiza uma busca por Todos os Pedidos do Cliente.
$(document).ready(function(){

  //Envia uma requisição de busca de pedidos para o Controller de Pedidos.
  $.ajax({
    url: "../control/pedido.php",
    type: "post",
    data: "acao=buscarpedidos",
    dataType: "json",
    success: function(resultado){

      //Caso houverem resultados, exibe-os na tela
      if (resultado != 0) {
        for(var i = 0; i < resultado.length; i++){
          //Exibe os pedidos na tabela
          $("#tbodylistapedidos").append(
            "<tr>" +
              "<td style='text-align: center; vertical-align: middle;'>#"+ resultado[i].id +"</td>" +
              "<td style='text-align: center; vertical-align: middle;'>"+ resultado[i].qtdprod +"</td>" +
              "<td style='text-align: center; vertical-align: middle;'>R$ "+ resultado[i].total +"</td>" +
              "<td style='text-align: center; vertical-align: middle;'>"+ resultado[i].status +"</td>" +
              "<td style='text-align: center; vertical-align: middle;'>"+ resultado[i].end +"</td>" +
              "<td style='text-align: center; vertical-align: middle;'>"+ resultado[i].trans +"</td>" +
              "<td style='text-align: center; vertical-align: middle;'>"+
                "<button id='btndetalhes' onclick='DetalhesPedido("+ resultado[i].id +")' class='btn btn-info collapsed'>Detalhes</button>"+
              "</td>" +
            "</tr>"
          );
        }
      //Caso não houverem, exibe uma mensagem.
      }else{
        $("#tbodylistapedidos").append("<tr><td colspan='7' style='text-align:center;'>Nenhum Pedido Encontrado !</td></tr>");
      }
    }
  });

});

//Exibe os detalhes do pedido
function DetalhesPedido(id){

  //Limpa e Esconde a Lista de Pedidos.
  $("#listapedidos").fadeOut(500, function(){

    //Envia uma requisição para obter a lista de produtos
    $.ajax({
      url: "../control/pedido.php",
      type: "post",
      data: "acao=buscarprodutospedido&pedido=" + id,
      dataType: "json",
      success: function(resultado){
        //Caso houverem resultados, exibe-os na tela
        if (resultado != 0) {
          for(var i = 0; i < resultado.length; i++){
            //Exibe os pedidos na tabela
            $("#tbodylistaprodutos").append(
              "<tr>" +
                "<td style='text-align: center;'>" +
                  "<img src='../"+ resultado[i].img +"' style='background-repeat: no-repeat;width: 120px;height: 120px;' class='img-fluid rounded' alt='Responsive image'>"+
                "</td>" +
                "<td style='text-align: center; vertical-align: middle;'>"+ resultado[i].nome +"</td>" +
                "<td style='text-align: center; vertical-align: middle;'>"+ resultado[i].qtd +"</td>" +
                "<td style='text-align: center; vertical-align: middle;'>R$ "+ resultado[i].valor +"</td>" +
                "<td style='text-align: center; vertical-align: middle;'>R$ "+ resultado[i].subtotal +"</td>" +
                "<td style='text-align: center; vertical-align: middle;'>" +
                  "<a href='../produtoselecionado.php?p="+ resultado[i].id +"' target='_blank'>" +
                    "<button class='btn btn-info collapsed'>Visualizar</button>" +
                  "</a>" +
                "</td>" +
              "</tr>"
            );
          }

          //Esconde a Lista de Produtos
          $("#listaprodutos").fadeIn(500);
        }
      }
    });
  });

}
