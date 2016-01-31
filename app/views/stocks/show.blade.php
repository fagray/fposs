@extends('layouts.master')

@section('content')
	<span class="pull-right"><a href="/inventory" class="btn btn-primary">Back to Ingredients</a></span>
	<h3 class="head-2">Ingredient Details</h3><hr/>
	<div class="row">
		<div class="span6">
			<div class="card">
				<div class="card-block">
					<h3 class="head-2"> {{ $ingredient->name }}</h3><hr/>
					<p> Stocks on hand : <strong>{{ $ingredient->stocks .' ' . $ingredient->shipment_unit }}  </strong>
						<i>
							( {{ number_format( $ingredient->in_grams ) .' '. ' g ' }} )
						</i>
					</p><hr/>
					<p><strong>Supplier Details </strong> </p>
					<a href="/suppliers/{{ $supplier->id }}"><h3 class="head-3"> {{ $supplier->name }} </h3></a>
					<i> {{ $supplier->address }}</i>

				</div><!-- /card-block -->
			</div><!-- /card -->
		</div><!-- /span6 -->

		<div class="span6">
			<div class="card">
				<div class="card-block">
					<h3 class="head-2">  Unit types ( {{ count($units) }})</h3><hr/>
					<table class="table">
						<thead>
							<th>Desc</th>
							<th>Symbol</th>
							<th>Equivalent in grams</th>
						</thead>

						<tbody>
							@if(count($units) > 0 )

								@foreach($units as $unit)
									<tr>
										<td>{{ $unit->name }} </td>
										<td>{{ $unit->symbol }} </td>
										<td>{{ $unit->in_grams }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="3">No units found.</td>
								</tr>

							@endif
							
						</tbody>
					</table>
				</div><!-- /card-block -->
			</div><!-- /card -->
		</div><!-- /span6 -->
	</div><!-- /row -->


@stop