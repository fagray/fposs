<?php

class Shipment extends \Eloquent {

	protected $table  = "fposs_shipments";
	protected $fillable = ['stock_id','qty','remarks','received_by','deliver_by','type'];
	protected $primaryKey = "ship_no";
	//get all shipments with the corresponding suppliers

	public function getAll(){


		$shipments = DB::table($this->table)
						->selectRaw('fposs_ingredients.name,fposs_shipments.created_at,fposs_shipments.received_by,fposs_shipments.qty,
							fposs_ingredients.shipment_unit,fposs_shipments.ship_no,fposs_suppliers.name as supplier')
						->leftJoin('fposs_ingredients','fposs_shipments.stock_id','=','fposs_ingredients.id')
						->leftJoin('fposs_suppliers','fposs_ingredients.supplier_id','=','fposs_suppliers.id')
						->get();
		return $shipments;
	}

	/**
	 * Get the shipment details
	 */
	
	public function getShipmentDetails($id){

		$shipment = DB::table($this->table)
						->selectRaw("fposs_suppliers.name as supplier,fposs_ingredients.name as stock,
							fposs_shipments.qty,fposs_shipments.created_at,fposs_shipments.deliver_by,
							fposs_shipments.received_by,fposs_ingredients.price,fposs_shipments.ship_no,
							fposs_shipments.stock_id,fposs_ingredients.id")
						->where('ship_no','=',$id)
						->leftJoin('fposs_ingredients','fposs_shipments.stock_id','=','fposs_ingredients.id')
						->leftJoin('fposs_suppliers','fposs_ingredients.supplier_id','=','fposs_suppliers.id')
						->get();
		return $shipment;
	}

	/**
	 * Generate inventory report by range
	 */
	
	public static function generateInventoryReport($from,$to,$stock_id){

			return $data = static::where('fposs_shipments.created_at', '>=',$from)
				->where('fposs_shipments.created_at','<=',$to)
				->where('fposs_shipments.stock_id','=',$stock_id)
				->leftJoin('fposs_ingredients','fposs_shipments.stock_id','=','fposs_ingredients.id')
				->get();

	
	}
}