<?php

class Supplier extends \Eloquent
{

	protected $table = "fposs_suppliers";
	protected $fillable = ['name', 'resource_person', 'address', 'email', 'contact_num'];

	/**
	 * Get all supplier's details
	 */
	
	public function getSupplierAllDetails($supp_id)
	{
		$data = static::
				selectRaw("
							fposs_ingredients.name as stock_name,
							fposs_suppliers.name,
							fposs_suppliers.resource_person,
							fposs_suppliers.email,
							fposs_suppliers.contact_num,
							fposs_suppliers.address,
							fposs_ingredients.price
						")
				->where('fposs_suppliers.id','=',$supp_id)
				->leftJoin('fposs_ingredients','fposs_suppliers.id','=','fposs_ingredients.supplier_id')
				->get();
	return $data;
	}


}
