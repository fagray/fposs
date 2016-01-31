@extends('layouts.master')

@section('content')
    <span class="pull-right">
         <div class="btn-group">
             <a href="#modal-newIcing" data-toggle="modal"  class="btn btn-success"><i class="icon-plus"> New</i></a>
             <button type="button" class="btn btn-default"><i class="icon-refresh"></i> Refresh</button>
             <button type="button" class="btn btn-default"><i class="icon-trash"></i> Delete</button>
         </div>
    </span><br/>
    <br/>

    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-th-list"></i>

            <h3>Icings</h3>

        </div>
        <!-- /widget-header -->
        <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> Name </th>
                    <th> Desc</th>
                  
                    <th class="td-actions">Actions </th>
                </tr>
                </thead>
                <tbody>
                @foreach($icings as $icing)
                    <tr>
                        <td> {{ $icing->name }} </td>
                        <td>{{ $icing->desc }} </td>
                     
                        <td class="td-actions">
                            <a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-pencil"> </i></a>
                            <a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
        <!-- /widget-content -->
    </div>

    <!-- Modal -->
    <div id="modal-newIcing" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">New Icing</h3>
        </div>
        {{ Form::open(array('route' => 'icings.store','class' => 'form-horizontal')) }}
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="category name">Icing Name</label>
                <div class="controls">
                    {{ Form::text('name',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="category name">Description</label>
                <div class="controls">
                    {{ Form::textarea('desc',null,array('autofocus'=> 'autofocus','rows' => '3','cols' => '4')) }}
                </div> <!-- /controls -->
            </div>

            @foreach($ingredients as $ingredient)
	            <label class="control-label" for="">{{ $ingredient->name }}</label>
	            <div class="control-group">
	                <div class="controls">
	                    <div class="input-prepend input-append">

	                        <input value="{{ $ingredient->id  }}" name="ing_id[]" type="checkbox" >
	                        <!-- <input placeholder="amount in grams" name="ing_amount[]" type="text" ng-show="{{ $ingredient->name }}">

	                        <span ng-show="{{ $ingredient->name }}" class="add-on">
	                        {{ $ingredient->units }}
	                        </span> -->
	                    </div>
	                </div>  <!-- /controls -->

	            </div>
            @endforeach
        </div>
        <div class="modal-footer">
            {{ Form::submit('Save',array('class' => 'btn btn-primary')) }}
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
        {{ Form::close() }}
    </div>


@stop
