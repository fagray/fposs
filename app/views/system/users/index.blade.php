@extends('layouts.master')

@section('content')
	
	<h2 class="head-2">System Users </h2></hr>

	<table class="table">
		<thead>
			<th>Username</th>
		
			<th>Role</th>
			<th>Actions</th>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>
						@if($user->username == Auth::user()->username)
							{{ $user->username }} (<i>Logged in as you</i>)
						@else
							{{ $user->username }}
						@endif

					</td>
					
					<td>
						@if( $user->role  == '2')

							Administrator

						@elseif ( $user->role == '3')

							SuperAdmin

						@endif
					</td>
					<td>
						<a data-username="{{$user->username}}" data-role="{{Auth::user()->role }}" class="linkChangePass" href="#">Change Password  </a>
						@if($user->username == Auth::user()->username)
							
						@else
							<a data-uid="{{ $user->id }}" class="linkRemove" href="#">| Remove User </a>
						@endif
						
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

		<h3 class="head-2">
			<i class="icon icon-plus"></i> Add a new user 
		</h3><hr/>

		<div class="card span10">
			<div class="card-block">
			{{ Form::open(['route' => 'users.add','id' => 'formNewUser']) }}
				<p class="card-text muted">User Details</p>
				{{ Form::submit('Add User',['class' => 'btn btn-primary btnAdd']) }}
				<hr/> 
				<div class="error-msg"></div>
				
				<span class="pull-right">

					{{ Form::label('Role ') }}
					{{ Form::select('role',['1' => 'Cashier','2' => 'Administrator']) }}
				</span>
				
				{{ Form::label('Username ') }}
				{{ Form::text('username','',['class' => 'span3','required']) }}
				{{ Form::label('Password ') }}
				{{ Form::password('pass1',['class' => 'span3','required']) }}
				{{ Form::label('Confirm Password') }}
				{{ Form::password('pass2',['class' => 'span3','required']) }}
				<p class="card-text muted">To ensure that you are the superadmin, we need your password before adding a new user</p><hr/> 
				Super Administrator password : {{ Form::password('ad_pass') }}<span class="feedback"></span>
				
			{{ Form::close() }}
				
			</div>
		</div>

		<!-- Modal -->
    <div class="modal hide fade modal-changepass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button id="modal-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Change  Password</h3>
        </div>
        <div class="error-msg-modal"></div> 
         {{ Form::open(array('class' => 'form-horizontal form-changepass','autocomplete' => 'false')) }}
        <div align="center" class="modal-body">
           
            <div class="control-group">
                <label class="control-label" >Old Password</label>
                <div class="controls">
                    {{ Form::password('old_pass',null,array('required' => 'required','autofocus'=> 'autofocus','class' => 'span3')) }}
                     <span class="response"></span>
                </div> <!-- /controls -->
            </div>

            <div class="control-group">
                <label class="control-label" >New Password</label>
                <div class="controls">
                    {{ Form::password('new_pass1',null,array('required' => 'required','class' => 'span3')) }}
                     
                </div> <!-- /controls -->
            </div>

            <div class="control-group">
                <label class="control-label" >Confirm your new Password</label>
                <div class="controls">
                    {{ Form::password('new_pass2',null,array('required' => 'required','class' => 'span3')) }}
                     
                </div> <!-- /controls -->
            </div>

           
            <hr/>
           
          
        </div>
        <div class="modal-footer">

            
          {{ Form::hidden('type',2) }}
            {{ Form::submit('Save',array('class' => 'btn btn-primary')) }}
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
        {{ Form::close() }}

        
    </div>
			
	
@stop

@section('external-scripts')
		
		<script type="text/javascript">
			$(document).ready(function(){

				var username;

				$('.linkChangePass').click(function(){

					username = $(this).attr('data-username');

					$('.modal-changepass').modal({

                 		 backdrop: false

              		});

				});

				// $('.old_pass').on('change',function(){

				// 	var val = $(this).val();

				// 	if(val.length == 3){

				// 		$.getJSON('/system/users/changepass'+val,function(data){

				// 			if(data.response == 300){

				// 				$('.response').html('<p style="color:red">Invalid password.</p>');
				// 				return false;

				// 			}else if(data.response == 200){

				// 				$(this).attr('disabled','disabled');

				// 			}
				// 		});
				// 	}

				// });

				$('.form-changepass').submit(function(e){

					e.preventDefault();

					var pass1 = $('input[name="new_pass1"]').val();
					var pass2 = $('input[name="new_pass2"]').val();
					var old_pass = $('input[name="old_pass"]').val();
					

					// $('.feedBackModalContainer').html('<div class="alert alert-danger">Old password is invalid.</div>');

					if(pass1 != pass2 ){

						$('.error-msg-modal').html('<div class="alert alert-danger">Password do not match!</div>');
						$('input[name="pass1"]').focus();
						$('input[name="pass1"]').val('');
						$('input[name="pass2"]').val('');

						return false;
					}

					$.ajax({

                    url : '/system/users/'+username+'/changepass/',
                    type: 'GET',
                    data : { old_password : old_pass, new_password : pass1 },
                 

                    success : function(data){

                      
                        console.log(data);

                        if(data.response == 300){

							console.log("error");
							$('.error-msg-modal').html('<div class="alert alert-danger">Old password is invalid.!</div>');
					    	//$('.btnAdd').removeAttr('disabled');
					    	

                        }else if(data.response == 200){

                        	// $('input[name="ad_pass"]').attr('disabled','disabled');
                        	$('.error-msg-modal').html('<div style="color:green;">Password has been changed.</div>');
                        
                        }

                        
                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }


                	}); /* end ajax request */
				});
				  

				//remove user action
				$('.linkRemove').click(function(e){

					var user_id = $(this).attr('data-uid');

					e.preventDefault();
					if(confirm('Are you sure you want to remove user from the system ? ')){

						$(this).parent().parent().fadeOut(800);
						$.getJSON('/system/users/'+user_id+'/remove',function(data){
							

							if(data.response == 200){
								console.log(data);
									
								return false;
							}
							

							return alert('Fail to remove user !');

						});
						
					}
					
				});

				$('.btnAdd').attr('disabled','disabled');

				$('#formNewUser').submit(function(){

					var pass1 = $('input[name="pass1"]').val();
					var pass2 = $('input[name="pass2"]').val();

					if(pass1 != pass2 ){

						$('.error-msg').html('<div class="alert alert-danger">Password do not match!</div>');
						$('input[name="pass1"]').focus();
						$('input[name="pass1"]').val('');
						$('input[name="pass2"]').val('');

						return false;
					}


				});

				$('input[name="ad_pass"]').on('change',function(){

					var password = $(this).val();
					// alert(password);
					if(password.length > 3 ){

						checkPassword(password);
					}

				});

				function checkPassword(password){

                    $.ajax({

                    url : '/auth/password/check',
                    type: 'GET',
                    data : { admin_password : password } ,

                    success : function(data){

                        // $('.loading').html('');
                        console.log(data);

                        if(data.response == 300){

							console.log("error");
							$('span.feedback').html('<div style="color:red;">Invalid password!</div>');
					    	//$('.btnAdd').removeAttr('disabled');
					    	

                        }else if(data.response == 200){

                        	$('input[name="ad_pass"]').attr('disabled','disabled');
                        	$('span.feedback').html('<div style="color:green;">Correct password!</div>');
                        	$('.btnAdd').removeAttr('disabled');
                        	console.log("success");
                        	// window.location.href ='/system/logs';
                        
                        }

                        
                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }


                }); /* end ajax request */

                   
                }

			});


		</script>
@stop	