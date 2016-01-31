@extends('layouts.master')
	@section('content')

		<style type="text/css">

			#container .mix{

				display: none;
			}

			.mix{

				width: 200px;
				height: 100px;
				position: relative;
				background: red;


			}
			.controls div {

				margin-left: 20px;
				cursor: pointer;
				list-style-type: square;
			}


		</style>

		<div class="controls">
			<div class="filter" data-filter="all">Show All</div>
			<div class="filter" data-filter="category-1">Category 1</div>
			<div class="filter" data-filter="category-2">Category 2</div>
			<div class="filter" data-filter="category-3">Category 3</div>
		</div>
		<br/>
		<div id="container">
			<div class="mix category-1" ></div><br/>
			<div class="mix category-2" ></div><br/>
			<div class="mix category-2"></div><br/>
			...
			<div class="mix category-4" ></div>
		</div>

		</div>
	@stop

@section('external-scripts')
	<script type="text/javascript" src="/js/jquery.mixitup.min.js"></script>
	<script type="text/javascript">

	   

	    	 $(function(){
		        $('#container').mixitup();
		      });
	  
	     
	      
	    </script>

@stop