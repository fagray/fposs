<?php

class Category extends \Eloquent {

	protected $fillable = ['id','cat_name'];
	protected  $table  = "fposs_categories";
	protected $primaryKey = 'id';


	/**
	 * @return mixed
     */
	public function items(){

		return $this->hasMany('Item');
	}
}