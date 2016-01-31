<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/css/font-awesome.css" rel="stylesheet">
    <link href="/css/fposs-style.css" rel="stylesheet">
    <link href="/css/fposs-signin.css" rel="stylesheet">
    {{-- <link href="/css/starlight-style.css" rel="stylesheet">--}}

    <style type="text/css">

        .default {

            background: #000;
        }

        .success {

            background: green;
        }

        .error {

            background: red;
        }
    </style>
</head>
<body>
@include('layouts.nav')
<!-- BEGIN LOGIN SECTION -->
 
<div class="account-container">
    <div id="login-feedback"
        style="height:30px;padding:8px;line-height:2;color:#fff;font-size:15px;">
        Authenticating...
    </div>
   
    @if(Session::has('flash_message'))

        <div class="alert  {{ Session::get('flash_type') }} ">
            <button type="button" class="close" data-dismiss="alert">×</button>

            <strong>{{ Session::get('flash_message') }}</strong>

        </div>

    @endif

    <div  class="content clearfix">


        {{ Form::open(array('route' => 'login','id' => 'formLogin')) }}

       

        <div class="login-fields">

            <img style="margin-left:24%;" src="/img/logo.png">
           
            <hr/>
            Please enter your username and password.<br/><Br/>

            <div class="field">
                <label for="username">Username</label>
                
                {{ Form::text('fposs_username',null,array('class' => 'login username-field','placeholder' => 'Username','autofocus' => 'true')) }}
                {{--<input autofocus="" type="text" id="username" name="fposs_username" value="" placeholder="Username" class="login username-field">--}}
            </div> <!-- /field -->

            <div class="field">
                <label for="password">Password:</label>
                {{--{{ Form::text('fposs_password',null,array('class' => 'login password-field','placeholder' => 'Username')) }}--}}
                <input type="password" id="password" name="fposs_password" value="" placeholder="Password" class="login password-field">
            </div> <!-- /password -->

        </div> <!-- /login-fields -->

        <div class="login-actions">

            {{  Form::submit('Login',array('class' => 'button btn btn-large btn-success','id'=>'btnSubmit')) }}

        </div> <!-- .actions -->

        {{ Form::close() }}
    </div> <!-- /content -->
</div>
<script src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">

    
     $('div.alert').delay(5000).slideUp();

      <!-- //detect user's platform  -->

    $(document).ready(function(){

         if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.
                    test(navigator.userAgent) ) {

                     $('.content').html('<h3>You are using a mobile platform.This web application can only be run on laptop or desktop based platform.</h3>');

                    return false;
                }

         $('#login-feedback').hide();

         $('#formLogin').submit(function(e){

            e.preventDefault();
            $('#login-feedback').removeClass('error');
            $('#login-feedback').html('Authenticating...');
            $('#login-feedback').addClass('default');
            $('#login-feedback').show();

            var reqUrl = $(this).attr('action');
            var postData = $(this).serialize();

           $.ajax({

            url : reqUrl,
            type: 'POST',
            data : postData,

            success : function(data){

                console.log(data);
                if(data.login == 'false'){

                    $('#login-feedback').removeClass('default');
                    $('#login-feedback').addClass('error');
                    $('#login-feedback').html('Invalid username or password.');
                     $('#login-feedback').delay(3000).slideUp();
                     $('input[type="password"]').val('');

                }else if(data.login == 'true'){

                    $('#login-feedback').removeClass('default');
                    $('#login-feedback').addClass('success');
                    $('#login-feedback').html('Login successful. Redirecting...');
                    setTimeout("window.location.href='/'",1000);
                }


                
                
            },
            error : function(e){

                console.log('Error' + e.status +': ' + e.statusText);
            }

    

        }); /* end ajax request */

            // alert("Asasd");

            
     });

    });
   

</script>
<script src="/js/bootstrap.js"></script>
<script src="/js/base.js"></script>
</body>
