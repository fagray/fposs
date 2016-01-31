<?php

class ShipmentsController extends \BaseController {

	protected $item,$supplier,$ingredient,$shipment;

	function __construct(Item $item,Supplier $supplier,
							Ingredient $ingredient,Shipment $shipment){

		$this->item = $item;
		$this->supplier = $supplier;
		$this->ingredient = $ingredient;
		$this->shipment = $shipment;
	}



	/**
	 * Display a listing of the resource.
	 * GET /shipments
	 *
	 * @return Response
	 */
	public function index()
	{
		//return the view
		$shipments = $this->shipment->getAll();
		// return $shipments;
		return View::make('transactions.shipments.index')
			->with('title','Shipments')
			->with('shipments',$shipments);

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /shipments/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//show the view, pass the necessary dependencies
		$ingredients = $this->ingredient->getAllSuppliedIngredient();
		return 
			View::make('transactions.shipments.new')
				->with('title','New Shipment')
				->with('ingredients',$ingredients);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /shipments
	 *
	 * @return Response
	 */
	public function store()
	{
		//save the resource 
		// return Input::get('received_by');
		$save = $this->shipment->create(Input::all());

		$stock = Input::get('stock_id');
		$qty = Input::get('qty');

		
		$this->updateInventory($stock,$qty);

		return Redirect::to('/transactions/shipments')
			->with([

				'flash_message'		=> 'Stock has been received successfully!',
				'flash_type'		=> 'alert-success',
				'ingredients'		=> $this->ingredient->all()
			]);
		

		
		//$in_grams = 
		//save it also to the ingredients table to update the qty
	}

	/**
	 * Update the quantity on the inventory.
	 * 
	 *
	 * @return Response
	 */
	public function updateInventory($stock_id,$qty)
	{	
		//find the stock first
		$ingredient = $this->ingredient->find($stock_id);
		//grab its base_kg
		$base_kg = $ingredient->base_kg;

		//calculate for the new stock in kg
		$new_stocks = $ingredient->in_kg + ($base_kg * $qty);

		//grab the updated stocks
		$updated_stocks = $ingredient->stocks + $qty;

		//convert to grams
		$in_grams = $this->ingredient->toGrams($new_stocks);

		//save the data
		$ingredient->stocks = $updated_stocks;
		$ingredient->in_grams = $in_grams;
		$ingredient->in_kg = $new_stocks;
		$ingredient->save();

		
	} 

	/**
	 * Display the specified resource.
	 * GET /shipments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//get the shipment details
		$details = $this->shipment->getShipmentDetails($id);
		return $details;
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /shipments/{id}/edit
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
	 * PUT /shipments/{id}
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
	 * DELETE /shipments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}