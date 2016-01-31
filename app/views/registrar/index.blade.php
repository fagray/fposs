@extends('layouts.master')

@section('external-styles')
        
    <link rel="stylesheet" type="text/css" href="/chosen/chosen.min.css">
    <link rel="stylesheet" type="text/css" 
        href="/simple-modal/source/assets/css/simplemodal.css">

@stop

@section('content')
  
    <div class="row">
        <div class="span7"><div ng-view></div>
        <div id="flash" ></div>
            <div class="widget widget-nopad">
                <div class="shortcuts"></div>
                <!-- <div class="widget-header"> <i class="icon-tag"></i>
                    <h3> Sales Register</h3>
                    
                </div> -->
                <!-- /widget-header -->
                <div style="padding:0px;" class="widget-content">
                <div id="option-header" style="padding: 5px;background: #E6E6E6;">
                    Register Mode : <select id="selectModeType">
                            <option value="modeSales" > Sales</option>
                            <option value="modeReturns"> Returns</option>
                        </select>
                    Input type :  <select id="selectInputType">
                            <option value="inputBarcode" > Barcode</option>
                            <option value="inputItemName"> Item Name</option>
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
                            <a id="voidKey" class="payment-key" href="#"><i class="icon-ban-circle"></i>
                                <span>Void (F7)</span> 
                            </a> 
                        </li>
                        <li>
                            <a id="discountKey" class="payment-key" href="/store/items/sales"><i class="icon-money"></i>
                                <span>Sales (F8)</span> 
                            </a> 
                        </li>

                       <!--  <li>
                            <a class="payment-key" href="#"><i class="icon-off"></i>
                                <span>Close Register (F10)</span> 
                            </a> 
                        </li> -->
                        
                        </ul>
                        </li>

                        <span class="pull-right"  id="trans_id">

                        
                             
                            @if(Session::has('trans_id'))

                                TRNS # :  
                                <strong id="trans_id" data-value="{{ Session::get('trans_id') }}">
                                    {{ Session::get('trans_id') }}

                                </strong>

                            @endif


                        </span>
                      </ul>
                    </div>
                    <!-- /container --> 
                  </div>
                 <!--  <p>Register Mode  : </p>
                        <select id="selectModeType">
                            <option value="modeSales" > Sales</option>
                            <option value="modeReturns"> Returns</option>
                        </select>
                <p>Input item by  : </p>
                        <select id="selectInputType">
                            <option value="inputBarcode" > Barcode</option>
                            <option value="inputItemName"> Item Name</option>
                        </select> -->
                  <!-- /subnavbar-inner --> 
                </div>
                    <div class="widget big-stats-container">
                        
                        <div class="widget-content">
                        
                        
                            <!--  <p style="font-size:18px;padding:10px;margin-top:10px;">Total : </p> -->
                            {{ Form::open(array(

                                                'id'    => 'regForm',
                                                'method'   => 'POST',
                                                'class' => 'form-horizontal'

                                                
                                        )) 
                            }}  
                                <div id="tbBarcode" class="control-group">
                                    <label class="control-label" for="radiobtns">Find/Scan Item</label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input id="barcode" name="code"  class="span5 m-wrap input-lg"  placeholder ="Enter/Scan Barcode " autofocus="autofocus"  style="height:27px;" id="appendedInputButton" type="text">
                                        </div>
                                    </div>  <!-- /controls -->
                                   
                                </div>

                                <div style="display:none;" id="tbItemName" class="control-group">
                                    <label class="control-label" for="radiobtns">Type item name</label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input list="item-list" id="item_name"   class="span4 m-wrap input-lg"  placeholder ="Start typing the item name" autofocus="autofocus"  style="height:27px;" id="appendedInputButton" type="text">
                                            <datalist id="item-list">
                                               <!--  <option value="BBQ">
                                                <option value="Ham">
                                                <option value="Laswa">
                                                <option value="Uga"><option value="BBQ">
                                                <option value="Wala"> -->
                                            </datalist> 
                                        </div>
                                        <input class="btn btn-large btn-primary" type="submit">
                                    </div>  <!-- /controls -->
                                   
                                </div>
                             <!--    <ul class="populated_items" style="display:none;width:500px;height: auto;background: #fff;border:1px solid #000;margin-left: 150px;">
                                
                                </ul> -->

                            {{ Form::close() }}
                            <span id="preloader"></span>
                            <div style="" class="items-container">
                                <table style="font-family:'Helvetica';" id="items" class="table  table-bordered">
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
                           <!--  <div class="form-actions">
                                <span class="pull-right">
                                    <h3>
                                        Total : Php <strong id="total">0.00</strong>
                                    </h3>
                                </span>
                            </div> -->
                        </div>
                        <!-- /widget-content -->
                    </div>
                </div>{{--/end of widget-content --}}
            </div>
        </div>
        <div class="row">
            <div class="span5">
                <div class="widget widget-nopad">
                   
                    <h2 style="padding:5px;background: #11B936;color:#fff;" class="bold head-3">Checkout</h2>

                    
                          <div class="card" style="border:1px solid #ccc;margin-  top:0px;padding:10px;">
                            <div class="card-block">Customer : 
                               
                                <select class="chzn-select selectCust">
                                
                                  <!--   <option value="13">Walk-in Customer</option> -->
                                   <!--  <option value="13">Walk-in Customer</option> -->
                                    @foreach($customers as $customer)
                                      
                                        <option data-mobile="{{ $customer->contact_num }}" value="{{ $customer->id }}">{{ $customer->fname . ' ' . $customer->lname }} </option>
                                       
                                  
                                    @endforeach
                                </select>
                              
                                <hr/>

                                

                                <div class="cust-details">
                                     <span class="pull-right">
                                        <img src="/img/user.png">
                                    </span>
                                    <span id="cust_name" class="head-3"></span>
                                    <span id="mobile_container"></span>
                                </div>
                               
                            </div><!-- /end card-block -->
                          
                                 {{ Form::open(['route' => 'registrar.purchase',
                                'class' => 'form-control','id' => 'payment'])}}
                                <div id="summary"  style="padding:10px;">


                                    <h6 style="font-size:14px;" class="text-muted card-subtitle">
                                        Payment Details
                                    </h6><hr/>
                                 
                                    <div class="card card-footer">
                                        <p id="subtotal"> </p> 
                                        <p id="vat">VA :  </p> 
                                         <p  style="font-size:18px;font-weight:bold;color:#5F5859;"> Overall Total : Php <span class="total"></span>
                                         </p>

                                    </div>
                                      <div id="rightBar">
                                   

                                   
                                        <label class="control-label" for="category name">Enter Cash </label>
                                        
                                            {{ Form::number('cash',null,['class' => 'form-control tbAmount','required','style' => 'height:30px;font-size:20px;']) }}
                                            {{ Form::hidden('customer_id')}}
                                            {{ Form::hidden('trans_id','')}}
                                            {{ Form::hidden('qty','')}}
                                            {{ Form::hidden('cashier',Auth::user()->username)}}
                                            {{ Form::hidden('change','')}}
                                            {{ Form::hidden('amount','')}}
                                            {{ Form::hidden('vat','')}}
                                            {{ Form::submit('Add Payment',['class' => 'form-control   btn-primary'])}}
                               
                                   
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
    </div><!-- /row -->

@stop


@section('external-scripts')
    <script type="text/javascript" src="/chosen/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="/js/fposs.js"></script>
        <script type="text/javascript" 
        src="/simple-modal/source/simple-modal.js"></script>

    <script type="text/javascript"> 
        var cust_id;
        var customer;

      
        $(document).ready(function(){

            $(".chzn-select").chosen();
     
            setCustomerDetails();
             // $('input[name="customer_id"]').val(cust_id);

             $('.selectCust').on('change',function(){

                setCustomerDetails();

             });

             function setCustomerDetails(){

                customer = $('.selectCust option:selected').text();
                cust_id =  $('.selectCust').val();
                $("#cust_name").html(customer);
                
                //append the customer id value
              
                var contact_num = $('.selectCust option:selected').attr('data-mobile');
                // alert(contact_num);
                $('#cust_name').html(customer);
                $('#mobile_container').html('<p>' + contact_num + '</p>');
               
                // 
                 $('input[name="customer_id"]').val(cust_id);
             }
           
        

        });
        

    </script>

@stop
