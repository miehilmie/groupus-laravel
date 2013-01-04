<?php

class Ajax_Subjects_Controller extends Base_Controller {

	public $restful = true;    

    // available subject to enroll
    public function get_available()
    {
        return Response::eloquent(Auth::user()->faculty->subjects);
    }
}