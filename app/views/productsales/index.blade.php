@extends('layouts.master')


@section('content')
  <span class="pull-right" >
            {{ Form::open(['id' => 'formSearchInvoice','method' => 'GET']) }}
                <p>Search By Invoice # 
                <input id="tbInvoiceNum" placeholder="Type Invoice # and press Enter" type="number" value=""></p>
            {{ Form::close() }}
        </span>
    <h2 class="head-1">Store Sales</h2><hr/>

    <div class="card card-block search-result-container">
        <p style="background: #01A525;padding:5px;color:#fff;">Search Result For Invoice # <span id="iv"></span></p>
        <table class="table table-stripped">
            <thead>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Qty</th>
                
            </thead>

            <tbody class="result-body">
                <p id="total"></p>
            </tbody>

        </table>
    </div>

    <div class="row">
      <div class="span12">
        
        <div class="card card-block">
          <h3 class="card-title">Today's Sales </h3>
            <h1 class="card-text">
            <strong style="color:red;">Php {{ number_format($total,2) }}</strong>
                
            </h1>as of {{ Carbon\Carbon::now()->toDayDateTimeString() }}
        </div>
      </div>
 
    </div><!-- /end row -->


    <div class="widget widget-table ">
           <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#today" data-toggle="tab">Today</a></li>
          <li><a href="#yesterday" id="yes" data-toggle="tab">Yesterday</a></li>
          <li><a href="#thisweek" id="week" data-toggle="tab">This Week</a></li>
          <li><a href="#thismonth" id="month" data-toggle="tab">This Month</a></li>
        </ul>

       
        <div class="widget-content">

             <!-- Tab panes -->
            <div class="tab-content">

                <div class="tab-pane active" id="today">
                   
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th> Invoice No. </th>
                            <th> Amount </th>
                            <th> Cashier </th>
                            <th> Date </th>
                          
        <!--                     <th class="td-actions">Actions </th>
         -->                </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td> 
                                        {{ link_to_route('sales.view',$sale->trans_id,['trans_id' => $sale->trans_id]) 
                                        }} 
                                    </td>
                                    <td> Php {{ $sale->amount }} </td>
                                    <td>{{ $sale->cashier }} </td>
                                    <td>{{ $sale->created_at }} </td>
                                 
                                   <!--  <td class="td-actions">
                                        <a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-pencil"> </i></a>
                                        <a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /tab pane #today -->

                <div class="tab-pane" id="yesterday">
                    <div style="padding:5px;background:#EFEBFF;">
                            <p> Yesterday's sales  ( {{ Carbon\Carbon::now()->yesterday() }} ): 
                                <strong id="yesterdayTotal" style="color:red;font-size:20px;">
                                     
                                </strong>
                               
                            </p>
                               
                            
                    </div>
                    <div class="loading">
                        
                    </div>
                    <table class="table table-striped table-bordered" id="tblYSale">

                        <thead>
                            <tr id="header">

                                <th> Receipt No. </th>
                                <th> Amount </th>
                                <th> Cashier </th>
                                <th> Date </th>
                          
        <!--                     <th class="td-actions">Actions </th>
         -->                </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>

                        
                    </table>

                </div><!-- /tab-pane #yesterday -->

                 <div class="tab-pane" id="thismonth">
                 <div style="padding:5px;background:#EFEBFF;">
                        <p> This Month Sales : 
                            <strong id="monthTotal" style="color:red;font-size:20px;">
                                 
                            </strong>
                             as of {{ Carbon\Carbon::now() }}
                        </p>
                           
                            
                    </div>
                    <div class="loading">
                        
                    </div>
                    <table class="table table-striped table-bordered" id="tblMSale">
                        <thead>
                            <tr id="header">

                                <th> Receipt No. </th>
                                <th> Amount </th>
                                <th> Cashier </th>
                                <th> Date </th>
                          
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>

                        
                    </table>

                </div><!-- /tab-pane #thismonth -->

                <div class="tab-pane" id="thisweek">
                 <div style="padding:5px;background:#EFEBFF;">
                        <p> This Week Sales : 
                            <strong id="weekTotal" style="color:red;font-size:20px;">
                                 
                            </strong>
                             as of {{ Carbon\Carbon::now() }}
                        </p>
                           
                            
                    </div>
                    <div class="loading">
                        
                    </div>
                    <table class="table table-striped table-bordered" id="tblWSale">
                        <thead>
                            <tr id="header">

                                <th> Receipt No. </th>
                                <th> Amount </th>
                                <th> Cashier </th>
                                <th> Date </th>
                          
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>

                        
                    </table>

                </div><!-- /tab-pane #thisweek -->

            </div><!-- /tab-content -->
        </div> <!-- /widget-content -->
    </div><!-- /widget-table -->

@stop

@section('external-scripts')

    <script type="text/javascript" src="/js/sales.js"></script>

@stop