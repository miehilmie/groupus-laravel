<?php

class Ajax_Users_Controller extends Base_Controller {

    public $restful = true;

    public function get_index()
    {
        return eloquent_to_json(User::all());
    }
    public function get_show($id) {
        $user = User::find($id);
        $votevalue = Vote::get_average_value_all($user->id);

        $response = new StdClass;
        $response->response = json_decode(eloquent_to_json($user));
        $response->voteaverage = ($votevalue) ? $votevalue : 0;
    	return json_encode($response);
    }
    public function post_search() {
        $name = Input::get('id');
        return eloquent_to_json(User::where('name', 'like', '%'.$name.'%')->get());
    }
}