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
	    	$subject = Subject::find($id);
	    	$rule = $subject->get_only_grouprule();
	    	if($rule) {
		    	return eloquent_to_json($rule);
	    	}
	    	else {
	    		$rule = Grouprule::create(array(
	    			'subject_id' => $subject->id,
	    			'semester_id' => Auth::user()->university->semester_id
	    		));

	    		return eloquent_to_json(Grouprule::find($rule->id));
	    	}	
    	}

    	return null;

    }
    
    public function get_groups($id) {
        if(Subject::IsFacultySubject($id) && Subject::IsEnrolled($id)) {
            $subject = Subject::find($id);
            $groups = $subject->get_only_groups();
            $response = array();
            foreach ($groups as $g) {
            	$o = json_decode(eloquent_to_json($g));
            	$o->users = json_decode(eloquent_to_json($g->students()->get()));
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