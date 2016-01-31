@extends('layouts.master')


@section('content')
	<?php 
		$item_obj = new Item();
		$prod_unit = new ProductionUnit();
	?>
{{ Form::open(['route' => 'productions.cook','id' => 'formCook'])}}
{{ Form::submit("Let's Cook", ['class' => 'btn btn-large btn-primary pull-right'])}}
	<h2 class="head-1 ">Item Recipes</h2><hr/>
	<!-- <a id="addItem" class="btn btn-primary">Add Item</a><br/><br/> -->
	
	<!-- <div class="row span-offset-3" > -->
	
	 
	  @foreach($production_items as $item)

		<div  id="panel-content" class="span5" style="min-height: 600px;">
			 <divclass="widget widget-table action-table">
		        <div  class="widget-header"> <i class="icon-plus"></i>
		        <span class="pull-right">
		        	No. of servings : <input value="{{ $item->qty }}" class="span1" size="3" type="number">
				</span>		        	
		            <h3 >{{ Item::find($item->item_id)->name }} - {{ $item->qty }} pc(s)</h3>
		        </div>
		        <div  class="widget-content" style="padding:0px;">
		       		<div style="padding:3px;background: #EC407A;color:#fff;">Ingredients List</div>
		        	
		        	<ul>
		        		<?php 

		        			$item = $item_obj->find($item->item_id);
		        			$item_id = $item->item_id;
		        			$ingredients  = $item->ingredients;
		        		
		        		?>
		        		<table class="table ">
		        			
			        		@foreach($ingredients as $ingredient)
			        		<tr>
		        				<td>{{ $ingredient->name }} </td>
		        				<td>{{ Form::number('amount[]','',['placeholder' => 'Amount','class'=>'span1'

			        				]) }}</td>
			        			<td width="10%">
			        				{{ Form::select('ext[]',
			        					[
			        						'' 	  => '',
			        						'1/8' => '1/8',
			        						'1/4' => '1/4',
			        						'1/3' => '1/3',
			        						'1/2' => '1/2',
			        						'2/3' => '2/3',
			        						'3/4' => '3/4',
			        						'7/8' => '7/8',
			        						'3/8' => '3/8',
			        						'5/8' => '5/8'
			        					],'',['class'=>'span1','style' =>'width:70px;'])
			        				}}
			        			</td>
			        			<!-- <td>{{ $ingredient->units }}</td> -->
			        			<?php 
			        				$units = $prod_unit
			        							->getUnitsForSelectComponent($ingredient->id)
			        			?>
			        			<td>{{ Form::select('conv_rate[]',$units,'',['class' => 'span1','style' =>'width:70px;'])}} </td>
		        			</tr>
			        		
	        				{{ Form::hidden('units[]',$ingredient->units) }}
	        				{{ Form::hidden('ing_ids[]',$ingredient->id) }}
	        				


			        		@endforeach
		        		</table>

		        		
		        	
		        	</ul>


		        </div>

     		</div>   <!-- /widget-table -->
		<!-- </div>/span4 -->
	 @endforeach

	 <div id="loader">
	 	<!-- <img src="/img/baking.svg"> -->
	 </div>
	</div><!-- /row -->

	<!-- {{ link_to_route('productions.produce','Add more items','',['class' => 'btn btn-default']) }} -->
	
	{{ Form::close() }}
	



@stop

@section('external-scripts')
	
	<script type="text/javascript">
		$(document).ready(function(){

			var loader = $('div#loader').hide();

			$('form#formCook').submit(function(e){

				e.preventDefault();
				$('div.row').load('/partials/production.html');
				// loader.show();
				var postData = $(this).serialize();
				var reqUrl = $(this).attr('action');
				console.log(reqUrl);

				$.ajax({

			 		url : reqUrl,
			 		type: 'GET',
			 		data : postData,

			 		success : function(data){

			 			console.log(data);
			 			setTimeout("window.location.href='/items/productions/', function(){ $('#loader').hide(); };",1000);
			 			
					},
					error : function(e){

						console.log('Error' + e.status +': ' + e.statusText);
					}

	 	

	 		}); /* end ajax request */

			});
		});
	</script>

@stop

