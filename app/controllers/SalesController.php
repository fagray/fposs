<?php

class SalesController extends \BaseController {

	protected $sale;
	protected $item;
	protected $temp;
	protected $transaction;
	protected $production_item;
	private $inv_details;
	private $cashier;

	function __construct(Sale $sale,Item $item,TempCart $temp,
							Transaction $trans, ProductionItem $production_item){

		$this->temp = $temp;
		$this->sale = $sale;
		$this->item = $item;
		$this->transaction = $trans;
		$this->production_item = $production_item;
		$this->cashier = Auth::user()->username;
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /sales
	 *
	 * @return Response
	 */
	public function index()
	{
		// return Session::forget('trans_id');
		//generate the transaction id
		// return Session::forget('trans_id');
		if(!Session::has('trans_id') && $this->isCartEmpty() ) {

			$trans_id = $this->initTransaction(); 
			Session::put("trans_id", $trans_id);

		}else if(!$this->isCartEmpty()){

			//get the existing transaction id on the cart
			$temp = $this->temp->all()->first();
			$trans_id = $temp->trans_id;
			Session::put('trans_id',$trans_id);

		}
		
		//show the sales-register
		$customers = Customer::all();
		return View::make('registrar.index')
			->with('title','Sales Register')
			->with('customers',$customers);
		
	}

	/**
	 * Process the item on the Sales Order list.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function processOrder($code){

		// return print $code;exit();

		//find the item on the storage
		$found = $this->findItem($code);

		$in_production = false;

		$general_item = false;
		

		if($found){

			//cupcake category id 
			$cupcake_cat_id = Category::where('cat_name','=','Cupcake')->first()->id;

			if($this->item->getCategory($code) == $cupcake_cat_id ){

				//check if the item exist on the production items
				$production_items = $this->production_item->getCurrentProductionsBarcodes();

					if(in_array($code, $production_items)){

						$in_production = true;

						//check if  the item have enough stocks 
						if(!$this->haveEnoughStocks($code)){

							return Response::json(array('response' => '300','msg' => 'Not enough stocks.'));
						}

					}else{

						//not set for production
						return Response::json(array('response' => '300','msg' => 'Not set in production'));
					}
			}else{

				//item is not a cupcake
				//general item  / cookies
				$in_production = true;
				$general_item = true;
			}
		

			

			//check if the barcode exist on the cart
			$exist = $this->doExist($code);

			//get the item based on the barcode
			$item = $this->findItem($code);

			//if the product already exist, update its qty
			if($exist){

				//before updating qty, check first for the remaining stocks
				
				 $this->updateQty($code,$general_item);

			//check if the cupcake does  exist on the cart list
			}else if(!$exist){

				if($in_production ){

					
					$this->insertToTempCart($code,$item);

				}else{

					//not in production or out of stocks
					return Response::json(array('response' => '300'));
				}


				
			}
			 
			// $this->printInvoice();
			//retrieve cart items
			return $this->retrieveItems();	

			//print receipt
			 


		}

		//throw a not found exception
		return Response::json(array('found' => 'false'));

	}

	/**
	 * Check if the item have enough stock 
	 */
	
	public function haveEnoughStocks($code){

		//find the item id 
		$item_id = $this->item->findItemItemId($code);
		$obj = $this->production_item->getItemRemainingQty($item_id);

		if($obj->remaining < 1){

			return false;
		}

		return true;
	}

	/**
	 * Find a specific item.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function findItem($code){

		//find the item
		$count = $this->item->where('barcode','=',$code)->count();
		
		if($count != 0){

			// return true;
			return $this->item->where('barcode','=',$code)->get();
		}

		return false;

	}

	/**
	 * Insert to the temp cart storage.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function insertToTempCart($barcode,$item){

		$item_name = '';

		foreach($item as $val){

			$this->temp->barcode = $barcode;
			$this->temp->item_name = $val->name;
			$this->temp->trans_id = $this->retrieveTransactionId();
			$this->temp->item_id = $val->id;
			$this->temp->qty 	= 1;
			$this->temp->total = $val->price;
			$this->temp->price = $val->price;
			$this->temp->save();
			
		}

		TransactionLog::recordLog($this->retrieveTransactionId(),
			'Added new item. Item code : '. $barcode,$barcode,$item_name,$this->cashier);
		
		return true;
		

	}

	/**
	 * Check if the item exist on the cart
	 * GET sales/registrar
	 * 
	 * @return Response
	 */
	public function doExist($code){

		//check it
		$item = $this->temp->where('barcode','=',$code)->count();
		if($item != 0){

			return true;
		}

		return false;
	}

	/**
	 * Check if the cart is empty or not.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function isCartEmpty(){
		
		$count  = $this->temp->all()->count();

		if($count != 0){

			return false;
		}

		return true;
	}


	/**
	 * Update the qty if the item exist on the cart
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function updateQty($code,$general_item){

		//find the item on the storage.
		$item = $this->temp->where('barcode','=',$code)->first();

		
		//get the current qty
		$old_qty = $item->qty;

		//update the quantity
		$new_qty =  $old_qty += 1;

		if(!$general_item){
				//find the remaining qty
				$qty_on_hand = $this->production_item->getItemRemainingQty($item->item_id);

				if($qty_on_hand->remaining < $new_qty){

				//out of stocks
				return Response::json(['response' => '300','msg' => 'Not enough qty on the production.']);
			}

		}
		

		$item->qty = $new_qty;

		//solve for the total
		$item->total = $new_qty * $item->price;
		TransactionLog::recordLog($this->retrieveTransactionId(),
			'Updated item qty to '. $new_qty . '.Item code '.$code,$code,'',$this->cashier);
		return $item->save();

	}

	/**
	 * Retrieve all items on the temp cart.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function retrieveItems(){
	// 		$temp   = TempCart::all()->toArray();
	// $item = Item::where('barcode','=','900110023')->get()->toArray();

		// items on the tempcart's table
		return  $this->temp->all();


	}

	/**
	 * Initialize a new transaction.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function initTransaction(){

		$trans_id = $this->generateTransactionId();
		//no transaction id yet
		if(!$trans_id){

			//use the default transaction id
			$this->transaction->trans_id = $trans_id;
			$this->createTransaction();
			return true;
		}

		$this->transaction->trans_id = $trans_id;
		return $this->createTransaction();

		
	}

	/**
	 * Create a new transaction.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function createTransaction(){

		$this->transaction->cashier = Auth::user()->username;
		$this->transaction->terminal_ip  = Request::getClientIp();
		$this->transaction->save();
		return $this->transaction->trans_id;

	}

	/**
	 * Generate new transaction id.
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function generateTransactionId(){

		//count if there is an existing transaction stored.
		$id = $this->transaction->all()->count();

		if($id != 0){

			//grab the highest id on the table
			$max_id = DB::table('fposs_transactions')->max('trans_id');
			//increment it by 1
			$trans_id = $max_id + 1;
			//return the new transaction id
			return $trans_id;
		}

		return false;
	}

	/**
	 * Retrieve the transaction id
	 * GET /sales/registrar
	 *
	 * @return Response
	 */
	public function retrieveTransactionId(){

		//retrieve the transaction id on the Session storage.
		return Session::get('trans_id');
	}


	/**
	 * Purchasing process
	 * 
	 *
	 * @return Response
	 */
	public function purchase(){
		
		// return Input::all();
		//grab the item on the  temporary cart
		$temp_cart_items = $this->temp->all();
		$trans_id = Session::get('trans_id');
		$cust_id = Input::get('customer_id');
		$cashier = Input::get('cashier');
		$amount = Input::get('amount');
		$cash = Input::get('cash');
		$change = Input::get('change');
		$vat_amount = $amount * 0.12;

		// return $temp_cart_items[2]['item_id'];
		//save sold items
		$this->sale->saveSoldItems($temp_cart_items,$cust_id,$trans_id,
										$cashier,$amount,$cash,$change,$vat_amount);

		//update inventory
		 $this->updateInventory($temp_cart_items);

		 // store to the reports table
		 // $this->report->saveReportData($temp_cart_items);
		 // 
		 // //store the logs
		Audit::store(
						'Sales',
						'New purchase from a customer with an id of ' . $cust_id
					);
		TransactionLog::recordLog($trans_id,'Sale completed.Invoice # '.$trans_id,'','',$cashier);

		//complete the sale
		return $this->completeSale();

	}
	
	/**
	 * Completing sale.
	 * 
	 *
	 * @return Response
	 */
	public function completeSale(){

		//unset the transation id
		Session::forget('trans_id');

		//print receipt and pass the invoice details
		$inv_details = $this->retrieveItems();
		// $this->printInvoice($inv_details);

		Session::put('inv_details',$inv_details);

		// remove the items on the temporary cart
		$this->removeItemsFromTempCart();

	
		
	}

	/**
	 * Print invoice
	 * 
	 *
	 * @return Response
	 */
	public function printInvoice($trans_id){
		
		$inv_details = 
				Sale::selectRaw("fposs_items.name,fposs_sales.trans_id,fposs_sales.qty,fposs_sales.amount,
					fposs_items.price,fposs_sales.vat_amount,fposs_sales.cashier,
					fposs_sales.cash,fposs_sales.change,fposs_sales.qty,fposs_sales.created_at")
				->where('trans_id','=', $trans_id)
				->leftJoin('fposs_items','fposs_sales.item_id','=','fposs_items.id')
				->get();
		//return $inv_details;
		return  View::make('registrar.invoice')
				->with('inv_details',$inv_details);
			
				

	}




	public function removeItemsFromTempCart(){

		return $this->temp->removeItems();
	}

	public function removeCartItem(){

		$barcode = Input::get('barcode');
		$item =  $this->temp->where('barcode','=',$barcode)->first();
		
		TransactionLog::recordLog($this->retrieveTransactionId(),'Item has been removed from cart. Item code : '.$barcode,
					$barcode,$item->item_name,$this->cashier);

		$remove =  $this->temp->where('barcode','=',$item->barcode)->delete();
		
		return $this->retrieveItems();


	}


	/**
	 * Updating the inventory
	 * 
	 *
	 * @return Response
	 */
	public function updateInventory($temp_cart_items){

		$production_items  = $this->production_item->getCurrentProduction();
		
		// return $production_items;
		$new_qty = 0;

		foreach($production_items as $item){

			for($i = 0; $i < count($temp_cart_items); $i++ ){

				if($temp_cart_items[$i]['item_id'] == $item->item_id ){

					//update the qty if it is the same item
					$new_qty  = $item->remaining - $temp_cart_items[$i]['qty'];
					//update the item
					// return $new_qty;
					$prod_item =  $this->production_item->findOrFail($item->id);
					$prod_item->remaining = $new_qty;
					$prod_item->save();
				}

				// return "not equal";exit();
			}
		}

		// return true;

	}

	/**
	 * Update item qty on the temp cart
	 *
	 * @return Response
	 */
	public function updateNewQty(){

		$code = Input::get('barcode');

		$qty = Input::get('qty');
		//find the item
		$count = $this->temp->where('barcode','=',$code)->count();
		
		if($count != 0){

			// update its qty
			$item =  $this->temp->where('barcode','=',$code)->first();
			
			$item->qty =   $qty;
			$item->total = $qty * $item->price;
			$item->save();


			return array('response' => '200','msg' => 'Ok');
		}

		return array('response' => '300','msg' => 'Not found');

	}

	/**
	 * Void the current sale.
	 *
	 * @return Response
	 */
	public function void(){

		$trans_id = Input::get('trans_id');
		$items = $this->temp->where('trans_id','=',$trans_id)->get();

		TransactionLog::recordLog($trans_id,'Transaction voided.','','',$this->cashier);

		$this->sale->saveVoidedItems($items);
		//empty the temp cart
		$this->removeItemsFromTempCart();



		Session::forget('trans_id');
		//return the transaction id
		$trans_id = $this->initTransaction();
		Session::put('trans_id',$trans_id);

		

		return $trans_id;

	}

	public function generateReceipt(){

		$invoiceInfo =  ['customer' => 'Raymund Santillan','total' => 'Php 150.00'];
		return 
			PDF::loadView('registrar.invoice',$invoiceInfo)
				->setPaper('a6')
				->setOrientation('landscape')
				->setWarnings(false)
				->stream('myfile.pdf');

	}

	/**
	 * Find the item by its keyword
	 */
	
	public function autoSuggest(){

		// $data = $this->item->where('name','like',"$keyword%")->get();
		$data = $this->item->all();
		return Response::json($data);

	}

	/**
	 * Switch to returns mode
	 */
	
	public function returns(){

		//show the index page
		return View::make('registrar.returns.index')
				->with('title','Returns');
	}

	/**
	 * Process the returns
	 */

	public function processReturns($receipt_no){

		$data = $this->sale
				->selectRaw("
							fposs_items.name, fposs_items.barcode,fposs_sales.item_id,
							fposs_sales.created_at,
							fposs_sales.qty,fposs_customers.fname as fname,fposs_customers.lname as lname,fposs_customers.contact_num,
							fposs_sales.trans_id,fposs_items.price,fposs_sales.cash
							")
				->where('trans_id','=',$receipt_no)
				->leftJoin('fposs_items','fposs_sales.item_id','=','fposs_items.id')
				->leftJoin('fposs_customers','fposs_sales.customer_id','=','fposs_customers.id')
				->get();

		return $data;
	}

	/**
	 * Update item qty
	 */
	
	public function updateItemReturnQty($item_id,$receipt,$qty)
	{
		// return $qty;
		$sale_id = $this->sale->where('item_id','=',$item_id)
					->where('trans_id','=',$receipt)
					->first()->id;

		$sale_obj = $this->sale->findOrFail($sale_id);
		$item_price = Item::find($sale_obj->item_id)->first()->price;
		$sale_obj->qty = $qty;
		// $sale_obj->amount = $qty;
	
		$sale_obj->save();

		// $update = DB::table('fposs_sales')
		//             ->where('trans_id', $receipt)
		//             ->where('item_id', $item_id)
		//             ->update(array(
		//             				'qty' 		=> $qty,
		//             				'amount'	=> $qty
		//             		));

		return $this->processReturns($receipt);
	}

	/**
	 * Handle the updated return details
	 */
	
	public function updateReturns(){


		//run an update query, update the cash tendered
		$trans_id = Input::get('trans_id');
		$cash = Input::get('cash');
		 $total = Input::get('amount');
		$vat = Input::get('vat');

		$sales = $this->sale->where('trans_id','=',$trans_id)->get();
	//	$num_of_items = count($sales);

		foreach($sales as $sale){

			$sale->amount = $total;
			$sale->cash = $cash;
			$sale->change = $cash - $total;
			$sale->vat_amount = $vat;
			$sale->save();
		}

		//return Input::all();
	}

	/**
	 * Remove item from the returns
	 */
	
	public function removeReturnedItem($item_id,$receipt_no){

		$sale = $this->sale->where('item_id','=',$item_id)
				->where('trans_id','=',$receipt_no)
				->delete();
				
		return Response::json(['response' => '200','msg' => 'Remove from sales']);

	}

	/**
	 * Void the returns
	 */
	
	public function voidReturns($receipt_no){

		$update = DB::table('fposs_sales')
		            ->where('trans_id', $receipt_no)
		            ->update(array(
		            				'status'	=> '2'
		            		));

	}



}