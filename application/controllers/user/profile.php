<?php

class User_Profile_Controller extends Base_Controller {

    // show logged in user profile
    public function action_index() {
        $u = Auth::user();
        $fac = $u->faculty()->first();
        $uni = $u->university()->only('name');
        return View::make('user.profile')
            ->with(array(
                'name' => $u->name,
                'phone' => $u->username,
                'faculty' => $fac,
                'university' => $uni
            ));
    }

}