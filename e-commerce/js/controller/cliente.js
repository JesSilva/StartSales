//Cria a conta do cliente
$("#btncriarconta").click(function(){

  //Verifica se não há campos vazios.
  if($("#txtNomeCadastro").val() == "" || $("#txtSobrenomeCadastro").val() == "" ||
    $("#txtNumDocCadastro").val() == "" || $("#txtEmailCadastro").val() == ""
    || $("#txtSenhaCadastro").val() == ""){

      alert("Por favor, preencha corretamente todos os campos !");

    }else{

      //Obtém os valores das caixas de texto
      var nome = $("#txtNomeCadastro").val();
      var sobrenome = $("#txtSobrenomeCadastro").val();
      var numdoc = $("#txtNumDocCadastro").val();
      var email = $("#txtEmailCadastro").val();
      var pw = $("#txtSenhaCadastro").val();

      //Realiza a requisição AJAX para o cadastro
      $.ajax({
        url: "control/cliente.php",
        type: "post",
        data: "acao=novaconta&nome="+ nome +"&sobrenome=" + sobrenome + "&email=" + email + "&doc=" + numdoc + "&pw=" + pw,
        success: function(resultado){
          //SUCESSO
          if (resultado == 1) {
            alert("Cadastro bem sucedido ! Bem-vindo(a) à RR Outlet !");

            setTimeout(function(){
              window.location.replace("index.php");
            }, 2000);

          //ERRO - Email já registrado.
          }else if (resultado == 2) {
            alert("Este endereço de Email já foi Registrado !");
            $("#txtEmailCadastro").val("").focus();

          //ERRO - CPF/CNPJ já registrado.
          }else if (resultado == 3) {
            alert("Este CPF/CNPJ já foi Registrado !");
            $("#txtNumDocCadastro").val("").focus();

          //ERRO - Outro.
          }else{
            alert("Não foi possível finalizar seu Cadastro. Por favor, tente novamente em alguns instantes.");
          }
        }
      });

    }
});

//Altera os dados pessoais do cliente
$("#btninfopessoais").click(function(){

  //Verifica se todos os campos foram preenchidos corretamente.
  if($("#txtfirstname").val() == "" || $("#txtlastname").val() == "" ||
      $("#txtmail").val() == "" || $("#txtnumdoc").val() == ""){

        alert("Por favor, preencha corretamente todos os campos !");

  }else{

    //Obtém a ID do usuário
    var id = $("#btninfopessoais").val();

    //Obtém os valores digitados
    var nome = $("#txtfirstname").val();
    var sobrenome = $("#txtlastname").val();
    var email = $("#txtmail").val();
    var doc = $("#txtnumdoc").val();

    //Envia a requisição para a página Controller de Clientes
    $.ajax({
      url: "control/cliente.php",
      type: "post",
      data: "acao=atualizardadospessoais&id="+ id +"&nome="+ nome +"&sobrenome=" + sobrenome + "&email=" + email + "&numdoc=" + doc,
      success: function(resultado){
        //SUCESSO
        if (resultado == 1) {

          //Exibe uma mensagem de sucesso para o usuário e o redireciona para a tela de login.
          alert("Informações Pessoais Atualizadas com Sucesso !");
          setTimeout(function(){
            window.location.replace("login.php");
          }, 2000);

        //ERRO - Email já registrado.
        }else if (resultado == 2) {
          alert("Este endereço de Email já foi Registrado !");
          $("#txtmail").val("").focus();

        //ERRO - CPF/CNPJ já registrado.
        }else if (resultado == 3) {
          alert("Este CPF/CNPJ já foi Registrado !");
          $("#txtnumdoc").val("").focus();

        //ERRO - Outros.
        }else{
          console.log(resultado);
          alert("Não foi possível alterar suas informações pessoais. Por favor, tente novamente em alguns instantes.");
        }
      }
    });
  }
});

//Altera a Senha do cliente
$("#btnalterarsenha").click(function(){

  if($("#txtnovasenha").val() != $("#txtrepetirsenha").val()){
    alert("As senhas digitadas não são iguais.");
  }else{
    if($("#txtsenhaantiga").val() == $("#txtnovasenha").val()){
      alert("Sua nova senha não pode ser igual a antiga.");
    }else{

      var id = $("#btnalterarsenha").val();
      var pw = $("#txtnovasenha").val();

      $.ajax({
        url: "control/cliente.php", //Página alvo
        type: "post", //Metodo de envio
        data: "acao=atualizarsenha&id="+ id +"&newpw="+ pw, //Dados que serão enviados até a página

        success: function(result){
          if (result == 1) {
            alert("Senha Atualizada com Sucesso !");

            setTimeout(function(){
              window.location.replace("login.php");
            }, 2000);

          }else{
            alert("Não foi possível alterar sua senha. Por favor, tente novamente em alguns instantes.");
          }
        }
      });

    }
  }
});
