<?php

class ItemIngredient extends \Eloquent {

	protected  $table = "fposs_ingredient_item";
	protected $fillable = ['ingredient_id','item_id'];


	/**
	 * Store Item Ingredients
	 *
	 * @param $ing_ids
	 * @param $item_id
	 * @param $amount
     */
	public  function saveItemIngredients($ing_ids,$item_id,$amount){

		//counter
		$i = 0;

		//insert to the database
		foreach($ing_ids as $id){

			DB::table($this->table)->insert([

				'ingredient_id'		=> $id,
				'item_id'			=> $item_id,
				'amount'			=> $amount[$i],

			]);

			$i++;
		}



	}

	/**
	 * Remove Item Ingredients
	 *
	 * @param $ing_ids
	 * @param $item_id
	 * @param $amount
     */
	public  function removeItemIngredients($item_id){

		//remove the ingredients
		DB::table($this->table)->where('item_id', '=', $item_id)->delete();
		return true;
	}

	/**
	 * Update Item Ingredients
	 *
	 * @param $ing_ids
	 * @param $item_id
	 * @param $amount
     */
	public  function updateItemIngredients($ing_ids,$item_id){

	

		//insert to the database
		foreach($ing_ids as $id){

			DB::table($this->table)
	            ->where('item_id', $item_id)
	            ->update(array(

	            				'ingredient_id' => $id
	            		));

			
		}



	}


}