@extends('layouts.master')

@section('external-styles')
	<link rel="stylesheet" type="text/css" href="/smart-wizard/smart_wizard_vertical.css">
@stop

@section('content')

	<div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-plus"></i>
            <h3>New Item</h3>
        </div>
        <div style="padding:20px;" class="widget-content">
            <p class="head-4 dashed bold ">Item details</p>

            <div id="wizard" class="swMain">
			  <ul>
			    <li><a href="#step-1">
			          <label class="stepNumber">1</label>
			          <span class="stepDesc">
			             Categorization<br />
			             <small>Item Category/Type</small>
			          </span>
			      </a></li>
			    <li><a href="#step-2">
			          <label class="stepNumber">2</label>
			          <span class="stepDesc">
			              Information<br />
			             <small>Item Information</small>
			          </span>
			      </a></li>
			    <li><a href="#step-3">
			          <label class="stepNumber">3</label>
			          <span class="stepDesc">
			             Pricing<br />
			             <small>Item price</small>
			          </span>                   
			       </a></li>
			    <li><a href="#step-4">
			          <label class="stepNumber">4</label>
			          <span class="stepDesc">
			             Raw Materials<br />
			             <small>Item Raw Materials</small>
			          </span>                   
			      </a></li>
			  </ul>
			  <div id="step-1">   
			     
			       <!-- step content -->
			       <div class="control-group ">

                        <label class="control-label" for="barcode ">Barcode</label>
                        <div class="controls">
                            {{ Form::text('barcode',null,
                                            array(
                                                    'autofocus'=> '',
                                                    'class' => 'form-control span3',   
                                                )
                                        ) }}

                            @{{ barcode.length }}
                            {{ Form::button('Generate',['class' => 'btn btn-sm'])}} 
                            
                        </div> <!-- /controls -->
                        
                    </div>
			  </div>
			  <div id="step-2">
			      <h2 class="StepTitle">Step 2 Content</h2> 
			       <!-- step content -->
			  </div>                      
			  <div id="step-3">
			      <h2 class="StepTitle">Step 3 Title</h2>   
			       <!-- step content -->
			  </div>
			  <div id="step-4">
			      <h2 class="StepTitle">Step 4 Title</h2>   
			       <!-- step content -->                         
			  </div>
			</div><!-- /end wizardi -->

          <!--   <p class="head-4 dashed bold ">Item details</p> -->

                    {{ Form::open(array('route' => 'items.store','name'=>'form-item','class' => 'form-horizontal')) }}

                   
                

                    {{ Form::hidden('status','1') }}
                   <!--  <div class="form-actions">
                        <button  type="submit" class="btn btn-primary"><icon class="icon-save"></icon> Save</button>
                        <a href="/items" class="btn"><icon class="icon-arrow-left"></i> Back</a>
                    </div> -->
                    {{ Form::close() }}
        </div>{{-- /end of widget-content --}}
    </div>{{-- /end of widget-table--}}

@stop

@section('external-scripts')
	<script type="text/javascript" src="/smart-wizard/jquery.smartWizard.js"></script>
	<script type="text/javascript">
		  $(document).ready(function() {
		      // Initialize Smart Wizard
        $('#wizard').smartWizard();
  }); 
</script>

@stop