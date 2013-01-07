<?php

class User extends Basemodel {

    public static $rules = array(
        'username' => 'required|email|unique:users',
        'name' => 'required',
        'password' => 'required|same:password2',
        'agree' => 'required'
    );

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
	public function get_message_jewel() {
		$count = $this->messages()->where_has_read(false)->count();
		if($count > 0)
			return $count;
		else
			return '';
	}

	public static function updates() {
		$user = Auth::user();
		$subjects = DB::table('enrollments')
		->where_user_id_and_semester_id($user->id, $user->university->semester_id)
		->get('subject_id');
		$subject_arr = array();

		foreach ($subjects as $s) {
			$subject_arr[] = $s->subject_id;
		}
		if(count($subject_arr) == 0) {
			return null;
		}
		return Discussion::where_in('subject_id', $subject_arr)
		->where('semester_id','=', $user->university->semester_id)
		->order_by('created_at', 'desc')->get();
		// $user = Auth::user();
		// return static::join('enrollments', function($join) {
		// 	$join->on('users.id', '=', 'enrollments.user_id');
		// })
		// ->join('subjects', function($join) {
		// 	$join->on('subjects.id', '=', 'enrollments.subject_id');
		// })
		// ->join('discussions', function($join) {
		// 	$join->on('enrollments.subject_id', '=', 'discussions.subject_id');
		// 	$join->on('enrollments.semester_id', '=', 'discussions.semester_id');
		// 	$join->on('discussions.poster_id', '=', 'users.id');
		// })
		// ->where('enrollments.semester_id','=', $user->university->semester_id)
		// ->order_by('discussions.created_at', 'desc')
		// ->get(array('discussions.message', 'discussions.created_at', 'users.name'));
	}
}
