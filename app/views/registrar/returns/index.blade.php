@extends('layouts.master')

@section('external-styles')
	<link rel="stylesheet" type="text/css" 
		href="/simple-modal/source/assets/css/simplemodal.css">
@stop

@section('content')
	<div class="row">
        <div class="span7">

	<div class="widget widget-nopad">
    	<div style="padding:0px;" class="widget-content">
    		<div id="option-header" style="padding: 5px;background: #E6E6E6;">
                    Register Mode :<select id="selectModeType">
	                        <option value="modeSales" > Sales</option>
	                        <option selected="selected" value="modeReturns"> Returns</option>
	                    </select>
                  
            </div>
            <div class="subnavbar">
                <div class="subnavbar-inner">
                    <div class="container">
                     	<ul class="mainnav">
	                        <li>
	                            <a id="payKey" class="payment-key" href="#">
	                                <i class="icon-chevron-down"></i>
	                                <span>Pay (F2)</span> 
	                            </a> 
	                        </li>
	                    
	                        <li>
	                            <a id="returnVoidKey" class="payment-key" href="#"><i class="icon-ban-circle"></i>
	                                <span>Void (F7)</span> 
	                            </a> 
	                        </li>
	                        <li>
	                            <a id="discountKey" class="payment-key" href="/store/items/sales"><i class="icon-money"></i>
	                                <span>Sales (F8)</span> 
	                            </a> 
	                        </li>
                        </ul>
                    </div>
                    <!-- /container --> 
                </div>
	              <!-- 	<p>Register Mode  : </p>
	                    <select id="selectModeType">
	                        <option value="modeSales" > Sales</option>
	                        <option selected="selected" value="modeReturns"> Returns</option>
	                    </select> -->
	            	
                  <!-- /subnavbar-inner --> 
                  <span class="pull-right">
                  	Date/Time Purchased :
                  	<span id="dateTime"></span>
                  </span>
            </div>

			<div class="widget big-stats-container">

				<div class="widget-content">
				<strong id="total"></strong>

					<!--  <p style="font-size:18px;padding:10px;margin-top:10px;">Total : </p> -->
					{{ Form::open(array(

					    'id'    => 'returnForm',
					    'method'   => 'POST',
					    'class' => 'form-horizontal'

					    
					)) 
					}}  

					<div id="tbBarcode" class="control-group">
						<label class="control-label" for="radiobtns">Type Receipt No.</label>
						<div class="controls">
						<div class="input-append">
						<input id="receipt_no"  class="span5 m-wrap input-lg"  placeholder ="Find / Type Barcode or Receipt No. " autofocus="autofocus"  style="height:27px;" id="appendedInputButton" type="text">
						</div>
						</div>  <!-- /controls -->

					</div>

					<!--    <ul class="populated_items" style="display:none;width:500px;height: auto;background: #fff;border:1px solid #000;margin-left: 150px;">

					</ul> -->

					{{ Form::close() }}
				<span id="preloader"></span>
				<div id="receiptContainer" style="padding:8px;background: #D9E0DB;color:red;"></div>
				<div style="" class="items-container">
					<table style="font-family:'Helvetica';" id="return-items" class="table  table-bordered">
						<thead>
							<tr id="header">
								<th> Item Code </th>
								<th> Description </th>
								<th> Price</th>
								<th> Quantity</th>
								<th></th>
							</tr>
						</thead>
					<tbody>

					</tbody>
					</table>
				</div>
			
				</div>
			<!-- /widget-content -->
			</div>
		</div>{{--/end of widget-content --}}
	</div>

        </div><!-- /span7 -->
          <div class="span5">
                <div class="widget widget-nopad">
                   
                    <h2 style="padding:5px;background: #11B936;color:#fff;" class="bold head-3">Update Checkout Details</h2>

                    
                          <div class="card" style="border:1px solid #ccc;margin-  top:0px;padding:10px;">
                            <div class="card-block">Customer Details
                               
                                <hr/>

                                

                                <div class="cust-details">
                                     <span class="pull-right">
                                        <img src="/img/user.png">
                                    </span>
                                    <span id="cust_name" class="head-3"></span>
                                    <span id="mobile_container"></span>
                                </div>
                               
                            </div><!-- /end card-block -->
                          
                                 {{ Form::open(['route' => 'registrar.return',
                                'class' => 'form-control','id' => 'payment'])}}
                                <div id="summary"  style="padding:10px;">


                                    <h6 style="font-size:14px;" class="text-muted card-subtitle">
                                        Update Payment Details
                                    </h6><hr/>
                                 
                                    <div class="card card-footer">
                                    	<p id="subtotal"> </p> 
                                    	<p id="vat">VA :  </p> 
                                         <p  style="font-size:18px;font-weight:bold;color:#5F5859;"> Overall Total : Php <span class="total"></span>
                                         </p>

                                    </div>
                                      <div id="rightBar">
                                   

                                   
                                        <label class="control-label" for="category name">Update  Cash </label>
                                        
                                            {{ Form::number('cash',null,['class' => 'form-control tbAmount','required','style' => 'height:30px;font-size:20px;']) }}
                                            {{ Form::hidden('customer_id')}}
                                            {{ Form::hidden('trans_id','')}}
                                            {{ Form::hidden('vat','')}}
                                            {{ Form::hidden('change','')}}
                                            {{ Form::hidden('amount','')}}
                                            {{ Form::submit('Update Payment',['class' => 'form-control   btn-primary'])}}
                               
                                   
                                        <Br/><strong style="font-size:15px;"><span id="amount"></span><br/>
                                        <span id="change"></span></strong>
                                        <span id="qty"></span>
                                    </p>
                                   
                                    
                                    <div class="card card-footer">
                                        Thank you for your purchase Raymund.        
                                    </div>
                                </div><!-- /summary -->
                            {{ Form::close() }} 
                         </div>
                    </div><!-- /end card -->
               
                    
                </div>{{-- /end no-pad --}}
            </div><!-- /end of span5 -->
    </div><!-- /row -->

@stop

@section('external-scripts')
	
	<script type="text/javascript" src="/js/returns.js"></script>
	<script type="text/javascript" 
		src="/simple-modal/source/simple-modal.js"></script>

@stop