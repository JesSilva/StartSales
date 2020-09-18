$("#btnlogin").click(function(){

  //Verifica se os campos email e senha foram preenchidos
  if($("#txtEmail").val() == "" || $("#txtSenha").val() == ""){
    alert("Por favor, preencha corretamente todos os campos !");
  }else{

    var login = $("#txtEmail").val();
    var pw = $("#txtSenha").val();

    //Envia uma requisição para o Controller de Login
    $.ajax({
      url: "control/login.php",
      type: "post",
      data: "login="+ login +"&pw=" + pw,
      success: function(result){

        //Login bem sucedido.
        if (result == 1) {
          //Redireciona o usuário para a página principal
          window.location.replace("index.php");

        //Login mal sucedido.
        }else{
          //Exibe mensagem de erro.
          alert("Credenciais incorretas. Por favor, verifique seus dados e tente novamente.");
        }
      }
    });

  }

});
