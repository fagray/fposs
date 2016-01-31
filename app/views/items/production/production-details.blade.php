@extends('layouts.master')

@section('content')
	<span class="pull-right"><a href="/items/productions#production-list" class="btn btn-primary">Back to Production</a></span>
	<h3 class="head-2">Production Details - PROD # {{ $productions[0]['production_id'] }} </h3><hr/>
	<p>Production Date and Time :  {{ $productions[0]->created_at }}</p>

	<div class="row">
		<div class="span6">
			<div class="card">
				<div class="card-block">
					<h4 class="card-text" >Production Items </h4><hr/>
					<table class="table">
						<thead>
							<th>Item Name</th>
							<th>Qty</th>
						</thead>

						<tbody>

							@foreach($items as $item)
								<tr>
									<td> {{ $item->item_name }}</td>
									
									<td> {{ $item->qty }}</td>
									
								</tr>
							@endforeach

						</tbody>

					</table>
					
				</div><!-- /card-block -->
			</div><!-- /card -->
		</div><!-- /span6 -->
		<div class="span6">
			<div class="card">
				<div class="card-block">
					<h4 class="card-text" >Billing of Ingredients </h4><hr/>
					<table class="table">
						<thead>
							<th>Ingredient Name</th>
							<th>Equivalent in grams</th>
						</thead>

						<tbody>

							@foreach($productions as $production)
								<tr>
									<td> {{ $production->name }}</td>
									@if($production->name == 'Eggs')
										<td> {{ $production->amount }} pc(s)</td>
									@else
										<td> {{ $production->in_grams }} g</td>
									@endif
									
								</tr>
							@endforeach

						</tbody>

					</table>
					
				</div><!-- /card-block -->
			</div><!-- /card -->
		</div><!-- /span6 -->
	</div><!-- /row -->

	
	
	



@stop
