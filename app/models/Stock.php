<?php

class Stock extends \Eloquent {


	protected  $table = "fposs_ingredients";
	protected $fillable = ['description','stock','supplier_id'];


	/**
	 * @return mixed
	 */
	public function items(){

		return $this->belongsToMany('Item');
	}

	public function supplier(){

		
	}




}