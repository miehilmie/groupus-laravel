<?php

class Lecturer extends Basemodel {

	public static $timestamps = false;
	public function user()
	{
		return $this->belongs_to('User');
	}

    public static function register() {

    }

}
