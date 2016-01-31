<?php

use Carbon\Carbon;

class ItemSalesController extends \BaseController {

	protected $sale;

	function __construct(Sale $sale){

		$this->sale  = $sale;
	}

	/**
	 * Display a listing of the resource.
	 * GET /itemsales
	 *
	 * @return Response
	 */
	public function index()
	{
		$sales = $this->sale->today();
		 $total = $this->sale->getTotalOfTodaySales();
		return View::make('productsales.index')
				->with('title','Store Sales')
				->with('sales',$sales)
				->with('total',$total);
	}

	/**
	 * Get sales 
	 * GET /sales/retrieve
	 *
	 * @return Response
	 */
	public function getSales()
	{
		//get the type of sale
		$salestype = Input::get('type');

		switch ($salestype) {

			case 'yesterday':
				$this->sale->yesterdayTotal();
				return $this->getYesterdaySales();
				break;

			case 'thismonth':
				$this->sale->thisMonthTotal();
				return $this->getThisMonthSales();
				break;

			case 'thisweek':
				$this->sale->thisWeekTotal();
				return $this->getThisWeekSales();

				break;
			
			default:
				# code...
				break;
		}
		// return Response::json($sales);
	}

	/**
	 * Retrieve the yesterday's sales
	 * GET /sales/yesterday
	 *
	 * @return Response
	 */
	public function getYesterdaySales()
	{
		$total = $this->sale->yesterdayTotal();
		$sales = $this->sale->yesterday();
		return Response::json($sales);
	}

	/**
	 * Retrieve the this month sales
	 *
	 * @return Response
	 */
	public function getThisMonthSales()
	{
		$total = $this->sale->thisMonthTotal();
		$sales = $this->sale->thisMonth();
		return Response::json($sales);
	}

	/**
	 * Retrieve the this week sales
	 *
	 * @return Response
	 */
	public function getThisWeekSales()
	{
		$total = $this->sale->thisWeekTotal();
		$sales = $this->sale->thisWeek();
		return Response::json($sales);
	}


	/**
	 * Show the form for creating a new resource.
	 * GET /itemsales/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /itemsales
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /itemsales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($trans_id)
	{
		$sales = $this->sale->where('trans_id','=',$trans_id)->get();
		return 
			View::make('productsales.show')
			->with('sales',$sales)
			->with('title','Sales Detail - Receipt No.' . $trans_id);

	}

	/**
	 * Find a specific sale, ajax based
	 *
	 * @return Response
	 */
	public function find()
	{
		$trans_id = Input::get('inv_num');
		$sales = $this->sale->where('trans_id','=',$trans_id)
				->leftJoin('fposs_items','fposs_sales.item_id','=','fposs_items.id')
				->get();
		return $sales;
	}

}