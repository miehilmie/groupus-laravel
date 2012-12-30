<?php

class Messages_Controller extends Base_Controller {
	public $restful = true;


	public function get_index() {
		return View::make('message.index')->with('messages', Directmessage::your_messages_paginated());
	}

	public function post_create() {
		$input = Input::all();
		$message = Directmessage::create(array(
			'sender_id' => Auth::user()->id,
			'receiver_id' => Input::get('msgto'),
			'subject' => Input::get('msgsubject'),
			'message' => Input::get('msgbody')
		));
		return Redirect::to('/');

	}

	private function your_messages($id) {
	}


}