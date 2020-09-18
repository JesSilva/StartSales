$("#btnincluirendereco").click(function(){
  $(".listaenderecos").fadeOut(500, function(){
    $(".gerenciarenderecos").fadeIn(500);
  });
});

$("#btnvoltarendereco").click(function(){
  $(".gerenciarenderecos").fadeOut(500, function(){
    $(".listaenderecos").fadeIn(500);
  });
});

$("#btnalterarcliente").click(function(){
  $(".listaenderecos").fadeOut(500, function(){
    $(".gerenciarenderecos").fadeIn(500);
  });
});

//Esconde a lista de produtos do pedido e exibe a lista de pedidos
$("#btnvoltarpedidos").click(function(){
  //Esvazia e esconde a Lista de produtos do Pedido
  $("#listaprodutos").fadeOut(500, function(){

    //Limpa os produtos pesquisados
    $("#tbodylistaprodutos").empty();

    //Exibe a lista de Pedidos
    $("#listapedidos").fadeIn(500);
  });
});
