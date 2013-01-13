<?php

class Announcement extends Basemodel 
{
	public function poster() {
		return $this->belongs_to('Lecturer', 'poster_id');
	}

	public function attachment() {
		return $this->belongs_to('Attachment');
	}

	public function subject() {
		return $this->belongs_to('Subject');
	}
}