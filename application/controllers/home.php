<?php

class Home_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index()
	{

		if( is_null($u = Auth::user()) )
			return View::make('home.index');

		switch( $u->usertype_id ) {
			// student
			case 1:
			return View::make('home.student')->with(
				array(
					'name' => $u->name,
					'announcements' => array(), // @todo: add announcements
					'updates' => array(),
					'groups' => array()
				) 
			);
			break;
			// lecturer
			case 2:
			return View::make('home.lecturer')->with(
				array(
					'name' => $u->name,
					'announcements' => array(), // @todo: add announcements
					'subjects' => array(), // @todo: add subjects
					'messages' => $u->messages()->get(), // @todo: add messages
					'updates' => array()
				) 
			);
			break;


		};

	}
	/***
	 *	login
	**/
	public function post_login() {
		$remember = Input::get('remember');
		$credential = array(
			'username' => Input::get('username'),
			'password' => Input::get('password'),
			'remember' => !empty($remember) ? $remember : null 
		);

		if( Auth::attempt($credential) )
			return Redirect::to_route('home');

		return Redirect::to_route('home')->with('status', 'Invalid username or password')->with_input();
	}
	/***
	 *	logout
	**/
	public function get_logout() {
		Auth::logout();

		return Redirect::to_route('home');
	}

}