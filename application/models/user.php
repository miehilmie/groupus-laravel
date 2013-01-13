<?php

class User extends Basemodel {

    public static $rules = array(
        'username' => 'required|email|unique:users',
        'name'     => 'required|min:5',
        'password' => 'required|min:5|max:20|same:password2',
        'agree'    => 'required'
    );

    /**
     * Get announcements for user
     * @return Announcement
     */
	public function announcements() {
		$subjects = DB::table('enrollments')
		->where_user_id_and_semester_id($this->id, $this->university->semester_id)
		->get('subject_id');
		$subject_arr = array();

		foreach ($subjects as $s) {
			$subject_arr[] = $s->subject_id;
		}
		if(count($subject_arr) == 0) {
			return null;
		}
		return Announcement::where_in('subject_id', $subject_arr)
		->where('semester_id','=', $this->university->semester_id)
		->order_by('created_at', 'desc')->get();
	}

	/**
	 * Get updates for user
	 * @return Discussion
	 */
	public function updates() {
		$subjects = DB::table('enrollments')
			->where_user_id_and_semester_id($this->id, $this->university->semester_id)
			->get('subject_id');

		$subject_arr = array();

		foreach ($subjects as $s) {
			$subject_arr[] = $s->subject_id;
		}
		if(count($subject_arr) == 0) {
			return null;
		}
		return Discussion::where_in('subject_id', $subject_arr)
		->where('semester_id','=', $this->university->semester_id)
		->order_by('created_at', 'desc')->get();
	}

	/**
	 * Get unread message number
	 * @return mixed
	 */
	public function jewel() {
		$count = $this->messages()->where_has_read(false)->count();
		if($count > 0)
			return $count;
		else
			return '';
	}


	/**
	 * START
	 * Eloquents functions
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
