@extends('layouts.master')

@section('content')
    <span class="pull-right">
         <div class="btn-group">
             <a href="/suppliers/create" data-toggle="modal"  class="btn btn-success"><i class="icon-plus"> New Shipment</i></a>
             <button type="button" class="btn btn-default"><i class="icon-refresh"></i> Refresh</button>
             <button type="button" class="btn btn-default"><i class="icon-trash"></i> Delete</button>
         </div>
    </span><br/>
    <br/>

    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-th-list"></i>

            <h3>Suppliers/Vendors</h3>

        </div>
        <!-- /widget-header -->
        <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> Company/Venture Name </th>
                    <th> Resource Person </th>
                    <th> Contact No. </th>
                    <th> Address </th>
                    <th class="td-actions">Actions </th>
                </tr>
                </thead>
                <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td> {{ $supplier->name }} </td>
                        <td>{{ $supplier->resource_person }} </td>
                        <td>{{ $supplier->contact_num }} </td>
                        <td>{{ $supplier->address }} </td>
                        <td class="td-actions">
                            <a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-pencil"> </i></a>
                            <a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>
                            <a href="javascript:;">Track item</a></td>

                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
        <!-- /widget-content -->
    </div>



@stop
