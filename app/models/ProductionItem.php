<?php
use Carbon\Carbon;

class ProductionItem extends \Eloquent {

	protected $table = "fposs_production_items";
	protected $fillable = ['item_id','production_id','status','qty','remaining','expires_at','added'];

	public function storeProductionItems($qty,$items,$prod_id){
		
		$i = 0;
		foreach($items as $item){

			DB::table($this->table)->insert([

				'item_id'			=> $items[$i],
				'production_id'		=> $prod_id,
				'status'			=> 'pending',
				'qty'				=> $qty[$i],
				'remaining'			=> $qty[$i],
				'created_at'		=> Carbon::now(),
				'updated_at'		=> Carbon::now()
			
			]);

			$i++;

			
		}

	}

	public function getCurrentProduction(){

		//get the current production id based on today's timestamp
		$items = static::
				selectRaw('fposs_production_items.item_id,
							fposs_production_items.production_id,
							fposs_production_items.id,
							fposs_items.barcode,
							fposs_items.name,
							fposs_production_items.remaining,
							fposs_production_items.added,
							sum(fposs_production_items.qty) as qty,
							sum(fposs_production_items.remaining) as remaining') 
			->where('fposs_production_items.status','=','cooked')
			->where('fposs_production_items.created_at', '>=',Carbon::now()->startOfDay())
			->where('fposs_production_items.created_at','<=',Carbon::now()->endOfDay())
			->groupBy('fposs_production_items.item_id')
			->leftJoin('fposs_items','fposs_production_items.item_id','=','fposs_items.id')
			->get();

		return $items;
	}

	public function getCurrentProductionsBarcodes(){

		$cupcake_id = Category::where('cat_name','=','Cupcake')->first()->id;
		$items  = static::
			selectRaw("fposs_items.barcode as codes")
			->where('fposs_production_items.status','=','cooked')
			->where('fposs_items.category_id','=',$cupcake_id)
			->where('fposs_production_items.created_at', '>=',Carbon::now()->startOfDay())
			->where('fposs_production_items.created_at','<=',Carbon::now()->endOfDay())
			->groupBy('fposs_production_items.item_id')
			->leftJoin('fposs_items','fposs_production_items.item_id','=','fposs_items.id')
			->lists('codes');

		return $items;
	}

	public function getPendingItems(){

		$cupcake_id = Category::where('cat_name','=','Cupcake')->first()->id;
		$items  = static::
			selectRaw("fposs_items.id ")
			->selectRaw("fposs_production_items.qty,fposs_production_items.item_id,fposs_production_items.id")
			->where('fposs_production_items.status','=','pending')
			->where('fposs_items.category_id','=',$cupcake_id)
			->where('fposs_production_items.created_at', '>=',Carbon::now()->startOfDay())
			->where('fposs_production_items.created_at','<=',Carbon::now()->endOfDay())
			->groupBy('fposs_production_items.item_id')
			->leftJoin('fposs_items','fposs_production_items.item_id','=','fposs_items.id')
			->get();
			

		return $items;
	}

	/**
	 * [getPendingItemId description]
	 * @return [type] [description]
	 */
	public function getPendingItemId($item_id,$prod_id){

		$item = static::selectRaw('id')
				->where('item_id','=',$item_id)
				->where('production_id','=',$prod_id)
				->where('status','=','pending')
				->first()->id;
				
		return $item;

	}

	public function getCurrentProductionsItemId(){

		$cupcake_id = Category::where('cat_name','=','Cupcake')->first()->id;
		$items  = static::
			selectRaw("fposs_items.id as id")
			->where('fposs_production_items.status','=','cooked')
			->where('fposs_items.category_id','=',$cupcake_id)
			->where('fposs_production_items.created_at', '>=',Carbon::now()->startOfDay())
			->where('fposs_production_items.created_at','<=',Carbon::now()->endOfDay())
			->groupBy('fposs_production_items.item_id')
			->leftJoin('fposs_items','fposs_production_items.item_id','=','fposs_items.id')
			->lists('id');

		return $items;
	}

	public function updateCookedItemQty($item_id,$qty){

		$prod_obj = $this->getItemRemainingQty($item_id);
		$remaining_qty = $prod_obj->remaining;

		$new_qty  = $prod_obj->qty + $qty;

		$remaining_qty = $remaining_qty + $qty;

		DB::table($this->table)
		            ->where('item_id','=',$item_id)
		            ->where('fposs_production_items.created_at', '>=',Carbon::now()->startOfDay())
					->where('fposs_production_items.created_at','<=',Carbon::now()->endOfDay())
		            ->update(array('qty' => $new_qty, 'remaining' => $remaining_qty ));
	}

	public function getItemRemainingQty($item_id){

		return DB::table($this->table)
					->selectRaw("fposs_production_items.remaining as remaining,fposs_production_items.qty as qty")
		            ->where('item_id','=',$item_id)
		            ->where('fposs_production_items.created_at', '>=',Carbon::now()->startOfDay())
					->where('fposs_production_items.created_at','<=',Carbon::now()->endOfDay())
		            ->first();

	}

	public function getMaxId(){

		return  DB::table($this->table)->max('production_id');
	}

	//save the unsold items for the day
	public function saveUnsoldItems(){

		$items = static::where('status','=','cooked')
					->where('created_at','>=',Carbon::now()->startOfDay())
					->where('created_at','<=',Carbon::now()->endOfDay())
				
					->get();

		foreach($items as $item){

			if($item->expires_at != Carbon::now()->startOfDay()){

				DB::table($this->table)
			        ->where('production_id','=',$item->production_id)
			        ->update(array('status' => 'unsold'));
			}else{

				//item is already expired
				//update its status
				
				DB::table($this->table)
			        ->where('production_id','=',$item->production_id)
			        ->update(array('status' => 'expired'));
			}

		}
		 


	}

	//get unsold items for the day

	public function getUnsoldItems(){

		$items = 
			static::
			selectRaw('fposs_production_items.created_at,fposs_items.name,
				fposs_production_items.remaining,fposs_production_items.expires_at')
			->where('fposs_production_items.status','=','unsold')
			->where('fposs_production_items.expires_at','>',Carbon::now()->startOfDay())
			->leftJoin('fposs_items','fposs_production_items.item_id','=','fposs_items.id')
			->get();

		return $items;
		
	}

	/**
	 * Add unsold items to production
	 */
	
	public function addToProduction($item_id,$qty,$production_id){

		//count if there is already item that have been cooked up
		// if so, update the added column and the remaining qty of 
		// that item

		//check if the item is already cooked up
		if(!in_array($item_id,$this->getCurrentProductionsItemId())){

			return Response::json(['response' => '300','msg' => 'Item has not been cooked up.']);
		}

		$item_remaining_qty = $this->getCookedItemQty($item_id);

		// return $item_remaining_qty;
		if($item_remaining_qty > 0 ){

			//yay ! update now the remaining field
			//
			DB::table($this->table)
			        ->where('item_id','=',$item_id)
			        ->where('status','=','cooked')
					->where('created_at','>=',Carbon::now()->startOfDay())
					->where('created_at','<=',Carbon::now()->endOfDay())
			        ->update(array(

			        				'remaining' => $item_remaining_qty + $qty,
			        				'added'		=> $qty
			        		));
			// update the unsold item that has been added to the production
			//  set its remaining qty to current remaining - qty that has been added to production
			
			$this->updateUnsoldItemRemainingQty($item_id,$production_id,$qty);

			return Response::json(['response' => '200','msg' => 'Ok, item has been updated.']);
		}

		// oopss, sorry 
		return Response::json(['response' => '300','msg' => 'Item has not been cooked up.']);
		
	}

	/**
	 * Get the item remaining qty of the cooked item
	 * that will be updated 
	 */
	
	public function getCookedItemQty($item_id){

		$item_qty =  static::where('item_id','=',$item_id)
					->where('status','=','cooked')
					->where('created_at','>=',Carbon::now()->startOfDay())
					->where('created_at','<=',Carbon::now()->endOfDay())
					->first()->remaining;

		if($item_qty < 1){

			return 0;
		}

		return $item_qty;
	}

	/**
	 * Get cooked production id
	 */
	
	public function getCookedItemProductionId($item_id){

		return static::where('item_id','=',$item_id)
					->where('status','=','cooked')
					->where('created_at','>=',Carbon::now()->startOfDay())
					->where('created_at','<=',Carbon::now()->endOfDay())
					->first()->production_id;
	}

	/**
	 * Update the remaining qty of the unsold item
	 * that has been added to the production 
	 */
	
	public function updateUnsoldItemRemainingQty($item_id,$production_id,$qty){

		$added_to_production_id = $this->getCookedItemProductionId($item_id);
		$unsold_item_qty = $this->getUnsoldItemQty($item_id,$production_id);
		return static::where('item_id','=',$item_id)
						->where('production_id','=',$production_id)
						->update(array(
										'remaining' => $unsold_item_qty - $qty,
										'status'  => 'added to prod # '.$added_to_production_id
								));
	}


	/**
	 * Get the remaining qty of the unsold item
	 */
	
	public function getUnsoldItemQty($item_id,$production_id){

		return static::where('item_id','=',$item_id)
					->where('status','=','unsold')
					->where('production_id','=',$production_id)
					->where('expires_at','>',Carbon::now()->startOfDay())
					->first()->remaining;
	}

	/**
	 * Get productions 
	 */
	
	public function getProductions()
	{
		$data = static::selectRaw(
					"
						fposs_production_items.production_id,
						fposs_productions.created_at,
						fposs_productions.num_of_items
						 ")
			->groupBy('fposs_production_items.production_id')
			->leftJoin('fposs_productions','fposs_production_items.production_id','=','fposs_productions.id')	
			->get();
		return $data;
	}


	/**
	 * Get production items and from a specific production
	 */
	
	public function getItemsFromAProduction($prod_id)
	{
		$data = static::selectRaw(
						"fposs_items.name as item_name,
						fposs_production_items.qty
						 ")
			->where('fposs_production_items.production_id','=',$prod_id)
			->leftJoin('fposs_items','fposs_production_items.item_id','=','fposs_items.id')	
			->get();
		return $data;
	}





}