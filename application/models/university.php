<?php

class University extends Eloquent 
{
	public function faculties() {
		return $this->has_many('Faculty');
	}

	public function users() {
		return $this->has_many('User');
	}
}