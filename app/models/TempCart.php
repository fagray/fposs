<?php

class TempCart extends \Eloquent {

	protected $fillable = ['item_id','barcode','qty','total','price','trans_id','item_name'];
	protected $table = "temp_cart";

	public function items(){

		return $this->hasMany('Item');
	}

	public function removeItems(){

		return DB::table($this->table)->delete();
	}
}