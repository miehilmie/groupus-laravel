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
	public static function IsYourMessage($id) {
		return (static::where_id_and_sender_id($id, Auth::user()->id)->count() > 0);
	}

	public static function your_messages() {
		return Auth::user()->sentitems()->order_by('created_at', 'desc')->take(5)->get();
	}
	public static function your_messages_paginated($n = 5) {
		return Auth::user()->sentitems()->order_by('created_at', 'desc')->paginate($n);
	}
}