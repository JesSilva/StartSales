//Adiciona um Produto ao Carrinho.
function AddItemCarrinho(id){

  //Obtém a Quantidade de Produtos que o Cliente deseja.
  var qtd = $("#txtqtd_produto").val();

  //Envia uma requisicao para o Controller do Carrinho
  $.ajax({
    url: "control/carrinho.php",
    type: "post",
    data: "acao=adicionarproduto&qtd="+ qtd +"&cod=" + id,
    success: function(resultado){
      //Verifica se a ação foi bem sucedida
      if (resultado == 1) {
        //Exibe a mensagem de sucesso para o usuário.
        alert("Produto adicionado ao Carrinho !");

        //Recarrega a página.
        setTimeout(function(){
          location.reload(true);
        }, 1000);

      }else if (resultado == 2) { //Produto já existe
        alert("Quantidade Modificada !");

        //Recarrega a página.
        setTimeout(function(){
          location.reload(true);
        }, 1000);
      }else{ //Erro
        alert("Erro: Por favor, tente novamente em alguns instantes.");
      }
    }
  });
}

//Remove um Produto do Carrinho
function RemoverItemCarrinho(id){
  //Verifica se o usuário realmente deseja realizar a operação.
  if (confirm("Deseja remover este item ?")) {

    //Envia a Requisição para o Controller do Carrinho.
    $.ajax({
      url: "control/carrinho.php",
      type: "post",
      data: "acao=removerproduto&cod=" + id,
      success: function(resultado){
        //Se o produto for removido com Sucesso.
        if (resultado == 1) {

          //Exibe uma mensagem para o Usuário.
          alert("O produto foi Removido !");

          //Recarrega a Página.
          setTimeout(function(){
            location.reload(true);
          }, 1000);
        }else{
          //Exibe a mensagem de Carrinho Vazio.
          alert("Carrinho Esvaziado !");

          //Recarrega a Página.
          setTimeout(function(){
            location.reload(true);
          }, 1000);
        }
      }
    })
    return false;
  }
}

//Modifica a Quantidade de um Produto
function ModificarQuantidade(id){

  //Obtém a Quantidade de Produtos que o Cliente deseja.
  var qtd = $("#txtqtd_produto").val();

  //Envia uma requisição para o Controller do Carrinho
  $.ajax({
    url: "control/carrinho.php",
    type: "post",
    data: "acao=modificarquantidade&qtd="+ qtd +"&cod=" + id,
    success: function(resultado){
      console.log(resultado);
      //Verifica se a ação foi bem sucedida
      if (resultado == 1) {
        //Exibe a mensagem de sucesso para o usuário.
        alert("Quantidade Modificada !");

        //Recarrega a página.
        setTimeout(function(){
          location.reload(true);
        }, 1000);

      }
    }
  });

}

//Redireciona para a Página de um Produto.
function VisualizarProduto(id){
  window.location.replace("produtoselecionado.php?p=" + id);
}
