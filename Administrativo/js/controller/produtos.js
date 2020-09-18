//Cadastra um Produto no Banco de Dados ao enviar o formulário
$(document).ready(function (e) {
  //Cadastro do Produto
  $("#cadastrarproduto").on('submit',(function(e){
    //Previne a atualização da página
    e.preventDefault();

    //Verifica se há campos em branco
    if ($("#txtNomeProduto").val() == '' || $("#txtDescricaoProduto").val() == '' ||
        $("#txtValorProduto").val() == '' || $("#txtQuantidadeProduto").val() == '') {
          alert("Por favor, preencha corretamente todos os Campos.");
    }else{

      //Verifica se há valores impróprios
      if ($("#txtValorProduto").val() <= 0 || $("#txtQuantidadeProduto").val() <= 0) {
        alert("Por favor, insira valores válidos");
      }else{

        //Verifica se o usuário escolhei uma imagem
        if ($("#ImgProduto").val() == '') {
          alert("Por favor, escolha uma Imagem");
        }else{

          //Verifica se o usuário escolheu uma Categoria
          if ($("#slctCategoria").val() == 0) {
            alert("Por favor, escolha uma Categoria");
          }else{

            //Envia a requisição para o Controller de Produtos.
            $.ajax({
              url: "php/controller/produtos.php?cadastro",
              type: "post",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData: false,
              success: function(resultado){
                //Verifica o resultado da operação
                if (resultado == 1) {

                  //Exibe a mensagem para o usuário
                  alert("Produto Cadastrado com Sucesso !");

                  setTimeout(function(){
                    //Redireciona o Usuário.
                    window.location.replace("listaprod.php");
                  }, 1000);


                }else if (resultado == 2) {
                  //ERRO: Extensão Inválida
                  alert("Erro: Por favor, escolha um arquivo de Imagem Correto !");

                }else if (resultado == 3) {
                  //ERRO: Arquivo já existe na pasta alvo
                  alert("Erro: Um mesmo arquivo com este Nome já Existe. Por favor, Renomeie a Imagem.");
                }else if (resultado == 4) {
                  //ERRO: Arquivo não pode ser movido
                  alert("Erro: O arquivo não pôde ser Movido.");
                }else if (resultado == 5) {
                  //ERRO: Arquivo não pode ser movido
                  alert("Erro: Não foi possível Cadastrar o Produto no Banco de Dados.");
                }else if (resultado == 6) {
                  //ERRO: Arquivo não pode ser movido
                  alert("Erro: Não foi possível Cadastrar o Backup do Produto no Banco de Dados.");
                }
              }
            });

          }
        }
      }
    }
  }));

  //Alteração do produto
  $("#modificarproduto").on('submit',(function(e){
    //Previne a atualização da página
    e.preventDefault();

    //Verifica se há campos em branco
    if ($("#txtNomeProduto").val() == '' || $("#txtDescricaoProduto").val() == '' ||
        $("#txtValorProduto").val() == '' || $("#txtQuantidadeProduto").val() == '') {
          alert("Por favor, preencha corretamente todos os Campos.");
    }else{

      //Verifica se há valores impróprios
      if ($("#txtValorProduto").val() <= 0 || $("#txtQuantidadeProduto").val() <= 0) {
        alert("Por favor, insira valores válidos");
      }else{

        //Verifica se o usuário escolheu uma Categoria
        if ($("#slctCategoria").val() == 0) {
          alert("Por favor, escolha uma Categoria");
        }else{

          //Envia a requisição para o Controller de Produtos.
          $.ajax({
            url: "php/controller/produtos.php?alterar",
            type: "post",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(resultado){
              //Verifica o resultado da operação
              if (resultado == 1) {

                //Exibe a mensagem para o usuário
                alert("Produto Atualizado com Sucesso !");

                setTimeout(function(){
                  //Redireciona o Usuário.
                  window.location.replace("listaprod.php");
                }, 1000);


              }else if (resultado == 2) {
                //ERRO: Extensão Inválida
                alert("Erro: Por favor, escolha um arquivo de Imagem Correto !");

              }else if (resultado == 3) {
                //ERRO: Arquivo já existe na pasta alvo
                alert("Erro: Um mesmo arquivo com este Nome já Existe. Por favor, Renomeie a Imagem.");
              }else if (resultado == 4) {
                //ERRO: Arquivo não pode ser movido
                alert("Erro: O arquivo não pôde ser Movido.");
              }else if (resultado == 5) {
                //ERRO: Arquivo não pode ser movido
                alert("Erro: Não foi possível Cadastrar o Produto no Banco de Dados.");
              }else if (resultado == 6) {
                //ERRO: Arquivo não pode ser movido
                alert("Erro: Não foi possível Cadastrar o Backup do Produto no Banco de Dados.");
              }else{
                console.log(resultado);
              }
            }
          });

        }
      }
    }
  }));
});

//Remove um Produto do Banco de Dados
function RemoverProduto(id){

  //Verifica se o usuário realmente deseja excluir o produto
  if (confirm("Deseja realmente excluir este Produto ?")) {

    //Envia a requisição para o Controller de Produtos.
    $.ajax({
      url: "php/controller/produtos.php",
      type: "post",
      data: "acao=excluirproduto&id=" + id,
      success: function(resultado){
        //Verifica o resultado da operação
        if (resultado == 1) {

          //Exibe a mensagem para o usuário
          alert("Produto excluído com Sucesso !");

          setTimeout(function(){
            //Recarrega a Página
            window.location.reload();
          }, 1000);

        //Operação mal sucedida.
        }else{
          //Exibe mensagem de Erro para o usuário.
          alert("Houve um erro ao excluir o Produto");
        }
      }
    });
  }

}
