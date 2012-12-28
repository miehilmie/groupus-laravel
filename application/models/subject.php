<?php
// @todo add relationships
class Subject extends Basemodel 
{
	public function faculty()
	{
		return $this->belongs_to('Faculty');
	}
	public function university() {
		return $this->faculty()->first()->university();
	}
	public function users() {
		return $this->has_many_and_belongs_to('User', 'enrollments')->with('semester_id');
	}
}