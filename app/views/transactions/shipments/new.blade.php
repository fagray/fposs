@extends('layouts.master')

@section('external-styles')

    <link rel="stylesheet" type="text/css" href="/validetta/validetta.css">

@endsection

@section('content')
    <div class="widget ">
        <div class="widget-header"> <i class="icon-plus"></i>
            <h3>New Shipment</h3>
        </div>
        <div style="padding:10px;" class="widget-content">
           
           	<div class="row">
           		<div class="span10">
           		<span class="pull-right">Supplier : <strong id="supp_name"></strong></span>

 				<p class="head-4 dashed bold">Shipment details</p>
 				
           		{{ Form::open(array('route' => 'shipments.store','class' => 'form-horizontal','id' => 'newShipment')) }}

	          	
	            <div class="control-group">
                        <label class="control-label" for="">Stock Name</label>

                        <div class="controls">
                            <div class="input-prepend input-append">

                                {{ Form::select('stock_id',['Please select',$ingredients],'',array('id' => 'stock','data-validetta' => 'required')) }}

                            </div>
                        </div>	<!-- /controls -->
                </div>
	            <div class="control-group">
	                <label class="control-label" for="radiobtns">Quantity</label>

	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        {{ Form::number('qty',null,array('class' => 'form-control span2','min' => '1','max' => '500','data-validetta' => 'required,number')) }}
	                         <span class="add-on" id="unit"></span>

	                    </div>
	                </div>	<!-- /controls -->
	            </div>

	            <div class="control-group">
	                <label class="control-label" for="radiobtns">Received by </label>

	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        {{ Form::text('received_by',Auth::user()->username,array('class' => 'form-control span3','disabled')) }}
	                       

	                    </div>
	                </div>	<!-- /controls -->
	            </div>

	            <div class="control-group">
	                <label class="control-label" for="radiobtns"> Deliver by </label>

	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        {{ Form::text('deliver_by',null,array('class' => 'form-control span3','data-validetta' => 'required')) }}
	                       

	                    </div>
	                </div>	<!-- /controls -->
	            </div>

	            <div class="control-group">
	                <label class="control-label" for="">Remarks</label>

	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        {{ Form::textarea('remarks',null,array('class' => 'form-control span4','rows' => '4','data-validetta' => 'required')) }}

	                    </div>
	                </div>	<!-- /controls -->
	            </div>

	        
	            
	            {{ Form::hidden('type','1') }}
	            {{ Form::hidden('received_by',Auth::user()->username) }}
	           
	            <div class="form-actions">
	                <button type="submit" class="btn btn-primary"><icon class="icon-save"></icon> Save</button>
	                <a href="/transactions/shipments" class="btn"><icon class="icon-arrow-left"></i> Back</a>
	            </div>
	            {{ Form::close() }}
           	</div>
        </div>
            
        </div>{{-- /end of widget-content --}}
    </div>{{-- /end of widget-table--}}

    <br/><Br/>

@stop

@section('external-scripts')
<script type="text/javascript" src="/validetta/validetta.js"></script>
    


	<script type="text/javascript">
	$(document).ready(function(){

		  //validetta library
            $('form#newShipment').validetta({

                realTime : true
            });



		$('select[id=stock]').change(function(){

			// alert("ad");
			//get its value
			var stock = $(this).val();
			var stock_name  = $("#stock option:selected").text();

			

			$.getJSON('/stocks/units/'+stock,function(data){
				console.log(data);
				// alert(data.price);

				$('span[id=unit]').html(data.shipment_unit);
				
			});

			$.getJSON('/stocks/suppliers/'+stock,function(data){
				console.log(data);
				// alert(data.price);

				$('strong[id=supp_name]').html( data);
				
			});

		});
	});
	</script>
@stop
