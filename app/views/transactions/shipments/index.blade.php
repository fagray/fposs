@extends('layouts.master')

@section('external-styles')
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
@stop


@section('content')
    <span class="pull-right">
         <div class="btn-group">
             <a href="/transactions/shipments/create"  class="btn btn-success"><i class="icon-plus"> </i>New Receiving</a>
             <button id="btnRefresh" type="button" class="btn btn-default"><i class="icon-refresh"></i> Refresh</button>
           
         </div>
    </span>

  <h2 class="head-1 ">Receivings </h2>

  <hr/>
    
    <div class="widget widget-table action-table">
       
            <table id="shipments-data" class="table table-striped table-bordered">
                <thead>

                    <tr>
                        <th width="15%"> Date </th>
                        <th width="24%"> Stock Name </th>
                        <th> Received By </th>
                        <th> Qty </th>
                        <th> Supplier </th>
                        <th class="td-actions">Actions</th>
                    </tr>
                 </thead>

                @foreach($shipments as $transaction)
               
                   <tr>
                        <td> {{ $transaction->created_at }} </td>

                        <td> {{ $transaction->name }} </td>
                      
                        <td> {{ $transaction->received_by }}  </td>

                    @if ($transaction->shipment_unit == 'dozen'  )
                        <td> 
                            {{ $transaction->qty }} pcs
                              
                        </td>
                    @else
                         <td> 
                            {{ $transaction->qty }} 
                            {{ $transaction->shipment_unit }}  
                        </td>

                    @endif
                       <td> {{ $transaction->supplier }}</td>
                        <td class="td-actions">
                                <a data-id="{{$transaction->ship_no }}" class="linkViewDetail" data-toggle="modal" href="#shipment-modal">View Details </a>
                        </td>
                    </tr>
                </a>

                @endforeach
               
                <tbody>
               

                </tbody>
            </table>
        
    </div>

      <!-- Modal  -->
      
        <div id="shipment-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h2>Receiving Details</h2>
                  <div class="details-container"></div>
               
            </div>
            
            <div class="modal-body">
             
                 
            </div>
        </div>
        <!-- /modal -->




@stop

@section('external-scripts')
    <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#shipments-data').DataTable({
               dom: 'T<"clear">lfrtip'
             });

            $('.linkViewDetail').click(function(){

                var id = $(this).attr('data-id');
                //get the shipment details
                getShipmentDetails(id);
                // alert(id);
               
            });

            function getShipmentDetails(id){
                
                var total = 0;
               $.getJSON('/shipments/'+id+'/details',function(data){
                    //append the data to the modal
                    
                    $.each(data,function(key,val){
                        console.log(val.stock);
                        total += val.price * val.qty;
                        $('div.details-container').html('<p><strong>RCVNG # : '+val.ship_no+'<br/>Stock Name : '+val.stock+'<br/>Qty : '+val.qty+'<Br/>Cost : Php '+val.price+'<br/>Total : '+total+'</strong></p>');
                        console.log(data);
                    });
                    
               });
            }



        });
    </script>
    
@stop
