<!DOCTYPE html >
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
    <link href="/css/fposs-custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/pace/flash-theme.css">
    <link rel="stylesheet" href="/fakeloader/fakeLoader.css">
    
     @yield('external-styles')
     <style type="text/css">
        .digits .well {
            text-align: center;
            cursor: pointer;
            font-weight: bold;
            font-size: 2em;
            }
            .result {
            text-align: right;
            font-weight: bold;
            font-size: 2em;
            }
     </style>

    {{-- <link href="/css/starlight-style.css" rel="stylesheet">--}}

</head>
<body>
<div class="fakeloader"></div>
<!-- /container -->

@include('layouts.nav')

@if(Auth::user()->role == '2' || Auth::user()->role == '3')
    @include('layouts.subnav')
@else
    @include('layouts.subnav-cashier')
@endif

<!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->
<div class="main">
    <div class="main-inner">

        <div id="main-content" class="container">
        <div class="pace"></div>
            <div class="msg-container"></div>
            @if(Session::has('flash_message'))

                <div class="alert  {{ Session::get('flash_type') }} ">
                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <strong>{{ Session::get('flash_message') }}</strong>

                </div>

            @endif
            {{-- sections --}}
            @yield('content')

        <!-- @include('layouts.footer') -->
        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->

</div>
<!-- /main -->
    <!-- Modal -->
   
        <div id="modal-calc" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">
            <div id="calculator">
                <div class="row">
                <div class="span7">
                <div class="well result"> 0 </div>
                </div>
                <div class="digits">
                <div class="span1">
                <div class="well digit">7</div>
                </div>
                <div class="span1">
                <div class="well digit">8</div>
                </div>
                <div class="span1">
                <div class="well digit">9</div>
                </div>
                <div class="span1">
                <div class="well digit">+</div>
                </div>
                <div class="span1">
                <div class="well digit">4</div>
                </div>
                <div class="span1">
                <div class="well digit">5</div>
                </div>
                <div class="span1">
                <div class="well digit">6</div>
                </div>
                <div class="span1">
                <div class="well digit">-</div>
                </div>
                <div class="span1">
                <div class="well digit">1</div>
                </div>
                <div class="span1">
                <div class="well digit">2</div>
                </div>
                <div class="span1">
                <div class="well digit">3</div>
                </div>
                <div class="span1">
                <div class="well digit">&times;</div>
                </div>
                <div class="span1">
                <div class="well digit">0</div>
                </div>
                <div class="span1">
                <div class="well digit">.</div>
                </div>
                <div class="span1">
                <div class="well digit">=</div>
                </div>
                <div class="span1">
                <div class="well digit">&divide;</div>
                </div>
                </div>
                </div> 
            </div>
                   
            </div>
        </div>
    <!-- /modal -->
  




    
<script src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/calc.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/base.js"></script>
<script src="/fakeloader/fakeLoader.min.js"></script>

@if(Session::get('VC') == 'enabled')
    <script src='//vws.responsivevoice.com/v/e?key=GwyOGScn'></script>
@endif


<script type="text/javascript" src="/pace/pace.min.js"></script>



@yield('external-scripts')

<script type="text/javascript">

    //detect user's platform
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.
                    test(navigator.userAgent) ) {

                     $('.subnavbar').html('');
                     $('#main-content').html('<h3>You are using a mobile platform.This web application can only be run on laptop or desktop based computers.</h3>');

                }

	
     $(".fakeloader").fakeLoader({
                timeToHide:1000,
                bgColor:"#e74c3c",
                spinner:"spinner3"
            });

    

   
    //reload button 
    $('button#btnRefresh').click(function(){

        var uri  = window.location.href;
        window.location.href = uri;
    });


    $('div.alert').delay(5000).slideUp();

</script>

	
</body>
</html>
