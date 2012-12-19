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
        return 'Specific user with id = '. $id . ' view';
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
    
    // show logged in user profile
    public function get_profile() {
        $u = Auth::user();
        $fac = $u->faculty()->first();
        $uni = $u->university()->only('name');
        dd($fac);
        return View::make('user.profile')
            ->with(array(
                'name' => $u->name,
                'phone' => $u->username,
                'faculty' => $fac,
                'university' => $uni
            ));
    }

    // show logged in user setting
    public function get_setting() {
        return View::make('user.setting');
    }

}