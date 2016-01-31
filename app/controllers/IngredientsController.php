<?php

class IngredientsController extends \BaseController {

	protected  $stock;
	protected $supplier;

	function __construct(Ingredient $ingredient, Supplier $supplier){

		 $this->stock = $ingredient;
		 $this->supplier = $supplier;
	}
	/**
	 * Display a listing of the resource.
	 * GET /ingredients
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /ingredients/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//show the form
		$suppliers = $this->supplier->lists('name','id');
		return View::make('stocks.new')
			->with('title','New Stock')
			->with('suppliers',$suppliers);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /ingredients
	 *
	 * @return Response
	 */
	public function store()
	{
		//save the data
		// return Input::all();
		$save = $this->stock->create(Input::all());

		//store the logs
		Audit::store(
						'Inventory',
						'Added a new ingredient with an id of ' .$save->id
					);

		return Redirect::to('/inventory')
			->with([

				'flash_message'		=> 'Ingredient has been saved successfully.
						Please go to settings module to setup its production units.!',
				'flash_type'		=> 'alert-success',
				'ingredients'		=> $this->stock->all()
			]);
	}

	/**
	 * Get the product unit of a certain stock.
	 * GET /ingredients/units/stock_id
	 *
	 * @return Response
	 */
	public function getUnit($stock_id)
	{
		$data = $this->stock->find($stock_id);

		return Response::json($data);
	}

	/**
	 * Get the stock supplier
	 *
	 * @return Response
	 */
	public function getSupplier($stock_id)
	{

		$supp_id = $this->stock->findOrFail($stock_id)->supplier_id;
		$supplier = $this->supplier->find($supp_id)->name;
		return Response::json($supplier);
	}


	



	/**
	 * Display the specified resource.
	 * GET /ingredients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$prod_unit_obj = new ProductionUnit();
		$units = $prod_unit_obj->showUnitTypes($id);
		$ingredient = $this->stock->findOrFail($id);
		$supplier = $this->supplier->findOrFail($ingredient->supplier_id);
		return View::make('stocks.show')
				->with('ingredient',$ingredient)
				->with('units',$units)
				->with('supplier',$supplier)
				->with('title', $ingredient->name .' | Ingredient details');
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /ingredients/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//show the form
		$stock = $this->stock->findOrFail($id);
		$suppliers = $this->supplier->lists('name','id');
		return 
			View::make('stocks.edit')
			->with('stock',$stock)
			->with('title','Update stock')
			->with('suppliers',$suppliers);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /ingredients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$ingredient = $this->stock->findOrFail($id);
		$ingredient->fill(Input::all());
		$ingredient->save();
		$ingredients = $this->stock->all();

		//store the logs
		Audit::store(
						'Inventory',
						'Edited ingredient details  with an id of ' .$id
					);

		return Redirect::to('/inventory/')
			->with([

				'title' 		=> 	'Store Inventory',
				'ingredients'	=> 	$ingredients,
				'flash_message'	=> 	'Ingredient has been updated successfully.',
				'flash_type'	=>	'alert-success'

			]);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /ingredients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	
}