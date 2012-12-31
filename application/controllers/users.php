<?php

class Users_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
    {

    }    

	public function post_index()
    {
        
    }    

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
                'friendly_click' => !Vote::IsVoteExist(Auth::user()->id, $u->id, 1),
                'friendly_value' => Vote::get_average_value($u->id, 1),
                'friendly_votes' => Vote::get_vote_count($u->id, 1),
                'proficiency_click' => !Vote::IsVoteExist(Auth::user()->id, $u->id, 2),
                'proficiency_value' => Vote::get_average_value($u->id, 2),
                'proficiency_votes' => Vote::get_vote_count($u->id, 2),
                'hardwork_click' => !Vote::IsVoteExist(Auth::user()->id, $u->id, 3),
                'hardwork_value' => Vote::get_average_value($u->id, 3),
                'hardwork_votes' => Vote::get_vote_count($u->id, 3),
                'leadership_click' => !Vote::IsVoteExist(Auth::user()->id, $u->id, 4),
                'leadership_value' => Vote::get_average_value($u->id, 4),
                'leadership_votes' => Vote::get_vote_count($u->id, 4),
            ));
    }    

	public function get_edit()
    {

    }    

	public function get_new()
    {
        $u = University::all();
        $f = (Input::old('university', 'none') !== 'none') ? Faculty::find(Input::old('university'))->get() : array();

        return View::make('user.new')->with(
            array(
                'universities' => $u,
                'faculties' => $f,
            ));
    }    
    public function post_create()
    {
        // get all inputs
        $input = Input::get();

        // define validation rules
        $rules = array(
            'username' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|same:password2',
            'agree' => 'required'
        );

        // custom message
        $messages = array(
            'email' => 'The :attribute field must be in email format.',
            'same' => 'Password must match.'
        );
        //@todo
        // usertype additional condition
        switch(Input::get('usertype'))
        {
            // student
            case 1:
                $r = array(
                    'cgpa' => 'required',
                );
            break;
            // lecturer
            case 2:
                $r = array();
            break;

        }
        $rules = array_merge($rules, $r);

        // validation
        $validation = Validator::make($input,$rules, $messages);
        if($validation->fails()) {
            return Redirect::to('signup')->with_errors($validation)->with_input();
        }
        $user = new User(array(
            'username' => $input['username'],
            'name' => $input['name'],
            'password' => Hash::make($input['password']),
            'age' => $input['age'],
            'phone' => $input['contact'],
            'address' => $input['address'],
            'gender_id' => $input['gender'],
            'usertype_id' => $input['usertype'],
            'faculty_id' => $input['faculty'],
            'university_id' => $input['university']
        ));

        $user->save();

        // insert sub table
        switch(Input::get('usertype'))
        {
            // student
            case 1:
                $student = new Student(array(
                    'cgpa' => $input['cgpa'],
                    'distance_f_c' => $input['dfc']
                ));
                $user->student()->insert($student);

            break;
            //@todo: add lecturer field
            // lecturer
            case 2:
                $lecturer = new Lecturer(array(
                ));
                $user->lecturer()->insert($lecturer);
            break;

        }

        return Redirect::to('signup')->with('success','Registration is successful!');
    }

	public function put_update()
    {

    }    

	public function delete_destroy()
    {

    }
    public function get_profile()
    {
        $u = Auth::user();
        return View::make('user.profile')
            ->with(array(
                'user' => $u,
                'friendly_value' => Vote::get_average_value($u->id, 1),
                'friendly_votes' => Vote::get_vote_count($u->id, 1),
                'proficiency_value' => Vote::get_average_value($u->id, 2),
                'proficiency_votes' => Vote::get_vote_count($u->id, 2),
                'hardwork_value' => Vote::get_average_value($u->id, 3),
                'hardwork_votes' => Vote::get_vote_count($u->id, 3),
                'leadership_value' => Vote::get_average_value($u->id, 4),
                'leadership_votes' => Vote::get_vote_count($u->id, 4),
            ));
    }
    public function get_setting()
    {
        return View::make('user.setting');
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
            'user_id' => $user->id,
            'value' => Input::get('votes'),
            'type' => $itype
        ));
        $vote->save();
        return Redirect::to_route('show_user', array($id));
    }
}