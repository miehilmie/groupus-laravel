<?php

// =================================> ROUTE

// home, login, logout, signup
Route::get('/', array('as' => 'home', 'uses' => 'home@index'));
Route::get('logout', 'home@logout');
Route::post('login', array('before' => 'csrf', 'as' => 'login', 'uses' => 'home@login'));


// users resources
Route::get('signup', array('as' => 'new_user', 'uses' => 'users@new'));
Route::post('signup', array('before' => 'csrf' ,'as' => 'create_user', 'uses' => 'users@create'));

Route::get('profile', array('before' => 'auth', 'as'=> 'user_profile', 'uses' => 'users@profile'));
Route::get('setting', array('before' => 'auth', 'as'=> 'user_setting', 'uses' => 'users@setting'));
Route::get('users/(:any)', array('before' => 'auth','as' => 'show_user', 'uses' => 'users@show'));
Route::post('users/(:num)/(:any)', array('before' => 'auth' , 'uses' => 'users@vote'));

// subjects
Route::get('subjects/(:num)', array('before'=> 'auth', 'as' => 'subject_show', 'uses' => 'subjects@show'));

// messages
Route::get('messages', array('before' => 'auth', 'as' => 'messages', 'uses' => 'messages@index'));
Route::post('messages', array('before' => 'auth|csrf', 'as' => 'new_message', 'uses' => 'messages@create'));

// ===============================> DATA
// AJAX route
Route::get('ajax/universities/(:any)/faculties', array('as' => 'ajax_university_faculties', 'uses' => 'ajax.universities@faculties_index'));

// ajax/subject Resource
Route::get('ajax/subjects', array('as' => 'ajax_subjects', 'uses' => 'ajax.subjects@index'));
Route::get('ajax/subjects/(:any)', array('as' => 'ajax_subject', 'uses' => 'ajax.subjects@show'));
Route::get('ajax/subjects/new', array('as' => 'new_ajax_subject', 'uses' => 'ajax.subjects@new'));
Route::get('ajax/subjects/(:any)edit', array('as' => 'edit_ajax_subject', 'uses' => 'ajax.subjects@edit'));
Route::post('ajax/subjects', 'ajax/subjects@create');
Route::put('ajax/subjects/(:any)', 'ajax/subjects@update');
Route::delete('ajax/subjects/(:any)', 'ajax/subjects@destroy');


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