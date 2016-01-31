@extends('layouts.master')

@section('content')
	
	<h3 class="head-2">Production Units</h3><hr/>

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

			@endif
			
		</tbody>
	</table>



@stop