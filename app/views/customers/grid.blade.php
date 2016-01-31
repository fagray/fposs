@extends('layouts.master')


@section('external-styles')
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
    <link href="/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
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
    <h2 class="head-1 ">Customers Details</h2><hr/>

    <div class="row ">
        @foreach($customers as $customer )
            <div class="span4" style="border: 1px solid #ccc;min-height: 300px;border-top: 5px solid #ccc;">
                    <p>{{ $customer->fname }} </p>
            </div>
        @endforeach

    </div>
  

    


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

            //turn to inline mode
            $.fn.editable.defaults.mode = 'inline';
            $('.fname').editable();

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
                $('form#modal-edit input[name="fname"]').val(fname);
                $('form#modal-edit input[name="lname"]').val(lname);
                $('form#modal-edit input[name="contact_num"]').val(contact);
                $('form#modal-edit input[name="address"]').val(address);

                //show the modal 
                // modalEdit.show();

            });

        });
    </script>
@stop    

