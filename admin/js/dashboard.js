const getChartOptions = () => {
  return {
    series: [15, 28, 57],
    colors: ["#dbdabe", "#50463c", "#243956"],
    chart: {
      height: 420,
      width: "100%",
      type: "pie",
    },
    stroke: {
      colors: ["white"],
      lineCap: "",
    },
    plotOptions: {
      pie: {
        labels: {
          show: true,
        },
        size: "100%",
        dataLabels: {
          offset: -25,
        },
      },
    },
    labels: ["Afirmasi", "Prestasi", "Reguler"],
    dataLabels: {
      enabled: true,
      style: {
        fontFamily: "Inter, sans-serif",
      },
    },
    legend: {
      position: "bottom",
      fontFamily: "Inter, sans-serif",
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return value + "%";
        },
      },
    },
    xaxis: {
      labels: {
        formatter: function (value) {
          return value + "%";
        },
      },
      axisTicks: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
    },
  };
};

if (document.getElementById("pie-chart") && typeof ApexCharts !== "undefined") {
  const chart = new ApexCharts(
    document.getElementById("pie-chart"),
    getChartOptions()
  );
  chart.render();
}
