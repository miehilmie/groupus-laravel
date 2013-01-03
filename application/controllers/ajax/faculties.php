<?php

class Ajax_Faculties_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
    {
        $uid = Auth::user()->university_id;
        return Response::eloquent(Faculty::where_university_id($uid)->get());
    }    
	public function get_subjects($id)
    {
        return Response::eloquent(Subject::where_faculty_id($id)->get());
    } 

}