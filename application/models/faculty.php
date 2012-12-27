<?php

class Faculty extends Basemodel {

	public function university()
	{
		return $this->belongs_to('University');
	}
	public function users() {
		return $this->has_many('User');
	}
}
