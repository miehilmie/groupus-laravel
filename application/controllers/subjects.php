<?php

class Subjects_Controller extends Base_Controller {

	public $restful = true;


	public function post_enroll()
    {
        $redirect = Input::get('redirect');
        for($i = 1; $i <= 5;$i++) {
            $id = Input::get('subject'.$i);
            $subject = Subject::find($id);
            $u = Auth::user();
            if($subject && $subject->IsFacultySubject() && !$subject->IsEnrolled()) {
                $u->subjects()->attach($id,
                    array('semester_id' => $u->university->semester_id)
                );

            }
        }
        return Redirect::to($redirect);
    }

    public function post_settings()
    {
        $redirect = Input::get('redirect');
        $id = Input::get('id');
        $prefix = Input::get('prefix');
        $subject = Subject::find($id);

        // if subject exist, is same faculty with user, and enrolled
        if($subject && $subject->IsFacultySubject() && $subject->IsEnrolled()) {
            $grouprule = $subject->subject_grouprule();

            $grouprule->maxgroups = Input::get('max_groups');
            $grouprule->maxstudents = Input::get('max_students');
            $grouprule->mode = Input::get('mode');
            $grouprule->enable = 1;
            $grouprule->save();

            if($groups = Group::where_subject_id($id)
                ->where_semester_id(Auth::user()->university->semester_id)
                ->get())
            {
                foreach ($groups as $g) {
                    $g->students()->delete();
                    $g->delete();
                }
            }

            for($i = 1; $i <= $grouprule->maxgroups; $i++) {
                Group::create(array(
                    'name' => $prefix.'_'.$i,
                    'subject_id' => $id,
                    'semester_id' => Auth::user()->university->semester_id
                ));
            }
        }

        return Redirect::to($redirect);
    }

	public function get_show($id)
    {
        $u = Auth::user();
        $subject = Subject::find($id);

        if($subject && !$subject->IsEnrolled()) {
            return View::make('error.noauth');
        }


        switch($u->usertype_id)
        {
            // student
            case 1:
            return View::make('subject.student.show')->with(array(
                'announcements' => array(), // @todo: add announcements
                'subject'       => $subject,
                'groups' => $u->student->student_groups()
            ));
            break;

            // lecturer
            case 2:
            return View::make('subject.lecturer.show')->with(array(
                'announcements' => array(), // @todo: add announcements
                'subject'       => $subject,
            ));
            break;
        }

    }
    public function post_posts() {
        $id = Input::get('id');
        $redirect = Input::get('redirect');

        if(Subject::IsFacultySubject($id) && !Subject::IsEnrolled($id)) {
            return Redirect::to($redirect);
        }

        $input = Input::all();
        $rules = array(
            'message' => 'required',
        );

        $has_attachment = (is_uploaded_file($_FILES['attachment']['tmp_name'])) ? true : false;

        if($has_attachment) {
            // upload file and all
            $file = Input::file('attachment');
            $dest_path = Config::get('application.custom_attachment_path');
            Input::upload('attachment', $dest_path, $file['name']);

            $attachment = new Attachment(array(
                'filename' => $file['name']
            ));

            $attachment->save();
            $attachment_id = $attachment->id;
        }

        $validation = Validator::make($input, $rules);
        if($validation->fails()) {
            return Redirect::to($redirect);
        }

        $post = new Discussion(array(
            'poster_id'      => Auth::user()->id,
            'subject_id'     => $id,
            'semester_id'    => Auth::user()->university->semester_id,
            'message'        => Input::get('message'),
            'has_attachment' => $has_attachment,
            'attachment_id'  => ($has_attachment) ? $attachment_id : null
        ));

        $post->save();

        return Redirect::to($redirect);
    }
    public function post_announcements() {
        $id = Input::get('id');
        $redirect = Input::get('redirect');
        $subject = Subject::find($id);
        if($subject && $subject->IsFacultySubject() && !$subject->IsEnrolled()) {
            return Redirect::to($redirect);
        }

        $input = Input::all();
        $rules = array(
            'message' => 'required',
        );

        $has_attachment = (is_uploaded_file($_FILES['attachment']['tmp_name'])) ? true : false;

        if($has_attachment) {
            // upload file and all
            $file = Input::file('attachment');
            $dest_path = Config::get('application.custom_attachment_path');
            Input::upload('attachment', $dest_path, $file['name']);

            $attachment = new Attachment(array(
                'filename' => $file['name']
            ));

            $attachment->save();
            $attachment_id = $attachment->id;
        }

        $validation = Validator::make($input, $rules);
        if($validation->fails()) {
            return Redirect::to($redirect);
        }

        $post = new Announcement(array(
            'poster_id'      => Auth::user()->lecturer->id,
            'subject_id'     => $id,
            'semester_id'    => Auth::user()->university->semester_id,
            'message'        => Input::get('message'),
            'has_attachment' => $has_attachment,
            'attachment_id'  => ($has_attachment) ? $attachment_id : null
        ));

        $post->save();

        return Redirect::to($redirect);
    }
    public function post_groups() {
        $id = Input::get('id');
        $redirect = Input::get('redirect');

        $subject = Subject::find($id);
        if($subject && $subject->IsFacultySubject() && !$subject->IsEnrolled()) {
            return Redirect::to($redirect);
        }

        $input = Input::all();
        $rules = array(
            'group_num' => 'required',
        );

        $validation = Validator::make($input, $rules);
        if($validation->fails()) {
            return Redirect::to($redirect);
        }

        $group = Group::find(Input::get('group_num'));

        $student = Auth::user()->student;
        $group->students()->attach($student->id);

        return Redirect::to($redirect);
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