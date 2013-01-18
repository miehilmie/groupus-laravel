<?php

class Directmessage extends Basemodel
{
    public static $rules = array(
    );

	public function sender()
	{
		return $this->belongs_to('User', 'sender_id');
	}
	public function receiver()
	{
		return this.belongs_to('User', 'receiver_id');
	}

	public function IsYourMessage() {
		if(is_null($u = Auth::user())){
			return false;
		}
		return $this->receiver_id == $u->id;
	}
}