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
}