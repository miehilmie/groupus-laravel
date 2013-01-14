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

	public static function your_subjects() {
		return Auth::user()->subjects()
		->where('semester_id', '=', Auth::user()->university->semester_id)
		->get();
	}

	public function subject_discussions() {
		return $this->discussions()
		->where('semester_id','=', Auth::user()->university->semester_id)
		->order_by('created_at', 'desc')->get();
	}
	public function subject_announcements() {
		return $this->announcements()
		->where('semester_id','=', Auth::user()->university->semester_id)
		->order_by('created_at', 'desc')->get();
	}


	public function subject_onlinestudents() {
		if(is_null($u = Auth::user())){
			return false;
		}

		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', $u->university->semester_id)
		->where('last_activity','>', $five_minago)
		->where('usertype_id', '=', 1)
		->order_by('name', 'asc')->get();
	}
	public function subject_onlineusers() {
		if(is_null($u = Auth::user())){
			return false;
		}
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', $u->university->semester_id)
		->where('last_activity','>', $five_minago)
		->order_by('usertype_id', 'desc')
		->order_by('name', 'asc')->get();
	}
	public function subject_offlinestudents() {
		if(is_null($u = Auth::user())){
			return false;
		}
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', $u->university->semester_id)
		->where('last_activity','<=', $five_minago)
		->where('usertype_id', '=', 1)
		->order_by('name', 'asc')->get();
	}
	public function subject_offlineusers() {
		if(is_null($u = Auth::user())){
			return false;
		}
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', $u->university->semester_id)
		->where('last_activity','<=', $five_minago)
		->order_by('usertype_id', 'desc')
		->order_by('name', 'asc')->get();
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

		return ($this->grouprules()
		->where_semester_id($u->university->semester_id)
		->count() > 0) && $this->subject_grouprule()->enable == true;
	}
}