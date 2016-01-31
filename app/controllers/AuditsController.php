<?php

class AuditsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /audits
	 *
	 * @return Response
	 */
	public function index()
	{
		//check the user privliges
		if(Session::has('log_access')){

			//show the view
			$sys_logs = Audit::all();
			// $trans_logs = Audit::where('module','=','Sales')->get();
			$trans_logs = TransactionLog::all();
			return View::make('system.logs.index')
			->with('title','System Logs')
			->with('sys_logs',$sys_logs)
			->with('trans_logs',$trans_logs);
		}

		return View::make('system.errors.unauthorized')
				->with('title','Unauthorized Access');


		
	}

	


}