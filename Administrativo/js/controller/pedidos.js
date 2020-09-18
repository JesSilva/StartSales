$(document).ready(function(e){

  $("#pesquisarpedido").on('submit',(function(e){
    //Previne a atualização da página
    e.preventDefault();

    if ($("#txtNumPedido").val() <= 0) {
      alert("Código do Pedido Inválido !");
      $("#txtNumPedido").val(1).focus();
    }else{
      window.location.replace("listapedidos.php?pedido=" + $("#txtNumPedido").val());
    }
  }));

});

//Atualiza os dados do Pedido
function AtualizarPedido(id){

  var stts = $("#slctStatus").val();
  var codr = $("#txtCodRastreio").val();

  //Envia uma requisição para o controller de pedidos
  $.ajax({
    url: "php/controller/pedidos.php",
    type: "post",
    data: "acao=atualizar&id="+ id + "&stts="+ stts +"&codr=" + codr,
    success: function(resultado){

      //Login bem sucedido.
      if (resultado == 1) {
        //Exibe a mensagem para o usuário
        alert("Informações do Pedido Atualizadas com Sucesso !");

        setTimeout(function(){
          //Redireciona o Usuário.
          window.location.replace("listapedidos.php");
        }, 1000);


      //Login mal sucedido.
      }else{
        //Exibe mensagem de erro.
        alert("ERRO: Houve um problema ao atualizar as informações do Pedido");
      }
    }
  });

}
