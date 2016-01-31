<?php

class IcingsController extends \BaseController {

	private $icing,$ingredient,$ig;

	function __construct(Ingredient $ingredient, Icing $icing,IcingIngredient $ig){

		$this->icing = $icing;
		$this->ingredient = $ingredient;
		$this->ig = $ig;
	}
	/**
	 * Display a listing of the resource.
	 * GET /icings
	 *
	 * @return Response
	 */
	public function index()
	{
		//show the index page
		$icings = $this->icing->all();
		$ingredients = $this->ingredient->all();
		return View::make('icing.index')
			->with('title','Icings')
			->with('icings',$icings)
			->with('ingredients',$ingredients);

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /icings
	 *
	 * @return Response
	 */
	public function store()
	{
		//store the data
		$icings  = $this->icing->all();
		$icing = $this->icing->create(Input::all());
		$last_id = $icing->id;

		$this->ig->saveIcingngredients(Input::get('ing_id'),$last_id);
		return Redirect::to('/icings/')
			->with('title','Icings')
			->with('icings',$icings);
	}

	/**
	 * Display the specified resource.
	 * GET /icings/{id}
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
	 * GET /icings/{id}/edit
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
	 * PUT /icings/{id}
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
	 * DELETE /icings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}