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
        // @todo : add user column in db for
        //          img_url, age, address, phone, 
        $fac = $u->faculty()->first();
        $uni = $u->university()->only('name');
        return View::make('user.show')
            ->with(array(
                'img_url' => '',
                'address' => 'Unit 8-9-3, Blok 8, Fasa 2, Pantai Hillpark, Jalan Pantai Dalam, 52900 Kuala Lumpur',
                'age' => '23',
                'name' => $u->name,
                'phone' => '0177526474',
                'faculty' => $fac,
                'university' => $uni
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
            'gender_id' => $input['gender'],
            'usertype_id' => $input['usertype'],
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
        $fac = $u->faculty()->first();
        $uni = $u->university()->only('name');
        return View::make('user.profile')
            ->with(array(
                'user' => $u,
                'name' => $u->name,
                'img_src' => $u->img_url,
                'age' => $u->age ? $u->age : 'Not specified',
                'phone' => $u->phone ? $u->phone : 'Not specified',
                'address' => $u->address ? $u->address : 'Not specified',
                'faculty' => $fac,
                'university' => $uni
            ));
    }
    public function get_setting()
    {
        return View::make('user.setting');
    }
    public function post_vote() {
        return Input::get('id');
    }
}