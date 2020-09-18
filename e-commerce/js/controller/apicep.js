//CEP da página admincli.php
$("#cep").blur(function() {

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#uf").val("...");
            $("#ibge").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#rua").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#uf").val(dados.uf);
                    $("#ibge").val(dados.ibge);
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpar_campos_endereco();
                    alert("CEP não encontrado.");
                }
            });

        }else {
            limpar_campos_endereco();
            alert("Formato de CEP inválido.");
        }

    }else {
      limpar_campos_endereco();
    }
});

//CEP da página finalizar.php
$("#txtcepfinalizar").blur(function(){

  //Verifica se a Caixa está vazia
  if($("#txtcepfinalizar").val() != ""){

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Expressão regular para validar o CEP.
    var validacep = /^[0-9]{8}$/;

    //Valida o formato do CEP.
    if(validacep.test(cep)) {

      //Consulta o webservice viacep.com.br/
      $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

          if (!("erro" in dados)) {

            //Volta o select de endereços pro valor padrão nulo
            $("#slctendereco").val(0);

            //Recarrega os dados do endereço
            $("#cep_insert_fields").fadeOut(500, function(){

              //Limpa as caixas de texto
              $("#txtnum").val("");
              $("#txtcomplemento").val("");

              //Coloca os Dados do Endereco numa caixa de texto oculta.
              $("#cep_insert_fields").append("<input id='novoendereco' type='hidden' value='*" + dados.logradouro + "!" + dados.bairro + "@" + dados.uf + "#" + dados.localidade + "$'>")

              $("#cep_text").text(dados.logradouro + ", " + dados.bairro + " - " + dados.uf);

              //Esconde e recarrega as transportadoras
              $("#transp_list_wrapper").fadeOut(200);
              BuscarTransportadoras();

              //Exibe os campos e transportadoras
              $("#cep_insert_fields").fadeIn(200);
              $("#transp_list_wrapper").fadeIn(400);
            });
          }else {
              //Exibe uma mensagem de erro para o Usuário.
              alert("CEP não encontrado !");
              $("#txtcepfinalizar").val("");
              $("#txtcepfinalizar").focus();
          }
      });
    }else{
      //Exibe uma mensagem de erro para o Usuário.
      alert("Formato de CEP inválido !");
      $("#txtcepfinalizar").val("");
      $("#txtcepfinalizar").focus();
    }
  }
});

//Limpa os campos do Cadastro de Endereços
function limpar_campos_endereco() {
  $("#cep").val("").focus();
  $("#rua").val("");
  $("#num").val("");
  $("#comp").val("");
  $("#bairro").val("");
  $("#cidade").val("");
  $("#uf").val("");
  $("#ibge").val("");
}
