<?php

/***
*	Routes
***/

Route::get('/', array('as' => 'home', 'uses' => 'home@index'));
Route::get('logout', 'home@logout');

Route::get('signup', array('as' => 'new_signup', 'uses' => 'home@signup'));
Route::post('signup', array('as' => 'create_signup', 'uses' => 'home@signup'));

Route::post('login', array('before' => 'csrf', 'as' => 'login', 'uses' => 'home@login'));

// user resource
Route::get('profile', array('before' => 'auth','uses' => 'users@profile'));
Route::get('users/(:any)','users@show');
Route::get('setting', 'users@setting');

// install
Route::get('install', 'install@install');


// test
Route::get('subjects/(:num)', array('before'=> 'auth', 'as' => 'subject', 'uses' => 'subjects@show'));

Route::get('help', function() {
	$t = DB::table('users')->select('username')->get();
	$b = array(
		'miebaik',
		'miehilmie'
	);
	dd($b);
	return View::make('home.index');
});
/***
*	Listener
***/

// Event::listen('laravel.query', function($sql, $bindings, $time) {
// 	var_dump($sql);
// });


/***
*	Error page
***/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});


/***
*	Filters
***/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('/');
});

// student are not allowed
// announcements route?
Route::filter('nostudent', function ()
{

});

// allow view only associates with themselves
// @todo: maybe need to send parameter
Route::filter('belongs_to', function()
{

});