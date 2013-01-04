<?php

class Faculty extends Basemodel {

	public function university()
	{
		return $this->belongs_to('University');
	}
	public function users() {
		return $this->has_many('User');
	}

	public function subjects() {
		return $this->has_many('Subject');
	}
}
