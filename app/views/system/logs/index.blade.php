@extends('layouts.master')

@section('external-styles')

    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">

@stop


@section('content')

	<!-- Nav tabs -->
	<ul class="nav nav-tabs">

		<li  class="active"><a href="#system-logs" data-toggle="tab">System Logs</a></li>
		<li  ><a href="#trans-logs" data-toggle="tab"> Transaction Logs</a></li>

	</ul>


	<div class="tab-content">


		<div class="tab-pane active" id="system-logs">

			<h2 class="head-2">System Logs</h2><hr/>

			<table id="sys-data" class="table">
				<thead>
					<tr>
						<th>Timestamp</th>
						<th>Module</th>
						<th>Action</th>
						<th>User</th>
						<th>IP</th>
					</tr>
				</thead>	
					<tbody>
						@foreach($sys_logs as $log)
							<tr>
								<td>{{ $log->created_at }}</td>
								<td>{{ $log->module }}</td>
								<td>{{ $log->action }}</td>
								<td>{{ $log->user }}</td>
								<td>{{ $log->ip }}</td>
							</tr>
						@endforeach
					</tbody>
			</table>


		</div><!-- /tab-pane translogs -->


		<div class="tab-pane" id="trans-logs">

		<h2 class="head-2">Transaction Logs</h2><hr/>

			<table id="logs-data" class="table">
				<thead>
					<tr>
						<th>Timestamp</th>
						
						<th>Action</th>
						
						
						<th>User</th>
						
						
					</tr>
				</thead>	
					<tbody>
						@foreach($trans_logs as $log)
							<tr>
								<td>{{ $log->created_at }}</td>
								
								<td>{{ $log->action }}</td>
								
								<td>{{ $log->cashier }}</td>
								
						@endforeach
					</tbody>
			</table>

		</div><!-- /tab-pane translogs -->
	</div>	<!-- /tab-content -->


	


@stop

@section('external-scripts')
	<!-- // <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script> -->
	 <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    
	 <!-- // <script src="https://code.responsivevoice.org/responsivevoice.js"></script> -->
	
  
   	
    <script type="text/javascript">

    	

    	 $(document).ready(function(){

    	 	 $('#logs-data').DataTable();
    	 	 $('#sys-data').DataTable();
    	 	

    	 	// responsiveVoice.speak('Hello World');
    	 	// responsiveVoice.speak("Welcome to System logs");
    	 });

    	

    	
    	 


             

    </script>
@stop



