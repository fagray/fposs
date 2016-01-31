<?php
use Carbon\Carbon;

class Production extends \Eloquent {

	protected $table  = "fposs_productions";
	
	protected $fillable = ['status','num_of_items','num_of_rejects'];

	public function items(){

		return $this->belongsToMany('Item','fposs_production_items')->withTimeStamps();
	}

	public function ingredients(){

		return $this->belongsToMany('Ingredients','fposs_production_ingredients')->withTimeStamps();
	}



}