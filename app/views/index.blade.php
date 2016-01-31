@extends('layouts.master')


@section('external-styles')

    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.tableTools.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">

@stop

@section('content')
    {{-- / main content here--}}

    {{-- start of row --}}
    
    <div class="row">
        
        <div class="span12">
        
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Hello, {{ Auth::user()->username }}</h4>
                    <h6 class="card-subtitle text-muted">Have a nice day ahead!</h6>

                  
                </div>
  
                <div class="card-block">
                    <p class="card-text">Quick Links to get you started.</p>
                     <div class="subnavbar">

                       
                        <div style="background:fff;style:border-bottom:none !important;" class="subnavbar-inner">
                            <div class="container payment">
                                <ul class="mainnav">
                                @if(Auth::user()->role == '2' || Auth::user()->role == '3')
                                    <li>
                                        <a class="payment-key" href="/productions/items/unsold/">
                                        <i class="icon-search"></i>
                                        <span>Unsold Items</span> 
                                        </a> 
                                    </li>


                                    
                                    <li>
                                        <a class="payment-key" href="/items/create/">
                                        <i class="icon-plus"></i>
                                        <span>New Item</span> 
                                        </a> 
                                    </li>
                                    <li>
                                        <a class="payment-key" href="/transactions/shipments/create">
                                        <i class="icon-plus"></i>
                                        <span>New Receiving</span> 
                                        </a> 
                                    </li>
                                    
                                    <li>
                                        <a class="payment-key" target="_blank" href="/items/productions/"><i class="icon-cog"></i>
                                        <span>Production</span> 
                                        </a> 
                                    </li>
                                    <li>
                                        <a class="payment-key" target="_blank" href="/store/items/sales/">
                                        <i class="icon-money"></i>
                                        <span>Sales</span> 
                                        </a> 
                                    </li>
                                    <li>
                                        <a class="payment-key" target="_blank" href="/items/barcodes/">
                                        <i class="icon-print"></i>
                                        <span> Barcode Labels</span> 
                                        </a> 
                                    </li>
                                    @else
                                    <li>
                                        <a class="payment-key" target="_blank" href="/sales/registrar">
                                        <i class="icon-money"></i>
                                        <span>Open Register</span> 
                                        </a> 
                                    </li>  
                                    
                        
                                @endif 

                                </ul>
                            </div>
                        <!-- /container --> 
                        </div>
                       
                        <!-- /subnavbar-inner --> 
                    </div>
                </div>
            </div><!-- /card -->    

            <h3 class="head-2">Inventory</h3><hr/>
            <p>Some of our ingredients are getting low.Better to re-order new stocks.</p>   
            <table id="low-stock-data" class="table">
                <thead>
                    <th>Ingredient Name</th>
                    <th>In stock</th>
                    <th>Re-order unit</th>
                    <th>Supplier</th>
                </thead>

                <tbody>
                    @foreach($ingredients as $ingredient)
                    <tr>
                        <td> {{ $ingredient->name }} </td>
                        <td> {{ $ingredient->stocks . ' ' .  $ingredient->shipment_unit }} </td>
                        <td> {{ $ingredient->shipment_unit }} </td>
                        <td> {{ $ingredient->supp }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 

           
                <div class="row">
                    @if(count($items) > 0 )
                    <div class="span6">
                        <div class="widget widget-nopad">
                            <div class="widget-header"> <i class="icon-list-alt"></i>
                                <h3> Todays Production  </h3>
                            </div>
                        <!-- /widget-header -->
                            <div class="widget-content">
                                <div class="widget big-stats-container">
                                    <div class="widget-content">
                                            <table class="table">
                                                <tr>
                                                    <th>Item Id</th>
                                                    <th>Barcode</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Remaining</th>
                                                </tr>

                                                    @foreach($items as $item)
                                                        <tr>
                                                            <td>{{ $item->item_id }} </td>
                                                            <td>{{ $item->barcode }} </td>
                                                            <td>{{ Item::find($item->item_id)->name }} </td>
                                                            <td>{{ $item->qty }} </td>
                                                            <td>{{ $item->remaining }} </td>

                                                        </tr>
                                                       

                                                    @endforeach
                                            </table>
                                    </div>
                                    <!-- /widget-content -->
                                </div>
                            </div>
                         </div><!-- /widget-no-pad -->
                        
                    </div><!-- /span6 / today's production -->
                     @endif

                    <span class="span6">
                        <div class="widget widget-nopad">
                            <div class="widget-header"> <i class="icon-list-alt"></i>
                                <span class="pull-right"> 
                                    <a style="margin-right: 10px;" class="btn" href="/settings" >
                                      <i class="icon icon-cog"></i>  Go to settings and view all logs
                                    </a>
                                </span>
                                <h3> System Logs </h3>
                            </div>
                        <!-- /widget-header -->
                            <div class="widget-content">
                                <div class="widget big-stats-container">
                                    <div class="widget-content">
                                            <table class="table">
                                                <tr>
                                                    <th>Date </th>
                                                    <th>User</th>
                                                    <th>Action</th>
                                                    
                                                </tr>

                                                    @foreach($logs as $log)
                                                        <tr>
                                                            <td>{{ $log->created_at }} </td>
                                                            <td>{{ $log->user }} </td>
                                                            <td>{{ $log->action }} </td>
                                                          

                                                        </tr>
                                                       

                                                    @endforeach
                                            </table>


                                    </div>

                                    <!-- /widget-content -->
                                </div>
                            </div>
                         </div><!-- /widget-no-pad -->

                        
                    </span><!-- //span6 -->
                    
                </div><!-- /row -->

              
                
           

            

        </div><!-- /span12 -->
                <?php
                        //generate a randomized greeting
                        $greetings = 
                        array('Welcome back','Howdy ','Yo there ','Hello ','Hi there ','Good day');
                        $rand = rand(0,count($greetings)-1);
                       
                    ?>
         
                  <!-- Modal -->
                <a href="#indexModal" id="PModal" data-toggle="modal"></a>
                <div id="indexModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                         <button type="button"  class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         <h3 class="head-2 bold"> 
                            {{ $greetings[$rand] .', ' . Auth::user()->username }} 
                        </h3>
                       
                    </div>

                    
                    
                    <div class="modal-body">
                           
                            <img style="float:left;" height="130" width="150" src="/img/avatar.png">
                            <p style="float:left;font-size:15px;">
                                These items are our best sellers yesterday :
                            </p><br/><br/>
                            <div  id="items-container"></div>
                            <input id="cb_index" value="hey" type="checkbox" name="dismiss-checkbox"> Ok got it ! Don't annoy me again.
                    </div>
                  
                </div>
                <!-- /modal -->
          
    </div><!-- /row -->

@stop


@section('external-scripts')
    
    <script type="text/javascript" src="/js/ai.js"></script>
    <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/dataTables.tableTools.js"></script>
    <script type="text/javascript">

        $('#low-stock-data').DataTable({

                dom: 'T<"clear">lfrtip'
            });
    </script>

@stop


