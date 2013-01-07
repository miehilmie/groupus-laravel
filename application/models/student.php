<?php

class Student extends Basemodel {

	public static $timestamps = false;
	public function user()
	{
		return $this->belongs_to('User');
	}

	public function groups() {
		return $this->has_many_and_belongs_to('Group', 'student_group');
	}

}
