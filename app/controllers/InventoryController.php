<?php

class InventoryController extends \BaseController {

	private $item,$production,$shipment,$ingredient;

	function __construct(Item $item,Production $production,Shipment $shipment,Ingredient $ingredient){

		$this->item = $item;
		$this->production = $production;
		$this->shipment = $shipment;
		$this->ingredient = $ingredient;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get the low level ingredients list
		// $threshold = Ingredient::where('stocks', '<','alert_level')->get();
		$threshold  = Ingredient::getThresholdIngredients();
		// return $threshold;	
		//show the view

		return View::make('inventory.index')
			->with('title','Store Inventory')
			->with('ingredients',Ingredient::all())
			->with('threshold',$threshold);
	}


	/**
	 * Manual restock of stocks.
	 *
	 * @return Response
	 */
	public function restock()
	{
		$password = Input::get('admin_password');

		if(!Auth::attempt(array('password' => $password))){

			return array('response' => 'Invalid password','status' => '500');
		}	

		// return Input::all();
		$this->shipment->create(Input::all());

		$stock_id = Input::get('stock_id');
		// return $stock_id;
		$qty = Input::get('qty');
		// return $stock_id;
		//update the inventory
		$this->updateInventory($stock_id,$qty);

		//store the logs
		Audit::store(
						'Inventory',
						'Manual restock of ingredient with an id of ' .$stock_id
					);

		return Redirect::to('/inventory')
			->with([

				'flash_message'		=> 'Stock has been received successfully!',
				'flash_type'		=> 'alert-success',
				'ingredients'		=> $this->ingredient->all()
			]);

			
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
		$ingredient = $this->ingredient->findOrFail($stock_id);
		// return $ingredient;
		//grab its base_kg
		$base_kg = $ingredient->base_kg;

		

		//grab the updated stocks
		$updated_stocks = $ingredient->stocks + $qty;

		//calculate for the new stock in kg
		$new_stocks = $updated_stocks  * $base_kg;

		//convert to grams
		$in_grams = $this->ingredient->toGrams($new_stocks);

		//save the data

		$ingredient->stocks = $updated_stocks;
		$ingredient->in_grams = $in_grams;
		$ingredient->in_kg = $new_stocks;
		$ingredient->save();



		
	} 



	/**
	 * Produce new products
	 *
	 * @return Response
	 */
	public function produce()
	{

		//check if there is an existing item for production
		
		$items = $this->item->where('category_id','=','3')->get();
		return View::make('items.production.produce')
			->with('title','Production')
			->with('items',$items);
	}

	/**
	 * Store production items
	 *
	 * @return Response
	 */
	public function storeProductionItems()
	{	

		// return Input::all();
		//store item for billing 
		$qty = Input::get('qty');
		$items = Input::get('items');

		$this->production->storeItemsForProduction($qty,$items);
		
		// return $production_items;

		return Redirect::route('productions.billing')
				->with('title','Production');

	}

	/**
	 * Check inventory stocks
	 *
	 * @return Response
	 */
	public function checkInventoryLevel()
	{	

		$count = 0;
		$low_stock_items = array();
		$stocks = $this->ingredient->all();
		foreach($stocks as $stock){

			if($stock->stocks < $stock->alert_level){

				
				$low_stock_items['name'][$count] =  $stock->name;
				$low_stock_items['stocks'][$count] = $stock->name .' => ' 
								. number_format($stock->stocks,2) . ' ' . $stock->shipment_unit . '<hr/>';
								
				$low_stock_items['unit'][$count] =  $stock->shipment_unit;
				$count++;
				
			}
		}

		

		if($count > 0){

			return Response::json(['response' => 'true','count' => $count,'items' => $low_stock_items]);
		}
		
		return Response::json(['response' => 'false']);

	}

	public function showUnitTypes($ingredient_id){
		$prod_unit_obj = new ProductionUnit();
		$units = $prod_unit_obj->showUnitTypes($ingredient_id);
		return View::make('inventory.unit-types')
				->with('title','Unit types')
				->with('units',$units);
	}


	
}
