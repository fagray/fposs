<?php
use Carbon\Carbon;

class SettingsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /settings
	 *
	 * @return Response
	 */
	public function index()
	{
		//show the main view
		$ingredients = Ingredient::lists('name','id');
		$units = Unit::lists('symbol','id');
		return View::make('settings.index')
			->with('ingredients',$ingredients)
			->with('units',$units)
			->with('title','Settings');
	}

	/**
	 * Auto suggest
	 * GET /settings/
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function searchItemProductionUnits($ing_id)
	{
		$prod_unit = new ProductionUnit();
		$units = $prod_unit->getItemProductionUnits($ing_id);

		if(count($units) > 0){

			return $units;
		}

		return Response::json(['response' => 300]);
		
	}

	public function updateProductionUnits(){


		//equivalent in grams
		$equivalents = Input::get('prod_units');
		//unit ids
		$unit_id = Input::get('unit_id');
		//ingredient id
		$ing_id = Input::get('ing_id');
		//update the item
		$prod_unit = new ProductionUnit();
		//check for redundunt unit types
		$ing_units = $prod_unit->getIngredientUnits($ing_id);
		
		// for($i = 0; $i < count($unit_id); $i++){

		// 	if(in_array($unit_id[$i], $ing_units)){

		// 		return Response::json(['response' => 300,'msg' => 'Unit already exists.']);
		// 	}
		// }

		$prod_unit->updateProductionUnits($ing_id,$equivalents,$unit_id);

		//redirect to the view
		$ingredients = Ingredient::lists('name','id');
		return Redirect::to('/settings')
			->with('title','Settings')
			->with('flash_message','Changes has been saved.')
			->with('flash_type','alert alert-success')
			->with('ingredients',$ingredients);
	}


	public function storeProductionUnits(){

		//save the data 
		//TODO  : Validation  - Redudundant unit types.

		//equivalent in grams
		$equivalents = Input::get('prod_units');
		//unit ids
		$unit_id = Input::get('unit_id');
		//ingredient id
		$ing_id = Input::get('ing_id');

		$prod_unit = new ProductionUnit();
		//get the list of the production units on the ingredient
		$ing_units = $prod_unit->getIngredientUnits($ing_id);
		// return $ing_units;
		if(in_array($unit_id, $ing_units)){

			return Response::json(['response' => 300,'msg' => 'Unit already exists.']);
		}

		$units = $prod_unit->storeProductionUnits($ing_id,$equivalents,$unit_id);

		return Response::json(['response' => 200]);

	}

	/**
	 * Remove unit from the ingredient's unit list
	 */
	
	public function removeUnit($ing_id,$unit_id){

		$prod_unit = new ProductionUnit();
		$prod_unit->removeIngredientUnit($ing_id,$unit_id);
		return Response::json(['response' => 200,'msg' => 'Unit has been removed.']);
	}

	/**
	 * Add new unit on the units table
	 */
	
	public function addNewUnit(){

		$name = Input::get('name');
		$symbol = Input::get('symbol');
		$save = Unit::create(['name' => $name,'symbol' => $symbol]);
		return Response::json(['response' => 200,'msg' => 'Unit has been added.']);
	}

	/**
	 * Setup the store
	 */
	
	public function storeSetup($option){

		if($option == "CLOSE"){

			return $this->closeStore();
		}

		return $this->openStore();
	}

	/**
	 * Opens the store transactions
	 */
	
	public function openStore(){

		Session::put("STORE", "OPEN");
		Session::put("REGISTER", "OPEN");
		Session::put("PRODUCTION", "OPEN");
		return Response::json(['response' => '200','msg' => 'Store already opened.']);
	}

	/**
	 * Close the store transactions
	 */
	
	public function closeStore(){
		
		$production_item = new ProductionItem();
		Session::put("STORE", "CLOSE");
		Session::put("REGISTER", "CLOSE");
		Session::put("PRODUCTION", "CLOSE");
		//save the unsold items for the day
		$items = $production_item->saveUnsoldItems();

		//update the item status to unsold
		// $update = 
		// return $items;
		

		return Response::json(['response' => '200','msg' => 'Success']);
	}


	

}