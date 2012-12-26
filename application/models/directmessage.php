<?php

class Directmessage extends Eloquent
{
	public function sender()
	{
		return $this->belongs_to('User', 'sender_id');
	}
	public function receiver()
	{
		return this.belongs_to('User', 'receiver_id');
	}
}