<?php

/**
 * Class Ingredient
 */
class Ingredient extends \Eloquent {

	/**
	*
	* The table used by the model
	*
	*/
	protected  $table = "fposs_ingredients";

	/**
	*
	* The database fields used by the table
	*
	*/
	protected $fillable = ['name','price','alert_level','status','stocks','description','supplier_id','shipment_unit','in_kg','in_grams','base_kg','base_g'];


	/**
	 * Create the relationship
	 * @return mixed
	 * 
     */
	public function items(){

		return $this->belongsToMany('Item','fposs_ingredient_item')->withTimeStamps();
	}

	public function productions(){

		return $this->belongsToMany('Production','fposs_production_ingredients');
	}

	/**
	 * Convert units to grams
	 * @return grams
	 * 
     */
	public function toGrams($value){

		return $value * 1000;
	}

	/**
	 * Convert units to kg
	 * @return kg
	 * 
     */
	public function toKg($value){

		return $value / 1000;
	}

	/**
	 * Get all supplied ingredient
	 */
	
	public function getAllSuppliedIngredient()
	{
		//retailers id = 6
		$retailers_id = 6;
		$ingredients = static::where('supplier_id','!=',$retailers_id)->lists('name','id');
		return $ingredients;
	}

	/**
	 * Get threshold data
	 */
	
	public static function getThresholdIngredients(){

		return static::where('stocks','<=', 'alert_level')->get();
	}

	




}

