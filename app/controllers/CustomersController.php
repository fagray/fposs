<?php

class CustomersController extends \BaseController {

	protected $customer;

	function __construct(Customer $customer){

		$this->customer = $customer;
	}

	/**
	 * Display a listing of the resource.
	 * GET /customers
	 *
	 * @return Response
	 */
	public function index()
	{
		//show the index page
		//with the list of the customers

		$customers = $this->customer->all();
		return View::make('customers.index')
			->with('title','Store Customers')
			->with('customers',$customers);
	}


	/**
	 * Store a newly created resource in storage.
	 * POST /customers
	 *
	 * @return Response
	 */
	public function store()
	{
		//save it
		$save = $this->customer->create(Input::all());
		//grab the customers data
		$customers = $this->customer->all();

		//store the logs
		Audit::store(
						'Customers',
						'Added new customer with an id of ' .$save->id
					);
						
		return 
			Redirect::to('/customers')	
				->with([

						'title'			=> 	'Store Customers',
						'customers'		=> 	$customers,
						'flash_message'	=> 'Customer has been created.',
						'flash_type'	=> 'alert-success'
				]);
	}

	/**
	 * Display the specified resource.
	 * GET /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//find the customer
		$customer = $this->customer->findOrFail($id);
		
		return View::make('customers.edit')
			->with('title','Update Customer')
			->with('customer',$customer);
			
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /customers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//find the customer and send it back to the view
		// return $id;
		$customer = $this->customer->findOrFail($id);
		return $customer;
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// return Input::get('name');
		//save the form
		$customer = $this->customer->findOrFail($id);
		//fill the data
		$customer->fill(Input::all());
		$customer->save();

		//get the customers list and send it tot the index view
		// $customers = $this->customers->all();

		
		return Redirect::to('/customers/'.$id.'/profile')
				->with('title','Customer Profile | '.$customer->fname)
				->with('customer',$customer)
				->with('flash_message','Customer has been updated.')
				->with('flash_type','alert alert-success');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//soft delete the customer
	}

	/**
	 * Customers Profile
	 */
	
	public function profile($id){
		
		$customer = $this->customer->findOrFail($id);
		$total_amount_purchased = $this->customer->getTotalAmountPurchased($customer->id);
		$invoices = Sale::where('customer_id','=',$customer->id)->groupBy('trans_id')->get();
		return View::make('customers.profile')
			->with('title','Customer Profile | '. $customer->fname )
			->with('customer',$customer)
			->with('total',$total_amount_purchased)
			->with('invoices',$invoices);

	}

}