//Função de inserção de transportadoras.
function CadastrarTransportadora(){

  //Verifica se as caixas de texto estão vazias.
  if ($("#txtNomeTransportadora").val() != '' || $("#txtDescricaoTransportadora").val() == '') {

    //Obtém os valores das caixas de texto
    var nome = $("#txtNomeTransportadora").val();
    var desc = $("#txtDescricaoTransportadora").val();

    //Envia a requisição para o Controller de Transportadoras.
    $.ajax({
      url: "php/controller/transportadoras.php",
      type: "post",
      data: "acao=cadastrartransportadora&nome=" + nome + "&desc=" + desc,
      success: function(resultado){
        //Verifica o resultado da operação
        if (resultado == 1) {

          //Exibe a mensagem para o usuário
          alert("Transportadora Inserida com Sucesso !");

          setTimeout(function(){
            //Redireciona o Usuário.
            window.location.replace("listatransportadoras.php");
          }, 1000);

        //Operação mal sucedida.
        }else{
          //Exibe mensagem de Erro para o usuário.
          alert("Erro ao Cadastrar a Transportadora: Já existe uma Transportadora com este Nome !");
        }
      }
    });

  }else{
    //Exibe a mensagem de erro para o usuário.
    alert("Por favor, preencha corretamente todos os campos!");
  }
}

//Função de exclusão de transportadoras.
function ExcluirTransportadora(id){

  //Verifica se o usuário realmente deseja excluir a categoria
  if (confirm("Deseja realmente excluir esta Transportadora ?")) {

    //Envia a requisição para o Controller de Transportadoras.
    $.ajax({
      url: "php/controller/transportadoras.php",
      type: "post",
      data: "acao=excluirtransportadora&id=" + id,
      success: function(resultado){
        //Verifica o resultado da operação
        if (resultado == 1) {

          //Exibe a mensagem para o usuário
          alert("Transportadora excluída com Sucesso !");

          setTimeout(function(){
            //Recarrega a Página
            window.location.reload();
          }, 1000);

        //Operação mal sucedida.
        }else{
          //Exibe mensagem de Erro para o usuário.
          alert("Erro ao Excluir a Transportadora");
        }
      }
    });
  }
}

//Função de Edição de transportadoras.
function AlterarTransportadora(id){

  //Verifica se as caixas de texto estão vazias.
  if ($("#txtNomeTransportadora").val() != '' || $("#txtDescricaoTransportadora").val() == '') {

    //Obtém os valores das caixas de texto
    var nome = $("#txtNomeTransportadora").val();
    var desc = $("#txtDescricaoTransportadora").val();

    //Envia a requisição para o Controller de Transportadoras.
    $.ajax({
      url: "php/controller/transportadoras.php",
      type: "post",
      data: "acao=alterartransportadora&id="+ id +"&nome=" + nome + "&desc=" + desc,
      success: function(resultado){
        //Verifica o resultado da operação
        if (resultado == 1) {

          //Exibe a mensagem para o usuário
          alert("Transportadora Alterada com Sucesso !");

          setTimeout(function(){
            //Redireciona o Usuário
            window.location.replace("listatransportadoras.php");
          }, 1000);

        //Operação mal sucedida.
        }else{
          //Exibe mensagem de Erro para o usuário.
          alert("Erro ao Alterar a Transportadora: Já existe uma Transportadora com este Nome !");
        }
      }
    });
  }else{
    //Exibe a mensagem de erro para o usuário.
    alert("Existem campos não preenchidos. Por favor, preencha-os corretamente !");
  }
}
