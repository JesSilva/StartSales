//Função de inserção de categorias.
function CadastrarCategoria(){

  //Verifica se a caixa de texto está vazia.
  if ($("#txtNomeCategoria").val() != '') {

    //Obtém o valor da caixa de texto
    var nome = $("#txtNomeCategoria").val();

    //Envia a requisição para o Controller de Categorias.
    $.ajax({
      url: "php/controller/categorias.php",
      type: "post",
      data: "acao=cadastrarcategoria&nome=" + nome,
      success: function(resultado){
        //Verifica o resultado da operação
        if (resultado == 1) {

          //Exibe a mensagem para o usuário
          alert("Categoria Inserida com Sucesso !");

          setTimeout(function(){
            //Redireciona o Usuário.
            window.location.replace("listacategorias.php");
          }, 1000);

        //Operação mal sucedida.
        }else{
          //Exibe mensagem de Erro para o usuário.
          alert("Erro ao Cadastrar a Categoria: Já existe uma Categoria com este Nome !");
        }
      }
    });

  }else{
    //Exibe a mensagem de erro para o usuário.
    alert("O Nome da Categoria não pode estar Vazio. Por favor, preencha-o corretamente !");
  }
}

//Função de exclusão de categorias.
function ExcluirCategoria(id){

  //Verifica se o usuário realmente deseja excluir a categoria
  if (confirm("Deseja realmente excluir esta Categoria ?")) {

    //Envia a requisição para o Controller de Categorias.
    $.ajax({
      url: "php/controller/categorias.php",
      type: "post",
      data: "acao=excluircategoria&c=" + id,
      success: function(resultado){
        //Verifica o resultado da operação
        if (resultado == 1) {

          //Exibe a mensagem para o usuário
          alert("Categoria excluída com Sucesso !");

          setTimeout(function(){
            //Recarrega a Página
            window.location.reload();
          }, 1000);

        //Operação mal sucedida.
        }else{
          //Exibe mensagem de Erro para o usuário.
          alert("Erro ao Excluir a Categoria: Existem Produtos associados a esta Categoria !");
        }
      }
    });
  }
}

//Função de Edição de categorias.
function AlterarCategoria(id){

  //Verifica se a caixa de texto está vazia.
  if ($("#txtNomeCategoria").val() != '') {

    //Obtém o valor da caixa de texto
    var nome = $("#txtNomeCategoria").val();

    //Envia a requisição para o Controller de Categorias.
    $.ajax({
      url: "php/controller/categorias.php",
      type: "post",
      data: "acao=alterarcategoria&id="+ id +"&nome=" + nome,
      success: function(resultado){
        //Verifica o resultado da operação
        if (resultado == 1) {

          //Exibe a mensagem para o usuário
          alert("Categoria Alterada com Sucesso !");

          setTimeout(function(){
            //Redireciona o Usuário
            window.location.replace("listacategorias.php");
          }, 1000);

        //Operação mal sucedida.
        }else{
          //Exibe mensagem de Erro para o usuário.
          alert("Erro ao Alterar a Categoria: Já existe uma Categoria com este Nome !");
        }
      }
    });
  }else{
    //Exibe a mensagem de erro para o usuário.
    alert("O Nome da Categoria não pode estar Vazio. Por favor, preencha-o corretamente !");
  }
}
