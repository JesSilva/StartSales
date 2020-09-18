//Assim que a página é carregada.
$(document).ready(function(){

  //Envia uma requisição para o Controller para obter os enderecos do Cliente.
  $.ajax({
    url: "control/endereco.php",
    type: "post",
    data: "acao=buscarenderecos",
    dataType: "json",
    success: function(resultado){
      //Verifica se a busca foi realizada com sucesso
      if(resultado != 0){

        //Cria as opções de seleção com base nos valores retornados.
        for (var i=0; i < resultado.length; i++) {

          //Verifica se há algum complemento no Endereço.
          if(resultado[i].comp != ""){
            $("#slctendereco").append("<option value='"+ resultado[i].id +"'>"+ resultado[i].rua +" - Nº"+ resultado[i].num +" - "+ resultado[i].comp +" - "+ resultado[i].cid +"</option>");
          }else{
            $("#slctendereco").append("<option value='"+ resultado[i].id +"'>"+ resultado[i].rua +" - Nº"+ resultado[i].num +" - "+ resultado[i].cid +"</option>");
          }

        }
      //Exibe mensagem de erro ao usuário.
      }else{
        //Limpa a caixa de seleção
        $("#slctendereco").empty();
        //Atribui a mensagem à Caixa de Seleção.
        $("#slctendereco").append("<option value='0' selected>Nenhum Endereço Cadastrado</option>");
        //Desabilita a Caixa de Seleção
        $("#slctendereco").attr("disabled", "disabled");
      }
    }
  });

  //Executa modificações nas Divs ao alterar a Caixa de Seleção.
  $("#slctendereco").change(function(){

    //Verifica se o campo alterado ainda é o padrão nulo
    if ($("#slctendereco").val() != 0) {

      $("#cep_text").text("");
      $("#cep_insert_fields").hide();

      $("#transp_list_wrapper").fadeOut(200, function(){

        //Recarrega e exibe as transportadoras
        BuscarTransportadoras();
        $("#transp_list_wrapper").fadeIn(400);

      });

      $("#txtcepfinalizar").val("");

    }else{
      if($("#txtcepfinalizar").val() == ""){
        $("#transp_list_wrapper").fadeOut();
      }
    }
  });

});

//Busca transportadoras aleatória apenas para a exibição
function BuscarTransportadoras(){

  //Envia a requisição de busca para o Controller das Transportadoras.
  $.ajax({
    url: "control/transportadora.php",
    type: "post",
    data: "acao=buscartransportadoras",

    success: function(result){
      if (result) {
        $("#transp_list_wrapper").text("");
		  	if(result != 0){
          $("#transp_list_wrapper").append("<span><strong>Selecione uma Transportadora:</strong></span><br><br>");
		  		for (var i=0; i < result.length; i++) {
		  			$("#transp_list_wrapper").append("<input type='radio' class='rdTransportadora' name='rdTransportadora' value='" + result[i].cod + "'>&nbsp;&nbsp;<span>" + result[i].nome + " - " + result[i].custo + "</span><br>");
		  		}

		  	}
      }
    }, dataType: "json"
  });
}

//Processa os dados e chama a função CadastrarPedido
function FinalizarPedido(idcli){

  //Verifica se algum dos campos foi preenchido
  if($("#slctendereco").val() == 0 && $("#txtcepfinalizar").val() == ""){
    alert("Por favor, escolha um endereço para a entrega !");
  }else{

    var transp = "";
    var idend = "";

    //Verifica se alguma radio foi selecionada
    if ($(".rdTransportadora").is(":checked")) {

      //Adquire o valor da radio selecionada
      transp = $(".rdTransportadora:checked").val();

      //Verifica se a pessoa escolheu um endereço dos cadastrados ou inseriu um diferente
      if($("#slctendereco").val() == 0){

        //Verifica se o compo número está vazio.
        if ($("#txtnum").val() == "") {
          alert("Por favor, insira o número do endereço para a entrega !");
        }else{

          //Obtém o valor das caixas de texto.
          var cep = $("#txtcepfinalizar").val();
          var num = $("#txtnum").val();
          var com = $("#txtcomplemento").val();

          //Obtém os dados do endereço
          var caixaendereco = $("#novoendereco").val();
          var rua = caixaendereco.substring(caixaendereco.lastIndexOf("*") + 1, caixaendereco.lastIndexOf("!"));
          var bairro = caixaendereco.substring(caixaendereco.lastIndexOf("!") + 1, caixaendereco.lastIndexOf("@"));
          var cid = caixaendereco.substring(caixaendereco.lastIndexOf("#") + 1, caixaendereco.lastIndexOf("$"));
          var uf = caixaendereco.substring(caixaendereco.lastIndexOf("@") + 1, caixaendereco.lastIndexOf("#"));

          //Executa uma requisição de Cadastro do novo Endereço
          $.ajax({
            url: "control/endereco.php",
            type: "post",
            data: "acao=cadastrarendereco&idcli=" + idcli + "&cep=" + cep + "&num=" + num + "&com=" + com + "&rua=" + rua + "&bairro=" + bairro + "&cid=" + cid + "&uf=" + uf,
            success: function(resultado){
              //Exibe a mensagem de sucesso para o usuário e recarrega a Página.
              if (resultado == 1) {

                //Executa outra requisição para obter o ID do endereço recém cadastrado.
                $.ajax({
                  url: "control/endereco.php",
                  type: "post",
                  data: "acao=buscarultimoendereco",
                  success: function(resultado){
                    //Atribui o valor do endereço a variável.
                    idend = resultado;
                    CadastrarPedido(transp, idend);
                  }
                });

              //Exibe a mensagem de erro para o usuário
              }else if (resultado == 2) {
                window.parent.window.alert("Este Endereço já está Cadastrado !");
                $("#txtcepfinalizar").val().focus();
              }else{
                window.parent.window.alert("Houve um erro ao Cadastrar o Endereço. Por favor, tente novamente em alguns instantes.");
              }
            }
          });
        }
      }else{
        //Obtem o valor da Caixa de Seleção
        idend = $("#slctendereco").val();
        CadastrarPedido(transp, idend);
      }
    }else{
      alert("Por favor, selecione uma transportadora !");
    }
  }
}

//Executa o Cadastro do Pedido.
function CadastrarPedido(transp, idend){

  //Manda a requisição de finalização do pedido para o Controller de Pedidos.
  $.ajax({
    url: "control/pedido.php",
    type: "post",
    data: "acao=finalizarpedido&transp=" + transp + "&idend=" + idend,
    success: function(resultado){
      if (resultado == 1) {
        alert("Pedido realizado com sucesso ! A RR Outlet Agradece a Preferência !");

        //Redireciona o usuário para a página inicial.
        setTimeout(function(){
          window.location.replace("index.php");
        }, 2000);

      }else{
        alert("Houve um erro ao realizar o pedido. Por favor, tente novamente em alguns instantes !");
      }
    }
  });
}
