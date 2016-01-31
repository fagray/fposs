@extends('layouts.master')

@section('content')


	<h2 class="head-2">Item Details</h2><br/>
 
	<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#basic" aria-controls=">Item Information" role="tab" data-toggle="tab">Item Information</a></li>
    <li role="presentation"><a href="#units" aria-controls="Inventory" role="tab" data-toggle="tab">Production Units</a></li>
    <li role="presentation"><a href="#raw" aria-controls="Raw Materials" role="tab" data-toggle="tab">Recipe</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="basic">
    	
    	<div class="row">
    		<div class="span4">
          <div class="card">
              <div class="card-block">
                  <h2 class="card-text">{{ $item->name }}</h2>
                  <img src="/img/cupcake.jpg" width="200" height="200">
                  <p style="font-size:17px;">Item Code: {{ $item->barcode }}

                  {{ DNS1D::getBarcodeHTML('123456789012', "EAN13",2,60); }} 
                  <strong></strong> </p>
                       
              </div><!-- /card-block -->
          </div><!-- /card -->  
	    	
    		</div><!-- /span4 -->

	    	<div class="span8">
         @if(count($ingredients) != 0)
          <div class="card">
              <?php $i = 0; ?>
              
                <div class="card-block">
                    <p style="font-size:18px;">Add/Modify Ingredients</p><hr/>
                    <p  style="font-size:18px;" ><strong>Ingredients ( {{ count($materials) }} ) </strong></p>
                    {{ Form::open(['route' => 'ingredients.modify'])}}
                    <ul>
                     
                        @foreach($ingredients as $ingredient)
                          
                          <li class="item_ingredient" style="list-style:none;">
                            <input name="ing_ids[]" type="checkbox" value="{{ $ingredient->id }}"
                                <?php 
                                  if( $ingredient->id == $materials[$i]['id'] ) 
                                  { 
                                      print "checked";
                                  } 
                                ?>>
                              {{ $ingredient->name }}
                           
                            </li>
                         <?php if($i != count($materials) - 1) { $i++; }  ?>
                        @endforeach
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        {{ Form::submit('Save changes',['class' => 'btn pull-right'])}}
                       {{ Form::close() }}
                    </ul>
                </div><!-- /card-block -->
             

          </div><!-- /card -->  
           @endif
	    		
	    		
	    	</div><!-- /span8 -->

    	</div><!-- /row -->
    	

    </div>
    <div role="tabpanel" class="tab-pane" id="units">
        <table class="table">
          <thead>
            <th>Unit Description</th>
            <th>Unit Symbol</th>
            <th>Equivalent in grams</th>
          </thead>
          <tbody>
            @foreach($units as $unit)
              <tr>
                <td>{{ $unit->name }}</td>
                <td>{{ $unit->symbol }}</td>
                <td>{{ $unit->in_grams }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

    </div>
    <div role="tabpanel" class="tab-pane" id="raw">
     @if($ingredients != null)
      	@foreach($materials as $material)

      		<h2>{{ $material->name }}</h2>

      	@endforeach
      @endif
    </div>
   
  </div>

</div>
	
@stop

@section('external-scripts')
    
    <script type="text/javascript">

      $(document).ready(function(){

          // window.print('http://fposs.net/items/');
          $('.btn').attr('disabled','disabled');
          $('.item_ingredient').on('change',function(){

            $('.btn').removeAttr('disabled');

          });

      });
        
    </script>

@stop