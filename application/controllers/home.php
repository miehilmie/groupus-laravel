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
			return View::make('home.lecturer')->with(
				array(
					'name' => Auth::user()->name,
					'announcements' => array(), // @todo: add announcements
					'subjects' => array('TCP1234' => 1,'TCS2111' => 2), // @todo: add subjects
					'messages' => array(), // @todo: add messages
					'updates' => array()
				) 
			);

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
		$u = University::all();
		$f = (Input::old('university', 'none') !== 'none') ? Faculty::find(Input::old('university'))->get() : array();

		return View::make('home.signup')->with(
			array(
				'universities' => $u,
				'faculties' => $f,
			));
	}

	public function post_signup() {
		// get all inputs
		$input = Input::get();

		// define validation rules
		$rules = array(
			'username' => 'required|email|unique:users',
			'name' => 'required',
			'password' => 'required|same:password2',
			'agree' => 'required'
		);

		// custom message
		$messages = array(
		    'email' => 'The :attribute field must be in email format.',
		    'same' => 'Password must match.'
		);
		//@todo
		// usertype additional condition
		switch(Input::get('usertype'))
		{
			// student
			case 1:
				$r = array(
					'cgpa' => 'required'
				);
			break;
			// lecturer
			case 2:
				$r = array();
			break;

		}
		$rules = array_merge($rules, $r);

		// validation
		$validation = Validator::make($input,$rules, $messages);
		if($validation->fails()) {
			return Redirect::to('signup')->with_errors($validation)->with_input();
		}
		$user = new User(array(
			'username' => $input['username'],
			'name' => $input['name'],
			'password' => Hash::make($input['password']),
			'gender_id' => $input['gender'],
			'usertype_id' => $input['usertype'],
			'university_id' => $input['university']
		));

		$user->save();

		// insert sub table
		switch(Input::get('usertype'))
		{
			// student
			case 1:
				$student = new Student(array(
					'cgpa' => $input['cgpa'],
					'distance_f_c' => $input['dfc']
				));
				$user->student()->insert($student);

			break;
			//@todo: add lecturer field
			// lecturer
			case 2:
				$lecturer = new Lecturer(array(
				));
				$user->lecturer()->insert($lecturer);
			break;

		}

		return Redirect::to('signup')->with('success','Registration is successful!');
	}

}