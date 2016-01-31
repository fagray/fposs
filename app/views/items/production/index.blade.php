@extends('layouts.master')

@section('content')
<?php 
    
    $total = 0;
    $subtotal = 0;

?>
    
	<h2 class="head-1">Productions</h2><hr/>
  
    {{ 
        link_to_route('productions.produce','Create New',
            
                        ['type' => 'by-items'],
                        ['class' => 'btn btn-primary'])
    }}
    <hr/>

    <!-- Prroduction tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#current-production" data-toggle="tab">Current Production</a></li>
      <li><a href="#production-list" data-toggle="tab">Production's List</a></li>
      
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active" id="current-production">
          <div class="row">
       

    <div class="span6">
  
        <div class="widget widget-table action-table">
            <div class="widget-header"><i class="icon-th-list"></i>

                <h3>Ingredient's usage 
                    ( {{ Carbon\Carbon::now()->toFormattedDateString() }} )
                </h3>
            </div>
            <div class="widget-content">

                <table id="item-data"  class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Ingredient </th>
                       
                        <th>Equivalent </th>
                         <th>Cost</th>
                      
                      
                        <!-- <th class="td-actions">Actions </th> -->
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($ingredients as $ingredient)
                        <tr>
                            <td> {{ $ingredient->name }}  </td>

                            @if($ingredient->name == 'Eggs')

                                <td> {{number_format($ingredient->amount) }} pc(s)  </td>
                                 <td>
                                <?php 
                                    $total  += $ingredient->amount   * $ingredient->price;

                                ?>
                                  Php {{
                                    number_format ( $ingredient->amount   * $ingredient->price,2) 
                                    }} 
                                </td>
                                

                            @else
                               
                               <td> {{number_format($ingredient->in_grams,2) }} g </td>

                               <td> 
                               <?php 

                                    $total  +=  ($ingredient->in_grams / $ingredient->base_g)
                                                * $ingredient->price;
                               ?>
                               Php {{
                                    number_format (( $ingredient->in_grams / $ingredient->base_g) * $ingredient->price,2) 
                                    }} 
                                </td>
                               
                          
                           @endif
                          
                          

                       
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td><strong>Total Cost</strong></td>
                        <td colspan="2"><strong>Php {{ $total }}</strong></td>
                       
                    </tr>

                    </tbody>
                </table>
  <i><strong> Cost</strong> = amount used in grams / shipment unit in grams * price</i>            </div><!-- /widget-content -->
        </div><!-- /widget action-table -->
        </div><!-- /span6 -->

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
                                                  
                                                    <th>Barcode</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Remaining</th>
                                                    <th>Actions</th>
                                                </tr>

                                                    @foreach($items as $item)
                                                        <tr>
                                                            <td>{{ $item->barcode }} </td>
                                                            <td>{{ Item::find($item->item_id)->name }} </td>
                                                            <td>{{ $item->qty }} </td>
                                                            <td>{{ $item->remaining }} </td>
                                                            <td><a data-prod-id="{{$item->id}}"  data-item-current-qty="{{ $item->remaining }} " data-item-id="{{ $item->item_id }}" data-item-name ="{{ $item->name }}" class="linkDispose" href="#" data-toggle="modal">Edit Quantity</a></td>
                                                        </tr>
                                                       

                                                    @endforeach
                                            </table>
                                    </div>
                                    <!-- /widget-content -->
                                </div>
                            </div>
                         </div><!-- /widget-no-pad -->
                        
                    </div><!-- /span6 / today's production -->
    </div><!-- /row -->

      </div><!-- /end of current-production tab-pane -->


      <div class="tab-pane" id="production-list">
        <table class="table">
            <thead>
                <th>Production ID</th>
                <th>Date of Production</th>
              
               
            </thead>

            <tbody>
                @foreach($productions as $production)
                    <tr>
                        <td>
                            <a href="/productions/{{$production->production_id}}/details"> {{ $production->production_id }}</a>
                            </td>
                        <td>{{ $production->created_at }}</td>
                       <!--  <td>{{ $production->num_of_items }}</td> -->
                     
                    </tr>
                @endforeach
            </tbody>

        </table>
          

      </div><!-- /end of production-list tab-pane -->
     
    </div><!-- /end of tab content -->

    <!-- /modal manual edit -->

    <!-- Modal -->
    <div class="modal hide fade modal-dispose" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button id="modal-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Manual Dispose</h3>
        </div>
         
        <div class="modal-body">
        {{ Form::open(['class' => 'frmDispose']) }}
            <span class="offset-2">

                <div class="control-group">

                    <label class="control-label" for="stock name">Item Name</label>
                    <div class="controls">
                        <input disabled="disabled" name="item_name" type="text">
                    </div> <!-- /controls -->

                </div>

                <div class="control-group">
                    <label class="control-label" for="stock name">Quantity to dispose</label>
                    <div class="controls">
                        <input name="qty" type="number">
                    </div> <!-- /controls -->
                   <span class="current_qty"></span>

                </div>
                

            </span>
            {{ Form::submit("Submit",['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
           
         
          
        </div>
        <div class="modal-footer">

            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

        </div>
       

        
    </div>
    
	

@stop

@section('external-scripts')

    <script type="text/javascript">

        $(document).ready(function(){

            var current = 0;
            var id;

            $('a.linkDispose').click(function(e){

                 e.preventDefault();


                     $('.modal-dispose').modal({

                        backdrop: false
                    });

                var item_name = $(this).attr('data-item-name');

               //  alert(item_name);
                var item_id = $(this).attr('data-item-id');
                current = $(this).attr('data-item-current-qty');
               
                 id = $(this).attr('data-prod-id');

               

                //append to the DOM
                $('input[name="item_name"]').val(item_name);
               
                $('.current_qty').html("Current Quantity : " + current);


            
            });

            $('form.frmDispose').submit(function(e){

                    e.preventDefault();
                    
                    alert(current);
                    var qty = $('input[name="qty"]').val(); 
                    //alert(current);
                     //alert("Qty to dispose : "  + qty + " Current : " + current);

                  
                        if(confirm("Are you sure you want to dispose " + qty + " from its current quanity ? This cannot be undone.")){


                            $.getJSON('/productions/'+id+'/dispose/'+qty,function(data){

                                if(data.response == '200'){

                                    alert('Changes has been saved!.');
                                    window.location.href='/items/productions/';
                                }

                            });//end of getJSON

                        }

                    

                    
                });
        });

    </script>
@stop