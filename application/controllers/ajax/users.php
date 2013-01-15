<?php

class Ajax_Users_Controller extends Base_Controller {

    public $restful = true;

    public function get_index()
    {
        return eloquent_to_json(User::all());
    }
    public function get_show($id) {
    	return eloquent_to_json(User::find($id));
    }
    public function post_search() {
        $name = Input::get('id');
        return eloquent_to_json(User::where('name', 'like', '%'.$name.'%')->get());
    }
}