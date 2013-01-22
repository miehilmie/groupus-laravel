<?php
// @todo add relationships
class Subject extends Basemodel
{
	public function faculty() {
		return $this->belongs_to('Faculty');
	}

	public function university() {
		return $this->faculty()->first()->university();
	}

	public function users() {
		return $this->has_many_and_belongs_to('User', 'enrollments')
		->with('semester_id');
	}

	public function discussions() {
		return $this->has_many('Discussion');
	}

	public function announcements() {
		return $this->has_many('Announcement');
	}

	public function grouprules() {
		return $this->has_many('Grouprule');
	}

	public function groups() {
		return $this->has_many('Group');
	}

	public function subject_discussions() {
		$user = Auth::user();
		$discuss = DB::table('discussions')
		->join('users','users.id', '=', 'discussions.poster_id')
		->left_join('attachments', 'attachments.id', '=', 'discussions.attachment_id')
		->where('discussions.subject_id', '=', $this->id)
		->where('semester_id','=', $user->university->semester_id)
		->order_by('discussions.created_at', 'desc')
		->get(array(
			'discussions.has_attachment',
			'users.name as poster_user_name',
			'users.id as poster_user_id',
			'users.usertype_id as poster_usertype_id',
			'users.img_url as poster_user_img_url',
			'discussions.created_at',
			'discussions.message',
			'attachments.filename as attachment_filename'
		));
		return $discuss;
	}
	public function subject_announcements() {
		$user = Auth::user();
		$ann = DB::table('announcements')
		->join('lecturers', 'lecturers.id', '=', 'announcements.poster_id')
		->join('users','users.id', '=', 'lecturers.user_id')
		->left_join('attachments', 'attachments.id', '=', 'announcements.attachment_id')
		->where('announcements.subject_id', '=', $this->id)
		->where('semester_id','=', $user->university->semester_id)
		->order_by('announcements.created_at', 'desc')
		->get(array(
			'announcements.has_attachment',
			'users.name as poster_user_name',
			'users.id as poster_user_id',
			'users.img_url as poster_user_img_url',
			'announcements.created_at',
			'announcements.message',
			'attachments.filename as attachment_filename'
		));
		return $ann;
	}

	public function subject_students() {
		if(is_null($u = Auth::user())){
			return false;
		}

        $students = User::join('enrollments', 'users.id', '=', 'enrollments.user_id')
            ->join('students', 'users.id', '=', 'students.user_id')
            ->where('enrollments.subject_id', '=', $this->id)
            ->where('enrollments.semester_id', '=', $u->university->semester_id)
            ->where('users.usertype_id', '=', '1')
            ->order_by('cgpa', 'desc')
            ->get();

       	return $students;
	}

	public function subject_onlinestudents() {
		if(is_null($u = Auth::user())){
			return false;
		}
    	$five_minago = date('Y-m-d H:i:s',(time()- 5*60));
        $students = DB::query('SELECT IF(last_activity > \''. $five_minago. '\',\'online\',\'offline\') as status,'
            .' `users`.* FROM `users` INNER JOIN'
            .' `enrollments` ON `users`.`id` = `enrollments`.`user_id` INNER JOIN'
            .' `subjects` ON `subjects`.`id` = `enrollments`.`subject_id`'
            .' WHERE `enrollments`.`semester_id` = ?'
            .' AND `subjects`.`id` = ?'
            .' AND `users`.`usertype_id` = 1'
            .' ORDER BY `status` DESC, `users`.name ASC',
            array($u->university->semester_id, $this->id));

		return $students;
	}
	public function subject_onlineusers() {
		if(is_null($u = Auth::user())){
			return false;
		}
    	$five_minago = date('Y-m-d H:i:s',(time()- 5*60));
        $students = DB::query('SELECT IF(last_activity > \''. $five_minago. '\',\'online\',\'offline\') as status,'
            .' `users`.* FROM `users` INNER JOIN'
            .' `enrollments` ON `users`.`id` = `enrollments`.`user_id` INNER JOIN'
            .' `subjects` ON `subjects`.`id` = `enrollments`.`subject_id`'
            .' WHERE `enrollments`.`semester_id` = ?'
            .' AND `subjects`.`id` = ?'
            .' ORDER BY `users`.usertype_id DESC, `status` DESC, `users`.name ASC',
            array($u->university->semester_id, $this->id));

		return $students;
	}

	public function subject_grouprule() {
		if(is_null($u = Auth::user())){
			return false;
		}

		return $this->grouprules()
		->where_semester_id($u->university->semester_id)
		->first();
	}

	public function subject_groups() {
		if(is_null($u = Auth::user())){
			return false;
		}

		$groups = $this->groups()
		->where_semester_id($u->university->semester_id)
		->get();

		return $groups;
	}

	public function IsEnrolled() {
		if(is_null($u = Auth::user())){
			return false;
		}

		return $this->users()
		->where('user_id','=', $u->id)
		->where('semester_id', '=', $u->university->semester_id)
		->count() > 0;
	}

	public function IsFacultySubject() {
		if(is_null($u = Auth::user())){
			return false;
		}

		return $this->faculty_id == $u->faculty_id;
	}

	public function IsGroupingEnable() {
		if(is_null($u = Auth::user())){
			return false;
		}

		return $this->grouprules()
		->where_semester_id($u->university->semester_id)
		->count() > 0;
	}
}