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

	public function get_only_discussions() {
		return $this->discussions()
		->where('semester_id','=', Auth::user()->university->semester_id)
		->order_by('created_at', 'desc')->get();
	}
	public function get_only_announcements() {
		return $this->announcements()
		->where('semester_id','=', Auth::user()->university->semester_id)
		->order_by('created_at', 'desc')->get();
	}

	public function get_only_students_and_lecturers() {
		return $this->users()
		->where('semester_id', '=', Auth::user()->university->semester_id)
		->order_by('usertype_id', 'desc')->get();
	}

	public function get_only_onlinestudents() {
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', Auth::user()->university->semester_id)
		->where('last_activity','>', $five_minago)
		->where('usertype_id', '=', 1)
		->order_by('name', 'asc')->get();
	}
	public function get_only_onlineusers() {
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', Auth::user()->university->semester_id)
		->where('last_activity','>', $five_minago)
		->order_by('usertype_id', 'desc')
		->order_by('name', 'asc')->get();
	}
	public function get_only_offlinestudents() {
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', Auth::user()->university->semester_id)
		->where('last_activity','<=', $five_minago)
		->where('usertype_id', '=', 1)
		->order_by('name', 'asc')->get();
	}
	public function get_only_offlineusers() {
		$five_minago = date('Y-m-d H:i:s',(time()- 5*60));

		return $this->users()
		->where('semester_id', '=', Auth::user()->university->semester_id)
		->where('last_activity','<=', $five_minago)
		->order_by('usertype_id', 'desc')
		->order_by('name', 'asc')->get();
	}
	public function get_only_grouprule() {
		return $this->grouprules()
		->where_semester_id(Auth::user()->university->semester_id)
		->first();
	}

	public function get_only_groups() {

		$groups = $this->groups()
		->where_semester_id(Auth::user()->university->semester_id)
		->get();

		return $groups;
		// $response = array();
		// foreach ($groups as $g) {
		// 	$o = json_decode(eloquent_to_json($g));
		// 	$o->users = $g->students();

		// 	$response[] = $o;
		// }

		// return json_encode($response);
	}
	// BOOLEAN

	public static function IsEnrolled($id) {
		return Auth::user()->subjects()
		->where('subject_id','=',$id)
		->where('semester_id', '=', Auth::user()->university->semester_id)
		->count() > 0;
	}

	public static function IsFacultySubject($id) {
		return static::where_faculty_id_and_id(Auth::user()->faculty_id, $id)
		->count() > 0;
	}

	public function IsGroupingEnable() {
		return ($this->grouprules()
		->where_semester_id(Auth::user()->university->semester_id)
		->count() > 0) && $this->get_only_grouprule()->enable == true;
	}
}