<?php

class Customer extends \Eloquent {

	
	protected $fillable = ['fname','lname','address','contact_num'];
	protected $table = "fposs_customers";

	public function items(){

		return $this->belongsToMany('customer');
	}

	/**
	 * Get total amount purchased
	 */
	
	public function getTotalAmountPurchased($customer_id){

		$total = DB::table('fposs_sales')
				->where('customer_id','=',$customer_id)
				->sum('amount');
		return $total;
	}

}