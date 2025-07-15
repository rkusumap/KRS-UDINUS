@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('page-tittle')
Dashboard
@endsection

@section('content')
<style>
    .sortable > li > div {
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    .sortable, .sortable > li > div {
        display: block;
        width: 100%;
        float: left;
    }

    .sortable > li {
        display: block;
        width: 100%;
        margin-bottom: 5px;
        float: left;
        border: 1px solid #ddd;
        background : #fff;
        padding: 5px;
    }
    .sortable ul {
        padding: 5px;
    }
</style>

<div class="card">
    <div class="card-body">
       <canvas id="myChartNew" width="400" height="200"></canvas>
    </div>
</div>

@endsection

@section('script')
<script src="custom/chart/dist/chart.umd.js"></script>
<script>
// Simulate Utils.CHART_COLORS
const Utils = {
      CHART_COLORS: {
        red: 'rgb(255, 99, 132)',
        blue: 'rgb(54, 162, 235)',
        green: 'rgb(75, 192, 192)'
      }
    };

    const DATA_COUNT = 12;
    const labels = [];
    for (let i = 0; i < DATA_COUNT; ++i) {
      labels.push(i.toString());
    }

    const datapoints = [0, 20, 20, 60, 60, 120, NaN, 180, 120, 125, 105, 110, 170];

    const data = {
      labels: labels,
      datasets: [
        {
          label: 'Cubic interpolation (monotone)',
          data: datapoints,
          borderColor: Utils.CHART_COLORS.red,
          fill: false,
          cubicInterpolationMode: 'monotone',
          tension: 0.4
        },
        {
          label: 'Cubic interpolation',
          data: datapoints,
          borderColor: Utils.CHART_COLORS.blue,
          fill: false,
          tension: 0.4
        },
        {
          label: 'Linear interpolation (default)',
          data: datapoints,
          borderColor: Utils.CHART_COLORS.green,
          fill: false
        }
      ]
    };

    const config = {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Chart.js Line Chart - Cubic interpolation mode'
          },
        },
        interaction: {
          intersect: false,
        },
        scales: {
          x: {
            display: true,
            title: {
              display: true
            }
          },
          y: {
            display: true,
            title: {
              display: true,
              text: 'Value'
            },
            suggestedMin: -10,
            suggestedMax: 200
          }
        }
      },
    };

    // Render the chart
    const ctx = document.getElementById('myChartNew').getContext('2d');
    new Chart(ctx, config);
</script>

@endsection
