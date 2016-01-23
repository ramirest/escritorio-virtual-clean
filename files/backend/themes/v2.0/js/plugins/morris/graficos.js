//Ultimos cadastros
Morris.Donut({
element: 'morris-chart-donut',
data: [
 {label: "MENSAL", value: $("#cad_mes").val()},
 {label: "SEMANAL", value: $("#cad_semana").val()}
],
resize: true,
colors: ['#16a085','#2980b9'],
formatter: function (y) { return y ;}
});