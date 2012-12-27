<?php // file: /application/seeds/users.php

class Seed_Universities extends \S2\Seed {

    public function grow()
    {

		$university = new University(array(
				'name' => 'Multimedia University',
				'abbrevation' => 'MMU',
                'semester_id' => '1'
			));
		$university->save();
		$this->addReference('university-mmu', $university);
	}

    // This is optional. It lets you specify the order each seed is grown.
    // Seeds with a lower number are grown first.
    public function order()
    {
        return 2;
    }

}
