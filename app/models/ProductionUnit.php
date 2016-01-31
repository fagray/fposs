<?php

class ProductionUnit extends \Eloquent {

	protected $table = "fposs_production_units";
	protected $fillable = ['item_id','unit_id','in_grams'];

	public  function getItemProductionUnits($ing_id){

		$units  = DB::table($this->table)
					->selectRaw('fposs_ingredients.name,fposs_units.symbol,fposs_units.id,fposs_production_units.in_grams,fposs_production_units.ingredient_id')
					->where('fposs_production_units.ingredient_id','=',$ing_id)
					->leftJoin('fposs_ingredients','fposs_production_units.ingredient_id','=','fposs_ingredients.id')
					->leftJoin('fposs_units','fposs_production_units.unit_id','=','fposs_units.id')
					->get();

		return $units;
	}

	public function getUnitsForSelectComponent($ing_id){

		$units  = DB::table($this->table)
			->where('fposs_production_units.ingredient_id','=',$ing_id)
			->leftJoin('fposs_units','fposs_production_units.unit_id','=','fposs_units.id')
			->lists('fposs_units.symbol','in_grams');

		return $units;
	}

	public function updateProductionUnits($ing_id,$equivalents,$unit_id){

		//delete first the old units
		DB::table($this->table)->where('ingredient_id', '=', $ing_id)->delete();

		//now, insert the new value
		$i = 0;
		foreach($equivalents as $equivalent){

			DB::table($this->table)->insert([

				'ingredient_id'		=> $ing_id,
				'unit_id'			=> $unit_id[$i],
				'in_grams'			=> $equivalent

			]);

			$i++;

		}
	

	}

	public function storeProductionUnits($ing_id,$equivalents,$unit_id){


		//now, insert the new value
		$i = 0;
		foreach($equivalents as $equivalent){

			DB::table($this->table)->insert([

				'ingredient_id'		=> $ing_id,
				'unit_id'			=> $unit_id[$i],
				'in_grams'			=> $equivalent

			]);

			$i++;

		}
	
	}

	/**
	 * Get the ingredient production units
	 *  Throw in array form
	 */
	
	public function getIngredientUnits($ing_id){

		return $units = static::where('ingredient_id','=',$ing_id)->lists('unit_id');

	}

	/**
	 * Remove unit from the units list
	 */
	
	public function removeIngredientUnit($ing_id,$unit_id){
		// return $ing_id . ' ' . $unit_id;
		return  $remove  = DB::table($this->table)->where('ingredient_id','=',$ing_id)
					->where('unit_id','=',$unit_id)
					->delete();

	}

	/**
	 * Show the ingredient units
	 */
	
	public function showUnitTypes($ing_id){

		return static::where('fposs_production_units.ingredient_id','=',$ing_id)
				->leftJoin('fposs_units','fposs_production_units.unit_id','=','fposs_units.id')
				->get();
	}
}