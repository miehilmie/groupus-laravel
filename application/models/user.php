<?php

class User extends Basemodel {

	static $semester_id;

    public static $rules = array(
        'username' => 'required|email|unique:users',
        'name'     => 'required|min:5',
        'password' => 'required|min:5|max:20|same:password2',
        'agree'    => 'required'
    );

    /**
     * Get announcements for user
     * @return arrayofAnnouncement
     */
	public function announcements() {
		$anns = DB::table('enrollments')
		->join('announcements', function($join) {
			$join->on('announcements.subject_id', '=', 'enrollments.subject_id');
			$join->on('announcements.semester_id', '=', 'enrollments.semester_id');
		})
		->join('subjects', 'subjects.id', '=', 'enrollments.subject_id')
		->join('lecturers', 'lecturers.id', '=', 'announcements.poster_id')
		->join('users','users.id', '=', 'lecturers.user_id')
		->left_join('attachments', 'attachments.id', '=', 'announcements.attachment_id')
		->where('enrollments.user_id', '=', $this->id)
		->where('enrollments.semester_id', '=', $this->university->semester_id)
		->order_by('announcements.created_at', 'desc')
		->get(array(
			'subjects.id as subject_id',
			'subjects.code as subject_code',
			'announcements.has_attachment',
			'users.name as poster_user_name',
			'users.id as poster_user_id',
			'announcements.created_at',
			'announcements.message',
			'attachments.filename as attachment_filename'
		));


		return $anns;
	}

	/**
	 * Get updates for user
	 * @return arrayofDiscussion
	 */
	public function updates() {
		$discuss = DB::table('enrollments')
		->join('discussions', function($join) {
			$join->on('discussions.subject_id', '=', 'enrollments.subject_id');
			$join->on('discussions.semester_id', '=', 'enrollments.semester_id');
		})
		->join('subjects', 'subjects.id', '=', 'enrollments.subject_id')
		->join('users','users.id', '=', 'discussions.poster_id')
		->left_join('attachments', 'attachments.id', '=', 'discussions.attachment_id')
		->where('enrollments.user_id', '=', $this->id)
		->where('enrollments.semester_id', '=', $this->university->semester_id)
		->order_by('discussions.created_at', 'desc')
		->get(array(
			'subjects.id as subject_id',
			'subjects.code as subject_code',
			'discussions.has_attachment',
			'users.name as poster_user_name',
			'users.id as poster_user_id',
			'users.usertype_id as poster_usertype_id',
			'discussions.created_at',
			'discussions.message',
			'attachments.filename as attachment_filename'
		));
		return $discuss;
	}

	/**
	 * Get unread message number
	 * @return mixed
	 */
	public function user_jewel() {
		$count = $this->messages()->where_has_read(false)->count();
		if($count > 0)
			return $count;
		else
			return '';
	}

	/**
	 * Get user's directmessages limited by number of n
	 * @param  integer $n number of result
	 * @return arrayofMessage
	 */
	public function user_messages($n = 5) {
		return Directmessage::with('sender')->where('receiver_id','=',$this->id)
			->order_by('created_at', 'desc')->take($n)->get();
	}

	/**
	 * Get user's directmessages in pagination
	 * @param  integer $n number of result
	 * @return arrayofDirectessage
	 */
	public function user_messages_paginated($n = 5) {
		return $this->messages()
			->order_by('created_at', 'desc')->paginate($n);
	}

	/**
	 * Get user's sentitems limited by number of n
	 * @param  integer $n number of result
	 * @return arrayofSentitem
	 */
	public function user_sentitems($n = 5) {
		return $this->sentitems()
			->order_by('created_at', 'desc')->take($n)->get();
	}

	/**
	 * Get user's sentitems in pagination
	 * @param  integer $n number of result
	 * @return arrayofSentitem
	 */
	public function user_sentitems_paginated($n = 5) {
		return $this->sentitems()
			->order_by('created_at', 'desc')->paginate($n);
	}

	/**
	 * Get user's chat
	 * @return arrayofChat
	 */
	public function chats() {
		return Chat::with('receiver')->where('sender_id', '=', $this->id)
		->where('open','=', '1')
		->get();
	}

	/**
	 * Get user's subject
	 * @return [type] [description]
	 */
	public function user_subjects() {
		return $this->subjects()
		->where('semester_id', '=',$this->university->semester_id)
		->get();
	}

	/**
	 * START
	 * Eloquents relations
	 */
	public function university()
	{
		return $this->belongs_to('University');
	}

	public function usertype()
	{
		return $this->belongs_to('Usertype');
	}

	public function faculty() {
		return $this->belongs_to('Faculty');
	}

	public function gender()
	{
		return $this->belongs_to('Gender');
	}

	public function student()
	{
		return $this->has_one('Student');
	}

	public function lecturer()
	{
		return $this->has_one('Lecturer');
	}

	public function messages() {
		return $this->has_many('Directmessage', 'receiver_id');
	}

	public function sentitems() {
		return $this->has_many('SentItem', 'sender_id');
	}

	public function subjects() {
		return $this->has_many_and_belongs_to('Subject', 'enrollments')->with('semester_id');
	}

	/**
	 * END
	 * Eloquents functions
	 */

}
