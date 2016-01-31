<?php

class CategoriesController extends \BaseController {

	protected  $category;
	function __construct(Category $category){

		$this->category  = $category;

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$categories = $this->category->all();
		// return Response::json($categories);
		return View::make('categories.index')
			->with('title','Categories')
			->with('categories',$categories);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$save = $this->category->create(Input::all());

		//store the logs
		Audit::store(
						'Settings',
						'Added a new category with an id of ' .$save->id
					);

		return Redirect::to('/categories')
			->with([

				'flash_message' 	=>  'Category has been saved.',
				'flash_type'		=> 	'alert-success',
				'title'				=> 	'Category list',
				'categories'		=> 	$this->category->all()
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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
