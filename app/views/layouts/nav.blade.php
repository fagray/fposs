<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"><a class="brand" href="index.php">Flibby's POS  </a>

            @if(Auth::check())
                <div class="nav-collapse">
                    <ul class="nav pull-right">
                        <li><a href="#modal-calc" data-toggle="modal"><i clas="icon-calc"></i>Calculator</a></li>
                        <li><a target="_blank" href="/items/conversion-units" id="conv">Conversion Units</a></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user"></i> <strong>Howdy,</strong> {{ Auth::user()->username }} <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                 <li><a href="/system/users">System Users</a></li>
                                <li><a href="javascript:;">Change Password</a></li>
                                <li> {{ link_to_route('logout','Logout') }}</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                @endif
                        <!--/.nav-collapse -->
        </div>
        <!-- /container -->
    </div>
    <!-- /navbar-inner -->
    <div class="navbar-bottom"></div>
</div>
<!-- /navbar -->


 @section('external-scripts')
    <script type="text/javascript">
        $('a#conv').click(function(){
            // alert("Asdasd");
            $('#modal-conversion').modal({
                backdrop: false
            });
        });
        
    </script>
 @stop   

