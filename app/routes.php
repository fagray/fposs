<?php
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/* Sample routes */

Route::get('fuck',function(){

	return (new ProductionItem)->getUnsoldItems();
	return Carbon::now()->addDays(2);

	return	$item = ProductionItem::
					where('production_id','=','215')
					->where('item_id','=','10037')
					->where('status','=',"pending")->first()->id;


	return ReportsController::generateSalesByRange();
	return View::make('hello');
	
	return Auth::user()->username;
	return PDF::loadView('items.barcodes')->setPaper('a6')
		->setOrientation('landscape')
		->setWarnings(false)
		->stream('barcodes.pdf');
});

Route::get('tt',function(){

	return Session::get('REGISTER');
	$item = Item::all();
	return PDF::loadView('items.barcodes')->setPaper('a6')
		->setOrientation('landscape')
		->setWarnings(false)
		->stream('barcodes.pdf');


	$prod = new ProductionItem();
	$pending = $prod->getPendingItems();
	$prod_items = $prod->getCurrentProductionsItemId();

	// return $pending[0]->remaining;

	foreach($pending as $item ){

		print $item->item_id . " ";

		if(in_array($item->item_id,$prod_items)){

			return "pending";exit();
		}

		return "not pending";exit();

		

	}

	
	


	$invoiceInfo =  ['customer' => 'Raymund Santillan','total' => 'Php 150.00'];
	PDF::loadView('registrar.invoice',$invoiceInfo)->setPaper('a6')
		->setOrientation('landscape')
		->setWarnings(false)
		->stream('myfile.pdf');

	$invoiceInfo =  ['customer' => 'Raymund Santillan','total' => 'Php 150.00'];
	$invoice = PDF::loadView('registrar.invoice',$invoiceInfo);
    return $invoice->download();

	// $pdf = App::make('dompdf');
	// $pdf->loadHTML('<h1>Tesasdasdasddast</h1>');
	// return $pdf->setPaper(array(0,0,161.57,229.61))->stream();

	return (new ProductionItem)->getCurrentProduction();
	return (new Sale)->getItemSales(10036);
		return (new ProductionIngredient)->getUsedIngredientsToday();
	return rand(1000,9999);
	// return $date = Carbon::create(2015,02,03)->startOfDay();
	return (new Sale)->salesPerMonth();
	print $date = '2015-02-03'  . ' <Br>';

	return substr($date, 8,2);
	// return Carbon::yesterday()->endOfDay();

	// return (new Sale)->getYesterdaysBestSeller();
	// return Carbon::create(2015,2,3,0)->startOfDay();
	// return Carbon::create(2015-08-26 23:06:20)->endOfDay();

	// return $prod->getCurrentProduction()->toArray();



	return Auth::user()->role;
	if(Auth::attempt(array('password' => 'raymund123'))){

		return 'true';

	}else{

		return 'false';
	}


	// return 10 + -10;
	// return Item::find(1)->cart;
	
	$temp   = TempCart::all()->toArray();
	$item = Item::where('barcode','=','900110023')->get()->toArray();
	// return TempCart::all();		
	return json_encode(array_merge($temp,$item));

	return  DNS1D::getBarcodeHTML('123456789', "EAN13",2,60);
	$production = Production::find(2);
	return $production->items;
	
});

	Route::get('test/{trans_id}',['uses' => 'SalesController@printInvoice']);

		
		

	Route::get('sample/{code}',['uses' => 'SalesController@processOrder']);


	Route::get('/item/findbyname/{name}',['uses' => 'ItemsController@findByName']);

	


	Route::group(array('before' => 'auth'),function(){

	Route::get('/',['as' => 'home','uses' => 'BaseController@index']);
	
	// Route::get('/',function(){

	// 	return View::make('index')
	// 		->with('title',"Flibbys Point of Sale System");
	// });

	/* Inventory Routes */
	Route::get('/inventory/',['uses' => 'InventoryController@index']);
	Route::get('/inventory/stocks/{stockid}/edit',['as' => 'stock.edit','uses' => 'IngredientsController@edit']);
	Route::put('/inventory/stocks/{stockid}/update',['as' => 'stock.update','uses' => 'IngredientsController@update']);
	Route::get('/inventory/stocks/create',['uses' => 'IngredientsController@create']);
	Route::post('/inventory/stocks/create',['uses' => 'IngredientsController@store']);
	Route::post('/inventory/stocks/{stock_id}/restock',['as' => 'inventory.restock','uses' => 'InventoryController@restock']);
	Route::get('/inventory/stocks/check',['uses' => 'InventoryController@checkInventoryLevel']);
	Route::get('/inventory/stocks/{id}/units',['uses' => 'InventoryController@showUnitTypes']);
	Route::get('/inventory/stocks/{id}/show',['uses' => 'IngredientsController@show']);
	

	/* Transaction Routes */
	Route::get('/transactions/shipments',['as' => 'shipment','uses' => 'ShipmentsController@index']);
	Route::get('/transactions/shipments/create',['as' => 'shipment','uses' => 'ShipmentsController@create']);
	Route::post('/transactions/shipments/create',['as' => 'shipments.store','uses' => 'ShipmentsController@store']);
	Route::get('/stocks/units/{stockid}',['uses' => 'IngredientsController@getUnit']);
	Route::get('/stocks/suppliers/{stockid}',['uses' => 'IngredientsController@getSupplier']);

	/* Production Routes */
	

	/* Registrar Routes */

	Route::get('/sales/registrar',['as' => 'registrar','before' => 'isRegisterOpen','uses' => 'SalesController@index']);
	Route::get('/sales/registrar/void',['uses' => 'SalesController@void']);
	Route::get('/sales/registrar/receipt/print',['uses' => 'SalesController@printInvoice']);
	Route::get('/sales/registrar/mode/returns',['uses' => 'SalesController@returns']);
	Route::get('/sales/registrar/mode/returns/{receipt}/void',['uses' => 'SalesController@voidReturns']);
	Route::get('/sales/registrar/mode/returns/{receipt_id}/items/{item_id}/',['uses' => 'SalesController@removeReturnedItem']);
	Route::get('/sales/registrar/mode/returns/update',['as' => 'registrar.return','uses' => 'SalesController@updateReturns']);
	Route::get('/sales/registrar/mode/returns/{receipt_no}',['uses' => 'SalesController@processReturns']);
	Route::get('/sales/registrar/mode/returns/items/{item_id}/receipt/{receipt_no}/{qty}/',['uses' => 'SalesController@updateItemReturnQty']);
	// Route::get('/sales/registrar',['as' => 'registrar','uses' => 'SalesController@index']);
	// Route::get('/sales/registrar/payment',['as' => 'registrar.complete','uses' => 'SalesController@index']);
	
	Route::get('/sales/registrar/payment/',['as' => 'registrar.purchase','uses' => 'SalesController@purchase']);
	Route::get('/sales/registrar/cart/items/quantity/update',['uses' => 'SalesController@updateNewQty']);

	Route::get('/sales',function(){
		return Redirect::route('registrar');
	});

	/* Product sales */
	Route::get('/store/items/sales',['as' => 'sales.index','uses' => 'ItemSalesController@index']);
	Route::get('/store/items/sales/{tran_id}/',['as' => 'sales.view','uses' => 'ItemSalesController@show']);
	Route::get('/sales/retrieve/',['uses' => 'ItemSalesController@getSales']);
	Route::get('/sales/search/',['uses' => 'ItemSalesController@find']);
	
	Route::get('/cart/items/remove',['uses' => 'SalesController@removeCartItem']);

	Route::get('/cart/items/',['as' => 'cart','uses' => 'SalesController@retrieveItems']);
	Route::get('/cart/items/find/all/',['uses' => 'SalesController@autoSuggest']);
	




	/* Reports Routes */
	Route::get('reports',['as ' => 'reports','uses' => 'ReportsController@index']);

	Route::get('/reports/sales/generate/range',['uses' => 'ReportsController@generateSalesByRange']);
	Route::get('/reports/inventory/generate/range',['uses' => 'ReportsController@generateInventoryReportsByRange']);
	/*  Controller */
	Route::get('/settings/store/setup/{option}',['uses' => 'SettingsController@storeSetup']);


	
	Route::get('/settings',['as' => 'settings', 'uses' => 'SettingsController@index']);
	Route::get('/settings/units/new',['as' => 'settings', 'uses' => 'SettingsController@addNewUnit']);
	Route::get('/items/units/find/{keyword}',['uses' => 'SettingsController@searchItemProductionUnits']);
	Route::get('/items/units/store/',['as' => 'settings.storeProdUnits','uses' => 'SettingsController@storeProductionUnits']);
	Route::get('/items/ingredients/{ing_id}/units/{unit_id}/remove/',['uses' => 'SettingsController@removeUnit']);
	Route::post('/items/units/update',['as' => 'settings.updateUnits','uses' => 'SettingsController@updateProductionUnits']);

	/* Production Routes */
	Route::get('/items/productions',['as' => 'productions','before' => 'isProductionOpen','uses' => 'ProductionController@index']);
	Route::get('/items/productions/produce',['as' => 'productions.produce','before' => 'checkProductionsList','uses' => 'ProductionController@produce']);
	Route::post('/items/productions/produce',[ 'uses' => 'ProductionController@store']);
	
	Route::get('/items/productions/produce/billing/',['as' => 'productions.billing','before' =>'isThereItemToBeCooked','uses' => 'ProductionController@billing']);
	Route::get('/items/productions/produce/billing/asd/',['as' => 'productions.cook','uses' => 'ProductionController@cook']);
	Route::get('/items/{item}/inventory/check/',['uses' => 'ProductionController@checkStocks']);

	Route::get('/items/{id}/barcodes/generate/',['uses' => 'ItemsController@getBarcode']);
	Route::get('/items/barcodes/',['uses' => 'ItemsController@exportBarcodes']);
	Route::get('/items/list/',['uses' => 'ItemsController@getJSONItems']);
	Route::get('/productions/billing/items/{item_id}/remove/',['uses' => 'ProductionController@removeItemFromBilling']);
	
	Route::get('/productions/items/unsold',['uses' => 'ProductionController@unsold']);
	Route::get('/productions/items/unsold/add',['uses' => 'ProductionController@addUnsoldItemsToProduction']);
	Route::get('/productions/{prod_id}/details',['uses' => 'ProductionController@showProductionDetails']);
	Route::get('/productions/{id}/dispose/{qty}/',['uses' => 'ProductionController@dispose']);

	// Misc routes
	Route::get('/items/conversion-units',['uses' => 'ItemsController@indexUnits']);
	Route::get('/testupdate',['uses' => 'CustomersController@update']);
	Route::get('/customers/{id}/find',['uses' => 'CustomersController@edit']);
	Route::post('/items/ingredients/modify',['as' => 'ingredients.modify','uses' => 'ItemsController@updateRawMaterial']);

	/* Customer's Profile */

	Route::get('/customers/{id}/profile',['uses' => 'CustomersController@profile']);

	/*Employees Routes */
	Route::get('/employees/{emp_id}/priviliges/elevate/{elevatecode}',['uses' => 'UsersController@elevatePriviliges']);

	/* Suppliers Routes */

	Route::get('/suppliers/{supp_id}/remove',['uses' => 'SuppliersController@destroy']);

	/* AI Routes */
	
	Route::get('/ai/production/best-sellers/yesterday',['uses' => 'AIController@bestSellerYesterday']);

	/* System logs routes */

	Route::get('/system/logs',['uses' => 'AuditsController@index']);

	/* Shipments Routes */

	Route::get('/shipments/{id}/details/',['uses' => 'ShipmentsController@show']);
			
	/* Chart Routes */
	Route::get('/reports/charts/bestsellers/{value}',['uses' => 'ReportsController@getBarChartJSONData']);

	/* System Routes */

	Route::get('/system/users',['uses' => 'UsersController@index']);
	Route::get('/system/users/{user_id}/remove',['uses' => 'UsersController@removeUser']);
	Route::post('/system/users',['as' => 'users.add','uses' => 'UsersController@saveNewUser']);
	Route::get('/system/users/{user}/changepass/',['uses' => 'UsersController@changePassword']);

	/* AI Controller */

	Route::get('/settings/vc/action/{option}',['uses' => 'AIController@setOption']);
	/*
	Route::post('/sales/registrar',function(){

		return Input::all();

	});
*/
	/* Resource controllers */

	Route::resource('items', 'ItemsController');
	Route::resource('employees', 'EmployeesController');
	Route::resource('categories', 'CategoriesController');
	Route::resource('suppliers', 'SuppliersController');
	Route::resource('customers', 'CustomersController');
	Route::resource('icings', 'IcingsController');



});


/* Auth */

Route::get('auth/login',['as' => 'login','uses' => 'UsersController@create']);
Route::post('auth/login',['as' => 'login','uses' => 'UsersController@store']);
Route::get('auth/logout',['as' => 'logout','uses' => 'UsersController@destroy']);
Route::get('/auth/password/check',['uses' => 'UsersController@checkPassword']);


/* Invalid Routes */

App::missing(function($exception)
{
	return Response::view('errors.404', array(), 404);
});



/* Angular Routes */



