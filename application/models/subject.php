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
}