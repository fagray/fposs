<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Page not found | FPOSS </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/css/font-awesome.css" rel="stylesheet">
    <link href="/css/fposs-style.css" rel="stylesheet">
    <link href="/css/fposs-signin.css" rel="stylesheet">
    {{-- <link href="/css/starlight-style.css" rel="stylesheet">--}}


</head>
<body>
@include('layouts.nav')
<!-- BEGIN ERROR SECTION -->
<div class="container">

    <div class="row">

        <div class="span12">

            <div class="error-container">
                <h1>500</h1>

                <h2>Whoa ! Unauthorized Access</h2>

                <div class="error-details">

                    Sorry, but this section is restricted. Please go to settings
                    and supply your password to access this section.

                </div> <!-- /error-details -->

                <div class="error-actions">
                    <a href="/settings" class="btn btn-large btn-primary">
                       
                       Go to Settings
                        <i class="icon-chevron-right"></i>
                        &nbsp;
                    </a>



                </div> <!-- /error-actions -->

            </div> <!-- /error-container -->

        </div> <!-- /span12 -->

    </div> <!-- /row -->

</div> <!-- /container -->


</body>

</html>
