@extends('layouts.master')

@section('external-styles')
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.tableTools.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
@stop


@section('content')
    <span class="pull-right">
         <div class="btn-group">
             <a href="/inventory/stocks/create" data-toggle="modal"  class="btn btn-success"><i class="icon-plus"></i> New Stock</a>
            
             <button id="btnRefresh" type="button" class="btn btn-default">
                <i class="icon-refresh"></i> Refresh
             </button>

         </div>
    </span>
    <h2 class="head-1 ">Inventory Module</h2><hr/>
    

    <div class="widget widget-table action-table">
           <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#stocklevel" data-toggle="tab">Stocks Level</a></li>
          <li><a href="#stocks" data-toggle="tab">Ingredients List</a></li>
          <li><a href="#low-level-threshold" data-toggle="tab">Threshold</a></li>
        </ul>
        
        <!-- /widget-header -->
        <!-- Tab panes -->
        <div class="tab-content">

            <div class="tab-pane" id="stocks">

                <table  class="table table-striped table-bordered stocks-list">
                    <thead>
                    <tr>
                        <th> Name </th>
                        <th> Cost </th>
                        <th> Supplier </th>
                        <th> Unit type(Shipment) </th>
                      <!--   <th> Unit type(Production)  </th> -->

                        <th class="td-actions">Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ingredients as $ingredient)
                        <tr>
                            <td> {{ $ingredient->name }} </td>

                             <td>
                                
                                   Php {{ number_format($ingredient->price,2) }} / 
                                        {{ $ingredient->shipment_unit }}

                                
                                </td>
                                
                       
                                <td>
                                
                                   {{ Supplier::find($ingredient->supplier_id)->name }}

                                
                                </td>

                                

                                 @if($ingredient->shipment_unit == 'sacks')
                                    <td> 
                                        {{ $ingredient->base_kg }} kg / {{ $ingredient->shipment_unit }} 
                                    </td>

                                 @elseif($ingredient->shipment_unit == 'packs')

                                    <td> 
                                        {{ $ingredient->base_g }} g / {{ $ingredient->shipment_unit }} 
                                    </td>
                                 @elseif($ingredient->shipment_unit == 'pc')

                                    <td> 
                                        pc(s)
                                    </td>
                                   @elseif($ingredient->shipment_unit == 'bottle')

                                    <td> 
                                        {{ $ingredient->base_g. ' g / ' .  $ingredient->shipment_unit }}
                                    </td>

                                    @elseif($ingredient->shipment_unit == 'can')

                                    <td> 
                                        {{ $ingredient->shipment_unit }}
                                    </td>


                                 @endif
                                  @if($ingredient->shipment_unit == 'dozen')


                                @else

                               
                                   
                                @endif

                              
                                 
                            

                           
                            <td class="td-actions">
                                <div class="btn-group">
                                  <button data-toggle="dropdown" class="btn dropdown-toggle">Actions <span class="caret"></span></button>
                                  <ul class="dropdown-menu">
                                  
                                    <li>
                                      <a href="{{ URL::to('inventory/stocks/'.$ingredient->id.'/edit') }}">
                                      Edit Data</a>
                                    </li>

                                    
                                    <li>
                                        <a href="{{ URL::to('inventory/stocks/'.$ingredient->id.'/show') }}">
                                        View</a>
                                    </li>
                                  
                                  </ul>
                                </div>
                              
                            </td>

                        </tr>
                    @endforeach


                    </tbody>
                </table>
                

            </div>

            <div class="tab-pane active" id="stocklevel">
                
                    
                <table id="inventory-data" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th> Name </th>
                        <th> Stocks ( shipment unit ) </th>
                        <th> Stocks ( kg ) </th>
                        <th> Stocks ( g ) </th>
                        <th>alert threshold </th>
                        <th class="td-actions">Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ingredients as $ingredient)
                        <tr>
                            
                            
                            @if($ingredient->shipment_unit == 'dozen')

                                 @if(number_format($ingredient->stocks,2) < $ingredient->alert_level)

                                    <td style="color:red;">  {{ $ingredient->name }} </td>
                                    <td style="color:red;">
                                    
                                    {{ $ingredient->stocks  }} {{ $ingredient->shipment_unit }}
                                    /  {{ $ingredient->stocks * 12 }} pcs
                                    
                                    </td>
                                    <td style="color:red;"></td>
                                    <td style="color:red;"></td>
                                @else

                                    <td> {{ $ingredient->name }} </td>
                                    <td>
                                    
                                    {{ $ingredient->stocks  }}  pcs
                                    
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                @endif


                            @else

                             @if(number_format($ingredient->stocks,2) < $ingredient->alert_level)

                               <td style="color:red;"> {{ $ingredient->name }} </td>
                                <td style="color:red;">
                                
                                    {{ number_format($ingredient->stocks,2)  }} {{ $ingredient->shipment_unit }} 

                                
                                </td>
                                 <td style="color:red;"> {{ number_format($ingredient->in_kg,2) }} </td>
                                 <td style="color:red;"> {{ number_format($ingredient->in_grams,2) }} </td>
                                 <td > {{ $ingredient->alert_level }} {{ $ingredient->shipment_unit }} </td>
                                    

                        

                             @else
                                <td > {{ $ingredient->name }} </td>
                                <td>
                                
                                    {{ number_format($ingredient->stocks,2)  }} {{ $ingredient->shipment_unit }}

                                
                                </td>
                                 <td> {{ number_format($ingredient->in_kg,2) }} </td>
                                 <td> {{ number_format($ingredient->in_grams,2) }} </td>
                                 <td > {{ $ingredient->alert_level }} {{ $ingredient->shipment_unit }} </td>

                             @endif
                                
                                
                            

                            @endif
                                
                           

                            <td class="td-actions">
                                <div class="btn-group">
                                  <button data-toggle="dropdown" class="btn dropdown-toggle">Actions <span class="caret"></span></button>
                                  <ul class="dropdown-menu">
                                   
                                     <li>
                                            <a class="linkRestock" data-unit="{{ $ingredient->shipment_unit }}" data-id="{{ $ingredient->id }}" data-item="{{ $ingredient->name }}" data-toggle="modal" href="#"><i class="icon icon-plus"></i> Manual Restock</a>
                                        </li>
                                    <li><a href="#">Usage Tracking</a></li>
                                 
                                
                                  </ul>
                                </div>
                           
                                </td>

                        </tr>
                    @endforeach


                    </tbody>
                </table>

            </div><!-- /tab pane stock level -->
            <div class="tab-pane" id="low-level-threshold">
                
                    
                <table id="threshold-list"  class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th> Name </th>
                        <th> Stocks ( shipment unit ) </th>
                        <th> Stocks ( kg ) </th>
                        <th> Stocks ( g ) </th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($threshold as $ingredient)
                        <tr>
                            
                            
                            @if($ingredient->shipment_unit == 'dozen')

                                 @if(number_format($ingredient->stocks,2) < $ingredient->alert_level)

                                    <td style="color:red;">  {{ $ingredient->name }} </td>
                                    <td style="color:red;">
                                    
                                    {{ $ingredient->stocks  }} {{ $ingredient->shipment_unit }}
                                    /  {{ $ingredient->stocks * 12 }} pcs
                                    
                                    </td>
                                    <td style="color:red;"></td>
                                    <td style="color:red;"></td>
                                @else

                                    <td> {{ $ingredient->name }} </td>
                                    <td>
                                    
                                    {{ $ingredient->stocks  }}  pcs
                                    
                                    </td>
                                    <td></td>
                                    <td></td>

                                @endif


                            @else

                             @if(number_format($ingredient->stocks,2) < $ingredient->alert_level)

                               <td style="color:red;"> {{ $ingredient->name }} </td>
                                <td style="color:red;">
                                
                                    {{ number_format($ingredient->stocks,2)  }} {{ $ingredient->shipment_unit }}

                                
                                </td>
                                 <td style="color:red;"> {{ number_format($ingredient->in_kg,2) }} </td>
                                 <td style="color:red;"> {{ number_format($ingredient->in_grams,2) }} </td>
                                    

                        

                             @else
                                <td > {{ $ingredient->name }} </td>
                                <td>
                                
                                    {{ number_format($ingredient->stocks,2)  }} {{ $ingredient->shipment_unit }}

                                
                                </td>
                                 <td> {{ number_format($ingredient->in_kg,2) }} </td>
                                 <td> {{ number_format($ingredient->in_grams,2) }} </td>

                             @endif
                                
                                
                            

                            @endif
                                
                           


                        </tr>
                    @endforeach


                    </tbody>
                </table>
              
            </div><!-- /tab pane threshold -->
        </div>
    </div>



 <!-- Modal -->
    <div class="modal hide fade modal-restock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button id="modal-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Manual Re-stock</h3>
        </div>
         {{ Form::open(array('route' => 'inventory.restock','class' => 'form-horizontal form-restock','autocomplete' => 'false')) }}
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="stock name">Stock Name</label>
                <div class="controls">
                    {{ Form::text('name',null,array('class' => 'span3','disabled' => 'disabled','id' => 'item_name')) }}
                     {{ Form::hidden('stock_id' )}}
                     {{ Form::hidden('unit' )}}
                     {{ Form::hidden('received_by',Auth::user()->username )}}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" >Stocks to Add/Subtract</label>
                <div class="controls">
                    {{ Form::number('qty',null,array('required' => 'required','autofocus'=> 'autofocus','class' => 'span3')) }}
                     <span class="add-on" id="unit">{{ $ingredient->shipment_unit }}</span>
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="category name">Remarks</label>
                <div class="controls">
                    {{ Form::textarea('remarks',null,array('required' => 'required','autofocus'=> 'autofocus','rows' => '4','cols' => '8','style' => 'width:270px;')) }}
                </div> <!-- /controls -->
            </div>
            <hr/>
            <strong>For security purposes : </strong>
            <div class="control-group">

                <label class="control-label">Admin Password</label>
                <div class="controls">
                    {{ Form::password('admin_password',null,array('required' => 'required','autofocus'=> 'autofocus','class' => 'span4','autocomplete' => 'false')) }}
                    <span id="feedback"></span>
                </div> <!-- /controls -->
            </div>
          
        </div>
        <div class="modal-footer">

            
          {{ Form::hidden('type',2) }}
            {{ Form::submit('Save',array('class' => 'btn btn-primary')) }}
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
        {{ Form::close() }}

        
    </div>
       <!-- Modal for inventory -->
        <a href="#inventory-modal" id="modal-low-stock" data-toggle="modal"></a>
        <div id="inventory-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                 <button id="btnInventoryModal" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h2>Stocks are getting low!</h2>
               
            </div>
            
            <div class="modal-body">
             
                    <img style="float:left;"  height="130" width="150" src="/img/avatar.png">
                    <div style="font-size:16px;">
                      Hey, <span id="item-count"></span>  are/is getting low, please contact your supplier to request a back order for your stocks. 
                    </div><hr/>
                    <div style="font-size:15px;" id="items-container"></div>
                      <input  id="cb_inv" type="checkbox" name="dismiss-checkbox">
             Ok, got it! Don't annoy me again.
            </div>
        </div>
        <!-- /modal -->

@stop

@section('external-scripts')

    
    <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/dataTables.tableTools.js"></script>
    <script type="text/javascript" src="/js/ai.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

         $('#inventory-data').DataTable({
            dom: 'T<"clear">lfrtip'
         });
          

         $('.stocks-list').DataTable({
            dom: 'T<"clear">lfrtip'
         });

         $('#threshold-list').DataTable({

           dom: 'T<"clear">lfrtip',

             tableTools: {

                "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
            }
         });

        //check for the stocks level
        $.getJSON('/inventory/stocks/check',function(data){

            if(data.response == 'true'){

              //show the fucking modal
              $('#item-count').html('<span style="color:red">' + data.items.name +' ' + '</span>');
              $('#items-container').html(data.items.stocks +' ');


            
               $('#modal-low-stock').click();
              
             
            }
        });

         $('input[type="submit"]').attr('disabled','disabled');

         $('form.restock').submit(function(e){

                e.preventDefault();

                 var stock_id =  $('input[name="stock_id"]').val();
                 // alert(stock_id);

                 var postData = $(this).serialize();
                 console.log(stock_id);

                $.ajax({

                    url : '/inventory/stocks/'+stock_id+'/restock',
                    type: 'GET',
                    data : postData,

                    success : function(data){

                        // $('.loading').html('');
                        console.log(data);
                        //append the data to the DOM
                        // appendToContainer(data);
                        // setTimeout(appendToContainer(data),"function(){ $('.loading').html(''); };",5500);
                        
                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }

            

                }); /* end ajax request */

                

            });

            $('#inventory-data').on('click','a.linkRestock',function(e){

                e.preventDefault();
                 $('.modal-restock').modal({
                  backdrop: false

              });

                var item = $(this).attr('data-item');
                var item_id = $(this).attr('data-id');
                var unit = $(this).attr('data-unit');
                $('input[name="unit"]').val(unit);

                console.log(item);
                console.log(item_id);
                console.log(unit);

               $('input[name="stock_id"]').val(item_id);
                $('input#item_name').val(item);
                $('span#unit').html(unit);

            });

            $('input[name="admin_password"]').on('keyup',function(){

               $('input[type="submit"]').attr('disabled','disabled');
                var password = $(this).val();
                
                if(password.length > 3 && password.length < 12){

                   $('span#feedback').html('Checking...');
                    //check the password
                    $.ajax({

                    url : '/auth/password/check',
                    type: 'GET',
                    data : { admin_password : password } ,

                    success : function(data){

                        // $('.loading').html('');
                        console.log(data);

                        if(data.response == 300){

                          $('span#feedback').html('<span style="color:red;">Invalid</span>');
                           $('input[type="submit"]').attr('disabled','disabled');

                        }else if(data.response == 200){

                           $('span#feedback').html('<span style="color:green;">Ok</span>');
                             $('input[type="submit"]').removeAttr('disabled');

                        }

                        //append the data to the DOM
                        // appendToContainer(data);
                        // setTimeout(appendToContainer(data),"function(){ $('.loading').html(''); };",5500);
                        
                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }

            

                }); /* end ajax request */

                   
                }
            });

            $('button#modal-close').click(function(){


               $('input[name="stock_id"]').val('');
                $('input#item_name').val('');
                 $('span#feedback').html('');
               

            });

            

      });



        //data-tables
       
    </script>
@stop
