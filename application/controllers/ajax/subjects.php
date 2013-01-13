<?php

class Ajax_Subjects_Controller extends Base_Controller {

	public $restful = true;    

    // available subject to enroll
    public function get_available()
    {
        return Response::eloquent(Auth::user()->faculty->subjects);
    }

    public function get_rule($id) {
    	if(Subject::IsEnrolled($id)) {
            $response = array();
	    	$subject = Subject::find($id);

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
        if(Subject::IsFacultySubject($id) && Subject::IsEnrolled($id)) {
            $subject = Subject::find($id);
            $groups = $subject->get_only_groups();
            $response = array();
            foreach ($groups as $g) {
            	$o = json_decode(eloquent_to_json($g));
            	$students = $g->students()->get();

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
            // $grouprule = $subject->get_only_grouprule();

 			// return $grouprule->maxstudents;
            // $grouprule->maxstudents = Input::get('max_students');
        }
	    // return eloquent_to_json(Grouprule::find($rule->id));


    }

    public function post_generate() {
    	$input = Input::json();
    	return json_encode($input);
    }
}