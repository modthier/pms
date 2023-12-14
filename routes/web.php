<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| updateItemroutes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

// Route::post('user/login','Admin\UserController@login')->name('user.login');
// Route::get('pms/login','Admin\UserController@showLoginForm')->name('pms.login');

 Route::group(['middleware' => 'auth'], function () {
 Route::post('/order/getItemById','DrugOrderController@getItemById')->name('order.getItemById');
 Route::post('/order/getItemByScanner','DrugOrderController@getItemByScanner')->name('order.getItemByScanner');


 Route::post('/pos/getItemById','PointOfSaleInsuranceController@getItemById')->name('pos.getItemById');

 Route::post('/pos/getItemByScanner','PointOfSaleInsuranceController@getItemByScanner')->name('pos.getItemByScanner');
 
 Route::post('/drugs/check','DrugsController@check')->name('drugs.check');
 Route::post('/stocks/getCount','StockController@getCount')->name('stocks.getCount');

 Route::post('getStock','DrugOrderController@getStock')->name('drugOrder.getStock');

 Route::get('ShowEditItem/{id}','DrugOrderController@ShowEditItem')->name('drugOrder.ShowEditItem');
 Route::match(['put','patch'],'updateItem/{id}','DrugOrderController@updateItem')->name('drugOrder.updateItem');

 Route::get('showAddtem/{id}','SalesController@showAddItem')->name('order.showAddItem');
 Route::post('storeItem/{id}','SalesController@storeItem')->name('order.storeItem');

 Route::post('getDrugs','SalesController@getDrugs')->name('sales.getDrugs');



});

Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth' ]
], function(){ //...






Route::get('DrugRequests/mostSold','DrugRequestController@mostSoldItems')
		->name('DrugRequests.mostSold');

Route::get('/expired','DrugsController@expired')->name('drugs.expired');

Route::get('returnOrder/{DrugRequest}','ReturnedItemsController@returnOrder')
 		  ->name('ReturnedItems.returnOrder');
		   Route::get('returnItemInc/{DrugRequest}','ReturnedItemsController@returnInc')->name('ReturnedItems.returnInc');
 Route::get('returnItem/{DrugRequest}','ReturnedItemsController@returnItem')->name('ReturnedItems.returnItem');
 

 Route::get('drugs/search','DrugsController@search')->name('drugs.search');
 Route::get('drugs','DrugsController@index')->name('drugs.index');
 Route::resource('DrugOrders','DrugOrderController')
   ->except(['show','destroy','edit','update','index']);
 
 

 
 

 Route::get('hourlySalesReport','DrugRequestController@hourlySalesReport')
           ->name('hourlySalesReport.DrugRequests');

           
 Route::get('tradeName','DrugRequestController@tradeName')
           ->name('tradeName.DrugRequests');

 Route::get('receiptNumber','DrugRequestController@receiptNumber')
           ->name('receiptNumber.DrugRequests');
           
 Route::get('salesBetween','DrugRequestController@dateSearch')
           ->name('salesBetween.DrugRequests');

 Route::get('user/DailyTotal/{user}','DrugRequestController@dailyTotal')
           ->name('user.dailyTotal');
 Route::get('user/DrugRequests/{user}','DrugRequestController@getUserSales')
           ->name('user.DrugRequests');


 Route::resource('DrugRequests','DrugRequestController');

 Route::resource('ReturnedItems','ReturnedItemsController');

 Route::get('/','HomeController@index' )->name('home');

 //

 Route::post('insurancePointOfSale','PointOfSaleInsuranceController@store')
 ->name('insurancePointOfSale.store');

Route::get('insurancePointOfSale','PointOfSaleInsuranceController@create')
 ->name('insurancePointOfSale.create');

Route::get('insurancePointOfSale/{id}','PointOfSaleInsuranceController@show')
 ->name('insurancePointOfSale.show');

 

 //

 Route::resource('expense','ExpenseController');


Route::group(['middleware' => 'can:can_access'], function(){

	 // backup routes

		Route::get('/backup', 'BackupController@index')->name('backup.index');
		Route::get('/backup/create', 'BackupController@create');
		Route::get('/backup/download/{file_name}', 'BackupController@download');
		Route::get('/backup/delete/{file_name}', 'BackupController@delete');
	
	 //

	 Route::resource('paymentMethod','PaymentMethodController');


     // Insurance

	 Route::resource('insuranceCompany','InsuranceCompanyController');
	 


	

	 

	 Route::get('insuranceReport',
	 	  'PointOfSaleInsuranceController@export')
	 		->name('pos.insuranceReport');


	 Route::get('InsuranceSalesReport','PointOfSaleInsuranceController@InsuranceReport')
	 	   ->name('pos.InsuranceSalesReport');



	 
	 
	 //end 

     Route::resource('setting','SettingController',['except' => ['show','destroy']]);

	 

	// All Exports

	// expenses
		Route::resource('item','ItemController',['except' => ['show','destroy']]);
		
	// end

	// InsurancePayment
	Route::match(['put','patch'],'InsuranceInvoice/balanceInvoice/{InsuranceInvoice}','InsuranceInvoiceController@balanceInvoice')
				->name('balanceInvoice.balanceInvoice');
	
				
    Route::get('InsuranceInvoice/{InsuranceInvoice}/editBalance','InsuranceInvoiceController@editBalance')
				->name('InsuranceInvoice.editBalance');
				
	Route::get('InsuranceInvoice/search','InsuranceInvoiceController@search')
				->name('InsuranceInvoice.search');

	Route::get('InsuranceInvoice/createInvoice','InsuranceInvoiceController@createInvoice')
			->name('InsuranceInvoice.createInvoice');

	Route::resource('InsuranceInvoice','InsuranceInvoiceController',['except' => ['show','create']]);
	
	
	//
	 

	 Route::get('exportStock', 'StockController@export')->name('stock.export');

	 Route::get('exportDrugs', 'DrugsController@export')->name('drug.export');

	 Route::get('exportPo', 'PurchaseOrdersController@exportReport')->name('po.export');
	 Route::get('exportPoDetails', 'PurchaseOrdersController@exportDetailsReport')->name('po.exportDetails');


	 Route::get('exportDrugRequest', 'DrugRequestController@export')->name('drugRequest.export');
	//end

	//expired stock controller

	 Route::match('delete','returnTostock/{ExpiredStock}' ,'ExpiredStockController@returnTostock')
	 	      ->name('expiredStock.returnTostock');

	 Route::get('ExpiredStock/moveToExpiry/{stock}','ExpiredStockController@moveToExpiry')
	 	->name('expiredStock.moveToExpiry');


	 Route::get('ExpiredStock','ExpiredStockController@index')
	 	->name('expiredStock.index');
	//end

	Route::get('summaryByDate','SummaryController@summaryByDates')->name('Summary.summaryByDates');

    Route::get('summary','SummaryController@index')->name('Summary.index');
    

	Route::resource('accounts','AccountController',['except' => ['show']]);

	Route::get('payments/search','PaymentsController@search')->name('payments.search');
	Route::get('payments/paid/{payment}','PaymentsController@pay')->name('payments.pay');
	Route::get('payments/cancel/{payment}','PaymentsController@cancel')->name('payments.cancel');

	Route::resource('payments','PaymentsController',['except' => ['show']]);

	Route::resource('drugTypes','DrugItemTypeController');

	
	Route::resource('drugs','DrugsController',['except' => ['index']]);

	Route::resource('DrugWithStock','DrugWithStock',['except' => ['index','show','edit','destroy','update']]);

	Route::resource('drugUnits','DrugUnitController');
	

	Route::get('stocks/addToStock/{stock}','StockController@showAddToStockForm')
		->name('stocks.showAddToStockForm');

	Route::match(['put','patch'],'stocks/updatAddedStock/{stock}','StockController@updatAddedStock')->name('stocks.updatAddedStock');

	Route::get('stocks/history','StockController@stockHistory')->name('stocks.history');


	Route::get('stocks/search','StockController@search')->name('stocks.search');
	Route::get('stocks/check','StockController@stockCheck')->name('stocks.check');

	
	Route::post('stocks/updatePrice','StockController@updatePrice')
		->name('stocks.updatePrice');
		
	Route::resource('stocks','StockController',['except' => ['show']]);


	Route::get('user/PurchaseOrders/{user}','PurchaseOrdersController@getUserPO')->name('user.po');
	Route::get('PurchaseOrders/search','PurchaseOrdersController@search')->name('PurchaseOrders.search');
	Route::resource('PurchaseOrders','PurchaseOrdersController');

	Route::match('delete','user/{user}','Admin\UserController@destroy')->name('user.destroy');

	Route::get('user/resetPasswordForm/{user}','Admin\UserController@resetPasswordForm')->name('user.resetPasswordForm');

	Route::post('user/resetPassword/{user}','Admin\UserController@resetPassword')->name('user.resetPassword');

	Route::get('user/shifts/{user}','ShiftController@getUserShitf')->name('user.shift');
	Route::resource('Shifts','ShiftController');


	Route::get('user/activities/{user}','Admin\UserController@showActivity')->name('user.activity');
	Route::get('user/enableUser/{user}','Admin\UserController@enableUser')->name('user.enableUser');
	Route::get('user/disableUser/{user}','Admin\UserController@disableUser')->name('user.disableUser');

	

	Route::resource('admin/register','Admin\UserController',['except' => ['show','destroy']]);

  });



});


