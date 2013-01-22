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
        return Redirect::to($redirect)->with('flashmsg', 'Subjects have successfully registered');
    }


    public function post_settings()
    {

        $redirect = Input::get('redirect');
        $id = Input::get('id');
        $prefix = Input::get('prefix');
        $subject = Subject::find($id);
        $user = Auth::user();
        // if subject exist, is same faculty with user, and enrolled
        if($subject && $subject->IsFacultySubject() && $subject->IsEnrolled()) {
            $grouprule = $subject->subject_grouprule();

            $groupmode = Input::get('mode');

            if($groups = Group::where_subject_id($id)
                ->where_semester_id($user->university->semester_id)
                ->get())
            {
                foreach ($groups as $g) {
                    $g->students()->delete();
                    $g->delete();
                }
            }

            $n_groups = Input::get('max_groups');
            $maxstudents = Input::get('max_students');

            $groups = array();

            for($i = 1; $i <= $n_groups; $i++) {
                $groups[] = Group::create(array(
                    'name' => $prefix.'_'.$i,
                    'subject_id'  => $id,
                    'semester_id' => $user->university->semester_id
                ));
            }
            if(Input::get('mode') == 2) {

                $characteristic = Input::get('characteristic');
                switch ($characteristic) {
                    case 0:
                        $students = User::join('enrollments', 'users.id', '=', 'enrollments.user_id')
                            ->join('students', 'users.id', '=', 'students.user_id')
                            ->where('enrollments.subject_id', '=', $id)
                            ->where('enrollments.semester_id', '=', $user->university->semester_id)
                            ->where('users.usertype_id', '=', '1')
                            ->order_by('cgpa', 'desc')
                            ->get();

                        $n_students = count($students);
                        $index = 0;

                        foreach($students as $student) {
                            $i = $index%$n_groups;
                            $groups[$i]->students()->attach($student->id);
                            $index++;
                        }


                        break;
                    case 1:
                        $students = User::join('enrollments', 'users.id', '=', 'enrollments.user_id')
                            ->join('students', 'users.id', '=', 'students.user_id')
                            ->where('enrollments.subject_id', '=', $id)
                            ->where('enrollments.semester_id', '=', $user->university->semester_id)
                            ->where('users.usertype_id', '=', '1')
                            ->order_by('distance_f_c', 'asc')
                            ->get();

                        $n_students = count($students);

                        $dfcs = null;

                        foreach($students as $student) {
                            $dfcs[$student->distance_f_c][] = $student;
                        }

                        // shuffle student on same group of dfc

                        foreach ($dfcs as $k => $temp_students) {
                            $keys = array_keys($temp_students);
                            shuffle($keys);
                            $random = null;
                            foreach ($keys as $key)
                                $random[$key] = $temp_students[$key];

                            $dfcs[$k] = $random;
                        }
                        $index = 0;
                        $student_balance = $n_students%$n_groups;
                        $student_pergroup = ($n_students-$student_balance)/$n_groups;
                        $student_count = 0;
                        foreach ($dfcs as $temp_students) {
                            foreach ($temp_students as $student) {
                                $groups[$index]->students()->attach($student->id);
                                $student_count++;

                                if($student_count >= $student_pergroup){
                                    if($index >= $student_balance || $student_count > $student_pergroup) {
                                        // reset counter for next group
                                        $student_count = 0;
                                        // attach to next group
                                        $index++;
                                    }
                                }
                            }

                        }
                        $maxstudents = $student_pergroup;
                        if($student_balance) {
                             $maxstudents += 1;
                        }

                        break;

                    default:
                        return Response::error('404');
                        break;
                }
                $groupmode += $characteristic;

            }

            $grouprule->maxgroups   = $n_groups;
            $grouprule->maxstudents = $maxstudents;
            $grouprule->mode        = $groupmode;
            $grouprule->enable      = 1;
            $grouprule->save();

        }

        return Redirect::to($redirect)->with('flashmsg', 'Your setting is saved');
    }

	public function get_show($id)
    {
        $user = Auth::user();
        $subject = Subject::find($id);

        if(!$subject || !$subject->IsEnrolled()) {
            return View::make('error.noauth');
        }


        switch($user->usertype_id)
        {
            // student
            case 1:
            return View::make('subject.student.show')->with(array(
                'user'    => $user,
                'subject' => $subject,
                'groups'  => $user->student->student_groups()
            ));
            break;

            // lecturer
            case 2:
            return View::make('subject.lecturer.show')->with(array(
                'user'    => $user,
                'subject' => $subject,
                'hasgroup' => count($subject->subject_groups())
            ));
            break;
        }

    }

    public function post_posts() {
        $id = Input::get('id');
        $redirect = Input::get('redirect');
        $subject = Subject::find($id);
        if(!$subject || $subject->IsFacultySubject($id) && !$subject->IsEnrolled($id)) {
            return Redirect::to($redirect)->with('flashmsg', 'An error has occured');
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
            return Redirect::to($redirect)->with('flashmsg', 'You need to type something');
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

        return Redirect::to($redirect)->with('flashmsg', 'You have posted a discussion');
    }
    public function post_announcements() {
        $id = Input::get('id');
        $redirect = Input::get('redirect');
        $subject = Subject::find($id);
        if(!$subject || $subject->IsFacultySubject() && !$subject->IsEnrolled()) {
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
            return Redirect::to($redirect)->with('flashmsg', 'You need to type something');
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

        return Redirect::to($redirect)->with('flashmsg', 'You have posted an announcement');
    }

    /**
     * Student join group
     * @return Redirect
     */
    public function post_groups() {
        $id = Input::get('id');
        $redirect = Input::get('redirect');

        $subject = Subject::find($id);
        if(!$subject || $subject->IsFacultySubject() && !$subject->IsEnrolled()) {
            return Redirect::to($redirect);
        }
        $grouprule = $subject->subject_grouprule();

        $input = Input::all();
        $rules = array(
            'group_num' => 'required',
        );

        $validation = Validator::make($input, $rules);

        if($validation->fails()) {
            return Redirect::to($redirect);
        }

        $group = Group::find(Input::get('group_num'));
        if(count($group->students) >= $grouprule->maxstudents) {
            return Redirect::to($redirect)->with('flashmsg', 'Group is full. Please choose different group');
        }
        $student = Auth::user()->student;
        $group->students()->attach($student->id);

        return Redirect::to($redirect)->with('flashmsg', 'You have successfully joined a group');
    }


}