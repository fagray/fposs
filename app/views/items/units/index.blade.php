@extends('layouts.master')

@section('external-styles')
	<style type="text/css">

		tbody tr td:hover { 

			background: #F0F4C3;
		}

		tbody tr{

			
		}

	</style>
		
@stop

@section('content')
		
		<div class="row">
			<div class="span8">
				<table class="table ">
					<tr style="background:#8BC34A;color:#fff;">
						<th>Ingredient </th>
						<th>Unit</th>
						<th>In Grams</th>
						
					</tr>
					<tbody>
						<tr>
							<td>Baking Flour</td>
							<td>Cup</td>
							<td>140 </td>

						</tr>
						<tr>
							<td>Baking Powder</td>
							<td>Cup</td>
							<td>110 </td>

						</tr>
						<tr>
							<td>Butter</td>
							<td>Sticks </td>
							<td>115 </td>
						</tr>
						<tr>
							<td>Brown Sugar</td>
							<td>Cup </td>
							<td>220 </td>
						</tr>

					</tbody>
					
				</table>
			</div>
			

		</div>
		

@stop