<?php

class Install_Controller extends Base_Controller {

	private function insert_gender() {
		// insert gender
		if( !Gender::where_gender('Male')->first() )
		{
			Gender::create(array(
				'gender' => 'Male'
			));
		}
		if( !Gender::where_gender('Female')->first() )
		{
			Gender::create(array(
				'gender' => 'Female'
			));
		}
	}

	private function insert_usertype() {
		// insert type
		if( !Usertype::where_type('Student')->first() )
		{
			Usertype::create(array(
				'type' => 'Student'
			));
		}
		if( !Usertype::where_type('Lecturer')->first() )
		{
			Usertype::create(array(
				'type' => 'Lecturer'
			));
		}
		if( !Usertype::where_type('Admin')->first() )
		{
			Usertype::create(array(
				'type' => 'Admin'
			));
		}
	}

	private function insert_student() {
		if( !User::where_username('miebaik')->first() )
		{
			$u = University::where_abbrevation('MMU')->first();
			$usertype_id = Usertype::where_type('Student')->only('id');
			$gender_id = Gender::where_gender('Male')->only('id');

			$user = new User(array(
				'username' => 'miebaik',
				'password' => Hash::make('testing'),
				'name' => 'Muhammad Hilmi',
				'usertype_id' => $usertype_id,
				'gender_id' => $gender_id
			));
			$student = new Student(array(
				'cgpa' => 3.33,
				'distance_f_c' => 1
			));
			$u->users()->insert($user);
			$user->student()->insert($student);
		}
		if( !User::where_username('miehilmie')->first() )
		{
			$u = University::where_abbrevation('MMU')->first();
			$usertype_id = Usertype::where_type('Lecturer')->only('id');
			$gender_id = Gender::where_gender('Male')->only('id');

			$user = new User(array(
				'username' => 'miehilmie',
				'password' => Hash::make('testing'),
				'name' => 'Muhammad Hilmie',
				'usertype_id' => $usertype_id,
				'gender_id' => $gender_id
			));
			$lecturer = new Lecturer(array(
			));
			$u->users()->insert($user);
			$user->lecturer()->insert($lecturer);
		}
	}

	private function insert_university() {
		if( !University::where_abbrevation('MMU')->first() )
		{
			University::create(array(
				'name' => 'Multimedia University',
				'abbrevation' => 'MMU'
			));
		}
	}

	private function insert_faculty() {
		if( ($u = University::where_abbrevation('MMU')->first()) && !Faculty::where_abbrevation('FCI')->first() ) {

			$faculty = new Faculty(array(
				'name' => 'Faculty of Computing and Informatics',
				'abbrevation' => 'FCI'
			));

			$u->faculties()->insert($faculty);

		}
		if( ($u = University::where_abbrevation('MMU')->first()) && !Faculty::where_abbrevation('FOE')->first() ) {

			$faculty = new Faculty(array(
				'name' => 'Faculty of Engineering',
				'abbrevation' => 'FOE'
			));

			$u->faculties()->insert($faculty);

		}
		if( ($u = University::where_abbrevation('MMU')->first()) && !Faculty::where_abbrevation('FOM')->first() ) {

			$faculty = new Faculty(array(
				'name' => 'Faculty of Management',
				'abbrevation' => 'FOM'
			));

			$u->faculties()->insert($faculty);

		}
		if( ($u = University::where_abbrevation('MMU')->first()) && !Faculty::where_abbrevation('FCM')->first() ) {

			$faculty = new Faculty(array(
				'name' => 'Faculty of Creative Multimedia',
				'abbrevation' => 'FCM'
			));

			$u->faculties()->insert($faculty);

		}
	}

	public function action_install() {
		$this->insert_gender();

		$this->insert_usertype();

		$this->insert_university();

		$this->insert_faculty();

		$this->insert_student();
		return 'Installed';
	}
}