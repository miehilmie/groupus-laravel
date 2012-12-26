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

    }    

	public function put_update()
    {

    }    

	public function delete_destroy()
    {

    }
   
}