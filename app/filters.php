<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

// Permission filter for sales module
Entrust::routeNeedsPermission( 'sales*', ['view_sales'] );

// Permission filter for customers
Entrust::routeNeedsPermission( 'customer*', ['manage_customers'] );

Entrust::routeNeedsRole( 'admin*', ['Admin'] );



Route::filter('users.manage', function(){
	if ( !Entrust::can('manage_users') ) {
		return Response::make('Unauthorized', 403);
	}
});

Route::filter('request.create', function(){

	if ( Entrust::can('direct_award') ) return;

	if ( !Entrust::can('create_quotations') ) {
		return Redirect::route('sales.index')
				->with('message', 'You do not have permission to view create RFQs.')
				->with('alert-class', 'danger');
	}
});

Route::filter('request.view', function($route){
	// Bypass if direct award
	if ( isDirectAward($route->parameter('rfq')) ) return;

	if ( !Entrust::can('view_request') ) {
		return Redirect::route('sales.index')
				->with('message', 'You do not have permission to view that.')
				->with('alert-class', 'danger');
	}
});

Route::filter('request.update', function($route){
	// Bypass if direct award
	if ( isDirectAward($route->parameter('rfq')) ) return;

	if ( !Entrust::can('edit_request') ) {
		return Redirect::route('sales.index')
				->with('message', 'You do not have permission to view that.')
				->with('alert-class', 'danger');
	}
});

Route::filter('bom.view', function($route){
	// Bypass if direct award
	if ( isDirectAward($route->parameter('rfq')) ) return;

	if ( !Entrust::can('view_bom') ) {
		return Redirect::route('sales.index')
				->with('message', 'You do not have permission to view that.')
				->with('alert-class', 'danger');
	}
});

Route::filter('approval.view', function($route){
	// Bypass if direct award
	if ( isDirectAward($route->parameter('rfq')) ) return;

	if ( !Entrust::can('view_approval') ) {
		return Redirect::route('sales.index')
				->with('message', 'You do not have permission to view that.')
				->with('alert-class', 'danger');
	}
});

Route::filter('summary.view', function($route){
	// Bypass if direct award
	if ( isDirectAward($route->parameter('rfq')) ) return;

	if ( !Entrust::can('view_summary') ) {
		return Redirect::route('sales.index')
				->with('message', 'You do not have permission to view that.')
				->with('alert-class', 'danger');
	}
});
