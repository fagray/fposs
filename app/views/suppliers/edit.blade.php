@extends('layouts.master')

@section('content')
    <div class="widget ">
        <div class="widget-header"> <i class="icon-plus"></i>
            <h3>New Vendor</h3>
        </div>
        <div style="padding:10px;" class="widget-content">
           

           	<div class="row">
           	
           		<div class="span10">
           			 <p class="head-4 dashed bold">Basic Information</p>
           			{{ Form::model($supplier,['method' => 'PUT','route' => ['suppliers.update',
           			$supplier->id],'class' => 'form-horizontal']) }}

	            <div class="control-group">
	                <label class="control-label" for="category name">Company Name</label>
	                <div class="controls">
	                    {{ Form::text('name',null,array('autofocus'=> '','class' => 'form-control span4')) }}
	                </div> <!-- /controls -->
	            </div>

	            <div class="control-group">
	                <label class="control-label" for="category name">Resource Person</label>
	                <div class="controls">
	                    {{ Form::text('resource_person',null,array('autofocus'=> '','class' => 'form-control span4')) }}
	                </div> <!-- /controls -->
	            </div>
	             <p class="head-4 dashed bold">Contact Information</p>
	            <div class="control-group">
	                <label class="control-label" for="radiobtns">Email</label>

	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        {{ Form::text('email',null,array('class' => 'form-control span4')) }}

	                    </div>
	                </div>	<!-- /controls -->
	            </div>
	            <div class="control-group">
	                <label class="control-label" for="radiobtns">Contact no.</label>

	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        {{ Form::text('contact_num',null,array('class' => 'form-control span4')) }}

	                    </div>
	                </div>	<!-- /controls -->
	            </div>

	            <div class="control-group">
	                <label class="control-label" for="">Address</label>

	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        {{ Form::textarea('address',null,array('class' => 'form-control span4','rows' => '4')) }}

	                    </div>
	                </div>	<!-- /controls -->
	            </div>

	            <div class="form-actions">
	                <button type="submit" class="btn btn-primary"><icon class="icon-save"></icon> Save</button>
	                <a href="/items" class="btn"><icon class="icon-arrow-left"></i> Back</a>
	            </div>
	            {{ Form::close() }}
           	</div>
        </div>
            
        </div>{{-- /end of widget-content --}}
    </div>{{-- /end of widget-table--}}

    <br/><Br/>

@stop
