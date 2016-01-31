@extends('layouts.master')

@section('content')
    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-plus"></i>
            <h3 class="page-header">New Receiving</h3>
        </div>
        <div class="widget-content">
            <p class="head-4 dashed">Receiving details</p>

            {{ Form::open(array('route' => 'receivings.store','class' => 'form-horizontal')) }}

            <div class="control-group">
                <label class="control-label" for="category name">Item Name</label>
                <div class="controls">
                    {{ Form::text('name',null,array('autofocus'=> '','class' => 'form-control span4')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="radiobtns">Quantity</label>

                <div class="controls">
                    <div class="input-prepend input-append">

                        {{ Form::number('quanity',null,array('class' => 'form-control span4')) }}

                    </div>
                </div>	<!-- /controls -->
            </div>

            <div class="control-group">
                <label class="control-label" for="radiobtns">Total Amount</label>

                <div class="controls">
                    <div class="input-prepend input-append">
                        <span class="add-on">Php</span>
                        {{ Form::number('payment',null,array('class' => 'form-control span3')) }}

                    </div>
                </div>	<!-- /controls -->
            </div>
            <div class=""
            <div class="control-group">
                <label class="control-label" for="">Supplier</label>

                <div class="controls">
                    <div class="input-prepend input-append">
                        {{--/select here--}}
                    </div>
                </div>	<!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="">Remarks</label>

                <div class="controls">
                    <div class="input-prepend input-append">

                        {{ Form::textarea('remarks',null,array('class' => 'form-control span4','rows' => '4')) }}

                    </div>
                </div>	<!-- /controls -->
            </div>

            {{ Form::hidden('status','1') }}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><icon class="icon-save"></icon> Save</button>
                <a href="/items" class="btn"><icon class="icon-arrow-left"></i> Back</a>
            </div>
            {{ Form::close() }}

        </div>{{-- /end of widget-content --}}
    </div>{{-- /end of widget-table--}}

    <br/><Br/>

@stop
