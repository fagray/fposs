@extends('layouts.master')

@section('content')
	<span class="pull-right">
		<a target="_blank" class="btn btn-primary btn-large" href="/items/productions"><i class="icon icon-cog"></i> Go to Production</a>
	</span>
	<h3 class="head-2">Unsold Items ({{count($unsold)}})</h3><hr/>

	<table class="table">
		<thead>

			<th>Item Name</th>
			<th>Remaining</th>
			<th>Date Baked</th>
			<th>Expiry Date</th>
			<th>Actions</th>
			
	
		</thead>

		<tbody>
		
			@foreach($unsold as $item)
				{{ Form::open(['class' => 'formAddToProduction']) }}
					<tr>
						<td>{{ $item->name }}</td>
						<td>{{ $item->remaining }}</td>
						<td>{{ substr($item->created_at,0,10) }}</td>
						<td>{{ substr($item->expires_at,0,10) }}</td>
						<td>
							{{ Form::number('qty', $item->remaining,['class' => 'span1'] ) }}
							{{ Form::hidden('item_id',$item->item_id) }}
							{{ Form::hidden('production_id',$item->production_id) }}
							<button class="btn ">Add to existing production</button>
						</td>
					</tr>
				{{ Form::close() }}
			@endforeach
		
		</tbody>
	</table>

@stop

@section('external-scripts')
		
	<script type="text/javascript">
		$(document).ready(function(){

			$('.formAddToProduction').submit(function(e){


				e.preventDefault();
				var formData = $(this).serialize();
				// alert(formData);
				// return false;
				$.ajax({

					url : '/productions/items/unsold/add',
					method : 'GET',
					data  : formData,

					success : function(data){

						console.log(data);
						if(data.response == 300){

							$('.msg-container').html('<div class="alert alert-danger">Item has not been cooked or brought to production.</div>');

						}else if(data.response == 200){

							$('.msg-container').html('<div class="alert alert-success">Item has been added to production.</div>');

						}

						$('div.alert').delay(5000).slideUp();

					} 


				});

				return false;
			});
		});
	</script>

@stop