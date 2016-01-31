@extends('layouts.master')

@section('external-styles')
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
@stop

@section('content')
    <span class="pull-right">
         <div class="btn-group">
             <a href="/suppliers/create" data-toggle="modal"  class="btn btn-success"><i class="icon-plus"> </i>New Vendor</a>
             <button type="button" class="btn btn-default"><i class="icon-refresh"></i> Refresh</button>
            
         </div>
    </span>
  
     <h2 class="head-1">Store Suppliers</h2><hr/>
    
    <div class="widget widget-table">
       
     
     
            <table id="suppliers-data" class="table table-striped table-bordered">
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
                            <div class="btn-group">
                              <button data-toggle="dropdown" class="btn dropdown-toggle">Actions <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                
                               <li>
                                    <a href="/suppliers/{{$supplier->id}}">
                                        <i class="icon icon-search"></i>  
                                        View
                                    </a>
                                </li>

                                <li>
                                    <a href="/suppliers/{{$supplier->id}}/edit">
                                        <i class="icon icon-pencil"></i>  
                                        Edit Data
                                    </a>
                                </li>

                                <li>
                                    <a href="/suppliers/{{$supplier->id}}/remove">
                                        <i class="icon icon-remove"></i>  
                                            Remove Supplier
                                    </a>
                                </li>
                               
                               <!--  <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li> -->
                              </ul>
                            </div>
                        </td>

                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
        <!-- /widget-content -->
    </div>



@stop

@section('external-scripts')
    <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#suppliers-data').DataTable({
               dom: 'T<"clear">lfrtip'
             });

        });
    </script>
@stop    

