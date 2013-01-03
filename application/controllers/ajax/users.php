<?php

class Ajax_Users_Controller extends Base_Controller {

    public $restful = true;    

    public function get_index()
    {
        return eloquent_to_json(User::all());
    }    

    public function post_index()
    {

    }    

    public function get_show()
    {

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