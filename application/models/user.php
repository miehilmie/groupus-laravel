<?php

class User extends Eloquent {

	public function university()
	{
		return $this->belongs_to('University');
	}

	public function usertype()
	{
		return $this->belongs_to('Usertype');
	}

	public function faculty() {
		return $this->belongs_to('Faculty');
	}

	public function gender()
	{
		return $this->belongs_to('Gender');
	}

	public function student()
	{
		return $this->has_one('Student');
	}

	public function lecturer()
	{
		return $this->has_one('Lecturer');
	}

}
