<!DOCTYPE html>
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<body>
<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

<script>
const xValues = [50,60,70,80,90,100,110,120,130,140,150];
const yValues = [7,8,8,9,9,9,10,11,14,14,15];

var cData = JSON.parse(`<?php echo $chart_data; ?>`);

console.log(cData)

var maxx = cData.data.reduce((a, b) => Math.max(a, b), -Infinity) +3;

console.log(maxx)

new Chart("myChart", {
  type: "line",
  data: {
    labels: cData.label,
    datasets: [{
      fill: false,
      lineTension: 0,
      borderColor: "red",
      data: cData.data
    },
    {
      fill: false,
      lineTension: 0,
      borderColor: "blue",
      data: cData.data
    }

    ]
  },
  options: {
    legend: {display: true},
    scales: {
      yAxes: [{ticks: {min: 0, max:maxx}}],
    }
  }
});
</script>

</body>
</html>


