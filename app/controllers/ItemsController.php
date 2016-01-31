<?php

class ItemsController extends \BaseController {

	protected  $items;
	protected  $item_ingredient;
	protected $ingredient;
	protected $category;



	function __construct(Item $item,ItemIngredient $item_ingredient,
							Ingredient $ingredient,Category $category){

		//dependencies
		$this->items  = $item;
		$this->item_ingredient = $item_ingredient;
		$this->category = $category;
		$this->ingredient = $ingredient;

	}
	/**
	 * Display a listing of the resource.
	 * GET /items
	 *
	 * @return Response
	 */
	public function index()
	{
		$items =  $this->items->all();
		$categories = $this->category->all();
		// return $items;
		return View::make('items.index')
			->with('title','Store Items')
			->with('items',$items)
			->with('categories',$categories);

		//return Response::json($this->items->all());
	}

	public function getJSONItems(){

		return $this->items->all();
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /items/create
	 *
	 * @return Response
	 */
	public function create()
	{	
		$cat_ids = $this->category->lists('cat_name','id');
		$categories = $this->category->lists('cat_name');
		$ingredients = $this->ingredient->all();
		return View::make('items.new',compact('cat_ids'))
			->with('title','New Item')
			->with('ingredients',$ingredients)
			->with('categories',$categories);

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /items
	 *
	 * @return Response
	 */
	public function store()
	{	
		// return count(Input::get('ing_id'));
		// return Input::all();
		//validate the form
		$validator = Validator::make(Input::all(),Item::$rules);

		if($validator->fails()){

			return
				Redirect::back()->withInput()->with('flash_message','Please Fill in all the fields')
					->with('flash_type','alert-danger');
		}

		//create an item
		$data = $this->items->create(Input::all());

		//get the last id
		$id =  $data->id;

		//store the item barcode
		$barcode = $this->generateBarcode($id);
		$item = $this->items->find($id);
		$item->barcode = $barcode;
		$item->save();

		if(count(Input::get('ing_id')) != 0){

			//save to the pivot table, not a general item
		
			$save = $this->item_ingredient->saveItemIngredients(Input::get('ing_id'),$id,Input::get('ing_amount'));

		}

		$items = $this->items->all();
		
		//redirect to the main page

		return Redirect::to('/items/')
			->with([

				'title' 		=> 	'Store Items',
				'items'			=> 	$items,
				'flash_message'	=> 	'Item created successfully.',
				'flash_type'	=>	'alert-success'

			]);

	}

	
	/**
	 * Display the specified resource.
	 * GET /items/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//general cateogory id
		$general_cat = Category::where('cat_name','=','General')->first()->id;
		
		//find the item and pass the credentials into the view
		$item = $this->items->findOrFail($id);

		$materials = null;
		$ingredients = null;

		if($item->category_id != $general_cat){

			$materials = $item->ingredients()->get();
			$ingredients = $this->ingredient->all();

		}
	
		return 	
				View::make('items.profile')
					->with('title',$item->name.' | Flibbys Point of Sale  ')
					->with('item',$item)
					->with('ingredients',$ingredients)
					->with('materials',$materials);
				

	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /items/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//show the edit form
		$item = $this->items->findOrFail($id);
		$cat_ids = $this->category->lists('cat_name','id');
		$categories = $this->category->lists('cat_name');
		return View::make('items.edit',compact('cat_ids'))
			->with('title','New Item')
			->with('categories',$categories)
			->with('item',$item);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /items/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$item = $this->items->findOrFail($id);
		$item->fill(Input::all());
		$item->save();
		$items = $this->items->all();
		
		return Redirect::to('/items/')
			->with([

				'title' 		=> 	'Store Items',
				'items'			=> 	$items,
				'flash_message'	=> 	'Item updated successfully.',
				'flash_type'	=>	'alert-success'

			]);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /items/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//delete the specific item
		$item = $this->items->findOrFail($id);
		$item->delete();
		return Redirect::to('/items')
			->with('title','Store Items');
	}

	
	/**
	 * Update the specified item in the storage
	 * GET /items/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRawMaterial()
	{

		$ing_ids = Input::get('ing_ids');
		// return $ing_ids;
		$id = Input::get('item_id');

		//delete the last ingredients
		$this->item_ingredient->removeItemIngredients($id);

		//add the new ingredient
		$this->item_ingredient->saveItemIngredients($ing_ids,$id,null);

		$item = $this->items->findOrFail($id);
		$materials = $item->ingredients()->get();
		$ingredients = $this->ingredient->all();
		return 
			Redirect::back()
					->with('title',$item->name.' | Flibbys Point of Sale  ')
					->with('item',$item)
					->with('flash_message','Changes has been saved.')
					->with('flash_type','alert alert-success')
					->with('ingredients',$ingredients)
					->with('materials',$materials);
	}

	/**
	 * Generating product barcode
	 * GET /items/{id}
	 *
	 * @return Response
	 */
	public function getBarcode($item_id)
	{
		//accept the last inserted id as an argument
		//show the form for barcode generation
		
		$barcode = $this->generateBarcode($item_id);
		return 
			View::make('items.barcode-generation')
			->with('code',$barcodes)
			->with('title','Item No.'. $item_id . '| Barcode Generation');
			

	}

	/**
	 * Generating product barcode
	 *
	 * @return barcode
	 */
	public function generateBarcode($item_id)
	{
		//accept the last inserted id as an argument
		$rand = rand(999,999);
		$item = $this->items->find($item_id);
		$cat_id =  $item->category->id;
		$barcode =  $cat_id.''. $item_id.''.$rand;
		return $barcode;
			

	}

	/**
	 * Exporting product barcodes
	 *
	 * @return barcodes
	 */
	public function exportBarcodes(){

		$items = $this->items->all();
		return View::make('items.barcodes')
			->with('items',$items);

	}

	/**
	 * Show conversion units
	 *
	 */
	public function indexUnits(){

		
		return View::make('items.units.index')
				->with('title','Conversion Units  | FPOSS ');

	}

	/**
	 * Get product sales
	 *
	 */
	public function getItemSales($item_id){

		$sales = Sale::getItemSales($item_id);
		return $sales;

	}

	/**
	 * Find item by name
	 */
	
	public function findByName($name){

		$data = $this->items->where('name','=',$name)->first()->barcode;

		return Response::json($data);

	}









}