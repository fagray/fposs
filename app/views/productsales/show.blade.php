@extends('layouts.master')

@section('content')

    <br/>
    <a class="btn " href="/store/items/sales"> 
        <i class="icon icon-chevron-left"></i> Back to sales</a>
    <a class="btn btn-primary" href="/test/{{$sales[0]['trans_id']}}"> 
        <i class="icon icon-print"></i> Re-print receipt</a>
        <hr/>
    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-th-list"></i>

            <span class="pull-right"> 
                <p style="margin-right: 10px;padding:5px;">
                    Transaction Date : {{ $sales[0]['created_at'] }}
                </p>
            </span>
            <h3>{{ $title }}</h3>


        </div>
        <!-- /widget-header -->
        <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                     <th>Item Code </th>
                    <th>Description </th>
                    <th> Price </th>
                    <th> Qty </th>

                  
                    <!-- <th class="td-actions">Actions </th> -->
                </tr>
                </thead>
                <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td> {{ Item::find($sale->item_id)->barcode }} </td>
                        <td> {{ Item::find($sale->item_id)->name }} </td>
                        <td> Php {{ number_format(Item::find($sale->item_id)->price,2) }} </td>
                        <td> {{ $sale->qty }} </td>


                    </tr>
                @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> <strong>Total : {{ $sale->amount }} </strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>  <strong>Cash Received : {{ $sale->cash }} </strong></td>
                        </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>  <strong>Change : {{ $sale->change }}
                                 | Cashier : {{ $sale->cashier }}</strong>  </td>
                            
                        </tr>
                        
                        


                </tbody>
            </table>
        </div>
        <!-- /widget-content -->
    </div>

   

@stop
