@extends('layouts.master')

@section('content')
	<span class="pull-right"><a href="/suppliers" class="btn btn-primary">Back to Suppliers</a></span>
	<h3 class="head-2">Supplier Details  </h3><hr/>
	
	<div class="row">
		<div class="span6">
			<div class="card">
				<div class="card-block">
					<h3 align="center" class="card-text" >{{ $supplier[0]->name }} </h3>
					<p align="center">{{ $supplier[0]->address }}</p>
					<hr/>
					<p> Resource Person : {{$supplier[0]->resource_person }} </p>
					<p> Contact Number : {{$supplier[0]->contact_num }} </p>
					<p> Email : {{$supplier[0]->email }} </p>
					
					
				</div><!-- /card-block -->
			</div><!-- /card -->
		</div><!-- /span6 -->
		<div class="span6">
			<div class="card">
				<div class="card-block">
					<h4 class="card-text"> Supplied Stocks </h4><hr/>
					<table class="table">
						<thead>
							<th>Stock Name</th>
							<th>Stock Price</th>
						</thead>

						<tbody>
							@foreach($supplier as $detail)
							
								<tr>
									<td> {{ $detail->stock_name }} </td>
									<td> {{ $detail->price }} </td>
									
									
								</tr>
							@endforeach	

						

						</tbody>

					</table>
					
				</div><!-- /card-block -->
			</div><!-- /card -->
		</div><!-- /span6 -->
	</div><!-- /row -->

	
	
	



@stop
