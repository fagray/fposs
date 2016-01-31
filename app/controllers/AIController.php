<?php

class AIController extends \BaseController {

	protected $sale;

	function __construct(Sale $sale){

		$this->sale = $sale;
	}

	/**
	 * Getting the yesterdays best seller
	 * GET /ai/production/best-sellers/yesterday
	 *
	 * @return Response
	 */
	public function bestSellerYesterday()
	{	
		//retrieve the data
		$best_sellers = $this->sale->getYesterdaysBestSeller();
		return Response::json($best_sellers);
	}

	/**
	 * Determine the option set by the user
	 */
	
	public function setOption($option){

		if($option == 'enable'){

			return $this->enableVC();
		}

		return $this->diasbleVC();
	}

	/**
	 * Disable the speaking secretary on the system
	 */
	
	public function diasbleVC(){

		return Session::put('VC','disabled');
	}

	/**
	 * Enable the speaking secretary on the system
	 */
	
	public function enableVC(){

		return Session::put('VC','enabled');
	}

	
}