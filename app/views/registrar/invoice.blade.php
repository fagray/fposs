<?php
	
	$total = 0;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Invoice # {{ $inv_details[0]['trans_id']; }}</title>

	<style type="text/css">

		.invoice-container{

			width: 290px;
			min-height: 400px;
			padding: 10px;
			margin: 0 auto;
			border: 1px dotted #ccc;

		}

		.header-text {

			font-size: 12px;
		}

		.subheader-text {

			font-size: 13px;

		}

		.pull-left {

			
			position: relative;
		}

		.left-side {

			font-size: 12px;
			list-style: none;
		}

		.hr {

			border-bottom: 1px solid #ccc;


		}

		.item-details {

			font-size: 12px;
			padding:0px;
			
		}

		.footer {

			font-size: 14px;

		}

		.dotted {

			border: 1px dotted #ccc;
		}

		.header-2 {

			font-size: 11px;
			font-weight: 300;
		}
	</style>
</head>
<body>

	<div class="invoice-container">
		<p class="header-text">
			
			<div class="header" align="center">

				<strong>Flibby's Sweet and Treats</strong>
				<p class="subheader-text">Lacson St. Bacolod City</p>
				<p class="subheader-text">Tel # : 1233-21233</p>
				<div class="dotted"></div>
				
			<!-- 	<p class="subheader-text"><strong>Invoice # {{ $inv_details[0]['trans_id']; }}</strong></p> -->

			</div>
		
				<p style="float:right;" class="header-2">Trans ID : {{ $inv_details[0]->trans_id }} </p>
				<p class="header-2">Date : {{ $inv_details[0]['created_at'] }}</p>
				<p class="header-2">Staff : {{ $inv_details[0]->cashier }} </p> 

			
		</p>
		<div class="dotted"></div>
			<p style="font-size: 12px;padding:0px;letter-spacing: 7px"  align="center">SALES TRANSACTION</p>
		<div class="dotted"></div>

		<!-- <ul class="left-side pull-left">

				<li>Date : Aug 8, 2015</li>
				<li>Customer : Raymund Santillan </li>

		</ul> -->
		
		<br/>
		<table width="100%" class="item-details">
			<thead>
				<tr>
					<th align="left" width="50%">Desc</th>
					<th align="center">Amount</th>
					
				</tr>
			</thead>
			<tbody>
				
					@foreach($inv_details as $detail)

						<tr>
							<td>
								{{ $detail->name . ' ' . $detail->qty . 'pc @ '.number_format($detail->price,2) }} 
							</td>

							<td align="center">
								Php {{ number_format($detail->price * $detail->qty,2) }}
							</td>
							
						</tr>
						<?php $total += ($detail->qty * $detail->price) ?>
					@endforeach


			</tbody>
		</table><br/>
		<div class="dotted"></div>
	
		<table width="100%" class="item-details">
			<thead>
				<tr>
					<th align="left" width="50%">Total Php</th>
					<th align="center"> {{ number_format($total,2) }}</th>
					

					
				</tr>
			</thead>
			<tbody>
				
				<tr>
					<td>Cash</td>
					<td align="center"> <strong> {{ $inv_details[0]['cash']}} </strong></td>
				
				</tr>

				<tr >
					<td>Change</td>
					<td  align="center">&nbsp;<strong> {{  number_format($inv_details[0]['cash'] -  $total,2)    }} </strong></td>
				
				</tr>

			</tbody>
		</table>
		<div class="dotted"></div>
		<p class="header-text">Number of Items  : {{ count($inv_details) }}</p>
		<p class="header-text">Vat (12%) :   <strong> {{ $inv_details[0]['vat_amount'] }}</strong></p>
		<p class="header-text">Vatable Amount :   <strong> {{ $inv_details[0]['amount'] - $inv_details[0]['vat_amount'] }}</strong></p>

		<div class="footer">
			<p class="header-text">

				<div style="margin-top:90px;" align="center">Thank you ! Come again !!!</div>
			</p>
		</div>
	
		

	</div>
	<script src="/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			// if(window.print()){

			// 	//close the window after printing
			// 	window.close();
			// }
			// window.close();
			
		});
	</script>

</body>
</html>
