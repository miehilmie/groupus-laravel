<?php

class Users_Controller extends Base_Controller {

	public $restful = true;

	public function get_show($id)
    {

        if(!($u = User::find($id))) {
            return View::make('error.404');
        }

        if($u->id === Auth::user()->id) {
            return $this->get_profile();
        }

        return View::make('user.show')
            ->with(array(
                'user' => $u,

                'friendly_click'    => !Vote::IsVoteExist(Auth::user()->id, $u->id, 1),
                'proficiency_click' => !Vote::IsVoteExist(Auth::user()->id, $u->id, 2),
                'hardwork_click'    => !Vote::IsVoteExist(Auth::user()->id, $u->id, 3),
                'leadership_click'  => !Vote::IsVoteExist(Auth::user()->id, $u->id, 4),

                'friendly_value'    => Vote::get_average_value($u->id, 1),
                'proficiency_value' => Vote::get_average_value($u->id, 2),
                'hardwork_value'    => Vote::get_average_value($u->id, 3),
                'leadership_value'  => Vote::get_average_value($u->id, 4),

                'friendly_votes'    => Vote::get_vote_count($u->id, 1),
                'proficiency_votes' => Vote::get_vote_count($u->id, 2),
                'hardwork_votes'    => Vote::get_vote_count($u->id, 3),
                'leadership_votes'  => Vote::get_vote_count($u->id, 4),
            ));
    }

	public function get_new()
    {
        $u = University::all();
        $f = (Input::old('university', 'none') !== 'none') ? Faculty::find(Input::old('university'))->get() : array();

        return View::make('user.new')->with(
            array(
                'universities' => $u,
                'faculties'    => $f,
            ));
    }
    public function post_create()
    {
        // get all inputs
        $input = Input::get();


        // custom error message
        $messages = array(
            'email' => 'The :attribute field must be in email format.',
            'same'  => 'Password must match.',
            'cgpa'  => 'CGPA must ranged from 0 to 4'
        );

        //custom validation

        // cgpa: must be valid value from 0 to 4
        Validator::register('cgpa', function($attribute, $value, $parameters)
        {
            return $value > 0 && $value <= 4;
        });

        // define validation rules
        $rules = array(
            'username' => 'required|email|unique:users',
            'name'     => 'required|min:5',
            'password' => 'required|min:5|max:20|same:password2',
            'agree'    => 'required'
        );


        // usertype additional condition
        switch(Input::get('usertype'))
        {
            // student
            case 1:
                $r = array(
                    'cgpa' => 'required|cgpa',
                );
            break;
            // lecturer
            case 2:
                $r = array(
                    'roomno' => 'required'
                );
            break;

        }
        $rules = array_merge($rules, $r);

        // validation
        $validation = Validator::make($input,$rules, $messages);
        if($validation->fails()) {
            return Redirect::to('signup')->with_errors($validation)->with_input();
        }
        $user = new User(array(
            'username'      => Input::get('username'),
            'name'          => Input::get('name'),
            'password'      => Hash::make(Input::get('password')),
            'age'           => Input::get('age'),
            'phone'         => Input::get('phone'),
            'address'       => Input::get('address'),
            'gender_id'     => Input::get('gender'),
            'usertype_id'   => Input::get('usertype'),
            'faculty_id'    => Input::get('faculty'),
            'university_id' => Input::get('university')
        ));

        $user->save();

        // insert sub table
        switch(Input::get('usertype'))
        {
            // student
            case 1:
                $student = new Student(array(
                    'cgpa'         => $input['cgpa'],
                    'distance_f_c' => $input['dfc']
                ));
                $user->student()->insert($student);

            break;
            // lecturer
            case 2:
                $lecturer = new Lecturer(array(
                    'roomno'       => $input['roomno']
                ));
                $user->lecturer()->insert($lecturer);
            break;

        }

        return Redirect::to('signup')->with('success','Registration is successful!');
    }


    public function get_profile() {
        $u = Auth::user();
        return View::make('user.profile')
            ->with(array(
                'user' => $u,

                'friendly_value'    => Vote::get_average_value($u->id, 1),
                'proficiency_value' => Vote::get_average_value($u->id, 2),
                'hardwork_value'    => Vote::get_average_value($u->id, 3),
                'leadership_value'  => Vote::get_average_value($u->id, 4),

                'friendly_votes'    => Vote::get_vote_count($u->id, 1),
                'proficiency_votes' => Vote::get_vote_count($u->id, 2),
                'hardwork_votes'    => Vote::get_vote_count($u->id, 3),
                'leadership_votes'  => Vote::get_vote_count($u->id, 4),
            ));
    }

    /* setting */
    public function get_setting() {
        $u = Auth::user();
        $data = array(
            'user' => $u
        );
        return View::make('user.setting')->with($data);
    }

    public function put_setting($id) {

        $u = Auth::user();
        $input = Input::all();

        switch ($id) {
            case 1:
                $rules = array(
                    'name' => 'required',
                    'gender' => 'required',
                );
                switch ($u->usertype_id) {
                    case 1:
                        $ext = array(
                            'cgpa' => 'required',
                            'dfc'  => 'required'
                        );
                        break;
                    case 2:
                        $ext = array();
                        break;
                    default:
                        break;
                }

                $rules = array_merge($rules, $ext);

                $validation = Validator::make($input, $rules);
                if($validation->fails()) {
                    return Redirect::to_route('user_setting')->with_errors($validation);
                }
                // update

                $u->name = Input::get('name');
                $u->gender_id = Input::get('gender');
                $u->age = Input::get('age');
                $u->phone = Input::get('phone');
                $u->address = Input::get('address');

                switch ($u->usertype_id) {
                    case 1:
                        $u->student->cgpa = Input::get('cgpa');
                        $u->student->distance_f_c = Input::get('dfc');
                        $u->student->save();
                        break;
                    case 2:
                        break;
                    default:
                        break;
                }
                $u->save();

                return Redirect::to_route('user_setting')
                    ->with('success', 'Your profile has been updated');

                break;
            case 2:
                // production server does not support finfo extension,
                // so disable it if baseurl = web.groupusmalaysia.com
                if(URL::base() != "http://web.groupusmalaysia.com") {
                    $rules = array(
                        'image' => 'required|image|max:500'
                    );
                    $validation = Validator::make($input, $rules);
                    if($validation->fails()) {
                        return Redirect::to_route('user_setting')->with_errors($validation);
                    }
                }


                $file = Input::file('image');
                $ext = File::extension($file['name']);

                $dest_path = Config::get('application.custom_img_path');
                $dest_path_thumb = Config::get('application.custom_img_thumbs_path');
                $dest_filename = time().'_'.$u->id.'.'.$ext;

                Bundle::start('resizer');
                $success = Resizer::open( $file )
                    ->resize( 50 , 50 , 'exact' )
                    ->save( $dest_path_thumb.$dest_filename , 90 );
                Input::upload('image', $dest_path, $dest_filename);

                $u->img_url = $dest_filename;
                $u->save();

                return Redirect::to_route('user_setting')
                    ->with('success', 'Your profile picture has been updated');

                break;
            case 3:
                Validator::register('sameold', function($attribute, $value, $parameters)
                {
                    return Hash::check($value, Auth::user()->password);
                });

                $rules = array(
                    'oldpassword' => 'required|sameold',
                    'password' => 'required|min:5|max:20|same:password2'
                );
                $messages = array(
                    'sameold' => 'Invalid old password!',
                );
                $validation = Validator::make($input, $rules, $messages);

                if($validation->fails()) {
                    return Redirect::to_route('user_setting')->with_errors($validation);
                }

                $u->password= Hash::make(Input::get('password'));
                $u->save();

                return Redirect::to_route('user_setting')
                    ->with('success', 'Your password has been updated');

                break;

            default:
                # code...
                break;
        }

    }

    public function post_vote($id, $type) {

        // stop if id not exist
        if(!($user = User::find($id))) {
            return Redirect::to_route('home');
        }

        // stop if voter == user
        $voter = Auth::user();
        if($id == $voter->id) {
            return Redirect::to_route('home');
        }

        // get integer type
        switch ($type) {
            case 'friendly':
                $itype = 1;
                break;
            case 'proficiency':
                $itype = 2;
                break;
            case 'hardwork':
                $itype = 3;
                break;
            case 'leadership':
                $itype = 4;
                break;
            default:
                return Redirect::to_route('home');
                break;
        }

        // stop if vote exist
        if(Vote::IsVoteExist($voter->id, $user->id, $type) == true) {
            return Redirect::to_route('home');
        }

        $vote_value = Input::get('votes');

        $vote = new Vote(array(
            'voter_id' => Auth::user()->id,
            'user_id'  => $user->id,
            'value'    => Input::get('votes'),
            'type'     => $itype
        ));
        $vote->save();
        return Redirect::to_route('show_user', array($id));
    }
}