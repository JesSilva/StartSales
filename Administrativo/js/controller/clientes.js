$(document).ready(function(e){

  $("#pesquisarcliente").on('submit',(function(e){
    //Previne a atualização da página
    e.preventDefault();

    if ($("#txtDadosCliente").val() == '') {
      alert("Por favor, insira um valor no campo.");
      $("#txtDadosCliente").val('').focus();
    }else{
      window.location.replace("listaclientes.php?cliente=" + $("#txtDadosCliente").val());
    }
  }));

});
