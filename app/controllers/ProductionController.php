<?php
use Carbon\Carbon;

class ProductionController extends \BaseController {

	protected $production;
	protected $production_item;
	protected $production_ingredient;
	protected $ingredient;
	protected $item;

	function __construct(Production $production, ProductionItem $production_item,
							ProductionIngredient $prod_ingredient,Ingredient $ingredient,Item $item){

		$this->production = $production;
		$this->production_item = $production_item;
		$this->production_ingredient = $prod_ingredient;
		$this->ingredient = $ingredient;
		$this->item  = $item;

	}

	/**
	 * Display a listing of the resource.
	 * GET /production
	 *
	 * @return Response
	 */
	public function index()
	{
		
		//get the current production id based on today's timestamp
		$items = $this->getCurrentProduction();
		//get all productions, it will displayed on the index of production module
		$productions = $this->production_item->getProductions();
		 $ingredients_used = $this->production_ingredient->getUsedIngredientsToday();
		return View::make('items.production.index')
			->with('title','Production')
			->with('items',$items)
			->with('ingredients',$ingredients_used)
			->with('productions',$productions);
	}

	/**
	 * Store the items for production
	 * POST /productions/produce
	 *
	 * @return Response
	 */
	public function store()
	{

		// return "fuck";
		//save the new production
		$this->production->status = '1';
		$this->production->num_of_items = count(Input::get('items'));
		$this->production->num_of_rejects = 0;
		$production = $this->production->save();
		//last $id
		$id = $this->production->id;

		//store the production id inside the session variable
		Session::put('production_id',$id);

		// return $id;
		//store the production items
		$qty = Input::get('qty');
		$items = Input::get('items');
		
		$this->production_item->storeProductionItems($qty,$items,$id);

		return Redirect::route('productions.billing')
				->with('title','Production');
		
	}

	/**
	 * Produce new products
	 *
	 * @return Response
	 */
	public function produce()
	{
		$category_id = Category::where('cat_name','=','Cupcake')->first()->id;
		$items = $this->item->where('category_id','=',$category_id)->get();
		// return $items = $this->item->getItemsWithInventoryStatus();
		return View::make('items.production.produce')
			->with('title','New Production')
			->with('items',$items);
	}

	/**
	 * Bill production items
	 *
	 * @return Response
	 */

	public function billing(){

		$production_items =  $this->production_item->where('status','=','pending')->get();
		
		return View::make('items.production.billing')
			->with('production_items',$production_items)
			->with('title','Billing');
	}

	/**
	 * Cook and produce new products
	 *
	 * @return Response
	 */
	public function cook()
	{
		// return Carbon::now()->addDays(2)->toDateTimeString();
		// return $this->updateItemProductionStatus();
		// return $production_id;
		$production_id = Session::get('production_id');
		// return  $this->updateItemProductionStatus();
		$amount 	 	=		Input::get('amount');
		$conv_rate		=	 	Input::get('conv_rate');
		$fraction  		= 		Input::get('ext');
		$item_id 		= 		Input::get('item_id');
		$servings 		= 		Input::get('qty');

		//return $conv_rate;
		// return $this->processCookedItems($item_id,$servings);
		//convert to grams
		 $amount_g = $this->getAmountInGrams($fraction,$conv_rate,$amount);
		// return $amount_g;
	
		$ingredients = Input::get('ing_ids');

		//check first the stocks 
		 $isStockEnough = $this->production_ingredient
						->haveEnoughStocks($ingredients,$amount_g,$amount);

		if(!$isStockEnough){

			return Response::json(['response' => '300','msg' => 'Not enough stocks']);
		}

		//store the used ingredients to the table
		 $this->production_ingredient->cook($ingredients,$production_id,$amount_g,$amount,$fraction);
												

		//update the inventory
		$this->updateInventory($amount_g,$ingredients,$amount);

		//if the item is already cooked, update its quantity
		$this->processCookedItems($item_id,$servings);

		//update the items status to "cooked"
		 $this->updateItemProductionStatus($item_id);

		

		// return true;

		// return 
		// 	Redirect::to('/items/productions')
		// 		->with('title','Productions')
		// 		->with('flash_message','Production has been set.')
		// 		->with('flash_type','alert-success')
		// 		->with('items',$this->getCurrentProduction());
	}

	/**
	 * Determine if the item is already cooked
	 *
	 * @return Response
	 */

	public function processCookedItems($item_id,$servings){
		$production_id = Session::get('production_id');
		$prod_items 		= 	$this->production_item->getCurrentProductionsItemId();
		$pending_item_id 	= 	$this->production_item->getPendingItemId($item_id,$production_id);
		// return $pending_item_id;
		// return $pending_items_id;

			if(in_array($item_id,$prod_items)){

				//update the qty
				$this->production_item->updateCookedItemQty($item_id,$servings);
				
				//remove the newly inserted production id
				// and update the production id of the used ingredient
				$this->removeProductionIfItemIsAlreadyCooked($pending_item_id);
				// $this->updateProductionIfItemIsAlreadyCooked($old_production_id);

			}else{

				return "not existed";
			}
		


	}

	public function removeProductionIfItemIsAlreadyCooked($id){

		$prod = $this->production_item->find($id);
		$prod->delete();
	}

	public function updateProductionIfItemIsAlreadyCooked($new_prod_id){

		$current_prod_id = Session::get('production_id');
		$prod = $this->production_ingredient->updateProductionId($new_prod_id,$current_prod_id);
		
	}

	/**
	 * Update the stocks on the inventory
	 *
	 * @return Response
	 */

	public function updateInventory($amount_in_grams,$ingredients,$amount){

		// return $amount_in_grams;
		// $i = 0;
		
		$length = count($ingredients);

		for($i = 0; $i  < $length; $i++){

			//find the remaining stocks of current ingredient
			$ingredient = $this->ingredient->findOrFail($ingredients[$i]);
			// print $ingredient->name;

			//if the ingredient is egg, just deduct it by pcs
			if(  $ingredient->name == "Eggs" || $ingredient->name == "eggs" ){
		
				//current stock
				$current_stock = $ingredient->stocks;
				//update the qty
				$ingredient->in_grams 	=  		'';
				$ingredient->in_kg 		= 		'';
				$ingredient->stocks 	= 		$current_stock - $amount[$i];
				$ingredient->save();

			}else{

				//current stock in grams
				$stock = $ingredient->in_grams;

				// print "stocks : " . $stock;

				$new_stock_in_g  = $stock - $amount_in_grams[$i];

				$new_stock_in_kg = $new_stock_in_g / 1000;

				// stocks in unit e.g 5 sacks
				$stocks = $new_stock_in_kg / $ingredient->base_kg;

				//run an update query
				$ingredient->in_grams 	=  		$new_stock_in_g;
				$ingredient->in_kg 		= 		$new_stock_in_kg;
				$ingredient->stocks 	= 		$stocks;
				$ingredient->save();


			}	

			 // print 'remaining : ' . $stock . ' amount to sub : ' . $amount_in_grams[$i] . ' = ' . $new_stock_in_g;

		}

	}

	/**
	 * Update production item status to "cooked" 
	 *
	 * @return Response
	 */
	
	public function updateItemProductionStatus($item_id){

			$expiration  = Carbon::now()->addDays(2)->startOfDay()->toDateTimeString();
			$prod_id = Session::get('production_id');
			// return $prod_id;exit();
			$item = ProductionItem::
					where('production_id','=',$prod_id)
					->where('item_id','=',$item_id)
					->where('status','=',"pending")->first();
					
			if($item != null){

				// print $item->id;exit();
				$prod = $this->production_item->findOrFail($item->id);
				// $prod->qty = $prod->qty +  $servings;
				// $prod->remaining = $prod->remaining + $servings;
				// 
				
				$prod->status = 'cooked';
				$prod->expires_at = $expiration;
				$prod->save();
			}
				

	}

	/**
	 * Retrieve the items to be sell today
	 *
	 * @return Response
	 */
	
	public function getCurrentProduction(){

		//get the current production id based on today's timestamp
		$items = $this->production_item->getCurrentProduction();

			
		return $items;
	}

	/**
	 * Convert production item ingredient's value to grams
	 *
	 * @return Response
	 */
	
	public function getAmountInGrams($values = null ,$conv_rate,$amount){
		//return $conv_rate;
		//return $values;
		//return $amount;
		// array for converted values
		$converted_values = array();
	
		$i = 0;
		
		foreach($values as $val){

			//if the fraction dropdown is not empty
			if( $val != '' ){

				//strip the value and get its quotient
				$strip_val = explode('/', Input::get('ext')[$i]);
				$ext = ($strip_val[0] / $strip_val[1] * $conv_rate[$i]) 
					+ $conv_rate[$i] * $amount[$i];

				//push the value inside the array
				array_push($converted_values, $ext);

			}else{

				$ext = $conv_rate[$i] * $amount[$i];

				//push the value inside the array
				array_push($converted_values, $ext);

			}

			$i++;
		}

		return $converted_values;
	}

	/**
	 * Check the item stocks
	 * GET /production/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function checkStocks($item_id)
	{
		$item = $this->item->find($item_id);
		$ingredients = $item->ingredients;

		foreach($ingredients as $ingredient){

			if($ingredient->stocks < $ingredient->alert_level){

			}

		}
		return $ingredients;
	}
	/**
	 * Remove item from billing
	 */
	
	public function removeItemFromBilling($item_id){

		$production_id = Session::get('production_id');
		$remove = ProductionItem::
			where('production_id','=',$production_id)
			->where('item_id','=',$item_id)
			->delete();

		
		return Response::json(['response' => '200','msg' => 'Success']);

	}

	/**
	 * Get the unsold items
	 */
	
	public function unsold(){

		$items = $this->production_item->getUnsoldItems();
		return 
			View::make('items.production.unsold')
				->with('unsold',$items)
				->with('title','Unsold Items');
	}

	/**
	 * Add unsold items to production
	 */
	
	public function addUnsoldItemsToProduction(){

		$item_id = Input::get('item_id');
		$qty = Input::get('qty');
		$production_id = Input::get('production_id');
		return $this->production_item->addToProduction($item_id,$qty,$production_id);
			

	}

	/**
	 * Show the production details
	 */
	
	public function showProductionDetails($prod_id)
	{
		$items_in_production = $this->production_item->getItemsFromAProduction($prod_id);
		$prod_details  = $this->production_ingredient->getProductionDetails($prod_id);
		return View::make('items.production.production-details')
			->with('title','Production # '.$prod_id.' | Details')
			->with('productions',$prod_details)
			->with('items',$items_in_production);
	}

	/**
	 * Manual dispose of current item production
	 */
	
	public function dispose($id,$qty){

		$production = $this->production_item->findOrFail($id); 
		$current_qty = $production->remaining;
		$production->remaining = $current_qty - $qty;
		$production->disposed = $qty;
		$production->save();

		return Response::json(['response' => '200','msg' => 'Success']);

	}
	
}