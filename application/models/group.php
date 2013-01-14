<?php

class Group extends Basemodel
{
	public function students() {
		return $this->has_many_and_belongs_to('Student', 'student_group');
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

    public function get_group_discussion() {
        return $this->groupposts()->order_by('created_at', 'desc')->get();
    }

}