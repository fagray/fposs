@extends('layouts.master')

@section('content')
    <span class="pull-right">
         <div class="btn-group">
             <a href="#modal-newCategory" data-toggle="modal"  class="btn btn-success"><i class="icon-plus"> New</i></a>
             <button type="button" class="btn btn-default"><i class="icon-refresh"></i> Refresh</button>
             <button type="button" class="btn btn-default"><i class="icon-trash"></i> Delete</button>
         </div>
    </span><br/>
    <br/>

    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-th-list"></i>

            <h3>Item Categories</h3>

        </div>
        <!-- /widget-header -->
        <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Category Name </th>
                    <th> Created at</th>
                    <th> No. of products </th>
                    <th class="td-actions">Actions </th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td> {{ $category->cat_name }} </td>
                        <td>{{ $category->created_at }} </td>
                        <td> {{ Category::find($category->id)->items()->count() }} </td>
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
    <div id="modal-newCategory" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">New Category</h3>
        </div>
        {{ Form::open(array('route' => 'categories.store','class' => 'form-horizontal')) }}
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="category name">Category Name</label>
                <div class="controls">
                    {{ Form::text('cat_name',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
        </div>
        <div class="modal-footer">
            {{ Form::submit('Save',array('class' => 'btn btn-primary')) }}
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
        {{ Form::close() }}
    </div>


@stop
