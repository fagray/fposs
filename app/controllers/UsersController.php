<?php

class UsersController extends \BaseController {

	protected $employee,$user;

	function __construct(Employee $employee,User $user){

		$this->employee = $employee;
		$this->user = $user;
	}

	/**
	 *  Show System Users
	 */
	
	public function index(){

		$users = User::all();
		return View::make('system.users.index')
			->with('title','System Users')
			->with('users',$users);
	}
	

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Auth::check()){
		
			//user has already logged in
			return Redirect::to('/')
				->with('tite','Flibbys Point of Sale System.');

		}
		
		//show the login form
		return View::make('auth.login')
			->with('title','Please Login | FPOSS ');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		//grab the input and
		//validate the form
		//return Input::get('fposs_password');
		$validator = Validator::make(Input::all(),User::$rules);
		$attempt = Auth::attempt([

					'username' => 	Input::get('fposs_username'),
					'password' =>	Input::get('fposs_password')
		]);

		if($attempt){

			//store the logs
			Audit::store(
							'Authentication',
							'Logged in successfully.'
						);
						
			return array('ai' => 'show-in-index','login' => 'true');
		}
		
			//store the logs
			Audit::store(
							'Authentication',
							'Logged in unsuccessful.'
						);

			return array('login' => 'false');

		
	}

	/**
	 * Check the user password
	 * 
	 *
	 */
	public function checkPassword()
	{
		$password = Input::get('admin_password');

		if(!Auth::attempt(array('password' => $password))){

			return array('response' => 300,'msg' => 'Invalid Request!');
		}

		Session::put('log_access',true);
		return array('response' => 200);
		
	}

	/**
	 * Elevate user privileges
	 * 
	 *
	 */
	public function elevatePriviliges($emp_id,$role)
	{

		//find the employee
		$employee = $this->employee->findOrFail($emp_id);

		switch ($role) {

			case '1':
				return $this->toCashier($employee);
				break;

			case '2':
				return $this->toAdmin($employee);
				break;
			
			default:
				# code...
				break;
		}

		
		
		
	}

	public function toCashier($employee){

		//update her/his privileges
		if($this->checkIfUserExist($employee->email)){

			return array('response' => 300);
		}

		$this->user->username = $employee->email;
		$this->user->password = Hash::make('12345');
		$this->user->role = '1';
		$this->user->save();

		

		//update his/her priviliges on the employees table
		$employee->role = 1;
		$employee->save();

		//store the logs
		Audit::store(
						'Priviliges',
						'Employee  ' . $employee->fname .' '. $employee->lname . ' is now privileged as a cashier.'
					);

		return array('response' => 200);

	}

	public function toAdmin($employee){

		//update her/his privileges
		$this->user->username = $employee->email;
		$this->user->password = Hash::make('12345');
		$this->user->role = '2';
		$this->user->save();
		$employee->role = 2;
		$employee->save();

		//store the logs
		Audit::store(
						'Priviliges',
						'Employee  ' . $employee->fname .' '. $employee->lname . ' is now privileged as an admin.'
					);

		return array('response' => 200);


	}

	public function checkIfUserExist($email){

		//update her/his privileges
		$row_count=  $this->user->where('username','=',$email)->count();

		if($row_count > 0){

			//user is already exist
			return true;
		}
		return false;

	}

	/**
	 * Add a new user to the system
	 */
	
	public function saveNewUser(){

		//check the username 
		$username = Input::get('username');
		$username_exists = $this->user->validateUsername($username);
		if($username_exists){

			return Redirect::to('/system/users#')
			->with([

				'title'				=> 		'System Users',
				'flash_message'		=> 		'Username ' . $username . '  is already exists.',
				'flash_type'		=>		'alert-danger'
			]);
		}
		$this->user->username = Input::get('username');
		$this->user->password = Hash::make(Input::get('pass1'));
		$this->user->role = Input::get('role');
		$this->user->password_md5 = md5(Input::get('pass1'));
		$this->user->save();

		return Redirect::to('/system/users')
			->with([

				'title'				=> 		'System Users',
				'flash_message'		=> 		'User has been added successfully!.',
				'flash_type'		=>		'alert-success'
			]);

	}

	/**
	 * Remove user from the system
	 */
	
	public function removeUser($user_id){

		return $this->user->removeUser($user_id);
	}


	/**
	 * Logout the user.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		$user = Auth::user()->username;
		//destroy the session
		Auth::logout();

		//store the logs
		Audit::store(
						'Authentication',
						'Logged out.'
					);

		Session::forget('log_access');

		return Redirect::to('auth/login')
			->with([

				'title'				=> 		'Please login',
				'flash_message'		=> 		'You have been logged out.',
				'flash_type'		=>		'alert-info'
			]);
	}


	/**
	 * Change password of a specific user
	 */

	public function changePassword($username){

		// return $username;
		$old_pass = Input::get('old_password');
		$new_pass = Input::get('new_password');
		// $password = md5($new_pass);
		$password = md5($old_pass);
		$hash_password = Hash::make($new_pass);
		//return $password;
		$row_count = $this->user->where('username','=',$username)
					->where('password_md5','=',$password)->count();

		//return $row_count;

		if($row_count > 0 ){

			//change the password
			DB::table('fposs_sessions')
	            ->where('username', $username)
	            ->update(array('password_md5' => $password,'password' => $hash_password));

			return Response::json(['response' => '200','msg' => 'Password changed.']);
		}

		return Response::json(['response' => '300','msg' => 'Invalid old password.']);
	}

}