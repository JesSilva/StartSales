//Função executada após a página ser carregada.
$(document).ready(function(){

  //Obtém os dados do gráfico de barras
  var ctx = document.getElementById('vendasanual');
  var dados = "";

  //Envia uma requisição de busca dos dados do primeiro gráfico para o Controller
  $.ajax({
    url: "php/controller/indexcontroller.php",
    type: "post",
    data: "acao=graficoanualvendas",
    dataType: "json",
    success: function(resultado){

      //Monta o gráfico de barras
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        datasets: [{
            label: 'Vendas',
            data: resultado,
            backgroundColor: ['rgba(5, 225, 245, 0.4)'],
            pointBackgroundColor: ['rgba(5, 225, 245, 1)'],
            borderColor: ['rgba(3, 150, 163, 1)'],
            borderWidth: 2,
            pointBorderWidth: 7,
            pointHoverBackgroundColor: 'rgba(18, 126, 176)',
            pointHoverBorderColor: 'rgba(18, 126, 176)'
          }]

          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  suggestedMax: 35,
                }
              }]
            }
          }
      });

    }
  });

  //Obtém os dados do grafico de rosquinha
  var ctx2 = document.getElementById("maisvendidossemana");

  //Envia uma requisição de busca dos dados do segundo gráfico para o Controller
  $.ajax({
    url: "php/controller/indexcontroller.php",
    type: "post",
    data: "acao=graficovendidossemana",
    dataType: "json",
    success: function(resultado2){

      var categorias = [];
      var vendas = [];

      //Separa os valores
      for(var i = 0; i < resultado2.length; i++){
        categorias[i] = resultado2[i].cat;
        vendas[i] = resultado2[i].qtd;
      }

      //Monta o Gráfico Rosquinha
      if (ctx2) {
        ctx2.height = 270;
        var myChart = new Chart(ctx2, {
          type: 'doughnut',
          data: {
            datasets: [
              {
                label: "",
                data: vendas,
                backgroundColor: [
                  '#00b5e9',
                  '#fa4251',
                  '#346445',
                  '#4d83bb',
                  '#3ebcf1',
                  '#ce0c9e',
                  '#c16ed9'
                ],
                hoverBackgroundColor: [
                  '#00b5e9',
                  '#fa4251',
                  '#346445',
                  '#4d83bb',
                  '#3ebcf1',
                  '#ce0c9e',
                  '#c16ed9'
                ],
                borderWidth: [
                  0, 0
                ],
                hoverBorderColor: [
                  'transparent',
                  'transparent'
                ]
              }
            ],
            labels: categorias
          },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            cutoutPercentage: 55,
            animation: {
              animateScale: true,
              animateRotate: true
            },
            legend: {
              display: false
            },
            tooltips: {
              titleFontFamily: "Poppins",
              xPadding: 15,
              yPadding: 10,
              caretPadding: 0,
              bodyFontSize: 16
            }
          }
        });
      }

    },
    error: function(resultado2){
      $(".maisvendidossemana").html("<br><br><span>Nenhum Produto vendido esta semana</span>");
    }
  });
});
