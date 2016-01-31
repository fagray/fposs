<?php

class ReportsController extends \BaseController {

	protected $sale;
	protected $item;

	function __construct(Sale $sale,Item $item){

		$this->sale = $sale;
		$this->item = $item;

	}
	
	/**
	 * Display a listing of the resource.
	 * GET /reports
	 *
	 * @return Response
	 */
	public function index()
	{
		// return Carbon\Carbon::createFromDate(2015,21,22)->addYears(9);
		 $sales_per_month =  $this->sale->salesPerMonth();
		// return $sales_per_month;
		$items =  $this->sale->topThreebestSellersName();
		$amounts = $this->sale->topThreebestSellersAmount();
		$items_by_sales = $this->sale->getItemsBySales();

	
		$data =  $this->sale->bestSellersThisWeek();
		//get all the cashiers
		$cashiers = User::lists('username','username');
		$ingredients = Ingredient::lists('name','id');
		// return $data;
		return View::make('reports.reports')
			->with('title','Reports Module')
			->with('sales',$sales_per_month)
			->with('items',$items)
			->with('amounts',$amounts)
			->with('sales_items',$items_by_sales)
			->with('cashiers',$cashiers)
			->with('ingredients',$ingredients);
			// ->with('amount',$amount);
			// ->with('value',$amount);
	}

	/**
	 * Capture the chart value
	 * GET /reports/charts/bestsellers/value
	 *
	 * @return Response
	 */
	public function getBarChartJSONData($value)
	{
		switch ($value) {

			case 'name':

				return $this->sale->topThreebestSellersName();

				break;

			case 'amounts':

				return json_encode($this->sale->topThreebestSellersAmount(),JSON_NUMERICK_CHECK);

				break;
			
			
			default:
				# code...
				break;
		}
	}

	/**
	 * Generate sales report by range
	 *
	 */
	
	public static function generateSalesByRange(){

		$from 	= 	Input::get('from') .' 00:00:00';
		$to 	= 	Input::get('to') .' 23:59:59';
		$by 	= 	Input::get('cashier');
		// $to = '2015-09-01 16:07:39';
		$data = Sale::generateByRange($from,$to,$by);
		return $data;


	}

	/**
	 * Generate inventory reports by range
	 */
	
	public function generateInventoryReportsByRange(){

		$from 	= 	Input::get('from');
		$to 	= 	Input::get('to');
		$stock_id = Input::get('stock');
		$data =  Shipment::generateInventoryReport($from,$to,$stock_id);
		return $data;

	}

	
}