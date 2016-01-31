@extends('layouts.master')

@section('external-styles')

    <link rel="stylesheet" type="text/css" href="/validetta/validetta.css">

@endsection

@section('content')
    
    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-plus"></i>
            <h3>Update Item</h3>
        </div>
        <div style="padding:10px;" class="widget-content">
            
            <p class="head-4 dashed bold ">Item details</p>

            	
                {{ Form::model($item,array(

                                    'route'     => array('items.update',$item->id),
                                    'name'      =>'form-item',
                                    'method'	=> 'PUT',
                                    'class'     => 'form-horizontal',
                                    'id'        => 'editItem')) 
                }}
            
            @include('items/partials.form');
           
                {{ Form::hidden('status','1') }}
                <div class="form-actions">
                    <button  type="submit" class="btn btn-primary">
                        <icon class="icon-save"></icon> Save
                    </button>
                    <a href="/items" class="btn"><i class="icon-arrow-left"></i> Back</a>
                </div>
                {{ Form::close() }}
        </div>{{-- /end of widget-content --}}
    </div>{{-- /end of widget-table--}}
    

@stop


@section('external-scripts')
    <script type="text/javascript" src="/validetta/validetta.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            //validetta library
            $('form#updateItem').validetta({

                realTime : true
            });

        });
    </script>
@stop
