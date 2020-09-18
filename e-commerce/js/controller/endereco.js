//Ao carregar a página, realiza uma busca por Todos os Endereços do Cliente.
$(document).ready(function(){

  //Envia uma requisição de busca para o Controller de Endereços.
  $.ajax({
    url: "../control/endereco.php",
    type: "post",
    data: "acao=buscarenderecos",
    dataType: "json",
    success: function(resultado){

      //Caso houverem resultados, exibe-os na tela
      if (resultado != 0) {

        for(var i = 0; i < resultado.length; i++){

          //Exibe o endereço na tela
          $("#tbodylistaenderecos").append(
            "<tr>" +
              "<td>"+ resultado[i].rua +"</td>" +
              "<td>"+ resultado[i].num +"</td>" +
              "<td>"+ resultado[i].comp +"</td>" +
              "<td>"+ resultado[i].est +"</td>" +
              "<td>"+ resultado[i].cid +"</td>" +
              "<td>"+ resultado[i].cep +"</td>" +
              "<td><button id='btnalterarendereco' onclick='AlterarEndereço("+ resultado[i].id +")' class='btn btn-info collapsed'>Alterar</button></td>" +
              "<td><button id='btnexcluirendereco' onclick='ExcluirEndereco("+ resultado[i].id +")' class='btn btn-danger collapsed'>Excluir</button></td>" +
            "</tr>"
          );

        }

      //Caso não houverem, exibe uma mensagem.
      }else{
        $("#tbodylistaenderecos").append("<tr><td colspan='8' style='text-align:center;'>Nenhum Endereço Encontrado !</td></tr>");
      }
    }
  });
});

//Cadastra ou Altera algum Endereço
function SalvarEndereco(){
  if($("#btnsalvarendereco").text() == 'Cadastrar'){
    //Atribui os valores das caixas de texto em variáveis.
    var idcli = $("#btnsalvarendereco").val();
    var cep = $("#cep").val();
    var num = $("#num").val();
    var com = $("#comp").val();
    var rua = $("#rua").val();
    var bairro = $("#bairro").val();
    var cid = $("#cidade").val();
    var uf = $("#uf").val();

    //Verifica se algum campo obrigatório não foi preenchido
    if(cep == "" || num == "" || rua == "" || bairro == "" || cid == "" || uf == ""){
      window.parent.window.alert("Por favor, preencha corretamente todos os campos");
    }else{

      //Envia a requisição de Cadastro para o Controller
      $.ajax({
        url: "../control/endereco.php",
        type: "post",
        data: "acao=cadastrarendereco&idcli=" + idcli + "&cep=" + cep + "&num=" + num + "&com=" + com + "&rua=" + rua + "&bairro=" + bairro + "&cid=" + cid + "&uf=" + uf,
        success: function(resultado){

          //Exibe a mensagem de sucesso para o usuário e recarrega a Página.
          if (resultado == 1) {
            window.parent.window.alert("Cadastro de Endereço bem sucedido !");

            setTimeout(function(){
              location.reload();
            }, 2000);

          //Exibe a mensagem de erro para o usuário
          }else if (resultado == 2) {
            window.parent.window.alert("Este Endereço já foi Cadastrado !");
          }else{
            window.parent.window.alert("Houve um erro ao Cadastrar o Endereço. Por favor, tente novamente em alguns instantes.");
          }
        }
      });
    }
  }else if ($("#btnsalvarendereco").text() == 'Alterar') {

    //Atribui os valores das caixas de texto em variáveis.
    var idend = $("#btnsalvarendereco").val();
    var cep = $("#cep").val();
    var num = $("#num").val();
    var com = $("#comp").val();
    var rua = $("#rua").val();
    var bairro = $("#bairro").val();
    var cid = $("#cidade").val();
    var uf = $("#uf").val();

    //Verifica se algum campo obrigatório não foi preenchido
    if(cep == "" || num == "" || rua == "" || bairro == "" || cid == "" || uf == ""){
      window.parent.window.alert("Por favor, preencha corretamente todos os campos");
    }else{

      //Envia a requisição de Edição para o Controller
      $.ajax({
        url: "../control/endereco.php",
        type: "post",
        data: "acao=atualizarendereco&idend=" + idend + "&cep=" + cep + "&num=" + num + "&com=" + com + "&rua=" + rua + "&bairro=" + bairro + "&cid=" + cid + "&uf=" + uf,
        success: function(resultado){
          //Exibe a mensagem de sucesso para o usuário e recarrega a Página.
          if (resultado == 1) {
            window.parent.window.alert("Alteração do Endereço bem sucedida !");

            setTimeout(function(){
              location.reload();
            }, 2000);

          //Exibe a mensagem de erro para o usuário.
          }else if (resultado == 2) {
            window.parent.window.alert("Este Endereço já foi Cadastrado !");
          }else{
            window.parent.window.alert("Não foi possível atualizar o endereço. Por favor, tente novamente em alguns instantes.");
          }
        }
      });
    }
  }
}

//Busca um Endereço no banco para Edição
function AlterarEndereço(idendereco){

  //Envia a requisição para o Controller
  $.ajax({
    url: "../control/endereco.php",
    type: "post",
    data: "acao=buscarendereco&idend=" + idendereco,
    dataType: "json",
    success: function(resultado){

      //Dados são atribuidos as caixas de texto
      $("#btnsalvarendereco").attr('value', resultado.id_end);
      $("#btnsalvarendereco").text("Alterar");
      $("#cep").val(resultado.cep);
      $("#num").val(resultado.num);
      $("#comp").val(resultado.com);
      $("#rua").val(resultado.rua);
      $("#bairro").val(resultado.bairro);
      $("#cidade").val(resultado.cid);
      $("#uf").val(resultado.uf);

      $(".listaenderecos").fadeOut(500, function(){
        $(".gerenciarenderecos").fadeIn(500);
      });
    }
  });
}

//Exclui um Endereço do Cliente.
function ExcluirEndereco(idendereco){

  //Confirmação de Escolha .
  if (window.parent.window.confirm("Deseja Realmente excluir este Endereço ?")) {

    //Requisição de exclusão para o Controller.
    $.ajax({
      url: "../control/endereco.php",
      type: "post",
      data: "acao=excluirendereco&idend=" + idendereco,
      success: function(resultado){

        //Exibe a mensagem de sucesso para o usuário e recarrega a página.
        if (resultado == 1) {
          window.parent.window.alert("Endereço excluído com Sucesso !");

          setTimeout(function(){
            location.reload();
          }, 2000);

        //Exibe a mensagem de Erro para o Usuário.
        }else{
          window.parent.window.alert("Não foi possível excluir o endereço. Por favor, tente novamente em alguns instantes.");
        }
      }
    });
  }
}
