<?php

class Flavor extends \Eloquent {
	protected $fillable = ['name'];
	protected  $table = "fposs_flavors";

	public function items(){

		return $this->hasMany('Item');
	}
}