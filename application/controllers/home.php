<?php

class Home_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index()
	{

		if( is_null($u = Auth::user()) )
			return View::make('home.index');
		$u->student->subjects()->get(array('code'));

		switch( $u->usertype_id ) {
			// student
			case 1:
			return View::make('home.student')->with(
				array(
					'name' => $u->name,
					'announcements' => array(), // @todo: add announcements
					'subjects' => $u->student->subjects()->where('semester_id','=', $u->university->semester_id)->get(),
					'messages' => $u->messages()->get(), // m : {sender, }
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