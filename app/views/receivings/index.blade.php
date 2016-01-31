@extends('layouts.master')

@section('content')
    <span class="pull-right">
         <div class="btn-group">
             
             <a href="/transactions/shipments/create" data-toggle="modal"  class="btn btn-success"><i class="icon-plus"> New Shipment</i></a>
             <button type="button" class="btn btn-default"><i class="icon-refresh"></i> Refresh</button>
             <button type="button" class="btn btn-default"><i class="icon-trash"></i> Delete</button>
         </div>
    </span><br/>
    <br/>

    <div class="widget widget-table action-table">
        <div class="widget-header"> <i class="icon-th-list"></i>

            <h3>Shipments</h3>

        </div>
        <!-- /widget-header -->
        <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> Date </th>
                    <th> Item </th>
                    <th> Supplier </th>
                    <th> Qty </th>
                    <th class="td-actions">Actions </th>
                </tr>
                </thead>
                <tbody>
                @foreach($shipments as $shipment)
                    <tr>
                        <td> {{ $shipment->created_at }} </td>
                        <td>blank for now </td>
                        <td>blank for now </td>
                        <td>blank for now </td>
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
