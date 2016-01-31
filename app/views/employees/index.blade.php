@extends('layouts.master')

@section('external-styles')
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
@stop


@section('content')

<span class="pull-right">
         <div class="btn-group">
             <a href="#modal-newEmployee" data-toggle="modal"  class="btn btn-success"><i class="icon-plus"> New</i></a>
                <button id="btnRefresh" type="button" class="btn btn-default">
                <i class="icon-refresh"></i> Refresh
             </button>
             
         </div>
    </span>

	<h2 class="head-1">Store Employees</h2><hr/>
    

    <div class="widget widget-table action-table">
        
       
        <table id="employees-data" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th> Name </th>
                <th> Email</th>
                <th> Contact # </th>
                <th> Role </th>
                <th class="td-actions">Actions </th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td> {{ $employee->fname }} {{ ' ' }} {{ $employee->lname }} </td>
                    <td>{{ $employee->email }} </td>
                    <td> {{ $employee->contact_no }} </td>
                    @if($employee->role == '1')

                    	<td> Cashier </td>
                    @elseif($employee->role == '2')

                    	<td> Administrator </td>
                    @else	
                    	<td> None </td>
                    @endif

                    
                    <td class="td-actions">
                        <div class="btn-group">
                          <button data-toggle="dropdown" class="btn dropdown-toggle">Actions <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            
                            @if($employee->role == '2')

                                <li>
                                    <a data-id="{{ $employee->id }}" id="priv_cashier" href="#">
                                        <i class="icon icon-plus"></i>
                                        Make as cashier
                                    </a>
                                </li>

                            @elseif($employee->role == '1')

                                <li>
                                    <a data-id="{{ $employee->id }}" id="priv_admin" href="#">
                                        <i class="icon icon-plus"></i>
                                        Make as admin
                                    </a>
                                </li>


                            @else
                                <li>
                                    <a data-id="{{ $employee->id }}" id="priv_cashier" href="#">
                                        <i class="icon icon-plus"></i>
                                        Make as cashier
                                    </a>
                                </li>
                                <li>
                                    <a data-id="{{ $employee->id }}" id="priv_admin" href="#">
                                        <i class="icon icon-plus"></i>
                                        Make as admin
                                    </a>
                                </li>

                            @endif

                            
                            

                           
                           
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

    <!-- Modal -->
    <div id="modal-newEmployee" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">New Employee</h3>
        </div>
        {{ Form::open(array('route' => 'employees.store','class' => 'form-horizontal')) }}
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="category name">First Name</label>
                <div class="controls">
                    {{ Form::text('fname',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="category name">Last Name</label>
                <div class="controls">
                    {{ Form::text('lname',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="category name">Email</label>
                <div class="controls">
                    {{ Form::text('email',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="category name">Mobile #</label>
                <div class="controls">
                    {{ Form::text('contact_no',null,array('autofocus'=> 'autofocus')) }}
                </div> <!-- /controls -->
            </div>
            <div class="control-group">
                <label class="control-label" for="category name">Address</label>
                <div class="controls">
                    {{ Form::text('address',null,array('autofocus'=> 'autofocus')) }}
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

@section('external-scripts')
    <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

             $('#employees-data').DataTable({
               dom: 'T<"clear">lfrtip'
            });

        $('a#priv_admin').click(function(e){
            var emp_id = $(this).attr('data-id');
            alert(emp_id);
            e.preventDefault();

            $.getJSON('/employees/'+emp_id+'/priviliges/elevate/'+2,function(data){

                console.log(data);
                checkResponse(data);
            });

        });

        $('a#priv_cashier').click(function(e){
            var emp_id = $(this).attr('data-id');
            alert(emp_id);
            e.preventDefault();

            $.getJSON('/employees/'+emp_id+'/priviliges/elevate/'+1,function(data){

                console.log(data);
                checkResponse(data);

            });

        });

        function checkResponse(data){

            if(data.response == '300'){

                    console.log('Employee exist.');
                    return false;
                }
            window.location.href='/employees';
            return true;

        }
    });
    </script>
@stop
