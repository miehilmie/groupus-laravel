<?php

class Subjects_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
    {

    }    

	public function post_index()
    {

    }    

	public function get_show($id)
    {
        $u = Auth::user();
        if($this->your_subject($id) == false) {
            return View::make('error.noauth');
        }
        switch($u->usertype_id)
        {
            // student
            case 1:
            return View::make('subject.student.show')->with(array(
                'name' => $u->name,
                'announcements' => array(), // @todo: add announcements
                'subjects' => $u->subjects()->where('semester_id','=', $u->university->semester_id)->get(),
                'messages' => array(),
                'updates' => array(),
                'groups' => array()
            ));
            break;

            // lecturer
            case 2:

            break;
        }

    }    
    private function your_subject($id) {
        if(Auth::user()->subjects()->where('subject_id','=',$id)->first()) {
            return true;
        } else {
            return false;
        }
    }

	public function get_edit()
    {

    }    

	public function get_new()
    {

    }    

	public function put_update()
    {

    }    

	public function delete_destroy()
    {

    }

}