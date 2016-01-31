
<?php
use Carbon\Carbon;

class ProductionIngredient extends \Eloquent {

	protected $fillable = ['ingredient_id','production_id','amount_in_grams','amount'];
	protected $table = "fposs_production_ingredients";


	public function cook($ingredients,$prod_id,$amount_g,$amount,$fraction){

		// return "im here cooking";
		$i = 0;

		foreach($ingredients as $ingredient){
			
			DB::table($this->table)->insert([

				'ingredient_id'				=> $ingredients[$i],
				'production_id'				=> $prod_id,
				'amount_in_grams'			=> $amount_g[$i],
				'amount'					=> $amount[$i] . ' ' . $fraction[$i],
				'created_at'				=> Carbon::now(),
				'updated_at'				=> Carbon::now()
			
			]);

			$i++;

			
		}
	
	}

	/**
	 * [haveEnoughStocks description]
	 * @param  [type] $ingredients [description]
	 * @param  [type] $amount_g    [converted amount in grams]
	 * @param  [type] $amount      [original inputted amount(for eggs)]
	 * @return [type]              [description]
	 */
	public function haveEnoughStocks($ingredients,$amount_g,$amount){

		$i = 0;

		$ingredient_obj = new Ingredient();

		$flag = true;

		foreach($ingredients as $ing){


			//get current stock in grams
			$ingredient = $ingredient_obj->findOrFail($ing);
			$current_stock = $ingredient->in_grams;
			// print $current_stock;exit();

			if($ingredient->name == 'Eggs'){

				if( $ingredient->stocks <  $amount[$i] ){

					$flag = false;
				}

			}else{

				if($amount_g[$i] > $current_stock ){

				//have enough stocks
				// return print "not enough stocks on ingredient ". $ing . 'tobe paid'.$amount_g[$i];exit();
					$flag = false;
				
				}

			}
			
			
			$i++;
			

		}

		return $flag;
	
	}

	public function getUsedIngredients($production_id){

	$ingredients =  
			static::where('production_id','=',$production_id)
			->leftJoin(
				'fposs_ingredients','fposs_production_ingredients.ingredient_id','=','fposs_ingredients.id')
			->get();

		return $ingredients;
	}

	public function getUsedIngredientsToday(){

		$ingredients =  
			static::selectRaw('fposs_ingredients.name,
				
				sum(fposs_production_ingredients.amount_in_grams) as in_grams,
				fposs_ingredients.base_g,fposs_ingredients.price,fposs_production_ingredients.amount, 
				sum(amount) as amount')
			->where('fposs_production_ingredients.created_at','>=',Carbon::now()->startOfDay())
			->where('fposs_production_ingredients.created_at','<=',Carbon::now()->endOfDay())
			->groupBy('fposs_production_ingredients.ingredient_id')
			->groupBy('fposs_ingredients.name')
			->leftJoin(
				'fposs_ingredients','fposs_production_ingredients.ingredient_id','=','fposs_ingredients.id')
			->get();

		return $ingredients;
	}

	/**
	 * Update production id if the item is already cooked up
	 */
	
	public function updateProductionId($new_prod_id,$current_prod_id){

		return DB::table($this->table)
	        ->where('production_id','=',$current_prod_id)
	        ->update(array('production_id' => $new_prod_id));
	}

	/**
	 * Get ingredients from a specific production id
	 */
	
	public function getProductionDetails($prod_id){

		$ingredients =  
			static::selectRaw('fposs_ingredients.name,
			
				fposs_production_ingredients.production_id,
				fposs_production_ingredients.created_at,
				sum(fposs_production_ingredients.amount_in_grams) as in_grams, 
				sum(amount) as amount')
			->where('fposs_production_ingredients.production_id','=',$prod_id)
			->groupBy('fposs_production_ingredients.ingredient_id')
			->groupBy('fposs_ingredients.name')
			->leftJoin('fposs_ingredients','fposs_production_ingredients.ingredient_id','=','fposs_ingredients.id')
			->get();

		return $ingredients;
	}
	
}