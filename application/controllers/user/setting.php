<?php

class User_Setting_Controller extends Base_Controller {

    // show logged in user profile
    public function action_index() {
    // show logged in user setting
        return View::make('user.setting');
    }

}