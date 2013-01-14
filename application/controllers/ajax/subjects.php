<?php

class Ajax_Subjects_Controller extends Base_Controller {

	public $restful = true;

    // available subject to enroll
    public function get_available()
    {
        return Response::eloquent(Auth::user()->faculty->subjects);
    }

    public function get_rule($id) {
        $subject = Subject::find($id);

    	if($subject && $subject->IsEnrolled()) {
            $response = array();

	    	$rule = $subject->get_only_grouprule();
	    	if(!$rule) {
	    		$rule = Grouprule::create(array(
	    			'subject_id' => $subject->id,
	    			'semester_id' => Auth::user()->university->semester_id
	    		));

                $rule = Grouprule::find($rule->id);
	    	}

            $response = json_decode(eloquent_to_json($rule));
            $response->has_group = (Group::where_subject_id($subject->id)
                ->where_semester_id(Auth::user()->university->semester_id)->count() > 0);

            return json_encode($response);

    	}

    	return Response::error('404');

    }

    public function get_groups($id) {
        $subject = Subject::find($id);

        if($subject && $subject->IsFacultySubject() && $subject->IsEnrolled()) {
            $groups = $subject->subject_groups();
            $response = array();
            foreach ($groups as $g) {
            	$o = json_decode(eloquent_to_json($g));
            	$students = $g->students;

            	$users = array();
            	foreach ($students as $student) {
            		$user = json_decode(eloquent_to_json($student->user));
            		$user->extra = json_decode(eloquent_to_json($student->first()));
            		$users[] = $user;
            	}
            	$o->users = $users;
            	$response[] = $o;
            }
            return json_encode($response);
        }


    }

    public function post_generate() {
    	$input = Input::json();
    	return json_encode($input);
    }
}