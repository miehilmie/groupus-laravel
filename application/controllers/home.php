<?php

class Home_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index()
	{
		if( is_null($u = Auth::user()) )
			return View::make('home.index');
		
		if( $u->usertype_id === Usertype::where_type('Student')->only('id') )
			


			return View::make('home.student')->with(
				array(
					'name' => Auth::user()->name,
					'announcements' => array(), // @todo: add announcements
					'subjects' => array('TCP1234' => 1,'TCS2111' => 2), // @todo: add subjects
					'messages' => array(), // @todo: add messages
					'updates' => array()
				) 
			);
		else if( $u->usertype_id === Usertype::where_type('Lecturer')->only('id') )
			return 'Logged in lecturer'; // @todo: add lecturer view

	}

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

	public function get_logout() {
		Auth::logout();

		return Redirect::to_route('home');
	}

	public function get_signup() {
		return View::make('home.signup');
	}

	public function post_signup() {
		$input = Input::all();
		$rules = array(
			'username' => 'required|email',
			'name' => 'required',
			'password' => 'required|same:password2',
		);
		$messages = array(
		    'email' => 'The :attribute field must be in email format.',
		    'same' => 'Password must match.'
		);
		$validation = Validator::make($input,$rules, $messages);
		if($validation->fails()) {
			return Redirect::to('signup')->with_errors($validation)->with_input();
		}
		return Redirect::to('signup');
	}

}