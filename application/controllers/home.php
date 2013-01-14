<?php

class Home_Controller extends Base_Controller {

	public $restful = true;

	/**
	 * HOME index
	 * @return mixed
	 */
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
					'announcements' => $u->announcements(),
					'updates' => $u->updates(),
					'groups' => $u->student->student_groups()
				)
			);
			break;
			// lecturer
			case 2:
			return View::make('home.lecturer')->with(
				array(
					'name' => $u->name,
					'announcements' => $u->announcements(),
					'updates' => $u->updates(),
					'groups' => array()
				)
			);
			break;


		};

	}

	/**
	 * Submit POST when login
	 * @return Redirect to home
	 */
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

	/**
	 * GET when link to logout
	 * @return Redirect to home
	 */
	public function get_logout() {
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));
		$user = Auth::user();
		$user->last_activity = $five_minago;
		$user->save();

		Auth::logout();

		return Redirect::to_route('home');
	}

}