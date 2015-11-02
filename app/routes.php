<?php

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

Route::pattern('id', '[0-9]+');

/* Unauthenticated */
Route::group(['before' => 'guest'], function(){

  Route::any('/', function(){
    return Redirect::route('login');
  });

  Route::get('/login', [
    'as' => 'login',
    'uses' => 'SiteController@login'
  ]);

  Route::post('/login', [
    'as' => 'login.post',
    'uses' => 'SiteController@postLogin'
  ]);

});

// Admin routes
Route::group(['prefix' => 'admin'], function(){

  Route::get('/', function(){
    return Redirect::route('users.index');
  });

  Route::group(['prefix' => 'users', 'before' => 'users.manage'], function(){

    Route::get('/', [
      'as' => 'users.index',
      'uses' => 'UsersController@index'
    ]);

    Route::get('/{id}/delete', [
      'as' => 'users.destroy',
      'uses' => 'UsersController@destroy'
    ]);

    Route::get('/create', [
      'as' => 'users.create',
      'uses' => 'UsersController@create'
    ]);

    Route::post('/create', [
      'as' => 'users.store',
      'uses' => 'UsersController@store'
    ]);

    Route::get('/{id}', [
      'as' => 'users.show',
      'uses' => 'UsersController@show'
    ]);

    Route::get('/{id}/edit', [
      'as' => 'users.edit',
      'uses' => 'UsersController@edit'
    ]);

    Route::match(['PUT', 'POST'], '/{id}/edit', [
      'as' => 'users.update',
      'uses' => 'UsersController@update'
    ]);

    Route::get('/role-permissions', [
      'as' => 'role.permissions.edit',
      'uses' => 'UsersController@editRolePermissions'
    ]);

    Route::post('/role-permissions', [
      'as' => 'role.permissions.update',
      'uses' => 'UsersController@updateRolePermissions'
    ]);

  });
});

// Logged in
Route::group(['before' => 'auth'], function(){

  Route::any('/', function(){
    return Redirect::to('dashboard');
  });

  Route::get('/dashboard', [
    'as' => 'home',
    'uses' => 'SiteController@home'
  ]);

  Route::get('/logout', [
    'as' => 'logout',
    'uses' => 'SiteController@logout'
  ]);

  Route::get('/profile', [
    'as' => 'profile',
    'uses' => 'SiteController@profile'
  ]);

  Route::get('/profile/edit', [
    'as' => 'profile.edit',
    'uses' => 'SiteController@editProfile'
  ]);

  Route::post('/profile/edit', [
    'as' => 'profile.update',
    'uses' => 'SiteController@updateProfile'
  ]);

  // Users
  Route::get('/users/{id}', [
    'as' => 'users.show',
    'uses' => 'UsersController@show'
  ]);

  Route::group(['prefix' => 'sales'], function() {

    // Customers resource route
    Route::group(['prefix' => 'customers'], function() {

      Route::get('/', [
        'as' => 'customers.index',
        'uses' => 'CustomersController@index'
      ]);

      Route::any('/{id}/representative/delete', [
        'as' => 'representative.delete',
        'uses' => 'CustomersController@destroyRepresentative'
      ]);

      Route::get('/{id}/representative/edit', [
        'as' => 'representative.edit',
        'uses' => 'CustomersController@editRepresentative'
      ]);

      Route::get('/create', [
        'as' => 'customers.create',
        'uses' => 'CustomersController@create'
      ]);

      Route::get('/search', [
        'as' => 'customers.search',
        'uses' => 'CustomersController@search'
      ]);

      Route::post('/create', [
        'as' => 'customers.store',
        'uses' => 'CustomersController@store'
      ]);

      Route::get('/{id}', [
        'as' => 'customers.view',
        'uses' => 'CustomersController@show'
      ]);

      Route::get('/{id}/edit', [
        'as' => 'customers.edit',
        'uses' => 'CustomersController@edit'
      ]);

      Route::get('/{id}/delete', [
        'as' => 'customers.destroy',
        'uses' => 'CustomersController@destroy'
      ]);

      Route::match(['PUT', 'POST'], '/{id}/edit', [
        'as' => 'customers.update',
        'uses' => 'CustomersController@update'
      ]);

      Route::match(['PUT', 'POST'], '/{id}/representative/edit', [
        'as' => 'representative.update',
        'uses' => 'CustomersController@updateRepresentative'
      ]);

      Route::get('/{id}/add-representative', [
        'as' => 'customers.create.representative',
        'uses' => 'CustomersController@createRepresentative'
      ]);

      Route::post('/{id}/add-representative', [
        'as' => 'customers.store.representative',
        'uses' => 'CustomersController@storeRepresentative'
      ]);

    }); // end customers

    Route::any('/', [
      'as' => 'sales.index',
      'uses' => 'SalesController@index'
    ]);

    Route::get('/create', [
      'as' => 'sales.create',
      'uses' => 'SalesController@create'
    ]);

    Route::post('/create', [
      'as' => 'sales.store',
      'uses' => 'SalesController@store'
    ]);

    // Quotations module routes
    Route::group(['prefix' => 'quotations'], function() {

      Route::get('/', function() {return Redirect::route('sales.index');});

      Route::get('/create/{customerId}', [
        'as' => 'quotations.create',
        'uses' => 'SalesController@createQuotation',
        'before' => 'request.create'
      ]);

      // Create quotation
      Route::post('/create/{customerId}', [
        'as' => 'quotations.store',
        'uses' => 'SalesController@storeQuotation'
      ]);

      // View quotation
      Route::get('/{rfq}', [
        'as' => 'quotations.view',
        'uses' => 'SalesController@show'
      ]);

      Route::get('/_getQuotationTableList',array(
        'as' => 'quotation.get.table.data',
        'uses' => 'SalesController@_getQuotationTableList'
      ));

      Route::get('/{id}/cancel', [
        'as' => 'quotations.cancel',
        'uses' => 'SalesController@destroy'
      ]);

      // Request
      Route::get('/{rfq}/request', [
        'as' => 'quotations.request',
        'uses' => 'SalesController@editRequest',
        'before' => 'request.view'
      ]);

      Route::match(['PUT', 'POST'], '/{rfq}/request', [
        'as' => 'quotations.request.update',
        'uses' => 'SalesController@updateRequest'
      ]);

      // Bill of Materials
      Route::get('/{rfq}/bom', [
        'as' => 'quotations.bom',
        'uses' => 'SalesController@editBillOfMaterials',
        'before' => 'bom.view'
      ]);

      Route::match(['PUT', 'POST'], '/{rfq}/bom', [
        'as' => 'quotations.bom.update',
        'uses' => 'SalesController@updateBillOfMaterials'
      ]);

      // Scopes
      Route::any('/{rfq}/scope/add', [
        'as' => 'quotations.scope.add',
        'uses' => 'SalesController@createScope'
      ]);

      Route::any('/{rfq}/scope/{id}/delete', [
        'as' => 'scope.delete',
        'uses' => 'SalesController@destroyScope'
      ]);

      // Materials
      Route::any('/{rfq}/material/add', [
        'as' => 'quotations.material.add',
        'uses' => 'SalesController@createMaterial'
      ]);

      Route::any('/{rfq}/material/{id}/delete', [
        'as' => 'material.delete',
        'uses' => 'SalesController@destroyMaterial'
      ]);

      // Approval
      Route::get('/{rfq}/approval', [
        'as' => 'quotations.approval',
        'uses' => 'SalesController@editApproval',
        'before' => 'approval.view'
      ]);

      Route::match(['PUT', 'POST'], '/{rfq}/approval', [
        'as' => 'quotations.approval.update',
        'uses' => 'SalesController@updateApproval'
      ]);

      // Summary
      Route::get('/{rfq}/summary', [
        'as' => 'quotations.summary',
        'uses' => 'SalesController@editSummary',
        'before' => 'summary.view'
      ]);

      Route::match(['PUT', 'POST'], '/{rfq}/summary', [
        'as' => 'quotations.summary.update',
        'uses' => 'SalesController@updateSummary'
      ]);

      // Add discount
      Route::any('/{rfq}/discount/add', [
        'as' => 'quotations.discount.add',
        'uses' => 'SalesController@createDiscount'
      ]);

      // delete discount
      Route::any('/{rfq}/discount/{id}/delete', [
        'as' => 'discount.delete',
        'uses' => 'SalesController@destroyDiscount'
      ]);

      // Get report
      Route::get('/{rfq}/report', [
        'as' => 'quotations.report',
        'uses' => 'SalesController@showReport',
        'before' => 'request.view|summary.view'
      ]);

      // Summary
      Route::get('/{rfq}/for-print', [
        'as' => 'quotations.for-print',
        'uses' => 'SalesController@showLetter',
        'before' => 'summary.view'
      ]);

      // pdf
      Route::post('/{rfq}/for-print/pdf', [
        'as' => 'quotations.pdf',
        'uses' => 'SalesController@showPdf',
        'before' => 'summary.view'
      ]);

    });


  });

});

// Route::any('/test', 'SalesController@showReport');

// AJAX for customers dropdown data
Route::post('/customers/dropdown/data',[
  'as' => 'customers.get.data',
  'uses' => 'CustomersController@_getCustomerListDropdownData'
]);


/*Route::post('/search',function(){
    $keyword = Input::get('keyword');

    $customers = Customers::where('name', 'LIKE', '%'.$keyword.'%')->get();

    var_dump('search results');

    foreach ($customer as $customer) {
      var_dump($product->name);
    }
    
  });*/

//PRODUCTION
Route::get('production', array('as'=>'production.index','uses'=>'ProductionsController@index'));
Route::post('production', array('as'=>'production.po_details','uses'=>'ProductionsController@po_details'));
Route::get('production/back', array('as'=>'production.cancel','uses'=>'ProductionsController@cancel'));
Route::get('production/da/create', array('as'=>'production.dacreate','uses'=>'ProductionsController@da_create'));
Route::post('production/da/store', array('uses'=>'ProductionsController@da_store'));
Route::get('production/po/create', array('as'=>'production.pocreate','uses'=>'ProductionsController@po_create'));
Route::get('production/view', array('as'=>'production.view', 'uses'=> 'ProductionsController@view_production'));
Route::get('production/submit_po', array('as'=>'production.submit_po', 'uses'=> 'ProductionsController@submit_po'));

Route::get('job_order/{id}', array('as'=>'job_order', 'uses'=> 'ProductionsController@view_job_order'));

Route::get('job_order_po/{id}', array('as'=>'job_order_po', 'uses'=> 'ProductionsController@view_job_order_po'));

Route::any('job_order/{id}/delete', array('as'=>'job_order.delete', 'uses'=>'ProductionsController@delete_job_order'));

Route::get('job_order/{id}/edit', array('as'=>'job_order.edit','uses'=>'ProductionsController@edit_job_order'));

Route::put('job_order/update', array('uses'=>'ProductionsController@update_job_order'));

Route::put('job_order_po/update', array('uses'=>'ProductionsController@update_job_order_po'));

Route::get('job_order_scope_edit/{id}', array('as'=>'job_order.edit_scope','uses'=>'ProductionsController@edit_job_order_po'));

Route::put('job_order_po_scope/update', array('uses'=>'ProductionsController@update_job_order_po_scope'));

Route::get('job_order_bom_edit/{id}', array('as'=>'job_order.edit_bom','uses'=>'ProductionsController@edit_job_order_bom'));

Route::put('job_order_po_bom/update', array('uses'=>'ProductionsController@update_job_order_po_bom'));

Route::get('production/workingdrawing', array('as'=>'production.workingdrawing','uses'=>'ProductionsController@submit_to_working_drawing'));