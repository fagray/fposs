<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fposs_sessions';
	protected  $fillable = array('username','password','role');

	public static  $rules =  [ 'fposs_username' => 'required','fposs_password' => 'required' ];



	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('fposs_password', 'remember_token');

	/**
	 * The guarded attributes
	 *
	 * @var array
	 */
	
	/**
	 * Validate the username before adding it to the table
	 */
	
	public function validateUsername($username){

		$username_count = static::where('username','=',$username)->count();

		if($username_count > 0 ){

			return true;
		}

		return false;
	}

	/**
	 * Remove user from the system
	 */
	
	public function removeUser($user_id){

		$action = DB::table($this->table)->where('id','=',$user_id)->delete();
		return Response::json(['response' => 200,'msg' => 'User has been removed.']);
	}


}

