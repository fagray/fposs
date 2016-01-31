<?php

class StocksController extends \BaseController {

	protected  $stock;

	function __construct(Ingredient $ingredient){

		$this->stock = $ingredient;
	}
	/**
	 * Display a listing of the resource.
	 * GET /stocks
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /stocks/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//show the form
		$suppliers = Supplier::lists('name','id');
		return View::make('stocks.new')
			->with('title','New Stock')
			->with('suppliers',compact('suppliers'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /stocks
	 *
	 * @return Response
	 */
	public function store()
	{
		//save the data
		$this->stock->create(Input::all());
		return Redirect::to('/inventory')
			->with([

				'flash_message'		=> 'Data has been saved successfully!',
				'flash_type'		=> 'alert-success',
				'ingredients'		=> $this->stock->all()
			]);
	}

	/**
	 * Display the specified resource.
	 * GET /stocks/{id}
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
	 * GET /stocks/{id}/edit
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
	 * PUT /stocks/{id}
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
	 * DELETE /stocks/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}