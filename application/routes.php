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
Route::put('setting/(:num)', array('before' => 'auth|csrf', 'uses' => 'users@setting'));
Route::get('users/(:any)', array('before' => 'auth','as' => 'show_user', 'uses' => 'users@show'));
Route::post('users/(:num)/(:any)', array('before' => 'auth' , 'uses' => 'users@vote'));

// subjects
Route::get('subjects/(:num)', array('before'=> 'auth|subjectowner', 'as' => 'subject_show', 'uses' => 'subjects@show'));
Route::post('subjects/enroll', array('as' => 'subjectsenroll', 'before' => 'auth|csrf', 'uses' => 'subjects@enroll'));
Route::post('subjects/posts', array('as' => 'subjectspost', 'before' => 'auth|csrf', 'uses' => 'subjects@posts'));
Route::post('subjects/settings', array('as' => 'subjectssettings', 'before' => 'auth|csrf', 'uses' => 'subjects@settings'));

// messages
Route::get('messages', array('as' => 'messages', 'before' => 'auth', 'uses' => 'messages@index'));
Route::get('messages/sents', array('as' => 'sents', 'before' => 'auth', 'uses' => 'messages@sents'));

Route::get('messages/new/(:num)', array('as' => 'reply_message', 'before' => 'auth', 'uses' => 'messages@new'));
Route::get('messages/new', array('as' => 'new_message', 'before' => 'auth', 'uses' => 'messages@new'));

Route::get('messages/(:num)', array('as'=> 'message', 'before' => 'auth', 'uses' => 'messages@show'));
Route::get('messages/sents/(:num)', array('as'=> 'message_sent', 'before' => 'auth', 'uses' => 'messages@sents_show'));

Route::post('messages', array('as' => 'new_message', 'before' => 'auth|csrf', 'uses' => 'messages@create'));

Route::delete('messages', array('before' => 'auth', 'uses' => 'messages@destroy'));
Route::delete('messages/sents', array('before' => 'auth', 'uses' => 'messages@sents_destroy'));

// ===============================> DATA



// AJAX route
Route::get('ajax/universities/(:any)/faculties', array('as' => 'ajax_university_faculties', 'uses' => 'ajax.universities@faculties_index'));


// ajax user Resource
Route::get('ajax/users', array('as' => 'ajaxusers', 'uses' => 'ajax.users@index'));

// ajax message Resource


// ajax faculty Resource
Route::get('ajax/faculties', array('as' => 'ajaxfaculties', 'uses' => 'ajax.faculties@index'));
Route::get('ajax/faculties/(:num)/subjects', array('as' => 'ajaxfaculties_subjects', 'uses' => 'ajax.faculties@subjects'));

// ajax subject Resource
Route::get('ajax/subjects/available', array('as' => 'ajaxsubjects', 'uses' => 'ajax.subjects@available'));
Route::get('ajax/subjects/(:num)/rule', array('as' => 'ajaxsubjectrule', 'uses' => 'ajax.subjects@rule'));
Route::get('ajax/subjects/(:num)/groups', array('as' => 'ajaxsubjectrule', 'uses' => 'ajax.subjects@groups'));


// API -------------------->
Route::get('hash/(:any)/(:any)', function($u, $p) {
	$user = User::where_username($u)->first();
	if($user) {
		return Hash::check($p, $user->password);
	}
	return false;
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
Route::filter('onlylecturer', function ()
{

});

Route::filter('subjectowner', function ()
{
	
});