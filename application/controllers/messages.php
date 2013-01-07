<?php

class Messages_Controller extends Base_Controller {
	public $restful = true;


	public function get_index() {
		return View::make('message.index')->with('messages', Directmessage::your_messages_paginated());
	}
	
	public function get_sents() {
		return View::make('message.sents')->with('messages', SentItem::your_messages_paginated());
	}

	public function get_show($id) {
		if(!Directmessage::IsYourMessage($id)) {
			return Redirect::to_route('messages');
		}
		$m = Directmessage::find($id);
		$m->has_read = true;
		$m->save();
		
		return View::make('message.show')->with(array(
			'message' => $m
		));
	}
	public function get_sents_show($id) {
		if(!SentItem::IsYourMessage($id)) {
			return Redirect::to_route('sents');
		}
		$m = SentItem::find($id);
		return View::make('message.sent_show')->with(array(
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
		$msgData = array(
			'sender_id' => Auth::user()->id,
			'receiver_id' => Input::get('msgto'),
			'subject' => Input::get('msgsubject'),
			'message' => Input::get('msgbody')
		);

		$message = Directmessage::create($msgData);
		$message = SentItem::create($msgData);
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

	public function delete_sents_destroy() {
		if(!SentItem::IsYourMessage(Input::get('id'))) {
			return Redirect::to_route('sents');
		}

		$msg = SentItem::find(Input::get('id'));
		$msg->delete();

		return Redirect::to_route('sents');

	}

	private function your_messages($id) {
	}


}