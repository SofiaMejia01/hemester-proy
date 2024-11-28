$(document).ready(function () {
  // Pie Chart Data
  Highcharts.chart("pieChart", {
    chart: {
      type: "pie",
    },
    title: {
      text: "Distribución de Tipos de Joyería",
    },
    series: [
      {
        name: "Ventas de Joya",
        colorByPoint: true,
        data: [
          { name: "Anillo", y: 25 },
          { name: "Aretes", y: 20 },
          { name: "Aros", y: 15 },
          { name: "Gemelos", y: 10 },
          { name: "Pulsera y Brazalete", y: 20 },
          { name: "Dijes y Collares", y: 10 },
          { name: "Plata 950", y: 5 },
        ],
      },
    ],
    colors: ["#004080", "#0073e6", "#ffcc00", "#0059b3", "#3399ff", "#66ccff"],
  });

  // Bar Chart Data
  Highcharts.chart("barChart", {
    chart: {
      type: "column",
    },
    title: {
      text: "Ventas por Mes (Primer Semestre)",
    },
    xAxis: {
      categories: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
    },
    yAxis: {
      min: 0,
      title: {
        text: "Ventas (USD)",
      },
    },
    series: [
      {
        name: "Ventas",
        data: [18000, 17000, 19000, 22000, 21000, 20000],
        color: "#0073e6",
      },
    ],
  });

  // Line Chart Data
  Highcharts.chart("lineChart", {
    chart: {
      type: "line",
    },
    title: {
      text: "Tendencia de Ventas (Primer Semestre)",
    },
    xAxis: {
      categories: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"],
    },
    yAxis: {
      title: {
        text: "Ventas (USD)",
      },
    },
    series: [
      {
        name: "Ventas",
        data: [18000, 17000, 19000, 22000, 21000, 20000],
        color: "#ffcc00",
      },
    ],
  });
});
