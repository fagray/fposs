<!DOCTYPE html>
<html>
<head>
	<title>Item Badrcodes</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.min.css" rel="stylesheet">

    <!-- Hartija Print Framework -->
    <link rel="stylesheet" href="/css/print.css" type="text/css" media="print">
    <style type="text/css">
    	div .barcode{

    		
    	}
    </style>
</head>
<body >
	<div class="main" style="margin:0 auto;">
	    <div class="main-inner">
	        <div class="container">

				<h2>Item Barcodes</h2><hr/>
				<?php $current_items = Item::all(); ?>
			
				<div class="row" >
					@foreach($current_items as $item)
					
					<div style="border:1px solid #ccc;padding:10px;width:292px;float:left;">

						<strong style="font-size:15px;"> {{ $item->name }}</strong>
						{{ DNS1D::getBarcodeHTML($item->barcode, "EAN13",3,80) }}
						<div class="barcode" style="letter-spacing:8px;line-height:26px;margin-left:38px;margin-top:10px;font-size:18px;">

							{{ $item->barcode }}
						</div>
						
						
					</div>

					@endforeach
					
				</div><!-- /row -->
			</div>
		</div>
	</div>		



</body>
</html>

