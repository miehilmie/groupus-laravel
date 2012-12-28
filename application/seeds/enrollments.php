<?php // file: /application/seeds/users.php

class Seed_Enrollments extends \S2\Seed {

    public function grow()
    {
        $this->getReference('user-1')->subjects()
            ->attach($this->getReference('subject-1')->id, array(
                'semester_id' => $this->getReference('user-1')
                    ->university()->first()->semester_id));

        $this->getReference('user-1')->subjects()
            ->attach($this->getReference('subject-2')->id, array(
                'semester_id' => $this->getReference('user-1')
                    ->university()->first()->semester_id));
	}

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 7;
    }

}
