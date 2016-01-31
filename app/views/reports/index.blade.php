@extends('layouts.master')

@section('external-styles')
    
    <link rel="stylesheet" type="text/css" href="/jquery.datetimepicker.css">
@stop

@section('content')
    <h2 class="head-1">Reports</h2><hr/>

    {{ Session::get('production_id')}}

    <p> Statistics</p>

    

    <div id="container"></div>
    <div id="container-two"></div>
    <!-- <p>   a fuck*ng bar graph</p> -->

    <canvas id="bar-chart" width="800" height="300"></canvas>


@stop

@section('external-scripts')
    <script src="/js/chart.min.js"></script>
    <script type="text/javascript" src="/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="/highcharts/exporting.js"></script>

    <script>


        // var ctx_line = document.getElementById('line-chart').getContext('2d');
        var ctx_bar = document.getElementById('bar-chart').getContext('2d');

      

       // new Chart(ctx_line).Line(chart);
        // new Chart(ctx_bar).Bar(chart);


        //  highcharts bar graph


$(function () {
    $('#container-two').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Monthly Average Temperature'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Sales',
            data: {{ json_encode($sales) }}
        }]
    });
});//end chart



            
           
    </script>

    <script type="text/javascript" src="/datepicker/jquery.datetimepicker.js"></script>



@stop



