@extends('layouts.master')

@section('external-styles')
	<style type="text/css">
		.success {

			background:#01A525;padding:5px;color:#fff;
		}

		.failed {

			background:#ff0000;padding:5px;color:#fff;
		}
	</style>
@stop

@section('content')

	<?php 
		$item_obj = new Item();
		$prod_unit = new ProductionUnit();
		$item_id = '';
	?>
<!-- {{ Form::open(['route' => 'productions.cook','id' => 'formCook'])}} -->
<!-- {{ Form::submit("Let's Cook", ['class' => 'btn btn-large btn-primary pull-right'])}} -->
	<span class="pull-right">
        <a  class="btn btn-primary btn-large" href="/items/productions"><i class="icon icon-cog"></i> Back to Production</a>
    </span>
	<h2 class="head-1 ">Item Recipes</h2><hr/>
	<!-- <a id="addItem" class="btn btn-primary">Add Item</a><br/><br/> -->
	
	<div class="row" >

	<div id="loaderContainer"></div>
	 
	  @foreach($production_items as $item)
	  {{ Form::open(['route' => 'productions.cook','id' => 'formCook','class' => 'formIngredientsList'])}}
	  {{ Form::hidden('item_id',$item->item_id) }}
		<div  id="panel-content" class="span5" style="min-height: 600px;">
			 <divclass="widget widget-table action-table">
		        <div  class="widget-header"> <i class="icon-plus"></i>
		        <span class="pull-right">
		        	No. of servings : <input name="qty" value="12" class="span1" size="3" type="number">
				</span>		        	
		            <h3 >{{ Item::find($item->item_id)->name }}</h3>
		        </div>
		        <div  class="widget-content" style="padding:0px;">
		       		<div align="center" style="padding:3px;background: #EC407A;color:#fff;">Ingredients List</div>
		        	
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
		        				<td>{{ Form::number('amount[]','',['placeholder' => 'Qty','class'=>'span1'

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
			        		
	        				<!-- {{ Form::hidden('units',$ingredient->units) }} -->
	        				{{ Form::hidden('ing_ids[]',$ingredient->id) }}
	        				
			        		@endforeach

		        		</table>

		        	
		        	<!-- <button class="btnBake btn btn-primary ">
		        		Start Baking
		        	</button> -->
		        	
		        	<button type="button" class="btnBake btn btn-primary ">
		        		Start Baking
		        	</button>

		        	<a href="#" data-id="{{ $item->id }}"  data-item="{{ $item->name }}" class="btnRemove btn btn-danger ">
		        		Remove
		        	</a>
		        	
		        	</ul>

		        	<div align="center" class="feedback">
		        		
		        	</div>
		        	



		        </div>

     		</div>   <!-- /widget-table -->
		<!-- </div>/span4 -->
		{{ Form::close() }}
	 @endforeach

	 <div id="loader">
	 	<!-- <img src="/img/baking.svg"> -->
	 </div>
	</div><!-- /row -->

	<!-- {{ link_to_route('productions.produce','Add more items','',['class' => 'btn btn-default']) }} -->
	
	
	



@stop

@section('external-scripts')
	
	<script type="text/javascript">
		$(document).ready(function(){

			// $('.feedback').hide();
			var loaderContainer = $('#loaderContainer');

			$('.btnRemove').click(function(e){

				e.preventDefault();
				var form = $(this).closest(".formIngredientsList");
				var item = $(this).attr('data-item');
				var item_id = $(this).attr('data-id');
				// return alert(item_id);
				if(confirm('Are you sure you want to remove ' + item + ' from the productions list ? This cannot be undone. ')){

					//handle the removal of the item
					removeItem(item_id,form);
					$(this).remove();
					
					
				}
			});
			$('.btnBake').click(function(e){

				e.preventDefault();

				var form = $(this).closest(".formIngredientsList");
        		var formData =  form.serialize();
        		var feedbackContainer = form.find('.feedback');
        		
        		var button = $(this).hide();

				form.css("opacity",'.6');
				// $('.btnBake').hide();

				loaderContainer.html('Baking <img id="bakerLoader" src="/img/baking-loader.gif">');

				console.log(form.serialize());
				// return false;
				// var postData = $(this).serialize();

				var reqUrl = form.attr('action');

					$.ajax({

				 		url : reqUrl,
				 		type: 'GET',
				 		data : formData,

				 		success : function(data){

				 			console.log(data);

				 			if(data.response == '300'){

				 				$('#loaderContainer').empty();
				 				form.css("opacity",'1');
				 				button.show();
				 				setTimeout("alert('Some stocks are not enough! Operation cancelled.'), function(){ $('#loaderContainer').empty(); };",1000);
				 				feedbackContainer.addClass('failed');
				 				feedbackContainer.html('Not enough ingredients.');
				 				return false;
				 			}

				 			
				 			// setTimeout("func");
				 			// feedback.show(function(){

				 			// 	feedback.addClass('success');
				 			// 	$(this).delay().slideUp(4000);
				 			// });
				 			
				 			
				 			// feedback.addClass('success');
        // 					feedback.delay().slideUp(1000);
				 			// setTimeout("alert('Baking Complete!'),function(){ $('#bakerLoader').remove(); };",1000);
				 			$('#loaderContainer').empty();
				 			alert('Operation has been completed!');
				 			feedbackContainer.addClass('success');
				 			
				 			feedbackContainer.html('Completed');
				 			$('.btnRemove').hide();
				 			
				 		
				 			
						},

						error : function(e){

							console.log('Error' + e.status +': ' + e.statusText);
						}

	 				}); /* end ajax request */



				return false;
			});

			
		
		});

		function removeItem(item_id,form){

			$.ajax({

				 		url : '/productions/billing/items/'+item_id+'/remove/',
				 		type: 'GET',
				 		

				 		success : function(data){

				 			console.log(data); 

				 			if(data.response == '200'){

				 				form.delay().slideUp(1000,function(){

				 					alert('Item has been removed !');

				 				});
				 				

				 			}
				 			

				 			
				 	
						},

						error : function(e){

							console.log('Error' + e.status +': ' + e.statusText);
						}

	 				}); /* end ajax request */
		}
	</script>

@stop

