<?php
use Carbon\Carbon;

class Audit extends \Eloquent {

	protected $fillable = ['module','action','ip','user','created_at','updated_at'];

	protected $table = "fposs_audits";

	/**
	 * @param  $string
	 * @param  [$string]
	 * @return @response
	 */	
	public static function store($module,$action){


		$audit = new Self();
		$audit->module 	= 	$module;
		$audit->action 	= 	$action;
		$audit->ip 		= 	Request::getClientIp();
		$audit->user 	= 	self::getUser();
		$audit->created_at = Carbon::now();
		$audit->updated_at = Carbon::now();
		$audit->save();

	}

	/**
	 * @return $user
	 */
	private static function getUser(){

		return Auth::check() ? Auth::user()->username : 'Guest';
	}
}