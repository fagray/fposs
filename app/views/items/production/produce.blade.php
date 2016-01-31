@extends('layouts.master')

@section('content')
	
	<h2 class="head-1 ">Item Production</h2>
	<!-- <a id="addItem" class="btn btn-primary">Add Item</a><br/><br/> -->
	
	<div class="row">
		<div  id="panel-content" class="span4">
			 <div class="widget widget-table action-table">
		        <div class="widget-header"> <i class="icon-plus"></i>
		            <h3>Select Items</h3>
		        </div>
		        <div style="padding:10px;height:400px;overflow:scroll;" class="widget-content">

		        	@foreach($items as $item)
		        		<?php 
		        			$item_ing  = Item::find($item->id);
		        			$below_alert_level = false;
		        			foreach($item_ing->ingredients as $ing){

		        				if($ing->stocks < $ing->alert_level){

		        					$below_alert_level = true;

		        				}
		        			}
		        		?>
		        		

				        	<div class="item"  >
				        			<a href="#" data-item="{{ $item->id }}" data-name="{{ $item->name }}" >
					        			<img src="/img/cupcake.jpg" width="50" height="50">
					        			{{ $item->name }}
					        		</a>	

					       			@if($below_alert_level)
					        			<span class="pull-right" style="color:green;"><label style="color:#fff;" class="label label-warning">Some stock needs to be re-ordered</label></span>
					        			<span id="stat" class="pull-left" style="color:green;"> </span>
					        		@else
					        			<span class="pull-right" style="color:green;"><label style="color:#fff;" class="label label-success">Available</label></span>
					        			<span id="stat" class="pull-left" style="color:green;"> </span>
					        		@endif
					       
				        			<br/>
				        			
				        			<hr/>

				        	</div>
				       
		        	@endforeach


		        </div>

     		</div>   <!-- /widget-table -->
		</div><!-- /span4 -->

		<div  id="panel-content" class="span8 ">
			 <div class="widget widget-table action-table">
		        <div class="widget-header"> <i class="icon-plus"></i>
		            <h3>For Production</h3>
		        </div>
		        <div style="padding:10px;" class="production-container widget-content">
		       {{ Form::open(['id' => 'production']) }}
		     
		        <!-- <input class="btn btn-info" type="submit" value="Proceed"><hr/> -->
		        {{ Form::submit('Proceed',['class' => 'btn btn-info']) }}<hr/>
		        {{ Form::close() }}
		        	


		        </div>

     		</div>   <!-- /widget-table -->
		</div>

	</div><!-- /row -->
	
@stop

@section('external-scripts')
	<script type="text/javascript" src="/js/production.js"></script>
@stop

