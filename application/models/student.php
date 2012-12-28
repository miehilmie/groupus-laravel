<?php

class Student extends Basemodel {

	public static $timestamps = false;
	public function user()
	{
		return $this->belongs_to('User');
	}

}
