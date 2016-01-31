<?php

class EmployeesController extends \BaseController {
	
	protected $employee;

	function __construct(Employee $employee){

		$this->employee = $employee;
	}
	/**
	 * Display a listing of the resource.
	 * GET /employees
	 *
	 * @return Response
	 */
	public function index()
	{
		//show the view
		$employees = $this->employee->all();
		return View::make('employees.index')
			->with('employees',$employees)
			->with('title','Employees');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /employees/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//show the create form
		return View::make('employees.new')
			->with('title','New Employee');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /employees
	 *
	 * @return Response
	 */
	public function store()
	{
		//add new employee
		$employees = $this->employee->all();
		$save = $this->employee->create(Input::all());

		//store the logs
		Audit::store(
						'Employees',
						'Added a new employee with an id of ' .$save->id
					);

		return Redirect::route('employees.index')
			->with('employees',$employees)
			->with('title','Employees')
			->with('flash_message','Employee has been added')
			->with('flash_type','alert alert-success');
	}

	/**
	 * Display the specified resource.
	 * GET /employees/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /employees/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /employees/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /employees/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}