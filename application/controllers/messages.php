<?php

class Messages_Controller extends Base_Controller {
	public $restful = true;


	public function get_index() {
		$user = Auth::user();
		return View::make('message.index')->with(array(
			'user' => $user,
			'messages' => $user->user_messages_paginated()
		));
	}

	public function get_sents() {
		$user = Auth::user();
		return View::make('message.sents')->with(array(
			'user' => $user,
			'messages' => $user->user_sentitems_paginated()
		));
	}

	public function get_show($id) {
		$m = Directmessage::find($id);

		if($m && !$m->IsYourMessage()) {
			return Redirect::to_route('messages');
		}
		$m->has_read = true;
		$m->save();

		return View::make('message.show')->with(array(
			'user' => Auth::user(),
			'message' => $m
		));
	}
	public function get_sents_show($id) {
		$m = SentItem::find($id);

		if($m && !$m->IsYourMessage()) {
			return Redirect::to_route('sents');
		}
		return View::make('message.sent_show')->with(array(
			'user' => Auth::user(),
			'message' => $m
		));
	}
	public function get_new($id = NULL) {
		$u = User::find($id);
		return View::make('message.new')->with(array(
			'user' => Auth::user(),
			'newuser' => $u
		));
	}

	public function post_create() {
		$input = Input::all();
		$rules = array(
			'msgto'      => 'required',
			'msgsubject' => 'required',
			'msgbody'    => 'required'
		);
		$validation = Validator::make($input,$rules);
		if($validation->fails()) {
			if(!Input::get('msgto'))
				return Redirect::to_route('new_message')
					->with_errors($validation);
			else
				return Redirect::to_route('reply_message',array(Input::get('msgto')))
					->with_errors($validation);
		}
		$msgData = array(
			'sender_id'   => Auth::user()->id,
			'receiver_id' => Input::get('msgto'),
			'subject'     => Input::get('msgsubject'),
			'message'     => Input::get('msgbody')
		);

		$message = Directmessage::create($msgData);
		$message = SentItem::create($msgData);
		return Redirect::to(Input::get('redirect'));

	}

	public function delete_destroy() {
		$msg = Directmessage::find(Input::get('id'));

		if($msg && !$msg->IsYourMessage()) {
			return Redirect::to_route('messages');
		}

		$msg->delete();

		return Redirect::to_route('messages');

	}

	public function delete_sents_destroy() {
		$m = SentItem::find(Input::get('id'));
		if($m && !$m->IsYourMessage()) {
			return Redirect::to_route('sents');
		}

		$m->delete();

		return Redirect::to_route('sents');

	}

	private function your_messages($id) {
	}


}