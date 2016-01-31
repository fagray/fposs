@extends('layouts.master')


@section('external-styles')
	
	<style type="text/css">

		table, tr, td, th{
	    /*border: 1px solid blue;*/
	    padding: 2px;
	}

	table th{
		
	    /*background-color: #999999;*/
	}

	em{
	    background-color: yellow
	}

	</style>
@stop
@section('content')
	<span class="pull-right"><a href="/customers" class="btn btn-primary">Back to customers</a></span>
	<h3 class="head-2">Customer Profile</h3><Hr/>
	<div class="offset1 span9 ">
		<div class="card">
			<div class="card-block">
				<img style="float:left;" align="center"  src="/img/cupcake.jpg" width="150" height="150">
				<div style="margin-left: 350px;" >
					<h3 style=""   class="head-2">
						{{ $customer->fname .' '. $customer->lname }}
				    </h3>
				    <p>{{ $customer->contact_num }}</p>

				    <hr/>
				    <p>Date Added : {{ $customer->created_at }} </p>
				    <p>
				    	Last Recorded Sale : 
				    	@if(count($invoices) < 1)
				    		No records yet.
				    	@else
				    		{{ $invoices[count($invoices)-1]['created_at'] }} 
				    	@endif
				    	
				    </p>
				    <p>Total Amount Purchase:  <strong>Php {{ $total }}</strong></p>
				</div>
					
			</div>
		</div><!-- /end customer profile block -->
		<div class="card">
			<div class="card-block">
				<p class="card-text text-muted"> Update Customer Details</p><hr/>

				{{ Form::model($customer,array('class' => 'form-horizontal','route' => array('customers.update',$customer->id),'method' => 'PUT')) }}
     
            <div class="control-group">
                <label class="control-label" for="customer fname">Customer Firstname</label>
                <div class="controls">
                    {{ Form::text('fname',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="customer lname">Customer Lastname</label>
                <div class="controls">
                    {{ Form::text('lname',null) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="customer address">Contact number</label>
                <div class="controls">
                    {{ Form::text('contact_num',null) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="customer address">Address</label>
                <div class="controls">
                    {{ Form::textarea('address',null,['cols' => '10','rows' => '3','placeholder' => 'Street/Brgy/City']) }}
                </div> <!-- /controls -->
            </div>

            {{ Form::submit('Update Details',['class' => 'btn btn-primary']) }}

      
      
        {{ Form::close() }}

			</div>
		</div><!-- /end edit customer block -->	
		<div class="card">
			<div class="card-block">
			<span class="pull-right">
				Search by invoice # <input id="search" class="invoiceNum" type="number">
			</span>
			<h3 class="head-2">Purchase History</h3>
			<table class="table">
				<thead>
					<th>Invoice #</th>
					<th>Date</th>
					<th>Amount Due</th>
				</thead>

				<tbody>
					@if(count($invoices) > 0)
						@foreach($invoices as $invoice)
							
							<tr class="invoiceRow">
								<td><a data-invoice="{{$invoice->trans_id}}" class="invoice" href="/store/items/sales/{{$invoice->trans_id}}">{{ $invoice->trans_id }}</a></td>
								<td>{{ $invoice->created_at }} </td>
								<td>{{ $invoice->amount }} </td>
							</tr>
						@endforeach

					@else
						<tr><td colspan="3" style="background:red;color:#fff;">No records found.</td></tr>
						
					@endif
				</tbody>
			</table>
			</div>
		</div>	
	</div>

@stop

@section('external-scripts')
		<script type="text/javascript">
			$(document).ready(function(){

				$('.invoiceNum').on('keyup',function(){

					var invoiceNum = $(this).val();

					// var result = $('.invoiceRow').find('td a.invoice').text();


					// if(invoiceNum == result){

					// 	$('.invoiceRow').css("background","yellow");
					// }

				});

		function removeHighlighting(highlightedElements){
		    highlightedElements.each(function(){
		        var element = $(this);
		        element.replaceWith(element.html());
		    })
		}

		function addHighlighting(element, textToHighlight){
		    var text = element.text();
		    var highlightedText = '<em>' + textToHighlight + '</em>';
		    var newText = text.replace(textToHighlight, highlightedText);
		    
		    element.html(newText);
		}

		$("#search").on("keyup", function() {
		    var value = $(this).val();
		    
		    removeHighlighting($("table tr em"));

		    $("table tr").each(function(index) {
		        if (index !== 0) {
		            $row = $(this);
		            
		            var $tdElement = $row.find("td:first");
		            var id = $tdElement.text();
		            var matchedIndex = id.indexOf(value);
		            
		            if (matchedIndex != 0) {
		                $row.hide();
		            }
		            else {
		                addHighlighting($tdElement, value);
		                $row.show();
		            }
		        }
		    });
		});



		}); //end ready function


		</script>
@stop