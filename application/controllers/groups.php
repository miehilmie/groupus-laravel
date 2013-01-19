<?php

class Groups_Controller extends Base_Controller {

    public $restful = true;

    public function get_show($id)
    {
        $u = Auth::user();
        if($u->usertype_id != 1 || !Group::IsEnrolled($id)) {
            return View::make('error.noauth');
        }
        $student = $u->student;
        $g = Group::with('subject')->find($id);

        return View::make('group.show')->with(array(
            'user' => $u,
            'group' => $g,
            'student' => $student,
            'groups' => $student->student_groups()
        ));
    }
    public function post_posts() {
        $id = Input::get('id');
        $redirect = Input::get('redirect');

        if(!Group::IsEnrolled($id)) {
            return Redirect::to($redirect)->with('flashmsg', 'You are not authorized to post to the group');
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
            return Redirect::to($redirect)->with('flashmsg', 'You need to write something');
        }

        $post = new Grouppost(array(
            'poster_id'      => Auth::user()->id,
            'group_id'     => $id,
            'message'        => Input::get('message'),
            'has_attachment' => $has_attachment,
            'attachment_id'  => ($has_attachment) ? $attachment_id : null
        ));

        $post->save();

        return Redirect::to($redirect)->with('flashmsg', 'You have posted a discussion');
    }
}