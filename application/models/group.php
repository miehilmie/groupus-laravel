<?php

class Group extends Basemodel 
{
	public function students() {
		return $this->has_many_and_belongs_to('Student', 'student_group');
	}
}