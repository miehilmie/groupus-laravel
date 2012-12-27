<?php

class Home_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index()
	{

		if( is_null($u = Auth::user()) )
			return View::make('home.index');


		switch( $u->usertype_id ) {
			// student
			case Usertype::where_type('Student')->only('id'):
			return View::make('home.student')->with(
				array(
					'name' => $u->name,
					'announcements' => array(), // @todo: add announcements
					'subjects' => $u->student()->first()->subjects()->where('semester_id','=', $u->university()->first()->semester_id)->get(),
					'messages' => array(), // @todo: add messages
					'updates' => array(),
					'groups' => array()
				) 
			);
			break;
			// lecturer
			case Usertype::where_type('Lecturer')->only('id'):
			return View::make('home.lecturer')->with(
				array(
					'name' => $u->name,
					'announcements' => array(), // @todo: add announcements
					'subjects' => $u->subjects()->get(), // @todo: add subjects
					'messages' => array(), // @todo: add messages
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