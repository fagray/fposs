<?php
use Carbon\Carbon;

class IcingIngredient extends \Eloquent {

	protected $table = "fposs_icing_ingredient";
	protected $fillable = ['icing_id','ingredient_id'];

	/**
	 * Store Icing Ingredients
	 *
	 * @param $ing_ids
	 * @param $icing_id
     */
	public  function saveIcingngredients($ing_ids,$icing_id){

		//counter
		$i = 0;

		//insert to the database
		foreach($ing_ids as $id){

			DB::table($this->table)->insert([

				'ingredient_id'		=> $id,
				'icing_id'			=> $icing_id,
				'created_at'		=> Carbon::now(),
				'updated_at'		=> Carbon::now()	

			]);

			$i++;
		}



	}
}