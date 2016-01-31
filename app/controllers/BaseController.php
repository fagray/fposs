<?php

class BaseController extends Controller {

	protected $production_item;

	function __construct(ProductionItem $production_item){

		$this->production_item = $production_item;

	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Return the list of items on the main page
	 *
	 * @return items
	 */
	protected function index()
	{
		//enabled Voice Command by default
		Session::put('VC','enabled');
		//get the first  most recent 10 logs
		$logs = Audit::orderBy('id','desc')->take(10)->get();

		$low_stocks = Ingredient::selectRaw("fposs_ingredients.name,fposs_suppliers.name as supp,
					fposs_suppliers.resource_person,fposs_ingredients.stocks,
					fposs_ingredients.alert_level,fposs_ingredients.shipment_unit")
					
					->where('stocks','<=','alert_level')
					->leftJoin('fposs_suppliers','fposs_ingredients.supplier_id','=','fposs_suppliers.id')
					->get();

		// $low_stocks = DB::table('fposs_ingredients')->where('stocks', '<', 'alert_level')->count();
		
	
		$items = $this->production_item->getCurrentProduction();
		return View::make('index')
			->with('title',"Flibbys Point of Sale System")
			->with('items',$items)
			->with('ingredients',$low_stocks)
			->with('logs',$logs);

	}

}
