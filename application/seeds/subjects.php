<?php // file: /application/seeds/subjects.php

class Seed_Users extends \S2\Seed {

    public function grow()
    {
        $subject = new Subject;
        $subject->save();

    }

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 100;
    }

}