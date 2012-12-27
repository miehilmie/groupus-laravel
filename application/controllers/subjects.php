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

        switch($u->usertype_id)
        {
            // student
            case 1:
                return View::make('subject.student.show')->with(array(
                    'name' => $u->name,
                    'announcements' => array(), // @todo: add announcements
                    'subjects' => $u->student()->first()->subjects()->where('semester_id','=', $u->university()->first()->semester_id)->get(),
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