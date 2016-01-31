<?php


class Item extends \Eloquent {

	/**
	*
	* The table used by the model
	*
	*/
	protected  $table = "fposs_items";

	/**
	*
	* The database fields used by the table
	*
	*/
	
	protected $fillable = ['barcode','name','description','price','category_id','status','image'];

	
	/**
	*
	* the validation rules binded to the view
	*
	*/
	
	public static $rules =	['name' => 'required','price' => 'required'];


	/**
	*
	* Return the items with its category
	*
	*/
	public function getItems(){

		$data =  DB::table($this->table)
                     ->leftJoin('fposs_categories','fposs_items.category_id','=','fposs_categories.id')
                     ->get();
        return $data;
	}

	public function getCategory($code){

		$category = DB::table($this->table)
						->where('barcode','=',$code)
						->first()
						->category_id;
		return $category;
	}

	public function findItemItemId($code){

		return  static::where('barcode','=',$code)->first()->id;
	}

	public function findItemByBarcode($code){

		return static::where('barcode','=',$code)->first()->name;
	}

	


	
	public function category(){

		return $this->belongsTo('Category');
	}

	public function flavors(){

		return $this->hasMany('Flavor');
	}

	public function ingredients(){

		return $this->belongsToMany('Ingredient','fposs_ingredient_item');
	}

	public function customers(){

		return $this->belongsToMany('Item');
	}

	public function cart(){

		return $this->belongsTo('TempCart');
	}

	public function productions(){

		return $this->belongsToMany('Item','fposs_production_items')->withTimeStamps();
	}

	/**
	 * Get cupcake items with inventory and stocks status
	 */
	
	// public function getItemsWithInventoryStatus()
	// {
	// 	$category_id = Category::where('cat_name','=','Cupcake')->first()->id;
	// 	$item= Item::find()

	// 	return $item->ingredients;
	// 	// $items = static::selectRaw("fposs_items.name,fposs_items.id")
	// 	// 		->where('fposs_items.category_id','=',$category_id)
	// 	// 		->groupBy('fposs_items.id')
	// 	// 		->leftJoin('fposs_ingredient_item','fposs_items.id','=','fposs_ingredient_item.item_id')
	// 	// 		->leftJoin('fposs_ingredients','fposs_items.id','=','fposs_ingredient_item.item_id')
	// 	// 		->get();

	// 	return $items;
	// }
}