<?php

class Subjects_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
    {

    }    

	public function post_enroll()
    {
        $redirect = Input::get('redirect');
        for($i = 1; $i <= 5;$i++) {
            $id = Input::get('subject'.$i);

            if(Subject::where_faculty_id_and_id(Auth::user()->faculty_id, $id)->count()
                    && !Subject::IsEnrolled($id)) {
                Auth::user()->subjects()->attach($id, array('semester_id' => Auth::user()->university->semester_id));
            }
        }
        return Redirect::to($redirect);
    }    

	public function get_show($id)
    {
        $u = Auth::user();
        if(!Subject::IsEnrolled($id)) {
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
            return View::make('subject.student.show')->with(array(
                'name' => $u->name,
                'announcements' => array(), // @todo: add announcements
                'subjects' => $u->subjects()->where('semester_id','=', $u->university->semester_id)->get(),
                'messages' => array(),
                'updates' => array(),
                'groups' => array()
            ));
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