@extends('layouts.master')

@section('external-styles')
    
    <link rel="stylesheet" type="text/css" href="/datepicker/jquery.datetimepicker.css">
@stop


@section('content')
    <h2 class="head-1">Reports</h2><hr/>

    <!-- {{ Session::get('production_id')}} -->

    <p> Statistics</p>
   

    <!-- Reports tabs -->
    <ul class="nav nav-tabs">

      <li class="active"><a href="#sales-tab" data-toggle="tab">Statistical Reports</a></li>
       <li><a href="#reports-panel-tab" data-toggle="tab">Reports Panel</a></li>
     
     
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

      <div class="tab-pane active" id="sales-tab">
      
            <div id="container-one"></div>

            <div class="row">

                <h3 class="head-3">
                    <strong>Top Three Product Best Sellers</strong>
                </h3><hr/>
                 <div class="span6">
                    
                    <canvas width="600" height="400" id="bestsellers"></canvas>
                </div>

                <div class="span6">
                   <ul class="list-group">

                        @foreach($sales_items as $item)
                            <li class="list-group-item" style="padding:5px;background:#fcfcfc;">
                                <img class="pull-right" src="/img/cupcake.jpg" width="50" height="50">
                                <div class="content" style="padding:2px;margin-left:50px;font-size:12px;"> 
                                    <p >
                                        <strong>{{ $item->name }}</strong>
                                    </p>
                               
                                    <p>Php {{ $item->total_sales }} </p>
                                    
                                </div>
                               

                            </li>
                        @endforeach
                      
                   
                    </ul>
                   
                </div>
                
            </div>
           
            
          

      </div><!-- /end of sales tab -->

      <div class="tab-pane" id="reports-panel-tab">
        <h3 class="head-3">Report format  </h3><hr/>
         <div class="row">
            <a class="report-format" data-format="detailed" href="#">
                <div id="selectionPanel" class="span6">

                   <div class="card">
                       <div class="card-block">Detailed Report</div>
                   </div>

                </div><!-- /span6 -->
            </a>

            <a class="report-format" data-format="graphical" href="#">

                <div class="span6">

                   <div class="card">
                       <div class="card-block">Graphical</div>
                   </div>

                </div><!-- /span6 -->
            </a>



        </div><!-- /row -->
        <div id="detailed-report-container" class="card">

            <div id="reportsPanel" class="card-block">
                <h3 class="head-2">Select Module</h3><hr/>
                <!-- <button data-module="items" class="btn">Items</button> -->
                <button data-module="inventory" class="btn">Inventory</button>
                <button data-module="sales" class="btn">Sales</button>
                
            </div><!-- /reports option -->

            <div class="module-containers"> 


                <div style="display: none;" id="bySales" class="card-block">
                    {{ Form::open(['id' => 'formGenerateSalesReport']) }}

                       From : {{ Form::text('from',null,['id' => 'tbFrom','class' => 'form-horizontal '])}}
                        To :
                        {{ Form::text('to',null,['id' => 'tbTo','class' => 'form-horizontal '])}}

                        By : {{ Form::select('cashier',['All' => 'All',$cashiers])}}

                    {{ Form::submit('Generate Sales Report',['style' => 'background:#01A525;color:#fff;padding:10px;'])}}
                    {{ Form::close() }}

                    <table id="resultSales" class="table">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>DateTime</th>
                               
                                <th>Amount</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody id="tbodySales">
                            
                        </tbody>
                    </table>
                
                </div><!-- /by sales report -->

                <div style="display: none;" id="byInventory" class="card-block">
                    Inventory

                    {{ Form::open(['class' => 'formGenerateInventoryReports']) }}

                    
                    
                       From : {{ Form::text('from',null,['id' => 'tbFrom','class' => 'form-horizontal '])}}
                        To
                        {{ Form::text('to',null,['id' => 'tbTo','class' => 'form-horizontal '])}}
                        Stock Name {{ Form::select('stock',['' => 'Select Ingredient',$ingredients])}}

                    {{ Form::submit('Generate Inventory Report',['style' => 'background:#01A525;color:#fff;padding:10px;'])}}
                    {{ Form::close() }}

                    <table id="resultInventory" class="table">
                        <thead>
                            <tr>
                                <th>Stock Name</th>
                                <th>Received/Change Date</th>
                                <th>In/Out</th>
                                
                                <th>By</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyInventory">
                            
                        </tbody>
                        <span class="pull-right stockOnHandContainer"></span>
                    </table>
                    
                </div><!-- /by inventory report -->

                <div style="display: none;" id="byItems" class="card-block">
                   Items
                    
                </div><!-- /by items reports -->

                <div style="display: none;" id="graphicalFormatContainer" class="card-block">
                    <canvas id="graphical"></canvas>  
                </div><!-- /by items reports -->
                

            </div><!-- /module-containers -->
            

        </div>
        

      </div><!-- /end of reports panel tab-->
      
   
    </div>

    
   
@stop

@section('external-scripts')
    <script src="/js/chart.min.js"></script>
    <script type="text/javascript" src="/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="/highcharts/exporting.js"></script>
     <script type="text/javascript" 
        src="/datepicker/jquery.datetimepicker.js"></script>
    <!-- /reports scripts -->
    <script type="text/javascript" src="/js/reports.js"></script>
    <script>

    
        //  highcharts bar graph



$(function () {
    $('#container-two').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Top Three Best Sellers'
        },
        subtitle: {
            text: "as of {{ Carbon\Carbon::now() }}"
        },
        xAxis: {
            categories: {{ json_encode($items,JSON_NUMERIC_CHECK)}}
            
        },
        yAxis: {
            title: {
                text: 'Amount in Peso'
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
            name: 'Top Three Product Best Sellers',
            data: {{ json_encode($amounts,JSON_NUMERIC_CHECK)}}
        }]
    });
});//end chart

$(document).ready(function(){

   

        var context = document.getElementById('bestsellers').getContext('2d');

        var graphicalContext = document.getElementById('graphical').getContext('2d');

        var data = {

                labels: {{ json_encode($items,JSON_NUMERIC_CHECK)}} ,
                datasets: [
                    {
                        label: "Top Three Product Best Sellers",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: {{ json_encode($amounts,JSON_NUMERIC_CHECK)}} 
                    }
                   
                ]
            };

            var myBarChart = new Chart(context).Bar(data,{

                 barShowStroke : true,
                 scaleShowGridLines : true,
                 scaleGridLineColor : "rgba(0,0,0,.05)"
            });

            // var dataGraphical = {

            //     labels: ["January", "February", "March", "April", "May", "June", "July"],
            //     datasets: [
            //         {
            //             label: "My First dataset",
            //             fillColor: "rgba(220,220,220,0.2)",
            //             strokeColor: "rgba(220,220,220,1)",
            //             pointColor: "rgba(220,220,220,1)",
            //             pointStrokeColor: "#fff",
            //             pointHighlightFill: "#fff",
            //             pointHighlightStroke: "rgba(220,220,220,1)",
            //             data: [65, 59, 80, 81, 56, 55, 40]
            //         },
            //         {
            //             label: "My Second dataset",
            //             fillColor: "rgba(151,187,205,0.2)",
            //             strokeColor: "rgba(151,187,205,1)",
            //             pointColor: "rgba(151,187,205,1)",
            //             pointStrokeColor: "#fff",
            //             pointHighlightFill: "#fff",
            //             pointHighlightStroke: "rgba(151,187,205,1)",
            //             data: [28, 48, 40, 19, 86, 27, 90]
            //         }
            //     ]
            // };

            //  var chart = new Chart(graphicalContext).Bar(dataGraphical);

            /* Sales Chart */

    $(function () {

        $('#container-one').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Store Sales'
            },
            subtitle: {
                text: "as of {{ Carbon\Carbon::now()->toDayDateTimeString() }}"
            },
            xAxis: {
                categories: 
                ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Amount in Peso'
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
                name: 'Product Sales per Month',
                data: {{ json_encode($sales,JSON_NUMERIC_CHECK)}}
            }]
        });
    });//end chart






});
            
           
    </script>




@stop



