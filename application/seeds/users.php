<?php // file: /application/seeds/users.php

class Seed_Users extends \S2\Seed {

    public function grow()
    {
        $user = new User;
        $user->username = 'johndoe';
        $user->password = '12345678';
        $user->save();

        $user = new User;
        $user->username = 'janedoe';
        $user->password = '12345678';
        $user->save();
    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 100;
    }

}