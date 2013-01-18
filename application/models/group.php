<?php

class Group extends Basemodel
{
	public function students() {
		return $this->has_many_and_belongs_to('Student', 'student_group');
	}

    public function get_onlinestudents() {
        $five_minago = date('Y-m-d H:i:s',(time()- 5*60));

        return $this->with('User')->students()
        ->where('last_activity','<=', $five_minago)
        ->order_by('name', 'asc')->get();
    }
    public static function IsEnrolled($id) {
        $u = Auth::user();

        if($u->usertype_id != 1) return false;

        return $u->student->groups()
        ->where('group_id','=',$id)
        ->where('semester_id', '=', $u->university->semester_id)
        ->count() > 0;
    }
    public function subject() {
        return $this->belongs_to('Subject');
    }

    public function groupposts() {
        return $this->has_many('Grouppost');
    }
    // public function subject_discussions() {
    //     $user = Auth::user();
    //     $discuss = DB::table('discussions')
    //     ->join('users','users.id', '=', 'discussions.poster_id')
    //     ->left_join('attachments', 'attachments.id', '=', 'discussions.attachment_id')
    //     ->where('discussions.subject_id', '=', $this->id)
    //     ->order_by('discussions.created_at', 'desc')
    //     ->get(array(
    //         'discussions.has_attachment',
    //         'users.name as poster_user_name',
    //         'users.id as poster_user_id',
    //         'users.usertype_id as poster_usertype_id',
    //         'users.img_url as poster_user_img_url',
    //         'discussions.created_at',
    //         'discussions.message',
    //         'attachments.filename as attachment_filename'
    //     ));
    //     return $discuss;
    // }
    //
    public function group_onlinestudents() {
        if(is_null($u = Auth::user())){
            return false;
        }
        $five_minago = date('Y-m-d H:i:s',(time()- 5*60));
        $students = DB::query('SELECT IF(last_activity > \''. $five_minago. '\',\'online\',\'offline\') as status,'
            .' `users`.* FROM `users` INNER JOIN'
            .' `students` ON `users`.`id` = `students`.`user_id` INNER JOIN'
            .' `student_group` ON `students`.`id` = `student_group`.`student_id` INNER JOIN'
            .' `groups` ON `groups`.`id` = `student_group`.`group_id`'
            .' AND `groups`.`id` = ?'
            .' ORDER BY `status` DESC, `users`.name ASC',
            array($this->id));

        return $students;
    }
    public function group_discussions() {
        $user = Auth::user();
        $gpost = DB::table('groupposts')
        ->join('users','users.id', '=', 'groupposts.poster_id')
        ->left_join('attachments', 'attachments.id', '=', 'groupposts.attachment_id')
        ->where('groupposts.group_id', '=', $this->id)
        ->order_by('groupposts.created_at', 'desc')
        ->get(array(
            'groupposts.has_attachment',
            'users.name as poster_user_name',
            'users.id as poster_user_id',
            'users.img_url as poster_user_img_url',
            'groupposts.created_at',
            'groupposts.message',
            'attachments.filename as attachment_filename'
        ));
        return $gpost;
    }

}