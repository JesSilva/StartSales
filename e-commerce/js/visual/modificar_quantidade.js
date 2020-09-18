var vlr_original;
var qtd;

$("#btnadd_produto").click(function(){

  qtd = $("#txtqtd_produto").val();

  if(qtd >= 50){
    alert("Quantidade Inválida");
  }else{
    qtd++;
  }

  $("#txtqtd_produto").val(qtd);
  var vlr = vlr_original * qtd;
  $("#vlr_produto_container").text(" " + vlr.toLocaleString('pt-BR'));

});

$("#btnremover_produto").click(function(){

  qtd = $("#txtqtd_produto").val();

  if(qtd <= 1){
    alert("Quantidade Inválida");
  }else{
    qtd--;
  }

  $("#txtqtd_produto").val(qtd);
  var vlr = vlr_original * qtd;
  $("#vlr_produto_container").text(" " + vlr.toLocaleString('pt-BR'));

});

$("#txtqtd_produto").change(function(){

  if($("#txtqtd_produto").val() < 1 || $("#txtqtd_produto").val() > 50){
    $("#txtqtd_produto").val(1);
    $("#vlr_produto_container").text(vlr_original);
  }else{
    qtd = $("#txtqtd_produto").val();

    var vlr = vlr_original * qtd;
    $("#vlr_produto_container").text(" " + vlr.toLocaleString('pt-BR'));
  }
});
