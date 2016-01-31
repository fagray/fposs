<?php

use Carbon\Carbon;

class Sale extends \Eloquent {

	
	protected $table = "fposs_sales";
	protected $fillable = ['trans_id','status','customer_id','item_id','qty','cashier','amount','cash','change','vat','vat_amount'];

	/**
	 * Store sold items
	 *
	 * @param $item_id
	 * @param $transaction_id
     */
	public  function saveSoldItems($temp_cart_items,$cust_id,$trans_id,
										$cashier,$amount,$cash,$change,$vat_amount){

		//counter
		$i = 0;

		//insert to the database
		foreach($temp_cart_items as $item){

			DB::table($this->table)->insert([

				'trans_id'			=> $item->trans_id,
				'customer_id'		=> $cust_id,
				'item_id'			=> $item->item_id,
				'qty'				=> $item->qty,
				'cashier'			=> $cashier,
				'amount'			=> $amount,
				'cash'				=> $cash,
				'change'			=> $change,
				'vat'				=> 12,
				'vat_amount'		=> $vat_amount,
				'created_at'		=> Carbon::now(),
				'updated_at'		=> Carbon::now()	

			]);

			

			// $i++;
		}

	}

	/**
	 * Store voided items
	 * 
     */
	public  function saveVoidedItems($items){

		//counter
		$i = 0;
		$cashier = Auth::user()->username;

		//insert to the database
		foreach($items as $item){

			DB::table($this->table)->insert([

				'trans_id'			=> $item->trans_id,
				'customer_id'		=> 13,
				'item_id'			=> $item->item_id,
				'qty'				=> $item->qty,
				'cashier'			=> $cashier,
				'amount'			=> $item->total,
				'cash'				=> 0,
				'change'			=> 0,
				'created_at'		=> Carbon::now(),
				'updated_at'		=> Carbon::now(),
				'status'			=> '2'

			]);

			$i++;
		}

	}


	

	public function today(){

		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::now()->startOfDay())
					 ->where('created_at','<=',Carbon::now()->endOfDay())
					 ->where('status','=','1')
					 ->groupBy('trans_id')
                     ->get();
        return $sales;             

	}

	/**
	 * Get today's sales
	 *
     */

	public function getTotalOfTodaySales(){

		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::now()->startOfDay())
					 ->where('created_at','<=',Carbon::now()->endOfDay())
					 ->where('status','=','1')
					 ->groupBy('trans_id')
					 ->get();
		$total = 0;

		foreach($sales as $sale){

			$total += $sale->amount;
		}

                    

        return $total;      

	}

	/**
	 * Get yesterday's sales
	 *
     */
	public function yesterday(){

		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::yesterday()->startOfDay())
					 ->where('created_at','<=',Carbon::yesterday()->endOfDay())
					 ->where('status','=','1')
                	 ->groupBy('trans_id')
                     ->get();
        $sales = array_merge($sales,$this->yesterdayTotal());
        return $sales;

	}

	/**
	 * Get total of yesterday's sales
	 *
     */
	public function yesterdayTotal(){

		$total = 0;
		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::yesterday()->startOfDay())
					 ->where('created_at','<=',Carbon::yesterday()->endOfDay())
					 ->where('status','=','1')
                     ->groupBy('trans_id')
                     ->get();
      
		foreach($sales as $sale){

			$total += $sale->amount;
		}

                    

        return array('total' => $total); 

	}

	/**
	 * Get total of this monthsales
	 *
     */
	public function thisMonthTotal(){

		$total = 0;
		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::yesterday()->startOfMonth())
					 ->where('created_at','<=',Carbon::yesterday()->endOfMonth())
					 ->where('status','=','1')
                     ->groupBy('trans_id')
                     ->get();

       foreach($sales as $sale){

			$total += $sale->amount;
		}


        return array('total' => $total); 
       
	}


	/**
	 * Get this month sales
	 *
     */
	public function thisMonth(){

		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::now()->startOfMonth())
					 ->where('created_at','<=',Carbon::now()->endOfMonth())
					 ->where('status','=','1')
                     ->groupBy('trans_id')
                     ->get();
        $sales = array_merge($sales,$this->thisMonthTotal());
        return $sales;

	}

	/**
	 * Get this week total sales
	 *
     */
	public function thisWeekTotal(){

		$total = 0;
		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::now()->startOfWeek())
					 ->where('created_at','<=',Carbon::now()->endOfWeek())
					 ->where('status','=','1')
                     ->groupBy('trans_id')
                     ->get();

        foreach($sales as $sale){

			$total += $sale->amount;
		}
             
                     
       return array('total' => $total);

	}

	/**
	 * Get this week sales
	 *
     */
	public function thisWeek(){

		$sales = DB::table($this->table)
                     ->where('created_at', '>=',Carbon::now()->startOfWeek())
					 ->where('created_at','<=',Carbon::now()->endOfWeek())
					 ->where('status','=','1')
                     ->groupBy('trans_id')
                     ->get();
        $sales = array_merge($sales,$this->thisWeekTotal());
        return $sales;

	}

	/**
	 * Get top 5 best seller products this week
	 *
     */
	public function bestSellersThisWeek(){

		$data =  DB::table($this->table)
                     ->where('fposs_sales.created_at', '>=',Carbon::now()->startOfWeek())
					 ->where('fposs_sales.created_at','<=',Carbon::now()->endOfWeek())
					 ->where('fposs_sales.status','=','1')
                     ->groupBy('fposs_sales.trans_id')
                     ->orderBy('fposs_sales.amount','ASC')
                     ->take(1)
                     ->leftJoin('fposs_items','fposs_sales.item_id','=','fposs_items.id')
                     ->get();
        return $data;
		// return Response::json($data);

	}

	/**
	 * Get the sales per month
	 *
     */
	public function salesPerMonth(){

		$dates = array(
						'2015-01',
						'2015-02',
						'2015-03',
						'2015-04',
						'2015-05',
						'2015-06',
						'2015-07',
						'2015-08',
						'2015-09',
						'2015-10',
						'2015-11',
						'2015-12'
					);
		
		$data = DB::table('fposs_sales')
				->groupBy('created_at')
				->get();

		$sales = array();
		$sale = 0;

		// $d = '2015-01-01 21:56:16';

		// return substr($d, 0,7);

		foreach ($data as $value) {

			for( $i = 0; $i < count($dates); $i++ ){

				if(substr($value->created_at,0,7) == $dates[$i]){

					//add the amount
					$sale += $value->amount;
					$sales[$i] = $sale;

				}

				

			}
			

			
		}

    	return $sales;
    }

    /**
	 * Get the sales per item
	 *
     */
	public function topThreebestSellersAmount(){

		
		$amount = $this->getColumnList('total_sales');
		// $data = 
	
        return $amount;
	}

	public function topThreebestSellersName(){

		return $items = $this->getColumnList('item');
	}

	

	public function getColumnList($list_column){

		$cupake_id = Category::where('cat_name','=','Cupcake')->first()->id;
		$data = DB::table('fposs_sales')
			->selectRaw('fposs_items.name as item, sum(amount)  as total_sales')
			->where('fposs_items.category_id','=',$cupake_id)
		    ->groupBy('item_id')
		    ->take(3)
		    ->leftJoin('fposs_items','fposs_sales.item_id','=','fposs_items.id')
		    ->orderBy('total_sales','desc')
		    ->lists($list_column);


		return $data;    
	}

	/**
	 * Get BEST Sellers for yesterday's production
	 *
     */
	
	public function getYesterdaysBestSeller(){

		$data =  DB::table($this->table)
				 ->selectRaw('fposs_items.name , sum(amount)  as amount')
                 ->where('fposs_sales.created_at', '>=',Carbon::yesterday()->startOfDay())
				 ->where('fposs_sales.created_at','<=',Carbon::yesterday()->endOfDay())
                 ->groupBy('fposs_sales.item_id')
                 ->orderBy('fposs_sales.amount','DESC')
                 ->take(3)
                 ->leftJoin('fposs_items','fposs_sales.item_id','=','fposs_items.id')
                 ->get();
        return $data;

	}


	// sales per item
	public function getItemSales($item_id){

		$sales = DB::table($this->table)
			->where('item_id','=',$item_id)
			->sum('amount');
			
		return $sales;
	}

	/*/ Getting all items sorted by their sales */
	public function getItemsBySales(){

		$cupake_id = Category::where('cat_name','=','Cupcake')->first()->id;
		$data = DB::table($this->table)
			->selectRaw('fposs_items.name,fposs_items.description, sum(amount)  as total_sales')
			->where('fposs_items.category_id','=',$cupake_id)
		    ->groupBy('item_id')
		    ->leftJoin('fposs_items','fposs_sales.item_id','=','fposs_items.id')
		    ->orderBy('total_sales','desc')
		    ->take(5)
		    ->get();

		return $data; 
	}

	/**
	 * Generate sales report by range
	 */
	
	public static function generateByRange($from,$to,$by){

		if($by == 'All'){
			
			return $data = static::where('fposs_sales.created_at','>=',$from)
			->where('fposs_sales.created_at','<=',$to)
			
			->groupBy('trans_id')
			->get();
		}

		return $data = static::where('fposs_sales.created_at','>=',$from)
			->where('fposs_sales.created_at','<=',$to)
			->where('cashier','=',$by)
			->groupBy('trans_id')
			->get();

		
	}
	
}