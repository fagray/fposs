<?php

class TransactionsController extends \BaseController {

	protected $item,$supplier,$ingredient;

	function __construct(Item $item,Supplier $supplier,Ingredient $ingredient){

		$this->item = $item;
		$this->supplier = $supplier;
		$this->ingredient = $ingredient;
	}

	/**
	 * Show the form for accepting new shipment.
	 * GET /transactions/shipments/create
	 *
	 * @return Response
	 */
	public function get_shipment()
	{
		//show the view, pass the necessary dependencies
		$suppliers = $this->supplier->lists('id','name');
		$ingredients = $this->ingredient->lists('id','name');
		return 
			View::make('transactions.shipments.create')
				->with('title','New Shipment')
				->with('suppliers',$suppliers)
				->with('ingredients',$ingredients);

	}

	/**
	 * Save the shipment details to the storage.
	 * POST /transactions/shipments/create
	 *
	 * @return Response
	 */
	public function post_shipment()
	{
		//save the resource 
		$save = $this->shipment->create(Input::all());

	}

	

}