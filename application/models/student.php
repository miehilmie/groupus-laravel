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

	public function get_only_groups() {
		return $this->groups()->where_semester_id($this->user->university->semester_id)->get();
	}
	public function IsJoinGroup($subject_id) {

		return $this->groups()
		->where_subject_id($subject_id)
		->where_semester_id($this->user->university->semester_id)->count() > 0;
	}
}
