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
}