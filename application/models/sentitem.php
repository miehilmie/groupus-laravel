<?php

class SentItem extends Eloquent
{
	public function sender()
	{
		return $this->belongs_to('User', 'sender_id');
	}
	public function receiver()
	{
		return $this->belongs_to('User', 'receiver_id');
	}
	public function IsYourMessage() {
		if(is_null($u = Auth::user())){
			return false;
		}

		return $this->sender_id == $u->id;
	}
	public static function your_messages() {
		return $user->sentitems()->order_by('created_at', 'desc')->take(5)->get();
	}
	public static function your_messages_paginated($n = 5) {
		return $user->sentitems()->order_by('created_at', 'desc')->paginate($n);
	}
}