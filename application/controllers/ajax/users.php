<?php

class Ajax_Users_Controller extends Base_Controller {

    public $restful = true;    

    public function get_index()
    {
        return eloquent_to_json(User::all());
    }    

}