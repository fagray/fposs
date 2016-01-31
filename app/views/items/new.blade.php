@extends('layouts.master')

@section('external-styles')

    <link rel="stylesheet" type="text/css" href="/validetta/validetta.css">

@endsection

@section('content')
    
    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-plus"></i>
            <h3>New Item</h3>
        </div>
        <div style="padding:10px;" class="widget-content">
            
            <p class="head-4 dashed bold ">Item details</p>

                {{ Form::open(array(
                                    'route'     => 'items.store',
                                    'name'      =>'form-item',
                                    'class'     => 'form-horizontal',
                                    'id'        => 'newItem')) 
                }}
            
            @include('items/partials.form');
            <div class="raw">
                <p class="head-4 dashed bold">Ingredients </strong> </p>
                @foreach($ingredients as $ingredient)
                    <label class="control-label" for="">{{ $ingredient->name }}</label>
                    <div class="control-group">
                        <div class="controls">
                            <div class="input-prepend input-append">

                                <input value="{{ $ingredient->id  }}" name="ing_id[]" type="checkbox" ng-model="{{ $ingredient->name }}">
                                <!-- <input placeholder="amount in grams" name="ing_amount[]" type="text" ng-show="{{ $ingredient->name }}">

                                <span ng-show="{{ $ingredient->name }}" class="add-on">
                                {{ $ingredient->units }}
                                </span> -->
                            </div>
                        </div>  <!-- /controls -->
                    </div>
                @endforeach
            </div><!-- /raw -->
                   

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
            $('form#newItem').validetta({

                realTime : true
            });

             $('div.raw').hide();

            $('select#category').on('change',function(){
                // alert("fuck");
                var cat_id  = $(this).val();
                var category = $(this).find('option[value=' + cat_id + ']').text();
                // alert(category);
                
                if(category == 'General'){

                    $('div.raw').hide();

                }else{

                    $('div.raw').show();
                }
            });
        });
    </script>
@stop
