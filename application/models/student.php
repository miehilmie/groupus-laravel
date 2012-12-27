<?php

class Student extends Basemodel {

	public static $timestamps = false;
	public function user()
	{
		return $this->belongs_to('User');
	}

	public function subjects() {
		return $this->has_many_and_belongs_to('Subject', 'enrollments')->with('semester_id');
	}

}
