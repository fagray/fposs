<?php

class SuppliersController extends \BaseController {

	protected $category,$supplier;

	function __construct(Category $category,Supplier $supplier){

		$this->category = $category;
		$this->supplier = $supplier;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//show all resource
		$suppliers  = $this->supplier->all();
		return View::make('suppliers.index')
			->with('title','Store Suppliers')
			->with('suppliers',$suppliers);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$categories = $this->category->lists('id','cat_name');
		return View::make('suppliers.new')
			->with('title','New Vendor')
			->with('categories',compact('categories'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//save the data from the form
		$save = $this->supplier->create(Input::all());
		//redirect back to main page
		$suppliers = $this->supplier->all();
		return 
				Redirect::to('/suppliers')
					->with([
								'title' => 'Vendors',
								'flash_message' => 'Vendor has been created.',
								'flash_type'	=> 'alert-success',
								'suppliers'		=> $suppliers
					]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$supplier = $this->supplier->getSupplierAllDetails($id);
		return View::make('suppliers.show')
				->with('title',' |  Supplier Details ')
				->with('supplier',$supplier);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//show the form
		$supplier = $this->supplier->findOrFail($id)->first();
		return View::make('suppliers.edit')
				->with('title','Update Supplier')
				->with('supplier',$supplier);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//update the entry
		$supplier = $this->supplier->findOrFail($id);
		$supplier->fill(Input::all());
		$supplier->save();
		$suppliers  = $this->supplier->all();
		return 
				Redirect::to('/suppliers')
					->with([
								'title' => 'Vendors',
								'flash_message' => 'Vendor has been updated.',
								'flash_type'	=> 'alert-success',
								'suppliers'		=> $suppliers
					]);
		// $supplier->update();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//remove supplier
		$supplier = $this->supplier->findOrFail($id);
		$supplier->delete();

		$suppliers  = $this->supplier->all();
		return 
				Redirect::to('/suppliers')
					->with([
								'title' => 'Vendors',
								'flash_message' => 'Vendor has been removed.',
								'flash_type'	=> 'alert-success',
								'suppliers'		=> $suppliers
					]);
	}


}
