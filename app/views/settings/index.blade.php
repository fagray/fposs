@extends('layouts.master')

@section('external-styles')
	
	<link rel="stylesheet" type="text/css" 
		href="/simple-modal/source/assets/css/simplemodal.css">
	

@stop
@section('content')
	<h2>Settings </h2><hr/>

	<div class="row">
		<div class="offset2 span8">
	        <div class="card">

	        	<div class="card-block">
	            	<h6 style="font-size:13px;" class="card-subtitle text-muted">
	                	STORE
	                </h6><hr/>
	               
	                @if(Session::get('STORE') == 'CLOSE')
	                
	                	<button data-action="store-setup"  data-option="OPEN"  id="btnStoreSetup" class="btn btn-danger passwordModal"><i class="icon icon-lock"></i> Open Store </button>
	                	 <p class="text-muted">
	                	Open the store. It will enabled all the transactions on the system.

	                	
	                @else

	                	<button data-action="store-setup" data-option="CLOSE" id="btnStoreSetup"  class="btn btn-danger passwordModal"><i class="icon icon-lock"></i> Close Store </button>
		                 <p class="text-muted">
		                	Close the store. It will disabled the register transactions and production module.
		               	 </p>
	                	
	                </p>

	                @endif
	            
	            </div><!-- /card-block -->
	            <span class="pull-right">
	            	<button id="new-unit-type" style="margin-right:20px;" class="btn">
	            		<i class="icon icon-plus"> </i> Add new unit type
	            	</button>
	            </span>
	            <div class="card-block">

	                <h6 style="font-size:13px;" class="card-subtitle text-muted">
	                	Unit types
	                </h6><hr/>
	              
	                		Select Item : 
	                		

		                		{{ Form::select('ing_name',['Choose Item',$ingredients],'',['id'=>'selectItem'])}}
		                		{{ Form::button('Search',['class' => 'btn btn-default','id' => 'btnSearch']) }}
		       
	            </div>
	            <div id="loading"></div>
	            <div class="card-block">	
	            	{{ Form::open(['route' => 'settings.updateUnits']) }}
	            	{{ Form::hidden('ing_id')}}
	            		<span id="ing-details">
	            		
	            		</span>
	            		<span id="new_units_container"></span>
	            	{{ Form::close() }}
	            </div>

	            
	             <div class="card-block">
	            	<h6 style="font-size:13px;" class="card-subtitle text-muted">
	                	SYSTEM LOGS
	                </h6><hr/>
	                <p class="text-muted">
	                	View all the system activities and transaction logs.
	                </p>
	                <a href="#" data-action="system-logs" class="btn passwordModal"><i class="icon icon-lock"></i> Open System Logs </a>
	            
	            </div><!-- /card-block -->

	              <div class="card-block">
	            	<h6 style="font-size:13px;" class="card-subtitle text-muted">
	                	VOICE RECOGNITION
	                </h6><hr/>
	            	
	            	
	                <p class="text-muted">

	                	Speaking is secretary on the system is 
	                	 @if(Session::get('VC') == 'enabled')
	                	 	<span style="color:green;">enabled.</span>
	            			<button data-option='disable' class="btnVC" class="btn">Disable</button> 
	            			
	            		@else
	            			<span style="color:red;">disabled.</span>
	            			<button data-option='enable' class="btnVC" class="btn">Enable</button> 
	            			
	            		@endif
	                </p>
	              
	            
	            </div><!-- /card-block -->
<!-- 
	            <div class="card-block">
	                <h6 style="font-size:13px;" class="card-subtitle text-muted">
	                	Unit types
	                </h6><hr/>
	                {{ Form::open(['class' => 'form-horizontal'])}}
	                	{{ Form::text('inv_unit','',['class' => 'form-control'])}}
	                {{ Form::close() }}
	            </div> -->

			</div><!-- /card -->   
		</div><!--  /span8 -->
	</div><!--  /row -->

	<!-- Modal -->
    <div id="modal-setup" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button id="modal-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel"></h3>
        </div>
         {{ Form::open(array('route' => 'settings.storeProdUnits','class' => 'form-horizontal form-setup')) }}
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label" for="stock name">Unit types</label>
                <button class="btnAddUnit btn btn-default pull-right">Add new</button><hr/>
                <div  class="controls unit-container">
                    1  &nbsp;&nbsp;&nbsp;{{ Form::select('unit_id[]',$units,'',['style' => 'width:80px;']) }}  &nbsp;&nbsp;&nbsp; =  &nbsp;&nbsp;&nbsp;
                    	 {{ Form::number('prod_units[]',null,array('class' => 'span1','id' => 'item_name')) }} grams
                    	 {{ Form::hidden('ing_id') }}
                   
                </div> <!-- /controls -->
                <div class="additional-units-container"></div>

            </div>
          
          
            <hr/>
           
          
        </div>
        <div class="modal-footer">

            
            <input type="hidden" name="type" value="2"> 
            {{ Form::submit('Save Changes',array('class' => 'btn btn-primary')) }}
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
        {{ Form::close() }}

        
    </div>
@stop

@section('external-scripts')
	<script type="text/javascript" 
		src="/simple-modal/source/simple-modal.js"></script>
	

	<script type="text/javascript">
		$(document).ready(function(){

			//VOICE RECOGNITION button
			$('.btnVC').click(function(){

				var option = $(this).attr('data-option');

				$.getJSON('/settings/vc/action/'+option,function(data){

					window.location.href='/settings';

				});

			});

			//modal for adding new unit type
			
			$('button#new-unit-type').click(function(){
				
				  $.fn.SimpleModal({
		               
		                title:    "<i class='icon icon-plus'></i> New Unit Type",
			            contents: "Unit name : <input name='name' id='txtPass' autofocus='autofocus' type='text'/><Br/>Symbol &nbsp;&nbsp;&nbsp;: <input name='symbol' id='txtPass' type='text'/><hr/><button id='btnCreateUnit' type='button' class='btn btn-primary'>Add new unit</button><span id='feedback'></span>"
			      }).showModal();

			      $('#btnCreateUnit').click(function(){

			     	var new_unit_name =  $('input[name="name"]').val();
			     	var new_unit_symbol =  $('input[name="symbol"]').val();

			     	if(new_unit_name  != '' && new_unit_symbol  != ''){

			     		$(this).text('Adding new unit...');
			     		$(this).attr('disabled','disabled');

			     		saveUnit(new_unit_name,new_unit_symbol);

			     		return false;

			     	}

			     	alert('Please filled in all the fields!');
			     	return false;
			     	

			      });

			});

			var action = '';

			

			//disable the save button on default
			var btnSave = '';

			var inputPass = '';

			$(".passwordModal").click(function() {
		
				action = $(this).attr('data-action');

			      $.fn.SimpleModal({
		               
		                title:    "<i class='icon icon-lock'></i> Super Admin Password Required",
			            contents: "Please enter the super admin's password : <input id='txtPass' autofocus='autofocus' type='password'/><hr/><button id='btnProceed' type='button' class='btn btn-primary'>Proceed</button><span id='feedback'></span>"
			      }).showModal();



			      $('#btnProceed').click(function(e){
			      		e.preventDefault();

			      		inputPass = $('#txtPass').val();
			      		$(this).attr('disabled','disabled');
			      		$(this).text('Checking password...');

			      		if(action == 'store-setup' ){

			      			return checkPassword(inputPass,'/settings/');
			      		}

			      		return checkPassword(inputPass,'/system/logs');
		      		
			      	
			      });

			});


		

			//clone components
			// var cloneComponents = $('.unit-container').first().clone();

			$('button.btnAddUnit').click(function(e){
				var cloneComponents = $('.unit-container').first().clone();
				e.preventDefault();
				$('.additional-units-container').append(cloneComponents);
			});

			//modal backdrop = disabled

			$('#btnSearch').on('click',function(){

				clearContainer();
				

				var item_text  = $("#selectItem option:selected").text();
				var item_id = $("#selectItem").val();
				
				//append the ingredient id on the hidden field
				$('input[name="ing_id"]').val(item_id);

				if(item_text != 'Choose Item'){

					$('#loading').html('Searching...');
					$(this).text('Searching...');
					$(this).attr('disabled','disabled')

					$.ajax({

	                    url : '/items/units/find/'+item_id,
	                    type: 'GET',
	                    
	                    success : function(data){

	                    	$('#loading').html('');
	                        // $('.loading').html('');
	                        console.log(data);
	                         $('#btnSearch').text('Search');
							 $('#btnSearch').removeAttr('disabled');

	                        if(data.response == 300){

	                       
	                         	throwNotFoundException();

	                        }else {

	                        	//get the data and append it to the dom
	                         console.log(data);
	                          getDataAndAppend(data);
	                         

	                        }

	                   
	                    },
	                    error : function(e){

	                        console.log('Error' + e.status +': ' + e.statusText);
	                    }

                	}); /* end ajax request */

                	return false;
				}

				alert('Please select an item');



			});

		function getDataAndAppend(data){

			$('span#ing-details').append('<hr/><p>Item Name : <strong>'+data[0].name+'<p>Production Units<button title="Add New Unit" id="btnNewUnit" class="btn pull-right"><i class="icon icon-plus"></i></button></hr>');

			$.each(data,function(key,value){

				$('span#ing-details').append('<span class="pull-right"><a data-ingredient="'+value.ingredient_id+'" data-unit="'+ value.id + '" class="btn btnRemoveUnit">x</a></span><p>1 ' + value.symbol + ' = <input style="width:80px;" required="required" class="p_units" name="prod_units[]" type="number" value="'+ value.in_grams + '"> g </p><input type="hidden" name="unit_id[]" value="'+value.id+'"><hr/>');



				
			});

			$('.btnRemoveUnit').click(function(){

					//remove the unit from the production units list
					if(confirm('Are you sure you want to remove the unit from the ingredient"s unit list ? ')){

						var unit_id = $(this).attr('data-unit');
						var ing_id = $(this).attr('data-ingredient');
						//okay remove the unit
						$.getJSON('/items/ingredients/'+ing_id+'/units/'+unit_id+'/remove/',

							function(data){

							console.log(data);
						});
					}

			});

			$('input.p_units').on('change',function(){

				btnSave.removeAttr('disabled');

			});

			

			$('#btnNewUnit').click(function(e){
				e.preventDefault();

				var cloneTextBox  = $('.unit-container').first().clone();
				
				$('span#ing-details').append(cloneTextBox);
				$('span#ing-details').append('<hr/>');
				btnSave.removeAttr('disabled');

			});

			$('span#new_units_container').append('<input class="btn btn-primary" type="submit" id="btnsaveChanges" value="Save Changes">');
			btnSave = $('#btnsaveChanges');
			btnSave.attr('disabled','disabled');

		}//end function append

		function clearContainer(){

			$('span#ing-details').html('');
		}

		function throwNotFoundException(){

			$('span#ing-details').html('<strong style="color:red;font-size:15px;">Ingredient units has not been setup.</strong><button class="btn btn-default" id="btnSetup">Set it up now </button>');

			$('button#btnSetup').click(function(e){

				e.preventDefault();

				//get the ingredient name
				var ing_name =  $("#selectItem option:selected").text();
				var ing_id =  $("#selectItem").val();
				$('.form-setup input[name="ing_id"]').val(ing_id);

				$('#myModalLabel').html('Setup production units for ' + ing_name);

				 $('#modal-setup').modal({
               		 backdrop: false
             	 });

			});
		}

		$('form.form-setup').submit(function(e){

			e.preventDefault();

			var postData = $(this).serialize();

			//show loading bar

			$.ajax({

                    url : '/items/units/store/',
                    type: 'GET',
                    data : postData,
                    
                    success : function(data){

                        // $('.loading').html('');
                        console.log(data);

                        if(data.response == 200){

                          alert('Units has been saved.')

                        }else if(data.response == 300){

                        	$('.msg-container').html('<div class="alert alert-danger">Unit is already existed on this ingredient.</div>');
                        	return false;

                        }

                        //append the data to the DOM
                        // appendToContainer(data);
                        // setTimeout(appendToContainer(data),"function(){ $('.loading').html(''); };",5500);
                        
                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }

                }); /* end ajax request */

			return false;

		});


		function checkPassword(password,redirectionLink){

                    $.ajax({

                    url : '/auth/password/check',
                    type: 'GET',
                    data : { admin_password : password } ,

                    success : function(data){

                        // $('.loading').html('');
                        console.log(data);

                        if(data.response == 300){
							console.log("error");
					    	$('#btnProceed').removeAttr('disabled');
					    	$('#btnProceed').text('Proceed');
					    	$('span#feedback').html('<span style="color:red">Invalid password!</span>');
					    	$('#txtPass').val('');
					    	$('#txtPass').attr('required','required');
					    	$('#txtPass').focus();

                        }else if(data.response == 200){

                        	console.log("success");
                        	// window.location.href ='/system/logs';
                        	
                        	// alert(action);

                        	if(action == 'store-setup'){

                        		var option = $('#btnStoreSetup').attr('data-option');
                        		// alert(option);

                        		$.getJSON('/settings/store/setup/'+option,function(data){

									console.log(data);
									redirectTo(redirectionLink);
						
								});

								return false;
								
                        	}else{

                        		//go to system logs
                        		return redirectTo(redirectionLink);
                        	}

                        	
                          
                        }

                     
                        
                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }

            

                }); /* end ajax request */

                   
                }

	    function redirectTo(link){

	    	return window.location.href = link;

	    }

	    function saveUnit(name,symbol){

	    		$.ajax({

	                    url : '/settings/units/new/',
	                    type: 'GET',
	                    data : { name : name, symbol : symbol },
	                    
	                    success : function(data){

	                  		
	                        console.log(data);
	                        alert('Unit has been successfully added !');
	                        window.location.href='/settings';
	                         // $('#btn').text('Search');
							 // $('#btnSearch').removeAttr('disabled');


	                   
	                    },
	                    error : function(e){

	                        console.log('Error' + e.status +': ' + e.statusText);
	                    }

                	}); /* end ajax request */
	    		}

	  

		});

	</script>
@stop

