<?php

class Messages_Controller extends Base_Controller {
	public $restful = true;


	public function get_index() {
		return View::make('message.index')->with('messages', Directmessage::your_messages_paginated());
	}

	public function get_show($id) {
		if(!Directmessage::IsYourMessage($id)) {
			return Redirect::to_route('messages');
		}
		$m = Directmessage::find($id);
		return View::make('message.show')->with(array(
			'message' => $m
		));
	}

	public function get_new($id = NULL) {
		$u = User::find($id);
		return View::make('message.new')->with(array(
			'user' => $u
		));
	}

	public function post_create() {
		$input = Input::all();
		$rules = array(
			'msgto' => 'required',
			'msgsubject' => 'required',
			'msgbody' => 'required'
		);
		$validation = Validator::make($input,$rules);
		if($validation->fails()) {
			if(!Input::get('msgto'))
				return Redirect::to_route('new_message')->with_errors($validation);
			else
				return Redirect::to_route('reply_message',array(Input::get('msgto')))->with_errors($validation);
		}
		$message = Directmessage::create(array(
			'sender_id' => Auth::user()->id,
			'receiver_id' => Input::get('msgto'),
			'subject' => Input::get('msgsubject'),
			'message' => Input::get('msgbody')
		));
		return Redirect::to(Input::get('redirect'));

	}

	public function delete_destroy() {
		if(!Directmessage::IsYourMessage(Input::get('id'))) {
			return Redirect::to_route('messages');
		}

		$msg = Directmessage::find(Input::get('id'));
		$msg->delete();

		return Redirect::to_route('messages');

	}

	private function your_messages($id) {
	}


}