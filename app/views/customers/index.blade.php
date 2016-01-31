@extends('layouts.master')


@section('external-styles')
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
  
@stop


@section('content')

    <span class="pull-right">
    
            <div class="btn-group">

                 <a href="#modal-newCustomer"  data-toggle="modal"  class="btn btn-success">
                    <i  class="icon-plus"></i> New Customer
                 </a>
                
                <button id="btnRefresh" type="button" class="btn btn-default">
                    <i class="icon-refresh"></i> Refresh
                </button>

            </div>
    </span>
    <h2 class="head-1 ">Customers Module</h2><hr/>
  

    <div class="widget widget-table">
       
        <!-- /widget-header -->
       
            <table id="customers-data" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name </th>
                   
                    <th>Contact no. </th>
                    <th class="td-actions">Actions </th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td> 
                           {{ $customer->fname. ' '. $customer->lname }} 
                            </a>
                           
                        </td>
                        
                        <td> {{ $customer->contact_num }} </td>
                        <td class="td-actions">
                            <div class="btn-group">
                              <button data-toggle="dropdown" class="btn dropdown-toggle">Actions <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                
                              

                                <li>

                                    <a
                                    href="/customers/{{$customer->id}}/profile/">
                                        <i class="icon icon-search"></i>  
                                        View Profile
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

    @include('customers.modal-new')
    @include('customers.modal-edit')


@stop

@section('external-scripts')
    <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script src="/bootstrap-editable/js/bootstrap-editable.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#customers-data').DataTable({
               dom: 'T<"clear">lfrtip'
             });

         

            var modalEdit = $('#modal-editCustomer');


            modalEdit.hide();

            $('.editcustomer').on('click',function(e){

                var cust_id  = $(this).attr('data-custid');
                // alert(cust_id);
                e.preventDefault();



                $.ajax({

                    url : '/customers/'+cust_id+'/find',
                    type: 'GET',

                    success : function(data){
                        modalEdit.show();

                        // $('.loading').html('');
                        console.log(data);
                        //append the data to the DOM
                        // appendToContainer(data);
                        // setTimeout(appendToContainer(data),"function(){ $('.loading').html(''); };",5500);
                        
                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }

            

                }); /* end ajax request */


                //append the values to the edit modal
                // $('form#modal-edit input[name="fname"]').val(fname);
                // $('form#modal-edit input[name="lname"]').val(lname);
                // $('form#modal-edit input[name="contact_num"]').val(contact);
                // $('form#modal-edit input[name="address"]').val(address);

                //show the modal 
                modalEdit.show();

            });

        });
    </script>
@stop    

