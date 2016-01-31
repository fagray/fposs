@extends('layouts.master')

@section('external-styles')

    <link rel="stylesheet" type="text/css" href="/validetta/validetta.css">

@endsection

@section('content')
    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-plus"></i>
            <h3>New Stock</h3>
        </div>
        <div class="widget-content">
            <div class="row">
                <div class="span10">

                <p class="head-4 bold">
                    <i>Production units can only be setup on the settings module.</i>
                </p>
                      
                 <p class="head-4 dashed bold">Basic Information</p>
                    {{ Form::open(array('class' => 'form-horizontal','id' => 'newStock')) }}
                    
                   <!--  <div class="control-group">
                        <label class="control-label" for="category name">Units</label>
                        <div class="controls">
                            
                            {{ Form::select('units',
                                            [
                                                'pcs' => 'Pieces(pcs)',
                                                'g'   => 'Grams(g)',
                                                'kg'  => 'Kilograms(kg)'
                                            ]
                            )}}
                            <span class="input-group-addon">This will served as the basis when adding a new item.</span>
                        </div> 
                    </div> -->

                    <div class="control-group">
                        <label class="control-label" for="category name">Stock Name</label>
                        <div class="controls">
                            {{ Form::text('name',null,array('autofocus'=> '',
                            'class' => 'form-control span3','data-validetta' => 'required')) }}
                        </div> <!-- /controls -->
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="">Description</label>

                        <div class="controls">
                            <div class="input-prepend input-append">

                                {{ Form::textarea('description',null,array('class' => 'form-control span3','rows' => '4','data-validetta' => 'required')) }}

                            </div>
                        </div>  <!-- /controls -->
                    </div>

                   
                  

                    <p class="head-4 dashed bold">Vendor Information</p>
                    <div class="control-group">
                        <label class="control-label" for="">Vendor</label>

                        <div class="controls">
                            <div class="input-prepend input-append">
                          
                                {{ Form::select('supplier_id',['' => '',$suppliers],'',
                                ['id' => 'supplier','style' => 'width:270px;','data-validetta' => 'required']) }}

                            </div>
                        </div>  <!-- /controls -->
                    </div>
                    <div id="shipmentContainer">
                        <p class="head-4 dashed bold">Receiving Information</p>
                        <div class="control-group">
                            <label class="control-label" for="">Re-order unit</label>

                             <div class="controls">
                                {{ Form::select('shipment_unit',
                                                [
                                                    'Please select' => '',  
                                                    'sacks'     => 'Sacks',
                                                    'packs'     => 'Packs',
                                                    'pc'        => 'Pc(s)'
                                                   
                                                ],'',
                                                ['id' => 'ship_unit',
                                                'style' => 'width:270px;',
                                                'data-validetta' => 'required']
                                )}}
                                <span class="input-group-addon"> Unit used for receiving / re-ordering new stocks. </span>
                            </div> <!--  /controls -->

                         </div>
                        <div class="control-group">
                            <label class="control-label" for="category name">Amount </label>
                            <div class="controls">
                                {{ Form::text('base_kg',null,array('autofocus'=> '','class' => 'form-control span3','id' => 'base_kg','data-validetta' => 'number,required')) }}
                                <span class="input-group-addon"> Converted amount in kg. <i>
                                e.g <strong> 1 sack = 25kg. / 1 packs = 0.250 kg  </strong></i> </span>
                            </div> <!-- /controls-->
                        </div>
                        

                    </div>

                    <p class="head-4 dashed bold">Inventory</p>

                     <div class="control-group">
                        <label class="control-label" for="">Low level threshold</label>

                        <div class="controls">
                            <div class="input-prepend input-append">

                                {{ Form::number('alert_level',null,['data-validetta' => 'required']) }}

                                <span class="add-on" id="alert-unit"></span>
                                <span class="input-group-addon"> The system will give an alert when this stock gets low </span>
                              
                            </div>

                        </div>  <!-- /controls -->
                    </div>
                    
                    <input type="hidden" name="base_g" value="">

                 <p class="head-4 dashed bold">Pricing</p>
                    <div class="control-group">
                        <label class="control-label" for="category name"> Price</label>
                        <div class="controls">
                            <div class="input-prepend input-append">
                                <span class="add-on">Php</span>
                                {{ Form::number('price',null,array('class' => 'form-control span3','style' => 'width:225px;','data-validetta' => 'required')) }}

                            </div>
                        </div>  <!-- /controls -->
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary"><icon class="icon-save"></icon> Save</button>
                        <a href="#" class="btn"><icon class="icon-arrow-left"></i> Back</a>
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
            $('form#newStock').validetta({

                realTime : true

            });

            // $('input[name="unit_in_grams"]').attr('disabled','disabled');

            $('input[id=base_kg]').keyup(function(){

               //get the value and convert to g
               var base_kg = $(this).val();
               var g = base_kg * 1000;


               //append to hidden input
               $('input[name=base_g]').val(g);

               // alert(base_kg);
            });

            

            $('select[name="shipment_unit"]').change(function(){

                // var unit = $(this).val();
                var unit  = $("#ship_unit option:selected").text();

               $('span#alert-unit').html(unit);
               
                // alert(unit);
            });


            function setValue(val){

                $('input[name="unit_in_grams"]').val(val);
                
         }
        });



    </script>
@stop
